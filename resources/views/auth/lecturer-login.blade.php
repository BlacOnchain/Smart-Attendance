<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Lecturer Login | Smart Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Sora', sans-serif; }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            background:
                radial-gradient(circle at 12% 18%, rgba(16, 185, 129, 0.32), transparent 40%),
                radial-gradient(circle at 88% 8%, rgba(45, 212, 191, 0.24), transparent 35%),
                radial-gradient(circle at 50% 95%, rgba(15, 118, 110, 0.3), transparent 45%),
                linear-gradient(160deg, #03170f 0%, #0a3a2c 45%, #0e2e2c 100%);
            background-attachment: fixed;
        }

        .orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(70px);
            opacity: 0.55;
            pointer-events: none;
            animation: floatOrb 24s ease-in-out infinite alternate;
        }
        .orb-1 { width: 420px; height: 420px; background: #14b8a6; top: -140px; left: -100px; animation-duration: 26s; }
        .orb-2 { width: 340px; height: 340px; background: #10b981; bottom: -100px; right: -80px; animation-duration: 21s; animation-delay: -6s; }
        .orb-3 { width: 240px; height: 240px; background: #2dd4bf; top: 38%; left: 58%; animation-duration: 30s; animation-delay: -12s; }

        @keyframes floatOrb {
            0%   { transform: translate(0, 0) scale(1); }
            50%  { transform: translate(30px, -25px) scale(1.08); }
            100% { transform: translate(-25px, 20px) scale(0.95); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(28px) saturate(160%);
            -webkit-backdrop-filter: blur(28px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        .glass-badge {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .glass-input::placeholder { color: rgba(255, 255, 255, 0.38); }
        .glass-input:focus {
            outline: none;
            border-color: rgba(45, 212, 191, 0.75);
            background: rgba(255, 255, 255, 0.085);
            box-shadow: 0 0 0 4px rgba(45, 212, 191, 0.16);
        }

        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0; left: -75%;
            width: 50%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.55), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }
        .btn-shine:hover::after { left: 125%; }

        .btn-nudge { transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease; }
        .btn-nudge:hover { transform: translateY(-2px); }

        .lift-hover { transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease; }
        .lift-hover:hover { transform: translateY(-3px); background: rgba(255, 255, 255, 0.14); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .stagger-up { animation: fadeInUp 0.6s ease both; animation-delay: var(--d, 0s); }

        @media (max-width: 640px) {
            .orb-1 { width: 260px; height: 260px; }
            .orb-2 { width: 220px; height: 220px; }
            .orb-3 { width: 160px; height: 160px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .orb { animation: none !important; }
            .stagger-up { animation: none !important; opacity: 1 !important; }
            .lift-hover, .btn-nudge { transition: none !important; }
        }
    </style>
</head>
<body class="min-h-screen text-white">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="relative z-10 grid min-h-screen lg:grid-cols-2">
        <!-- Glass login card -->
        <section class="flex items-center justify-center px-4 py-10 sm:px-6 sm:py-12" style="padding-top: max(2.5rem, env(safe-area-inset-top)); padding-bottom: max(2.5rem, env(safe-area-inset-bottom));">
            <div class="w-full max-w-md">
                <div class="stagger-up mb-8 flex items-center gap-4" style="--d: 0s">
                    <div class="glass-badge flex h-16 w-16 items-center justify-center rounded-2xl p-1.5 shadow-lg shadow-emerald-950/20">
                        <img src="{{ asset('images/smart-attendance-logo.png') }}" alt="Smart Attendance logo" class="h-full w-full rounded-xl object-cover">
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.34em] text-teal-200/80">Smart Attendance</p>
                        <h1 class="font-display text-2xl font-bold text-white">Lecturer Sign In</h1>
                    </div>
                </div>

                <div class="glass-card stagger-up rounded-[28px] p-6 sm:p-10" style="--d: 0.08s">
                    <div class="glass-badge mb-5 inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-[0.18em] text-teal-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-teal-300"></span>
                        Lecturer Portal
                    </div>

                    <h2 class="font-display text-3xl font-bold text-white">Welcome back</h2>
                    <p class="mt-2 text-sm leading-6 text-white/60">Use your lecturer account to open sessions and track attendance.</p>

                    @if ($errors->any())
                        <div class="mt-6 rounded-2xl border border-red-400/30 bg-red-500/10 p-4 text-sm text-red-200">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('lecturer.login.submit') }}" method="POST" class="mt-7 space-y-4">
                        @csrf
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com"
                                   class="glass-input w-full rounded-2xl px-4 py-3">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Password</label>
                            <div class="relative">
                                <input type="password" id="passwordInput" name="password" required placeholder="••••••••"
                                       class="glass-input w-full rounded-2xl px-4 py-3 pr-11">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-white/50 hover:text-white/80" aria-label="Toggle password visibility">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn-shine btn-nudge mt-2 w-full rounded-2xl bg-gradient-to-r from-teal-400 to-emerald-500 px-4 py-3.5 font-semibold text-slate-950 shadow-lg shadow-teal-500/20">
                            Sign in as Lecturer
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-white/50">
                        Want student login?
                        <a href="{{ route('login') }}" class="font-medium text-emerald-300 hover:text-emerald-200">Go back</a>
                    </p>
                </div>
            </div>
        </section>

        <!-- Brand / marketing side -->
        <aside class="hidden lg:flex lg:flex-col lg:justify-between lg:px-14 lg:py-14">
            <div class="stagger-up max-w-xl" style="--d: 0.12s">
                <div class="glass-badge inline-flex h-20 w-20 items-center justify-center rounded-3xl p-2 shadow-2xl shadow-black/20">
                    <img src="{{ asset('images/smart-attendance-logo.png') }}" alt="Smart Attendance logo" class="h-full w-full rounded-2xl object-cover">
                </div>
                <h2 class="font-display mt-9 text-5xl font-bold leading-tight text-white">Lecturer tools for live sessions.</h2>
                <p class="mt-5 text-lg leading-8 text-emerald-50/70">
                    Start QR sessions, manage attendance, and keep the classroom flow simple and organised.
                </p>
            </div>

            <div class="stagger-up grid gap-4 sm:grid-cols-3" style="--d: 0.2s">
                <div class="glass-badge lift-hover rounded-3xl p-5">
                    <p class="text-sm text-emerald-100/70">Sessions</p>
                    <p class="font-display mt-2 text-2xl font-semibold text-white">Live</p>
                </div>
                <div class="glass-badge lift-hover rounded-3xl p-5">
                    <p class="text-sm text-emerald-100/70">Students</p>
                    <p class="font-display mt-2 text-2xl font-semibold text-white">Check-in</p>
                </div>
                <div class="glass-badge lift-hover rounded-3xl p-5">
                    <p class="text-sm text-emerald-100/70">Course</p>
                    <p class="font-display mt-2 text-2xl font-semibold text-white">QR Code</p>
                </div>
            </div>
        </aside>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>