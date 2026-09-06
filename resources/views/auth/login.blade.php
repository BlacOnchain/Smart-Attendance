<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sign In | Smart Attendance</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #10201a;
            --paper: #fbfbf7;
            --line: #e4e6df;
            --brand: #059669;
            --brand-dark: #047857;
        }
        * { font-family: 'IBM Plex Sans', system-ui, sans-serif; }
        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }
        body { background: linear-gradient(160deg, #e9f4ec 0%, #f6f8f2 48%, #eef6f1 100%); color: var(--ink); min-height: 100vh; overflow-x: hidden; }

        /* ---- drifting mesh backdrop, same language as the welcome page ---- */
        .auth-mesh {
            position: absolute; inset: 0;
            background:
                radial-gradient(760px 620px at 8% 0%, rgba(5,150,105,0.38), transparent 62%),
                radial-gradient(700px 580px at 96% 6%, rgba(13,148,136,0.32), transparent 62%),
                radial-gradient(680px 560px at 46% 100%, rgba(180,83,9,0.20), transparent 62%);
            filter: blur(4px);
            animation: drift 20s ease-in-out infinite alternate;
            pointer-events: none;
        }
        @keyframes drift {
            from { transform: translate3d(0,0,0) scale(1); }
            to   { transform: translate3d(-2%, 2%, 0) scale(1.06); }
        }
        .grain {
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(16,32,26,0.05) 1px, transparent 1px);
            background-size: 24px 24px;
            mask-image: radial-gradient(circle at 40% 35%, black, transparent 88%);
            -webkit-mask-image: radial-gradient(circle at 40% 35%, black, transparent 88%);
            pointer-events: none;
        }

        .glass-panel {
            background: rgba(255,255,255,0.84);
            border: 1px solid rgba(255,255,255,0.95);
            backdrop-filter: blur(24px) saturate(170%);
            -webkit-backdrop-filter: blur(24px) saturate(170%);
            box-shadow: 0 32px 80px -18px rgba(16,32,26,0.24), inset 0 1px 0 rgba(255,255,255,0.9);
            position: relative;
            overflow: hidden;
        }
        .glass-panel::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--brand), transparent 75%);
        }
        .glass-chip {
            background: rgba(255,255,255,0.8);
            border: 1px solid rgba(255,255,255,0.95);
            box-shadow: 0 14px 34px -14px rgba(16,32,26,0.2);
        }
        .chip-icon {
            width: 30px; height: 30px; border-radius: 9px;
            background: rgba(5,150,105,0.1);
            border: 1px solid rgba(5,150,105,0.22);
            color: var(--brand-dark);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
        }
        .input-icon {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: #9aa39c; pointer-events: none;
        }

        .tag-badge {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600; font-size: 11.5px; letter-spacing: 0.01em;
            color: var(--brand-dark);
            background: rgba(5,150,105,0.1);
            border: 1px solid rgba(5,150,105,0.22);
            padding: 5px 11px; border-radius: 999px;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .tag-badge::before {
            content: ''; width: 5px; height: 5px; border-radius: 999px;
            background: var(--brand);
        }

        .field-label { font-size: 13px; font-weight: 500; color: #5b6660; margin-bottom: 6px; display: block; }

        .glass-input {
            background: rgba(255,255,255,0.85);
            border: 1px solid #d7dbd2;
            color: var(--ink);
            box-shadow: 0 1px 2px rgba(16,32,26,0.04), inset 0 1px 0 rgba(255,255,255,0.6);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .glass-input::placeholder { color: #9aa39c; }
        .glass-input:focus {
            outline: none;
            border-color: rgba(5,150,105,0.55);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(5,150,105,0.12);
        }

        .btn-nudge { transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease; }
        .btn-nudge:hover { transform: translateY(-2px); }

        .lift-hover { transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease; }
        .lift-hover:hover { transform: translateY(-3px); background: rgba(255,255,255,0.55); }

        /* ---- varied entrance animations (not identical) ---- */
        @keyframes riseIn      { from { opacity:0; transform: translateY(22px); } to { opacity:1; transform:none; } }
        @keyframes scaleIn     { from { opacity:0; transform: scale(.96) translateY(12px); } to { opacity:1; transform:none; } }
        @keyframes slideLeftIn { from { opacity:0; transform: translateX(-30px); } to { opacity:1; transform:none; } }
        .anim-rise       { animation: riseIn .6s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d,0s); }
        .anim-scale       { animation: scaleIn .6s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d,0s); }
        .anim-slide-left { animation: slideLeftIn .6s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d,0s); }

        @keyframes scaleUp {
            0% { opacity: 0; transform: scale(0.94); }
            100% { opacity: 1; transform: scale(1); }
        }
        .animate-scale-up { animation: scaleUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        @media (prefers-reduced-motion: reduce) {
            .auth-mesh { animation: none !important; }
            .anim-rise, .anim-scale, .anim-slide-left { animation: none !important; opacity: 1 !important; transform: none !important; }
            .lift-hover, .btn-nudge { transition: none !important; }
        }

        /* ---- OTP slot inputs + orbit collapse, restyled for the light palette ---- */
        .otp-slot {
            width: 44px;
            height: 54px;
            border-radius: 14px;
            background: rgba(255,255,255,0.75);
            border: 1px solid var(--line);
            color: var(--ink);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .otp-slot:focus {
            border-color: rgba(5,150,105,0.6);
            box-shadow: 0 0 0 4px rgba(5,150,105,0.14);
        }
        .otp-slot.filled {
            border-color: rgba(5,150,105,0.5);
            background: rgba(5,150,105,0.08);
        }
        .otp-slot.error {
            border-color: rgba(190,18,60,0.7);
            animation: otpShake 0.4s ease;
        }
        @keyframes otpShake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        .orbit {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            pointer-events: none;
        }
        .orbit-ring {
            width: 110px; height: 110px;
            fill: none;
            stroke: rgba(5,150,105,0.45);
            stroke-width: 1.5;
            stroke-dasharray: 2 6;
            animation: orbitSpin 2.4s linear infinite;
        }
        @keyframes orbitSpin { to { transform: rotate(360deg); } }
        .orbit_hub {
            position: absolute;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: var(--brand);
            box-shadow: 0 0 18px 4px rgba(5,150,105,0.45);
        }
    </style>
</head>
<body>
    <div class="relative min-h-screen overflow-hidden">
        <div class="auth-mesh"></div>
        <div class="grain"></div>

        <div class="relative z-10 grid min-h-screen lg:grid-cols-2">
            <!-- Sign-in panel -->
            <section class="flex items-center justify-center px-4 py-10 sm:px-6 sm:py-12" style="padding-top: max(2.5rem, env(safe-area-inset-top)); padding-bottom: max(2.5rem, env(safe-area-inset-bottom));">
                <div class="w-full max-w-md">
                    <div class="anim-rise mb-8 flex items-center gap-3" style="--d: 0s">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-600 text-white">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/>
                                <path d="M9.5 12.5L11.3 14.3L15 10.2"/>
                            </svg>
                        </div>
                        <span class="text-[15px] font-semibold tracking-tight">Smart Attendance</span>
                    </div>

                    <div class="glass-panel anim-scale rounded-[28px] p-6 sm:p-10" style="--d: 0.08s">
                        <span class="tag-badge">Student portal</span>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight">Welcome back</h2>
                        <p class="mt-2 text-sm leading-6" style="color:#5b6660">Sign in to check your timetable and log attendance.</p>

                        @if (session('success'))
                            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('login.submit') }}" method="POST" autocomplete="off" class="mt-7 space-y-4">
                            @csrf
                            <div>
                                <label class="field-label">Email address</label>
                                <div class="relative">
                                    <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 6.5L12 13l8.5-6.5"/></svg>
                                    <input type="email" name="email" id="emailInput" value="" autocomplete="off" required placeholder="you@example.com"
                                           class="glass-input w-full rounded-2xl pl-11 pr-4 py-3">
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Password</label>
                                <div class="relative">
                                    <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4.5" y="10.5" width="15" height="9.5" rx="2"/><path d="M8 10.5V7.5a4 4 0 118 0v3"/></svg>
                                    <input type="password" id="passwordInput" name="password" autocomplete="new-password" required placeholder="••••••••"
                                           class="glass-input w-full rounded-2xl pl-11 pr-11 py-3">
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 hover:opacity-70" style="color:#7a8580" aria-label="Toggle password visibility">
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-sm pt-1">
                                <label class="flex items-center gap-2" style="color:#5b6660">
                                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                    Remember me
                                </label>
                                <button type="button" onclick="openForgotModal()" class="font-medium text-emerald-700 hover:text-emerald-800 bg-transparent border-none cursor-pointer">Forgot password?</button>
                            </div>

                            <button type="submit" class="btn-nudge w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition">
                                Sign in
                            </button>
                        </form>

                        <a href="{{ route('lecturer.login') }}" class="lift-hover mt-4 block w-full rounded-2xl border px-4 py-3 text-center font-semibold" style="border-color: var(--line); background: rgba(255,255,255,0.5); color: var(--ink);">
                            Log in as lecturer
                        </a>

                        <p class="mt-6 text-center text-sm" style="color:#7a8580">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-medium text-emerald-700 hover:text-emerald-800">Sign up</a>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Marketing side -->
            <aside class="hidden lg:flex lg:flex-col lg:justify-between lg:px-14 lg:py-14">
                <div class="anim-slide-left max-w-xl" style="--d: 0.12s">
                    <span class="tag-badge">Smart Attendance</span>
                    <h2 class="mt-6 text-5xl font-bold leading-tight tracking-tight">One QR code, one classroom, no proxy sign-ins.</h2>
                    <p class="mt-5 text-lg leading-8" style="color:#4b564f">
                        Your dashboard, timetable, and course registration in one place — check in with a scan and see exactly what you're enrolled in.
                    </p>
                </div>

                <div class="anim-scale glass-panel rounded-2xl p-5 flex items-center gap-3 max-w-sm" style="--d: 0.16s">
                    <span class="relative flex h-2.5 w-2.5 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-60"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-600"></span>
                    </span>
                    <span class="text-sm" style="color:#5b6660">Live session code</span>
                    <span id="heroToken" class="mono text-sm font-semibold tracking-widest ml-auto" style="color: var(--brand-dark)">A3F9K2</span>
                </div>

                <div class="anim-slide-left grid gap-4 sm:grid-cols-3" style="--d: 0.24s">
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Students</p>
                        <p class="mt-1 text-xl font-semibold">Profiles</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="4.5" width="17" height="13" rx="2"/><path d="M8 21h8M12 17.5V21"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Lecturers</p>
                        <p class="mt-1 text-xl font-semibold">Sessions</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="2.5"/><path d="M4 9.5h16M9 4v4.5"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Department</p>
                        <p class="mt-1 text-xl font-semibold">Timetable</p>
                    </div>
                </div>
            </aside>
        </div>

        <!-- FORGOT PASSWORD MODAL OVERLAY -->
        <div id="forgotModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4" style="background: rgba(16,32,26,0.45); backdrop-filter: blur(6px);">
            <div class="w-full max-w-md rounded-[32px] p-8 shadow-2xl animate-scale-up" style="background: #ffffff; border: 1px solid var(--line); color: var(--ink);">

                <!-- Step 1: Enter Email -->
                <div id="forgotStep1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">Reset password</h3>
                        <button onclick="closeForgotModal()" class="text-lg font-bold" style="color:#9aa39c">✕</button>
                    </div>
                    <p class="text-sm mb-6" style="color:#5b6660">Enter your registered email address and we'll send you a 6-digit verification code.</p>

                    <div id="step1Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700"></div>

                    <div class="space-y-4">
                        <div>
                            <label class="field-label">Email address</label>
                            <input type="email" id="resetEmail" required placeholder="you@example.com" class="glass-input w-full rounded-2xl px-4 py-3">
                        </div>
                        <button type="button" onclick="sendOtpRequest()" id="sendOtpBtn" class="w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white hover:bg-emerald-700 transition">
                            Send verification code
                        </button>
                    </div>
                </div>

                <!-- Step 2: Enter OTP Code — 6 slots with orbit collapse verification animation -->
                <div id="forgotStep2" class="hidden">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-2xl font-bold">Enter verification code</h3>
                        <button onclick="closeForgotModal()" class="text-lg font-bold" style="color:#9aa39c">✕</button>
                    </div>
                    <p class="text-sm mb-5" style="color:#5b6660">Enter the 6-digit code sent to your email inbox.</p>

                    <div id="step2Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700 text-left"></div>

                    <div class="relative flex items-center justify-center py-6" style="min-height: 90px;">
                        <div id="otpSlotRow" class="flex items-center justify-center gap-2.5">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="0" autocomplete="one-time-code">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="1">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="2">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="3">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="4">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="5">
                        </div>

                        <div class="orbit hidden" id="otpOrbit">
                            <svg class="orbit-ring" viewBox="0 0 110 110">
                                <circle cx="55" cy="55" r="46" vector-effect="non-scaling-stroke" />
                            </svg>
                            <span class="orbit_hub" id="orbitHub"></span>
                        </div>
                    </div>

                    <input type="hidden" id="resetOtp">
                </div>

                <!-- Step 3: New Password Input -->
                <div id="forgotStep3" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">New password</h3>
                        <button onclick="closeForgotModal()" class="text-lg font-bold" style="color:#9aa39c">✕</button>
                    </div>
                    <p class="text-sm mb-6" style="color:#5b6660">Create a secure new password for your account.</p>

                    <div id="step3Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700"></div>

                    <div class="space-y-4">
                        <div>
                            <label class="field-label">New password</label>
                            <input type="password" id="newPassword" required placeholder="••••••••" class="glass-input w-full rounded-2xl px-4 py-3">
                        </div>
                        <div>
                            <label class="field-label">Confirm new password</label>
                            <input type="password" id="newPasswordConfirmation" required placeholder="••••••••" class="glass-input w-full rounded-2xl px-4 py-3">
                        </div>
                        <button type="button" onclick="resetPasswordRequest()" id="resetPassBtn" class="w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white hover:bg-emerald-700 transition">
                            Update password
                        </button>
                    </div>
                </div>

                <!-- Step 4: Success Confirmation -->
                <div id="forgotStep4" class="hidden text-center py-6">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 text-3xl mb-4">
                        ✓
                    </div>
                    <h3 class="text-2xl font-bold">Password updated</h3>
                    <p class="mt-2 text-sm" style="color:#5b6660">Your password has been changed successfully. Redirecting you...</p>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Live token ticker, matching the welcome page hero
        (function () {
            const el = document.getElementById('heroToken');
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            function rand() {
                let s = '';
                for (let i = 0; i < 6; i++) s += chars[Math.floor(Math.random() * chars.length)];
                return s;
            }
            el.style.transition = 'opacity .2s ease';
            setInterval(() => {
                el.style.opacity = 0;
                setTimeout(() => { el.textContent = rand(); el.style.opacity = 1; }, 200);
            }, 2600);
        })();

        // Force fields to remain empty on page load, refresh, or browser back/forward cache
        window.addEventListener('pageshow', function (event) {
            document.getElementById('emailInput').value = '';
            document.getElementById('passwordInput').value = '';
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('emailInput').value = '';
            document.getElementById('passwordInput').value = '';
        });

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function openForgotModal() {
            document.getElementById('forgotModal').classList.remove('hidden');
            document.getElementById('forgotModal').classList.add('flex');
        }

        function closeForgotModal() {
            document.getElementById('forgotModal').classList.add('hidden');
            document.getElementById('forgotModal').classList.remove('flex');
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        async function sendOtpRequest() {
            const email = document.getElementById('resetEmail').value;
            const errorBox = document.getElementById('step1Error');
            errorBox.classList.add('hidden');

            if (!email) {
                errorBox.textContent = 'Please enter your email address.';
                errorBox.classList.remove('hidden');
                return;
            }

            try {
                const response = await fetch("{{ route('password.otp.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();

                if (response.ok) {
                    document.getElementById('forgotStep1').classList.add('hidden');
                    document.getElementById('forgotStep2').classList.remove('hidden');
                    if (window.resetOtpSlots) resetOtpSlots();
                } else {
                    errorBox.textContent = data.message || 'Unable to send code. Check email address.';
                    errorBox.classList.remove('hidden');
                }
            } catch (e) {
                errorBox.textContent = 'Connection error. Please try again.';
                errorBox.classList.remove('hidden');
            }
        }

        // --- OTP slot input + orbit collapse animation ---
        (function () {
            const slots = Array.from(document.querySelectorAll('.otp-slot'));
            const hiddenOtp = document.getElementById('resetOtp');
            const slotRow = document.getElementById('otpSlotRow');
            const orbit = document.getElementById('otpOrbit');

            function syncHidden() {
                hiddenOtp.value = slots.map(s => s.value).join('');
            }

            slots.forEach((slot, i) => {
                slot.addEventListener('input', () => {
                    slot.value = slot.value.replace(/[^0-9]/g, '').slice(0, 1);
                    slot.classList.toggle('filled', slot.value !== '');
                    syncHidden();

                    if (slot.value && i < slots.length - 1) {
                        slots[i + 1].focus();
                    }

                    if (slots.every(s => s.value !== '')) {
                        playOrbitCollapse();
                    }
                });

                slot.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !slot.value && i > 0) {
                        slots[i - 1].focus();
                    }
                });

                slot.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                    pasted.split('').forEach((digit, idx) => {
                        if (slots[idx]) {
                            slots[idx].value = digit;
                            slots[idx].classList.add('filled');
                        }
                    });
                    syncHidden();
                    if (pasted.length === 6) {
                        playOrbitCollapse();
                    } else if (slots[pasted.length]) {
                        slots[pasted.length].focus();
                    }
                });
            });

            function playOrbitCollapse() {
                const hub = document.getElementById('orbitHub');
                orbit.classList.remove('hidden');

                const hRect = hub.getBoundingClientRect();
                const centerX = hRect.left + hRect.width / 2;
                const centerY = hRect.top + hRect.height / 2;

                slots.forEach((slot, i) => {
                    const rect = slot.getBoundingClientRect();
                    const dx = centerX - (rect.left + rect.width / 2);
                    const dy = centerY - (rect.top + rect.height / 2);

                    slot.animate([
                        { transform: 'translate(0, 0) rotate(0deg)', opacity: 1 },
                        { transform: `translate(${dx * 0.6}px, ${dy * 0.6}px) rotate(220deg)`, opacity: 0.7, offset: 0.6 },
                        { transform: `translate(${dx}px, ${dy}px) rotate(450deg)`, opacity: 0 },
                    ], {
                        duration: 550,
                        delay: i * 40,
                        easing: 'cubic-bezier(0.65, 0, 0.35, 1)',
                        fill: 'forwards',
                    });
                });

                setTimeout(() => { slotRow.style.visibility = 'hidden'; }, 550 + slots.length * 40);
                setTimeout(() => { verifyOtpRequest(); }, 700 + slots.length * 40);
            }

            window.resetOtpSlots = function () {
                slots.forEach(s => {
                    s.getAnimations().forEach(a => a.cancel());
                    s.value = '';
                    s.classList.remove('filled', 'error');
                });
                slotRow.style.visibility = 'visible';
                orbit.classList.add('hidden');
                syncHidden();
                slots[0].focus();
            };

            window.markOtpError = function () {
                slotRow.style.visibility = 'visible';
                orbit.classList.add('hidden');
                slots.forEach(s => {
                    s.getAnimations().forEach(a => a.cancel());
                    s.classList.add('error');
                });
                setTimeout(() => slots.forEach(s => s.classList.remove('error')), 400);
            };
        })();

        async function verifyOtpRequest() {
            const email = document.getElementById('resetEmail').value;
            const otp_code = document.getElementById('resetOtp').value;
            const errorBox = document.getElementById('step2Error');
            errorBox.classList.add('hidden');

            if (!otp_code || otp_code.length !== 6) {
                errorBox.textContent = 'Please enter the valid 6-digit code.';
                errorBox.classList.remove('hidden');
                if (window.markOtpError) markOtpError();
                return;
            }

            try {
                const response = await fetch("{{ route('password.otp.verify') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, otp_code })
                });
                const data = await response.json();

                if (response.ok) {
                    document.getElementById('forgotStep2').classList.add('hidden');
                    document.getElementById('forgotStep3').classList.remove('hidden');
                } else {
                    errorBox.textContent = data.message || 'Invalid or expired verification code.';
                    errorBox.classList.remove('hidden');
                    if (window.markOtpError) markOtpError();
                }
            } catch (e) {
                errorBox.textContent = 'Connection error. Please try again.';
                errorBox.classList.add('hidden');
                if (window.markOtpError) markOtpError();
            }
        }

        async function resetPasswordRequest() {
            const email = document.getElementById('resetEmail').value;
            const otp_code = document.getElementById('resetOtp').value;
            const password = document.getElementById('newPassword').value;
            const password_confirmation = document.getElementById('newPasswordConfirmation').value;
            const errorBox = document.getElementById('step3Error');
            errorBox.classList.add('hidden');

            if (!password || password.length < 8) {
                errorBox.textContent = 'Password must be at least 8 characters long.';
                errorBox.classList.remove('hidden');
                return;
            }

            if (password !== password_confirmation) {
                errorBox.textContent = 'Passwords do not match.';
                errorBox.classList.add('hidden');
                return;
            }

            try {
                const response = await fetch("{{ route('password.otp.reset') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, otp_code, password, password_confirmation })
                });
                const data = await response.json();

                if (response.ok) {
                    document.getElementById('forgotStep3').classList.add('hidden');
                    document.getElementById('forgotStep4').classList.remove('hidden');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else {
                    errorBox.textContent = data.message || 'Failed to reset password.';
                    errorBox.classList.add('hidden');
                }
            } catch (e) {
                errorBox.textContent = 'Connection error. Please try again.';
                errorBox.classList.add('hidden');
            }
        }
    </script>
</body>
</html>