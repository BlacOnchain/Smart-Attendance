<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/student/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'email' => $data['email'],
            'role' => 'student',
            'phone_number' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('student.profile')->with('success', 'Account created successfully.');
    }

    // --- OTP Forgot Password Methods ---

    // 1. Send OTP Code to Email
    public function sendOtpCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate a random 6-digit code
        $otp = (string) rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10); // Code valid for 10 mins
        $user->save();

        try {
            // Send the styled HTML email using our Mailable class
            Mail::to($user->email)->send(new SendOtpMail($otp));

            return response()->json(['success' => true, 'message' => 'Verification code sent to your Gmail!']);
        } catch (\Exception $e) {
            // Previously this returned $e->getMessage() straight to the
            // client, which can leak mail server hostnames, credentials
            // in transport errors, or stack details. Log it server-side
            // and keep the client message generic instead.
            Log::error('OTP mail send failed for ' . $user->email . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'We could not send the verification email right now. Please try again shortly.',
            ], 500);
        }
    }

    // 2. Verify OTP Code
    public function verifyOtpCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // otp_code is generated as a string above, but comparing with !==
        // is still fragile if it's ever stored/cast as an integer (e.g. by
        // a future migration change). hash_equals is both type-safe and
        // timing-attack resistant, which matters for a value guarding
        // password reset.
        if (!$user || !$user->otp_code || !hash_equals((string) $user->otp_code, (string) $request->otp_code)) {
            return response()->json(['success' => false, 'message' => 'Invalid verification code.'], 422);
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'Verification code has expired. Please request a new one.'], 422);
        }

        return response()->json(['success' => true, 'message' => 'Code verified successfully!']);
    }

    // 3. Reset Password
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        $validOtp = $user
            && $user->otp_code
            && hash_equals((string) $user->otp_code, (string) $request->otp_code)
            && Carbon::now()->lessThan($user->otp_expires_at);

        if (!$validOtp) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired session. Please start over.'], 422);
        }

        // Update password and clear OTP
        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password changed successfully! Redirecting...']);
    }

    // Logout functionality
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}