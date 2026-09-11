<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LoginActivity extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'location',
        'user_agent',
        'session_id',
        'logged_in_at',
    ];

    protected $casts = [
        'logged_in_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Turn a raw browser user-agent string into a short, human-readable
     * label like "Chrome on Windows" instead of exposing the full
     * technical string in the UI.
     */
    public static function deviceLabel(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'Unknown device';
        }

        $browser = match (true) {
            str_contains($userAgent, 'Edg/') => 'Edge',
            str_contains($userAgent, 'OPR/') || str_contains($userAgent, 'Opera') => 'Opera',
            str_contains($userAgent, 'Chrome/') && !str_contains($userAgent, 'Chromium') => 'Chrome',
            str_contains($userAgent, 'Firefox/') => 'Firefox',
            str_contains($userAgent, 'Safari/') && !str_contains($userAgent, 'Chrome') => 'Safari',
            default => 'a browser',
        };

        $os = match (true) {
            str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad') => 'iOS',
            str_contains($userAgent, 'Android') => 'Android',
            str_contains($userAgent, 'Windows') => 'Windows',
            str_contains($userAgent, 'Mac OS X') => 'macOS',
            str_contains($userAgent, 'Linux') => 'Linux',
            default => 'an unknown OS',
        };

        return "{$browser} on {$os}";
    }

    /**
     * Resolve an IP address to an approximate "City, Country" string at
     * login time, so we never need to store or display the raw IP in the
     * UI. Uses ip-api.com's free, keyless endpoint — safe to call once
     * per login, not meant to be called on every page render.
     *
     * Returns null on failure so a geolocation hiccup never blocks a
     * real login.
     */
    public static function locateIp(string $ip): ?string
    {
        // Local/private IPs (XAMPP, Docker bridge networks, etc.) will
        // never resolve to a real location - skip the API call entirely.
        if (in_array($ip, ['127.0.0.1', '::1']) || preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[0-1])\.)/', $ip)) {
            return 'Local network';
        }

        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,city,country',
            ]);

            if ($response->successful() && $response->json('status') === 'success') {
                $city = $response->json('city');
                $country = $response->json('country');

                return trim(implode(', ', array_filter([$city, $country]))) ?: null;
            }
        } catch (\Exception $e) {
            // Never block a login over a geolocation lookup failing.
            Log::warning('IP geolocation failed for ' . $ip . ': ' . $e->getMessage());
        }

        return null;
    }
}