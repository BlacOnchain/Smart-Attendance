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

        @keyframes floatBob {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .float-bob {
            animation: floatBob 5s ease-in-out infinite;
        }
        .step-row {
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        }
        .step-row .step-num {
            display: flex; align-items: center; justify-content: center;
            width: 26px; height: 26px; border-radius: 999px;
            background: var(--brand); color: #fff;
            font-size: 11px; font-weight: 700; flex-shrink: 0;
        }
        .step-row .step-label {
            font-size: 13.5px; font-weight: 500; color: #5b6660;
        }
        .step-row .step-arrow { color: #c8cec3; font-size: 13px; }

        @media (prefers-reduced-motion: reduce) {
            .float-bob { animation: none !important; }
            .auth-mesh { animation: none !important; }
            .anim-rise, .anim-scale, .anim-slide-left { animation: none !important; opacity: 1 !important; transform: none !important; }
            .lift-hover, .btn-nudge { transition: none !important; }
        }

        /* ---- OTP slot inputs + verification feedback, restyled for the light palette ---- */
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
        @media (max-width: 380px) {
            .otp-slot { width: 38px; height: 48px; font-size: 18px; border-radius: 11px; }
            #otpSlotRow { gap: 6px; }
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

        /* Split auth treatment based on the supplied reference. */
        body.auth-page { background: #f6f6f4; color: #f8fafc; }
        .auth-layout { max-width: none; }
        .auth-back { position: fixed; z-index: 30; top: 18px; left: 20px; display: grid; place-items: center; width: 62px; height: 62px; border-radius: 0 0 18px 0; background: #fff; color: #111827; font-size: 38px; line-height: 1; box-shadow: 0 8px 22px rgba(15,23,42,.08); transition: transform .2s ease; }
        .auth-back:hover { transform: translateX(-3px); }
        .auth-form-pane { background: #191a1f; color: #f8fafc; }
        .auth-form-pane > div { max-width: 470px; }
        .auth-form-pane .glass-panel { background: transparent; border: 0; box-shadow: none; backdrop-filter: none; padding: 0 !important; overflow: visible; }
        .auth-form-pane .glass-panel::before { display: none; }
        .auth-form-pane .tag-badge { color: #a8aab4; background: transparent; border: 0; padding: 0; font-family: 'IBM Plex Sans', sans-serif; font-size: 12px; text-transform: uppercase; letter-spacing: .22em; }
        .auth-form-pane .tag-badge::before { display: none; }
        .auth-form-pane h2 { color: #f8fafc; font-size: clamp(2rem, 5vw, 3rem); }
        .auth-form-pane p[style] { color: #a6a8b1 !important; }
        .auth-form-pane .field-label { color: #9b9da6; font-size: 11px; text-transform: uppercase; letter-spacing: .06em; }
        .auth-form-pane .glass-input { border: 0; border-bottom: 1px solid #4a4b52; border-radius: 0; background: transparent; color: #f8fafc; box-shadow: none; padding-left: 0; }
        .auth-form-pane .glass-input:focus { border-bottom-color: #a56be8; box-shadow: 0 2px 0 #a56be8; background: transparent; }
        .auth-form-pane .glass-input::placeholder { color: #686a73; }
        .auth-form-pane .input-icon { display: none; }
        .auth-form-pane .btn-nudge { border-radius: 8px; background: #a56be8; box-shadow: 0 12px 24px rgba(165,107,232,.22); }
        .auth-form-pane .btn-nudge:hover { background: #9258db; }
        .auth-form-pane a { color: #c49df4; }
        .auth-form-pane a:hover { color: #e1ccff; }
        .auth-form-pane .lift-hover { border-color: #45464d !important; background: transparent !important; color: #d5d6db !important; border-radius: 8px; }
        .auth-form-pane .lift-hover:hover { border-color: #a56be8 !important; }
        .auth-form-pane input[type="checkbox"] { accent-color: #a56be8; }
        .auth-art-pane { display: flex !important; position: relative; overflow: hidden; background: linear-gradient(145deg, #8750d4 0%, #9b62e6 48%, #b27bf0 100%); color: #fff; }
        .auth-art-pane::before, .auth-art-pane::after { content: ''; position: absolute; border-radius: 999px; background: rgba(255,255,255,.08); pointer-events: none; }
        .auth-art-pane::before { width: 390px; height: 210px; top: 7%; right: -100px; transform: rotate(-20deg); }
        .auth-art-pane::after { width: 520px; height: 260px; bottom: 7%; left: -170px; transform: rotate(18deg); }
        .auth-art-pane > * { position: relative; z-index: 1; }
        .auth-art-pane .tag-badge { color: rgba(255,255,255,.78); background: transparent; border: 0; padding: 0; }
        .auth-art-pane .tag-badge::before { background: #fff; }
        .auth-art-pane h2 { color: #fff; max-width: 650px; font-size: clamp(2.7rem, 5vw, 4.7rem); }
        .auth-art-pane h2 span { font-weight: 400; }
        .auth-art-pane p, .auth-art-pane .step-label { color: rgba(255,255,255,.76) !important; }
        .auth-art-pane .step-num { background: #fff; color: #8750d4; }
        .auth-art-pane .step-arrow { color: rgba(255,255,255,.55); }
        .auth-art-visual { display: flex; align-items: center; gap: clamp(1rem, 3vw, 2rem); margin: 1.5rem 0; }
        .auth-visual-orbit { position: relative; display: grid; place-items: center; width: clamp(170px, 22vw, 260px); height: clamp(170px, 22vw, 260px); flex: 0 0 auto; }
        .auth-visual-orbit::before { content: ''; position: absolute; inset: 8%; border: 1px solid rgba(255,255,255,.25); border-radius: 42% 58% 56% 44%; transform: rotate(25deg); }
        .auth-visual-orbit::after { content: ''; position: absolute; inset: 0; border: 1px dashed rgba(255,255,255,.2); border-radius: 50%; transform: rotate(-20deg); }
        .auth-art-visual img { width: 78%; height: 78%; object-fit: contain; position: relative; z-index: 1; filter: drop-shadow(0 24px 24px rgba(44,19,83,.22)); animation: shieldFloat 5s ease-in-out infinite; }
        .auth-checkmark { position: absolute; z-index: 2; right: 5%; bottom: 10%; display: grid; place-items: center; width: 38px; height: 38px; border: 3px solid #8750d4; border-radius: 50%; background: #fff; color: #1ba978; font-size: 1.35rem; font-weight: 800; }
        .auth-preview-card { width: min(205px, 42vw); padding: 1rem; border: 1px solid rgba(255,255,255,.22); border-radius: 18px; background: rgba(30,14,60,.2); box-shadow: 0 20px 35px rgba(44,19,83,.14); }
        .auth-preview-card p { margin: 0; color: rgba(255,255,255,.7) !important; font-size: .73rem; }
        .auth-preview-card strong { display: block; margin: .3rem 0 .6rem; color: #fff; font-size: 2rem; line-height: 1; }
        .auth-progress { height: 7px; overflow: hidden; border-radius: 999px; background: rgba(255,255,255,.2); }
        .auth-progress span { display: block; width: 92%; height: 100%; border-radius: inherit; background: #b9f4d8; }
        .auth-preview-card > div:last-child { display: flex; justify-content: space-between; gap: .5rem; margin-top: .65rem; color: #b9f4d8; font-size: .65rem; }
        .auth-preview-card b { color: rgba(255,255,255,.75); font-weight: 500; text-align: right; }
        @keyframes shieldFloat { 0%, 100% { transform: translateY(0) rotate(-2deg); } 50% { transform: translateY(-10px) rotate(2deg); } }
        .auth-art-pane .glass-panel, .auth-art-pane .glass-chip { background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.18); box-shadow: none; color: #fff; }
        .auth-art-pane .glass-panel::before { display: none; }
        .auth-art-pane > .glass-panel { display: none; }
        .auth-art-pane .chip-icon { background: rgba(255,255,255,.18); border-color: rgba(255,255,255,.2); color: #fff; }
        .auth-art-pane .glass-chip p, .auth-art-pane .glass-panel p { color: rgba(255,255,255,.75) !important; }
        @media (max-width: 1023px) {
            .auth-layout { display: flex; flex-direction: column; }
            .auth-form-pane { min-height: 100svh; padding-top: 6.2rem !important; }
            .auth-art-pane { min-height: 360px; padding: 3.5rem 1.5rem !important; }
            .auth-art-pane .text-5xl { font-size: 2.4rem; }
            .auth-art-pane .grid { display: none; }
            .auth-art-visual { margin-top: 2rem; }
        }
        @media (max-width: 520px) {
            .auth-back { width: 54px; height: 54px; top: 0; left: 8px; font-size: 32px; }
            .auth-form-pane { padding-left: 1.35rem !important; padding-right: 1.35rem !important; }
            .auth-art-visual { gap: .8rem; }
            .auth-visual-orbit { width: 135px; height: 135px; }
            .auth-preview-card { width: 165px; }
        }
    </style>
</head>
<body class="auth-page">
    <div class="relative min-h-screen overflow-hidden">
        <div class="auth-mesh"></div>
        <div class="grain"></div>

        <a href="{{ route('home') }}" class="auth-back" aria-label="Back to home">←</a>
        <div class="relative z-10 mx-auto grid min-h-screen max-w-7xl lg:grid-cols-2 auth-layout">
            <!-- Sign-in panel -->
            <section class="flex items-center justify-center px-4 py-10 sm:px-6 sm:py-12 auth-form-pane" style="padding-top: max(2.5rem, env(safe-area-inset-top)); padding-bottom: max(2.5rem, env(safe-area-inset-bottom));">
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
                                <button type="button" onclick="openForgotModal()" class="font-medium text-emerald-700 hover:text-emerald-800 bg-transparent border-none cursor-pointer">Forgot password?</button>
                            </div>

                            <button id="studentLoginButton" type="submit" class="btn-nudge w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition">
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
            <aside class="hidden lg:flex lg:flex-col lg:justify-between lg:px-14 lg:py-14 auth-art-pane">
                <div class="anim-slide-left max-w-xl" style="--d: 0.12s">
                    <span class="tag-badge">Smart Attendance</span>
                    <h2 class="mt-6 text-5xl font-bold leading-tight tracking-tight">Welcome to<br><span>student portal</span></h2>
                    <p class="mt-5 text-lg leading-8" style="color:#4b564f">
                        Sign in to access your timetable, courses, and secure attendance check-ins.
                    </p>
                    <div class="step-row anim-slide-left mt-6" style="--d: 0.14s">
                        <span class="step-num">1</span><span class="step-label">Scan</span>
                        <span class="step-arrow">→</span>
                        <span class="step-num">2</span><span class="step-label">Verify</span>
                        <span class="step-arrow">→</span>
                        <span class="step-num">3</span><span class="step-label">Done</span>
                    </div>
                </div>

                <div class="auth-art-visual anim-scale" style="--d: 0.18s">
                    <div class="auth-visual-orbit">
                        <img src="{{ asset('images/logo-3d-512.png') }}" alt="Smart Attendance shield" loading="eager">
                        <span class="auth-checkmark">✓</span>
                    </div>
                    <div class="auth-preview-card">
                        <p>Attendance overview</p>
                        <strong>92%</strong>
                        <div class="auth-progress"><span></span></div>
                        <div><span>On track</span><b>3 classes today</b></div>
                    </div>
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
                        <div class="chip-icon float-bob" style="animation-delay: 0s"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Students</p>
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
                        <button type="button" onclick="sendOtpRequest()" id="sendOtpBtn" class="w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white hover:bg-emerald-700 transition">
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
                    <p class="text-sm mb-5" style="color:#5b6660">Use 8 or more characters. A capital letter, number, and symbol make it stronger.</p>

                    <div id="step3Error" class="hidden mb-4 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-700"></div>

                    <div class="space-y-4">
                        <div>
                            <label class="field-label">New password</label>
                            <div class="relative"><input type="password" id="newPassword" required minlength="8" autocomplete="new-password" placeholder="Create a strong password" class="glass-input w-full rounded-2xl px-4 py-3 pr-12"><button type="button" onclick="toggleNewPassword('newPassword', 'newEye1')" class="absolute inset-y-0 right-0 px-4 text-slate-500" aria-label="Show new password"><span id="newEye1">Show</span></button></div>
                            <div class="password-meter mt-2"><span id="resetPasswordMeter"></span></div><p id="resetPasswordHint" class="mt-1 text-[11px] text-slate-500">Use at least 8 characters.</p>
                        </div>
                        <div>
                            <label class="field-label">Confirm new password</label>
                            <div class="relative"><input type="password" id="newPasswordConfirmation" required minlength="8" autocomplete="new-password" placeholder="Repeat your password" class="glass-input w-full rounded-2xl px-4 py-3 pr-12"><button type="button" onclick="toggleNewPassword('newPasswordConfirmation', 'newEye2')" class="absolute inset-y-0 right-0 px-4 text-slate-500" aria-label="Show password confirmation"><span id="newEye2">Show</span></button></div><p id="resetMatchHint" class="mt-1 text-[11px] text-slate-500">Passwords must match.</p>
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

        // --- OTP slot input + verification animation ---
        (function () {
            const slots = Array.from(document.querySelectorAll('.otp-slot'));
            const hiddenOtp = document.getElementById('resetOtp');
            const slotRow = document.getElementById('otpSlotRow');
            const status = document.getElementById('otpStatus');

            function syncHidden() {
                hiddenOtp.value = slots.map(s => s.value).join('');
            }

            slots.forEach((slot, i) => {
                slot.addEventListener('input', () => {
                    slot.value = slot.value.replace(/[^0-9]/g, '').slice(0, 1);
                    slot.classList.toggle('filled', slot.value !== '');
                    slot.classList.remove('ready');
                    syncHidden();

                    if (slot.value && i < slots.length - 1) {
                        slots[i + 1].focus();
                    }

                    if (slots.every(s => s.value !== '')) {
                        verifyWithAnimation();
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
                        verifyWithAnimation();
                    } else if (slots[pasted.length]) {
                        slots[pasted.length].focus();
                    }
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

            if (!password || password.length < 8) {
                errorBox.textContent = 'Password must be at least 8 characters long.';
                errorBox.classList.remove('hidden');
                return;
            }

            if (password !== password_confirmation) {
                errorBox.textContent = 'Passwords do not match.';
                errorBox.classList.remove('hidden');
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
                    errorBox.classList.remove('hidden');
                }
            } catch (e) {
                errorBox.textContent = 'Connection error. Please try again.';
                errorBox.classList.remove('hidden');
            }
        }

        function toggleNewPassword(id, labelId) { const input = document.getElementById(id); const label = document.getElementById(labelId); const visible = input.type === 'password'; input.type = visible ? 'text' : 'password'; label.textContent = visible ? 'Hide' : 'Show'; }
        function updateResetPasswordHints() { const password = document.getElementById('newPassword').value; const confirm = document.getElementById('newPasswordConfirmation').value; const score = [password.length >= 8, /[A-Z]/.test(password), /[0-9]/.test(password), /[^A-Za-z0-9]/.test(password)].filter(Boolean).length; const meter = document.getElementById('resetPasswordMeter'); meter.style.width = `${score * 25}%`; meter.style.backgroundColor = score < 2 ? '#e11d48' : score < 4 ? '#d97706' : '#059669'; const hint = document.getElementById('resetPasswordHint'); hint.textContent = score < 2 ? 'Use 8+ characters with a number or symbol.' : score < 4 ? 'Good start. Add a capital letter and symbol.' : 'Strong password.'; hint.style.color = score < 2 ? '#be123c' : score < 4 ? '#b45309' : '#047857'; const match = document.getElementById('resetMatchHint'); match.textContent = confirm && password === confirm ? 'Passwords match.' : 'Passwords must match.'; match.style.color = confirm && password === confirm ? '#047857' : '#64748b'; }
        document.getElementById('newPassword')?.addEventListener('input', updateResetPasswordHints); document.getElementById('newPasswordConfirmation')?.addEventListener('input', updateResetPasswordHints);
    </script>
</body>
</html>
