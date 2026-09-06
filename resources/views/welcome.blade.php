<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Attendance — QR check-ins for one CS department</title>
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
        body { background: linear-gradient(180deg, #eef6f1 0%, #f6f8f2 22%, #fbfbf7 45%, #f4f7f1 70%, #eef5f0 100%); color: var(--ink); }

        .nav-glass {
            background: rgba(251, 251, 247, 0.82);
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            border-bottom: 1px solid var(--line);
        }

        /* ---- hero backdrop ---- */
        .hero-mesh {
            position: absolute; inset: -10% -10% auto -10%; height: 640px;
            background:
                radial-gradient(420px 300px at 18% 20%, rgba(5,150,105,0.16), transparent 70%),
                radial-gradient(380px 280px at 82% 10%, rgba(13,148,136,0.14), transparent 70%),
                radial-gradient(320px 260px at 55% 55%, rgba(180,83,9,0.08), transparent 70%);
            filter: blur(2px);
            animation: drift 18s ease-in-out infinite alternate;
            pointer-events: none;
        }
        @keyframes drift {
            from { transform: translate3d(0,0,0) scale(1); }
            to   { transform: translate3d(-2%, 2%, 0) scale(1.05); }
        }
        .glass-panel {
            background: rgba(255,255,255,0.55);
            border: 1px solid rgba(255,255,255,0.6);
            backdrop-filter: blur(18px) saturate(160%);
            -webkit-backdrop-filter: blur(18px) saturate(160%);
        }

        /* ---- number badge ---- */
        .num-badge {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 700; font-size: 12px; letter-spacing: 0.02em;
            color: var(--accent, var(--brand));
            background: var(--accent-soft, rgba(5,150,105,0.1));
            border: 1px solid var(--accent-line, rgba(5,150,105,0.25));
            padding: 5px 10px; border-radius: 999px;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .num-badge::before {
            content: ''; width: 5px; height: 5px; border-radius: 999px;
            background: var(--accent, var(--brand));
        }

        .icon-chip {
            width: 40px; height: 40px; border-radius: 12px;
            background: var(--accent-soft, rgba(5,150,105,0.1));
            border: 1px solid var(--accent-line, rgba(5,150,105,0.22));
            color: var(--accent, var(--brand));
            display: flex; align-items: center; justify-content: center;
        }

        .feature-card {
            background: #ffffff;
            border: 1px solid var(--line);
            box-shadow: 0 20px 45px -20px rgba(16,32,26,0.12);
            position: relative;
            z-index: 1;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            inset: -22% -16%;
            background: radial-gradient(closest-side, var(--accent-soft, rgba(5,150,105,0.12)), transparent 70%);
            filter: blur(10px);
            z-index: -1;
        }

        /* ---- scroll reveals: varied, not identical ---- */
        .reveal { opacity: 0; transition: opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1); }
        .reveal[data-anim="rise"]       { transform: translateY(26px); }
        .reveal[data-anim="slide-left"] { transform: translateX(-34px) rotate(-1.2deg); }
        .reveal[data-anim="slide-right"]{ transform: translateX(34px) rotate(1.2deg); }
        .reveal[data-anim="scale"]      { transform: scale(.94) translateY(14px); }
        .reveal[data-anim="tilt"]       { transform: translateY(20px) rotate(-2deg); }
        .reveal.is-visible { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1 !important; transform: none !important; transition: none !important; }
            .hero-mesh, .anim-spin, .anim-scan, .anim-pulse, .anim-orbit, .anim-grow, .anim-stamp { animation: none !important; }
        }

        /* ---- 01 token ring ---- */
        .token-ring { animation: spin 7s linear infinite; transform-origin: center; }
        .token-ring--slow { animation: spin 11s linear infinite reverse; transform-origin: center; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ---- 02 stamp ---- */
        .anim-stamp { animation: stamp 3.4s ease-in-out infinite; transform-origin: center; }
        @keyframes stamp {
            0%, 60% { transform: scale(1) rotate(-8deg); }
            68%     { transform: scale(1.16) rotate(-8deg); }
            76%, 100% { transform: scale(1) rotate(-8deg); }
        }
        .row-check { opacity: 0; animation: rowin .5s ease forwards; }
        @keyframes rowin { to { opacity: 1; } }

        /* ---- 03 bars ---- */
        .bar { transform: scaleY(0); transform-origin: bottom; transition: transform 1s cubic-bezier(.2,.9,.2,1); }
        .bars-in .bar { transform: scaleY(1); }
        .trend-dot { opacity: 0; transition: opacity .6s ease .9s; }
        .bars-in .trend-dot { opacity: 1; }

        /* ---- 04 OTP orbit ---- */
        .otp-tile { animation: otpcycle 4.5s ease-in-out infinite; }
        .otp-tile:nth-child(1){ animation-delay: 0s; }
        .otp-tile:nth-child(2){ animation-delay: .08s; }
        .otp-tile:nth-child(3){ animation-delay: .16s; }
        .otp-tile:nth-child(4){ animation-delay: .24s; }
        @keyframes otpcycle {
            0%, 55% { transform: translateY(0) scale(1); opacity: 1; }
            72%     { transform: translateY(-10px) scale(.4); opacity: 0; }
            85%     { transform: translateY(0) scale(0); opacity: 0; }
            100%    { transform: translateY(0) scale(1); opacity: 1; }
        }
        .otp-loader { animation: spin 1.1s linear infinite; opacity: 0; }
        .otp-loader.show { animation: spin 1.1s linear infinite, loaderfade 4.5s ease-in-out infinite; }
        @keyframes loaderfade {
            0%, 60% { opacity: 0; }
            72%, 88% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* ---- 05 scan ---- */
        .anim-scan { animation: scanline 2.2s ease-in-out infinite; }
        @keyframes scanline {
            0%, 100% { transform: translateY(-30px); opacity: .3; }
            50%      { transform: translateY(30px); opacity: 1; }
        }

        /* ---- 06 sync pulse ---- */
        .anim-pulse { animation: travel 2.6s linear infinite; }
        @keyframes travel {
            0%   { left: 6%; opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { left: 88%; opacity: 0; }
        }
    </style>
</head>
<body class="min-h-screen antialiased selection:bg-emerald-600 selection:text-white overflow-x-hidden">

    <!-- Navigation -->
    <header class="nav-glass sticky top-0 z-50 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 text-white">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/>
                        <path d="M9.5 12.5L11.3 14.3L15 10.2"/>
                    </svg>
                </div>
                <span class="text-[15px] font-semibold tracking-tight">Smart Attendance</span>
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ route('login') }}" class="text-sm font-medium text-neutral-600 hover:text-emerald-700 transition">Sign in</a>
                <a href="{{ route('login') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                    Open portal
                </a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="hero-mesh"></div>
        <div class="relative mx-auto max-w-4xl px-6 pt-24 pb-20 text-center">

            <h1 class="reveal text-4xl sm:text-6xl font-bold tracking-tight leading-[1.1]" data-anim="rise">
                QR attendance built for<br class="hidden sm:block"> one CS department
            </h1>

            <p class="reveal mt-6 text-lg text-neutral-600 max-w-xl mx-auto leading-relaxed" data-anim="rise" style="transition-delay:.08s">
                Students scan a code that changes on a timer. Lecturers see who's actually in the room. No paper register, no proxy sign-ins.
            </p>

            <div class="reveal mt-9 flex flex-col items-center gap-4" data-anim="rise" style="transition-delay:.16s">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-7 py-3.5 text-[15px] font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition">
                    Get started
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>

                <div class="glass-panel rounded-full px-4 py-2 flex items-center gap-2.5 mt-1">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-60"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
                    </span>
                    <span class="text-xs text-neutral-500">Live session code</span>
                    <span id="heroToken" class="mono text-xs font-semibold tracking-widest text-emerald-700">A3F9K2</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <div id="features" class="max-w-5xl mx-auto px-6 py-8 space-y-28 sm:space-y-32">

        <!-- 01 — Token security -->
        <section class="grid md:grid-cols-2 gap-10 md:gap-14 items-center" style="--accent:#059669;--accent-soft:rgba(5,150,105,0.1);--accent-line:rgba(5,150,105,0.25)">
            <div class="reveal" data-anim="slide-left">
                <div class="flex items-center gap-3 mb-5">
                    <div class="icon-chip">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/><circle cx="12" cy="12" r="2.2"/>
                        </svg>
                    </div>
                    <span class="num-badge">01</span>
                </div>
                <h3 class="text-2xl sm:text-[28px] font-semibold leading-snug">Sessions can't be faked from across campus</h3>
                <p class="mt-4 text-neutral-600 leading-relaxed">
                    Each lecture generates a fresh code on a timer. A screenshot of last week's code, or one texted from outside the hall, simply stops working before anyone can use it.
                </p>
            </div>
            <div class="reveal feature-card rounded-2xl p-8" data-anim="scale">
                <div class="flex items-center justify-center py-4">
                    <div class="relative h-40 w-40 flex items-center justify-center">
                        <svg class="token-ring absolute" width="160" height="160" viewBox="0 0 160 160" fill="none">
                            <circle cx="80" cy="80" r="70" stroke="#05966933" stroke-width="1.5" stroke-dasharray="2 8" stroke-linecap="round"/>
                        </svg>
                        <svg class="token-ring--slow absolute" width="128" height="128" viewBox="0 0 128 128" fill="none">
                            <circle cx="64" cy="64" r="56" stroke="#05966955" stroke-width="1.5" stroke-dasharray="1 10" stroke-linecap="round"/>
                        </svg>
                        <div class="relative h-20 w-20 rounded-2xl bg-white border border-emerald-200 shadow-sm flex items-center justify-center">
                            <span class="mono text-sm font-bold text-emerald-700 tracking-wide">CSC401</span>
                        </div>
                    </div>
                </div>
                <p class="text-center text-xs text-neutral-500 mt-2">Code refreshes automatically while the session is open</p>
            </div>
        </section>

        <!-- 02 — Registration -->
        <section class="grid md:grid-cols-2 gap-10 md:gap-14 items-center" style="--accent:#B45309;--accent-soft:rgba(180,83,9,0.1);--accent-line:rgba(180,83,9,0.25)">
            <div class="reveal feature-card rounded-2xl p-8 order-2 md:order-1" data-anim="slide-left">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-neutral-900 text-white text-xs font-semibold flex items-center justify-center">JD</div>
                        <div>
                            <p class="text-sm font-semibold">Jonathan Davis</p>
                            <p class="text-xs text-neutral-500">Computer Science · 400L</p>
                        </div>
                    </div>
                    <div class="relative h-9 w-9 flex items-center justify-center">
                        <svg class="anim-stamp" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9" stroke-dasharray="2 3"/>
                            <path d="M8.5 12.5l2.2 2.2L15.5 9.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-5 space-y-2">
                    <div class="row-check flex items-center justify-between bg-amber-50/60 px-3.5 py-2.5 rounded-lg border border-amber-100" style="animation-delay:.1s">
                        <span class="mono text-xs font-medium text-neutral-700">CSC 401 · Software Eng.</span>
                        <span class="text-[11px] font-semibold text-amber-700">3 units</span>
                    </div>
                    <div class="row-check flex items-center justify-between bg-amber-50/60 px-3.5 py-2.5 rounded-lg border border-amber-100" style="animation-delay:.3s">
                        <span class="mono text-xs font-medium text-neutral-700">CSC 403 · Databases</span>
                        <span class="text-[11px] font-semibold text-amber-700">3 units</span>
                    </div>
                    <div class="row-check flex items-center justify-between bg-amber-50/60 px-3.5 py-2.5 rounded-lg border border-amber-100" style="animation-delay:.5s">
                        <span class="mono text-xs font-medium text-neutral-700">CSC 405 · Networks</span>
                        <span class="text-[11px] font-semibold text-amber-700">2 units</span>
                    </div>
                </div>
            </div>
            <div class="reveal order-1 md:order-2" data-anim="rise">
                <div class="flex items-center gap-3 mb-5">
                    <div class="icon-chip">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 3.5h6v2H9z"/><path d="M8.5 12l2 2 4-4.5"/>
                        </svg>
                    </div>
                    <span class="num-badge">02</span>
                </div>
                <h3 class="text-2xl sm:text-[28px] font-semibold leading-snug">Course forms without the queue</h3>
                <p class="mt-4 text-neutral-600 leading-relaxed">
                    Pick your level and semester, choose your courses, and the unit count adds itself up. A print-ready slip is there when you need one for the department office.
                </p>
            </div>
        </section>

        <!-- 03 — Analytics -->
        <section class="grid md:grid-cols-2 gap-10 md:gap-14 items-center" style="--accent:#4338CA;--accent-soft:rgba(67,56,202,0.1);--accent-line:rgba(67,56,202,0.25)">
            <div class="reveal" data-anim="slide-right">
                <div class="flex items-center gap-3 mb-5">
                    <div class="icon-chip">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 20V10M12 20V4M19 20v-7"/>
                        </svg>
                    </div>
                    <span class="num-badge">03</span>
                </div>
                <h3 class="text-2xl sm:text-[28px] font-semibold leading-snug">See who's showing up, at a glance</h3>
                <p class="mt-4 text-neutral-600 leading-relaxed">
                    Lecturers get a running attendance rate per course, updated the moment a student checks in — useful the week before an exam, not just at the end of semester.
                </p>
            </div>
            <div class="reveal feature-card rounded-2xl p-8 bars-container" data-anim="tilt">
                <div class="flex items-end justify-center gap-5 h-36 pt-4">
                    <div class="flex flex-col items-center gap-2">
                        <div class="bar w-10 rounded-t-md bg-indigo-200" style="height:70px;transition-delay:.05s"></div>
                        <span class="mono text-[10px] text-neutral-400">401</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="bar w-10 rounded-t-md bg-indigo-400" style="height:104px;transition-delay:.18s"></div>
                        <span class="mono text-[10px] text-neutral-400">403</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="bar w-10 rounded-t-md bg-indigo-600" style="height:118px;transition-delay:.3s"></div>
                        <span class="mono text-[10px] text-neutral-400">405</span>
                    </div>
                    <div class="trend-dot self-start -ml-2 mt-1">
                        <span class="mono text-[11px] font-semibold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100">96%</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 04 — OTP -->
        <section class="grid md:grid-cols-2 gap-10 md:gap-14 items-center" style="--accent:#BE123C;--accent-soft:rgba(190,18,60,0.1);--accent-line:rgba(190,18,60,0.25)">
            <div class="reveal feature-card rounded-2xl p-8 order-2 md:order-1" data-anim="slide-right">
                <div class="py-6 flex flex-col items-center justify-center">
                    <div class="relative flex items-center gap-2.5 h-14">
                        <div class="otp-tile h-11 w-9 rounded-lg bg-white border border-rose-200 flex items-center justify-center mono font-bold text-rose-700 text-sm">5</div>
                        <div class="otp-tile h-11 w-9 rounded-lg bg-white border border-rose-200 flex items-center justify-center mono font-bold text-rose-700 text-sm">9</div>
                        <div class="otp-tile h-11 w-9 rounded-lg bg-white border border-rose-200 flex items-center justify-center mono font-bold text-rose-700 text-sm">1</div>
                        <div class="otp-tile h-11 w-9 rounded-lg bg-white border border-rose-200 flex items-center justify-center mono font-bold text-rose-700 text-sm">4</div>
                        <svg class="otp-loader show absolute left-1/2 top-1/2" style="margin-left:-14px;margin-top:-14px" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#BE123C" stroke-width="2.2" stroke-linecap="round">
                            <path d="M12 3a9 9 0 1 1-9 9"/>
                        </svg>
                    </div>
                    <p class="text-xs text-neutral-500 mt-5">Code sent to your email · expires in 10 minutes</p>
                </div>
            </div>
            <div class="reveal order-1 md:order-2" data-anim="rise">
                <div class="flex items-center gap-3 mb-5">
                    <div class="icon-chip">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 1 1 8 0v3"/>
                        </svg>
                    </div>
                    <span class="num-badge">04</span>
                </div>
                <h3 class="text-2xl sm:text-[28px] font-semibold leading-snug">Forgot your password? Six digits, one minute</h3>
                <p class="mt-4 text-neutral-600 leading-relaxed">
                    A one-time code lands in your inbox and expires shortly after. No admin has to manually reset anyone's account.
                </p>
            </div>
        </section>

        <!-- 05 — Camera scan -->
        <section class="grid md:grid-cols-2 gap-10 md:gap-14 items-center" style="--accent:#0369A1;--accent-soft:rgba(3,105,161,0.1);--accent-line:rgba(3,105,161,0.25)">
            <div class="reveal" data-anim="slide-left">
                <div class="flex items-center gap-3 mb-5">
                    <div class="icon-chip">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 8V5a1 1 0 011-1h3M4 16v3a1 1 0 001 1h3M20 8V5a1 1 0 00-1-1h-3M20 16v3a1 1 0 01-1 1h-3"/>
                        </svg>
                    </div>
                    <span class="num-badge">05</span>
                </div>
                <h3 class="text-2xl sm:text-[28px] font-semibold leading-snug">Point, scan, done</h3>
                <p class="mt-4 text-neutral-600 leading-relaxed">
                    Nothing to install. The scanner opens straight in the browser, on a phone or a laptop, and reads the current code the moment it's in frame.
                </p>
            </div>
            <div class="reveal feature-card rounded-2xl p-8" data-anim="scale">
                <div class="flex justify-center">
                    <div class="relative h-32 w-52 rounded-xl bg-neutral-950 overflow-hidden">
                        <span class="absolute top-2.5 left-2.5 h-3.5 w-3.5 border-t-2 border-l-2 border-sky-400 rounded-tl-sm"></span>
                        <span class="absolute top-2.5 right-2.5 h-3.5 w-3.5 border-t-2 border-r-2 border-sky-400 rounded-tr-sm"></span>
                        <span class="absolute bottom-2.5 left-2.5 h-3.5 w-3.5 border-b-2 border-l-2 border-sky-400 rounded-bl-sm"></span>
                        <span class="absolute bottom-2.5 right-2.5 h-3.5 w-3.5 border-b-2 border-r-2 border-sky-400 rounded-br-sm"></span>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="#38bdf8" opacity="0.85">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                <rect x="14" y="14" width="3" height="3"/><rect x="18" y="14" width="3" height="3"/><rect x="14" y="18" width="3" height="3"/>
                            </svg>
                        </div>
                        <div class="anim-scan absolute left-0 right-0 h-[2px] bg-sky-400/80 shadow-[0_0_8px_2px_rgba(56,189,248,0.6)]"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 06 — Infra -->
        <section class="grid md:grid-cols-2 gap-10 md:gap-14 items-center" style="--accent:#6D28D9;--accent-soft:rgba(109,40,217,0.1);--accent-line:rgba(109,40,217,0.25)">
            <div class="reveal feature-card rounded-2xl p-8 order-2 md:order-1" data-anim="slide-right">
                <div class="relative flex items-center justify-between py-6 px-2">
                    <div class="flex flex-col items-center gap-2">
                        <div class="h-12 w-12 rounded-xl bg-violet-50 border border-violet-200 flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6D28D9" stroke-width="1.7"><rect x="4" y="4" width="16" height="16" rx="4"/><path d="M8 12h8M12 8v8"/></svg>
                        </div>
                        <span class="text-[11px] font-medium text-neutral-500">Laravel app</span>
                    </div>
                    <div class="relative flex-1 mx-3 h-px bg-violet-200">
                        <span class="anim-pulse absolute -top-[3px] h-[7px] w-[7px] rounded-full bg-violet-600"></span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="h-12 w-12 rounded-xl bg-violet-50 border border-violet-200 flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6D28D9" stroke-width="1.7"><ellipse cx="12" cy="6" rx="7" ry="3"/><path d="M5 6v6c0 1.7 3.1 3 7 3s7-1.3 7-3V6M5 12v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/></svg>
                        </div>
                        <span class="text-[11px] font-medium text-neutral-500">Postgres</span>
                    </div>
                </div>
            </div>
            <div class="reveal order-1 md:order-2" data-anim="rise">
                <div class="flex items-center gap-3 mb-5">
                    <div class="icon-chip">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 18a4 4 0 01-1-7.87A5.5 5.5 0 0116.9 8.5 4.5 4.5 0 0117 18H7z"/>
                        </svg>
                    </div>
                    <span class="num-badge">06</span>
                </div>
                <h3 class="text-2xl sm:text-[28px] font-semibold leading-snug">Runs on Railway, backed by Postgres</h3>
                <p class="mt-4 text-neutral-600 leading-relaxed">
                    Every check-in, registration, and profile update writes straight to a cloud database, so it's the same data whether you're on a lecture-hall wifi or your own phone later.
                </p>
            </div>
        </section>

    </div>

    <!-- Footer -->
    <footer class="border-t border-neutral-200 py-10 mt-20 text-center">
        <p class="text-xs text-neutral-400">Smart Attendance · a departmental attendance system built by <span class="font-medium text-neutral-500">Blac</span></p>
    </footer>

    <script>
        // Hero live token ticker
        (function () {
            const el = document.getElementById('heroToken');
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            function rand() {
                let s = '';
                for (let i = 0; i < 6; i++) s += chars[Math.floor(Math.random() * chars.length)];
                return s;
            }
            setInterval(() => {
                el.style.opacity = 0;
                setTimeout(() => { el.textContent = rand(); el.style.opacity = 1; }, 200);
            }, 2600);
            el.style.transition = 'opacity .2s ease';
        })();

        // Scroll reveals
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    if (entry.target.classList.contains('bars-container')) {
                        entry.target.classList.add('bars-in');
                    }
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.25 });

        document.querySelectorAll('.reveal').forEach(el => io.observe(el));
    </script>
</body>
</html>