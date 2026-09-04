<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PasswordResetController extends Controller
{
    // 1. Send 6-digit OTP code to email
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        $email = $request->email;
        $code = rand(100000, 999999);

        // Store code in cache for 10 minutes
        Cache::put('pwd_reset_' . $email, $code, now()->addMinutes(10));

        // Send Email (Falls back to log if mail server isn't active yet)
        try {
            Mail::raw("Your Smart Attendance password reset code is: {$code}. It expires in 10 minutes.", function ($message) use ($email) {
                $message->to($email)->subject('Password Reset Verification Code');
            });
        } catch (\Exception $e) {
            Log::info("Password Reset OTP for {$email}: {$code}");
        }

        return response()->json([
            'success' => true,
            'message' => 'A 6-digit verification code has been sent to your Gmail.'
        ]);
    }

    // 2. Verify the 6-digit code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric|digits:6'
        ]);

        $cachedCode = Cache::get('pwd_reset_' . $request->email);

        if (!$cachedCode || $cachedCode != $request->code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification code.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Code verified successfully! Enter your new password.'
        ]);
    }

    // 3. Update the password in the database
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $cachedCode = Cache::get('pwd_reset_' . $request->email);

        if (!$cachedCode || $cachedCode != $request->code) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please request a new code.'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User account not found.'
            ], 404);
        }

        // Update database with hashed new password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Clear the code from cache
        Cache::forget('pwd_reset_' . $request->email);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully!'
        ]);
    }
}