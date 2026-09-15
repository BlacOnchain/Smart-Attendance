<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function show(string $path): Response
    {
        // Never allow a URL to escape the public profile-photo directory.
        if ($path === '' || str_contains($path, '..') || str_contains($path, '\\')) {
            abort(404);
        }

        // Railway filesystems can be replaced during a redeploy. Prefer the
        // database copy when available, then fall back to the public disk.
        $user = User::where('profile_photo_path', $path)->first();
        if ($user?->profile_photo_data) {
            return response(base64_decode($user->profile_photo_data), 200, [
                'Content-Type' => $user->profile_photo_mime ?: 'image/jpeg',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            abort(404);
        }

        $absolutePath = $disk->path($path);
        $mimeType = $disk->mimeType($path) ?: 'application/octet-stream';

        return response()->file($absolutePath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
