<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sign In | Smart Attendance</title>
    <meta name="description" content="Sign in to manage your student timetable and secure QR attendance check-ins.">
    <link rel="icon" href="{{ asset('favicon-32.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('favicon-192.png') }}">
    <meta property="og:title" content="Sign In | Smart Attendance">
    <meta property="og:description" content="Access your Smart Attendance student portal.">
    <meta property="og:image" content="{{ asset('images/logo-3d-512.png') }}">
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

        /* Cohesive drifting mesh backdrop matching the lecturer portal */
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

        @keyframes floatBob {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .float-bob { animation: floatBob 5s ease-in-out infinite; }

        .step-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .step-row .step-num {
            display: flex; align-items: center; justify-content: center;
            width: 26px; height: 26px; border-radius: 999px;
            background: var(--brand); color: #fff;
            font-size: 11px; font-weight: 700; flex-shrink: 0;
        }
        .step-row .step-label { font-size: 13.5px; font-weight: 500; color: #5b6660; }
        .step-row .step-arrow { color: #c8cec3; font-size: 13px; }

        /* OTP slot inputs + verification feedback */
        .otp-slot {
            width: 44px; height: 54px; border-radius: 14px;
            background: rgba(255,255,255,0.75); border: 1px solid var(--line);
            color: var(--ink); font-family: 'IBM Plex Mono', monospace;
            font-size: 20px; font-weight: 700; text-align: center; outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .otp-slot:focus {
            border-color: rgba(5,150,105,0.6);
            box-shadow: 0 0 0 4px rgba(5,150,105,0.14);
        }
        .otp-slot.filled {
            border-color: rgba(5,150,105,0.5);
            background: rgba(5,150,105,0.08);
            animation: otpPop .28s cubic-bezier(.16,1,.3,1);
        }
        .otp-slot.ready { border-color: rgba(5,150,105,0.7); background: rgba(5,150,105,0.13); color: #047857; }
        .otp-slot.checking { animation: otpCheck .55s ease both; }
        @keyframes otpPop { from { transform: scale(.82); opacity: .55; } to { transform: scale(1); opacity: 1; } }
        @keyframes otpCheck { 0% { transform: translateY(0); } 45% { transform: translateY(-7px); } 100% { transform: translateY(0); } }
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
        .otp-status { min-height: 18px; transition: opacity .2s ease, transform .2s ease; }
        .password-meter { height: 6px; border-radius: 999px; background: #e8f1eb; overflow: hidden; }
        .password-meter span { display: block; height: 100%; width: 0; border-radius: inherit; transition: width .25s ease, background-color .25s ease; }
        .otp-status.checking { color: var(--brand-dark); animation: statusIn .35s ease both; }
        @keyframes statusIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: none; } }

        /* Final emerald product palette for all auth states. */
        body.auth-page { background: linear-gradient(160deg, #e9f4ec 0%, #f6f8f2 48%, #eef6f1 100%); }
        .auth-form-pane { background: #10201a; }
        .auth-form-pane .btn-nudge { background: #059669; box-shadow: 0 12px 24px rgba(5,150,105,.22); }
        .auth-form-pane .btn-nudge:hover { background: #047857; }
        .auth-form-pane .glass-input:focus { border-bottom-color: #34d399; box-shadow: 0 2px 0 #34d399; }
        .auth-form-pane a { color: #6ee7b7; }
        .auth-form-pane a:hover { color: #a7f3d0; }
        .auth-form-pane .lift-hover:hover { border-color: #34d399 !important; }
        .auth-art-pane { background: linear-gradient(145deg, #047857 0%, #059669 48%, #14b8a6 100%); }
        .auth-art-pane::before, .auth-art-pane::after { background: rgba(255,255,255,.11); }
        .auth-art-pane .step-num { color: #047857; }
        .auth-checkmark { border-color: #059669; }
        .auth-progress span { background: #a7f3d0; }
    </style>
</head>
<body>
    <div class="relative min-h-screen overflow-hidden">
        <div class="auth-mesh"></div>
        <div class="grain"></div>

        <div class="relative z-10 mx-auto grid min-h-screen max-w-7xl lg:grid-cols-2">
            <!-- Sign-in panel -->
            <section class="flex items-center justify-center px-4 py-10 sm:px-6 sm:py-12" style="padding-top: max(2.5rem, env(safe-area-inset-top)); padding-bottom: max(2.5rem, env(safe-area-inset-top));">
                <div class="w-full max-w-md">
                    <div class="anim-rise mb-8 flex items-center gap-3" style="--d: 0s">
                        <img src="{{ asset('images/logo-3d.svg') }}" alt="Smart Attendance logo" class="h-11 w-11 rounded-xl object-cover">
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

                        <form id="studentLoginForm" action="{{ route('login.submit') }}" method="POST" autocomplete="off" class="mt-7 space-y-4">
                            @csrf
                            <div>
                                <label class="field-label" for="emailInput">Email address</label>
                                <div class="relative">
                                    <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 6.5L12 13l8.5-6.5"/></svg>
                                    <input type="email" name="email" id="emailInput" value="" autocomplete="off" required placeholder="you@example.com"
                                           class="glass-input w-full rounded-2xl pl-11 pr-4 py-3">
                                </div>
                            </div>

                            <div>
                                <label class="field-label" for="passwordInput">Password</label>
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
                                <button type="button" onclick="openForgotModal()" class="font-medium bg-transparent border-none cursor-pointer" style="color: var(--brand-dark)">Forgot password?</button>
                            </div>

                            <button id="studentLoginButton" type="submit" class="btn-nudge mt-2 w-full rounded-2xl px-4 py-3.5 font-semibold text-white shadow-lg transition" style="background: var(--brand); box-shadow: 0 10px 25px -8px rgba(5,150,105,0.4);" onmouseover="this.style.background='var(--brand-dark)'" onmouseout="this.style.background='var(--brand)'">
                                Sign in
                            </button>
                        </form>

                        <a href="{{ route('lecturer.login') }}" class="lift-hover mt-4 block w-full rounded-2xl border px-4 py-3 text-center font-semibold" style="border-color: var(--line); background: rgba(255,255,255,0.5); color: var(--ink);">
                            Log in as lecturer
                        </a>

                        <p class="mt-6 text-center text-sm" style="color:#7a8580">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-medium" style="color: var(--brand-dark)">Sign up</a>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Marketing side -->
            <aside class="hidden lg:flex lg:flex-col lg:justify-between lg:px-14 lg:py-14">
                <div class="anim-slide-left max-w-xl" style="--d: 0.12s">
                    <span class="tag-badge">Smart Attendance</span>
                    <h2 class="mt-6 text-5xl font-bold leading-tight tracking-tight">Your attendance, streamlined.</h2>
                    <p class="mt-5 text-lg leading-8" style="color:#4b564f">
                        Access your timetable, keep track of your courses, and check in securely with live QR codes in seconds.
                    </p>
                    <div class="step-row anim-slide-left mt-6" style="--d: 0.14s">
                        <span class="step-num">1</span><span class="step-label">Scan QR</span>
                        <span class="step-arrow">→</span>
                        <span class="step-num">2</span><span class="step-label">Verify location</span>
                        <span class="step-arrow">→</span>
                        <span class="step-num">3</span><span class="step-label">Checked in</span>
                    </div>
                </div>

                <div class="anim-scale glass-panel rounded-2xl p-5 flex items-center gap-3 max-w-sm" style="--d: 0.16s">
                    <span class="relative flex h-2.5 w-2.5 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full" style="background: var(--brand); opacity:.6"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5" style="background: var(--brand)"></span>
                    </span>
                    <span class="text-sm" style="color:#5b6660">Live session code</span>
                    <span id="heroToken" class="mono text-sm font-semibold tracking-widest ml-auto" style="color: var(--brand-dark)">A3F9K2</span>
                </div>

                <div class="anim-slide-left grid gap-4 sm:grid-cols-3" style="--d: 0.24s">
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon float-bob" style="animation-delay: 0s"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Student</p>
                        <p class="mt-1 text-xl font-semibold">Profiles</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon float-bob" style="animation-delay: 0.6s"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="4.5" width="17" height="13" rx="2"/><path d="M8 21h8M12 17.5V21"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Lecturers</p>
                        <p class="mt-1 text-xl font-semibold">Sessions</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon float-bob" style="animation-delay: 1.2s"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="2.5"/><path d="M4 9.5h16M9 4v4.5"/></svg></div>
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
                        <button type="button" onclick="sendOtpRequest()" id="sendOtpBtn" class="w-full rounded-2xl px-4 py-3.5 font-semibold text-white transition" style="background: var(--brand)" onmouseover="this.style.background='var(--brand-dark)'" onmouseout="this.style.background='var(--brand)'">
                            Send verification code
                        </button>
                    </div>
                </div>

                <!-- Step 2: Enter OTP Code -->
                <div id="forgotStep2" class="hidden">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-2xl font-bold">Enter verification code</h3>
                        <button onclick="closeForgotModal()" class="text-lg font-bold" style="color:#9aa39c">✕</button>
                    </div>
                    <p class="text-sm mb-5" style="color:#5b6660">Enter the 6-digit code sent to your email inbox.</p>

                    <div id="step2Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700 text-left"></div>

                    <div class="flex flex-col items-center justify-center py-5" style="min-height: 90px;">
                        <div id="otpSlotRow" class="flex items-center justify-center gap-2.5">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="0" autocomplete="one-time-code">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="1">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="2">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="3">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="4">
                            <input type="text" inputmode="numeric" maxlength="1" class="otp-slot" data-otp-slot="5">
                        </div>
                        <p id="otpStatus" class="otp-status mt-4 text-xs text-neutral-400">Enter all 6 digits</p>
                    </div>
                    <input type="hidden" id="resetOtp">
                </div>

                <!-- Step 3: New Password Input -->
                <div id="forgotStep3" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">New password</h3>
                        <button onclick="closeForgotModal()" class="text-lg font-bold" style="color:#9aa39c">✕</button>
                    </div>
                    <p class="text-sm mb-5" style="color:#5b6660">Use 8 or more characters with a mix of letters, numbers, and symbols.</p>

                    <div id="step3Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700"></div>

                    <div class="space-y-4">
                        <div>
                            <label class="field-label">New password</label>
                            <div class="relative"><input type="password" id="newPassword" required minlength="8" autocomplete="new-password" placeholder="Create a strong password" class="glass-input w-full rounded-2xl px-4 py-3 pr-12"><button type="button" onclick="toggleNewPassword('newPassword', 'newEye1')" class="absolute inset-y-0 right-0 px-4 text-slate-500 text-xs font-semibold" aria-label="Show new password"><span id="newEye1">Show</span></button></div>
                            <div class="password-meter mt-2"><span id="resetPasswordMeter"></span></div><p id="resetPasswordHint" class="mt-1 text-[11px] text-slate-500">Use at least 8 characters.</p>
                        </div>
                        <div>
                            <label class="field-label">Confirm new password</label>
                            <div class="relative"><input type="password" id="newPasswordConfirmation" required minlength="8" autocomplete="new-password" placeholder="Repeat your password" class="glass-input w-full rounded-2xl px-4 py-3 pr-12"><button type="button" onclick="toggleNewPassword('newPasswordConfirmation', 'newEye2')" class="absolute inset-y-0 right-0 px-4 text-slate-500 text-xs font-semibold" aria-label="Show password confirmation"><span id="newEye2">Show</span></button></div><p id="resetMatchHint" class="mt-1 text-[11px] text-slate-500">Passwords must match.</p>
                        </div>
                        <button type="button" onclick="resetPasswordRequest()" id="resetPassBtn" class="w-full rounded-2xl px-4 py-3.5 font-semibold text-white transition" style="background: var(--brand)" onmouseover="this.style.background='var(--brand-dark)'" onmouseout="this.style.background='var(--brand)'">
                            Update password
                        </button>
                    </div>
                </div>

                <!-- Step 4: Success Confirmation -->
                <div id="forgotStep4" class="hidden text-center py-6">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border text-3xl mb-4" style="background: rgba(5,150,105,0.1); color: var(--brand); border-color: rgba(5,150,105,0.25)">
                        ✓
                    </div>
                    <h3 class="text-2xl font-bold">Password updated</h3>
                    <p class="mt-2 text-sm" style="color:#5b6660">Your password has been changed successfully. Redirecting you...</p>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Live token ticker
        (function () {
            const el = document.getElementById('heroToken');
            if (!el) return;
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

        window.addEventListener('pageshow', function () {
            document.getElementById('emailInput').value = '';
            document.getElementById('passwordInput').value = '';
        });

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('studentLoginForm').addEventListener('submit', function () {
            const button = document.getElementById('studentLoginButton');
            button.disabled = true;
            button.textContent = 'Signing in...';
            button.classList.add('opacity-80', 'cursor-wait');
        });

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
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
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

        // OTP Slot Inputs Handling
        (function () {
            const slots = Array.from(document.querySelectorAll('.otp-slot'));
            const hiddenOtp = document.getElementById('resetOtp');
            const slotRow = document.getElementById('otpSlotRow');
            const status = document.getElementById('otpStatus');
            if (!slots.length) return;

            function syncHidden() {
                hiddenOtp.value = slots.map(s => s.value).join('');
            }

            slots.forEach((slot, i) => {
                slot.addEventListener('input', () => {
                    slot.value = slot.value.replace(/[^0-9]/g, '').slice(0, 1);
                    slot.classList.toggle('filled', slot.value !== '');
                    slot.classList.remove('ready');
                    syncHidden();

                    if (slot.value && i < slots.length - 1) slots[i + 1].focus();
                    if (slots.every(s => s.value !== '')) verifyWithAnimation();
                });

                slot.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !slot.value && i > 0) slots[i - 1].focus();
                });

                slot.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                    pasted.split('').forEach((digit, idx) => {
                        if (slots[idx]) { slots[idx].value = digit; slots[idx].classList.add('filled'); }
                    });
                    syncHidden();
                    if (pasted.length === 6) verifyWithAnimation();
                    else if (slots[pasted.length]) slots[pasted.length].focus();
                });
            });

            function verifyWithAnimation() {
                if (slotRow.dataset.checking === 'true') return;
                slotRow.dataset.checking = 'true';
                slots.forEach((slot, i) => {
                    slot.classList.add('ready', 'checking');
                    slot.style.animationDelay = `${i * 45}ms`;
                });
                status.textContent = 'Checking your code...';
                status.classList.add('checking');
                setTimeout(() => { verifyOtpRequest(); }, 520);
            }

            window.resetOtpSlots = function () {
                slots.forEach(s => {
                    s.getAnimations().forEach(a => a.cancel());
                    s.value = '';
                    s.classList.remove('filled', 'ready', 'checking', 'error');
                    s.style.animationDelay = '';
                });
                slotRow.dataset.checking = 'false';
                status.textContent = 'Enter all 6 digits';
                status.classList.remove('checking');
                syncHidden();
                slots[0].focus();
            };

            window.markOtpError = function () {
                slotRow.dataset.checking = 'false';
                status.textContent = 'That code was not accepted. Try again.';
                status.classList.remove('checking');
                slots.forEach(s => {
                    s.getAnimations().forEach(a => a.cancel());
                    s.classList.remove('ready', 'checking');
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

            try {
                const response = await fetch("{{ route('password.otp.verify') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
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
                errorBox.classList.remove('hidden');
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

            if (password !== password_confirmation) {
                errorBox.textContent = 'Passwords do not match.';
                errorBox.classList.remove('hidden');
                return;
            }

            try {
                const response = await fetch("{{ route('password.otp.reset') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify({ email, otp_code, password, password_confirmation })
                });
                const data = await response.json();

                if (response.ok) {
                    document.getElementById('forgotStep3').classList.add('hidden');
                    document.getElementById('forgotStep4').classList.remove('hidden');
                    setTimeout(() => { window.location.reload(); }, 3000);
                } else {
                    errorBox.textContent = data.message || 'Failed to reset password.';
                    errorBox.classList.remove('hidden');
                }
            } catch (e) {
                errorBox.textContent = 'Connection error. Please try again.';
                errorBox.classList.remove('hidden');
            }
        }

        function toggleNewPassword(id, labelId) {
            const input = document.getElementById(id);
            const label = document.getElementById(labelId);
            const visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';
            label.textContent = visible ? 'Hide' : 'Show';
        }

        function updateResetPasswordHints() {
            const password = document.getElementById('newPassword').value;
            const confirm = document.getElementById('newPasswordConfirmation').value;
            const score = [password.length >= 8, /[A-Z]/.test(password), /[0-9]/.test(password), /[^A-Za-z0-9]/.test(password)].filter(Boolean).length;
            const meter = document.getElementById('resetPasswordMeter');
            if (meter) {
                meter.style.width = `${score * 25}%`;
                meter.style.backgroundColor = score < 2 ? '#e11d48' : score < 4 ? '#d97706' : '#059669';
            }
            const hint = document.getElementById('resetPasswordHint');
            if (hint) {
                hint.textContent = score < 2 ? 'Use 8+ characters with a number or symbol.' : score < 4 ? 'Good start. Add a capital letter and symbol.' : 'Strong password.';
                hint.style.color = score < 2 ? '#be123c' : score < 4 ? '#b45309' : '#047857';
            }
            const match = document.getElementById('resetMatchHint');
            if (match) {
                match.textContent = confirm && password === confirm ? 'Passwords match.' : 'Passwords must match.';
                match.style.color = confirm && password === confirm ? '#047857' : '#64748b';
            }
        }
        document.getElementById('newPassword')?.addEventListener('input', updateResetPasswordHints);
        document.getElementById('newPasswordConfirmation')?.addEventListener('input', updateResetPasswordHints);
    </script>
</body>
</html>
