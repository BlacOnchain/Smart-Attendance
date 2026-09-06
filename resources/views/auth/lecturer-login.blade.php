<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Lecturer Sign In | Smart Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #10201a;
            --paper: #fbfbf7;
            --line: #e4e6df;
            --brand: #0d9488;
            --brand-dark: #0f766e;
        }
        * { font-family: 'IBM Plex Sans', system-ui, sans-serif; }
        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }
        body { background: linear-gradient(160deg, #e9f4ec 0%, #f6f8f2 48%, #eef6f1 100%); color: var(--ink); min-height: 100vh; overflow-x: hidden; }

        .auth-mesh {
            position: absolute; inset: 0;
            background:
                radial-gradient(760px 620px at 10% 2%, rgba(13,148,136,0.40), transparent 62%),
                radial-gradient(700px 580px at 92% 4%, rgba(5,150,105,0.26), transparent 62%),
                radial-gradient(680px 560px at 48% 98%, rgba(67,56,202,0.18), transparent 62%);
            filter: blur(4px);
            animation: drift 22s ease-in-out infinite alternate;
            pointer-events: none;
        }
        @keyframes drift {
            from { transform: translate3d(0,0,0) scale(1); }
            to   { transform: translate3d(2%, -2%, 0) scale(1.06); }
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
            background: rgba(13,148,136,0.1);
            border: 1px solid rgba(13,148,136,0.22);
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
            background: rgba(13,148,136,0.1);
            border: 1px solid rgba(13,148,136,0.22);
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
            border-color: rgba(13,148,136,0.55);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(13,148,136,0.12);
        }

        .btn-nudge { transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease; }
        .btn-nudge:hover { transform: translateY(-2px); }

        .lift-hover { transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease; }
        .lift-hover:hover { transform: translateY(-3px); background: rgba(255,255,255,0.55); }

        @keyframes riseIn       { from { opacity:0; transform: translateY(22px); } to { opacity:1; transform:none; } }
        @keyframes scaleIn      { from { opacity:0; transform: scale(.96) translateY(12px); } to { opacity:1; transform:none; } }
        @keyframes slideRightIn { from { opacity:0; transform: translateX(30px); } to { opacity:1; transform:none; } }
        .anim-rise        { animation: riseIn .6s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d,0s); }
        .anim-scale        { animation: scaleIn .6s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d,0s); }
        .anim-slide-right { animation: slideRightIn .6s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d,0s); }

        @media (prefers-reduced-motion: reduce) {
            .auth-mesh { animation: none !important; }
            .anim-rise, .anim-scale, .anim-slide-right { animation: none !important; opacity: 1 !important; transform: none !important; }
            .lift-hover, .btn-nudge { transition: none !important; }
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
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl text-white" style="background: var(--brand)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/>
                                <path d="M9.5 12.5L11.3 14.3L15 10.2"/>
                            </svg>
                        </div>
                        <span class="text-[15px] font-semibold tracking-tight">Smart Attendance</span>
                    </div>

                    <div class="glass-panel anim-scale rounded-[28px] p-6 sm:p-10" style="--d: 0.08s">
                        <span class="tag-badge">Lecturer portal</span>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight">Welcome back</h2>
                        <p class="mt-2 text-sm leading-6" style="color:#5b6660">Sign in to open a session and see who's checked in.</p>

                        @if ($errors->any())
                            <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('lecturer.login.submit') }}" method="POST" class="mt-7 space-y-4">
                            @csrf
                            <div>
                                <label class="field-label">Email address</label>
                                <div class="relative">
                                    <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 6.5L12 13l8.5-6.5"/></svg>
                                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com"
                                           class="glass-input w-full rounded-2xl pl-11 pr-4 py-3">
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Password</label>
                                <div class="relative">
                                    <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4.5" y="10.5" width="15" height="9.5" rx="2"/><path d="M8 10.5V7.5a4 4 0 118 0v3"/></svg>
                                    <input type="password" id="passwordInput" name="password" required placeholder="••••••••"
                                           class="glass-input w-full rounded-2xl pl-11 pr-11 py-3">
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 hover:opacity-70" style="color:#7a8580" aria-label="Toggle password visibility">
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn-nudge mt-2 w-full rounded-2xl px-4 py-3.5 font-semibold text-white shadow-lg transition" style="background: var(--brand); box-shadow: 0 10px 25px -8px rgba(13,148,136,0.4);" onmouseover="this.style.background='var(--brand-dark)'" onmouseout="this.style.background='var(--brand)'">
                                Sign in as lecturer
                            </button>
                        </form>

                        <p class="mt-6 text-center text-sm" style="color:#7a8580">
                            Want student login?
                            <a href="{{ route('login') }}" class="font-medium" style="color: var(--brand-dark)">Go back</a>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Marketing side -->
            <aside class="hidden lg:flex lg:flex-col lg:justify-between lg:px-14 lg:py-14">
                <div class="anim-slide-right max-w-xl" style="--d: 0.12s">
                    <span class="tag-badge">Smart Attendance</span>
                    <h2 class="mt-6 text-5xl font-bold leading-tight tracking-tight">Run the session, not the paperwork.</h2>
                    <p class="mt-5 text-lg leading-8" style="color:#4b564f">
                        Open a live QR session, watch check-ins land in real time, and pull an attendance rate the moment class ends.
                    </p>
                </div>

                <div class="anim-scale glass-panel rounded-2xl p-5 flex items-center gap-3 max-w-sm" style="--d: 0.16s">
                    <span class="relative flex h-2.5 w-2.5 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full" style="background: var(--brand); opacity:.6"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5" style="background: var(--brand)"></span>
                    </span>
                    <span class="text-sm" style="color:#5b6660">CSC 401 · session open</span>
                    <span class="mono text-sm font-semibold ml-auto" style="color: var(--brand-dark)">18 checked in</span>
                </div>

                <div class="anim-slide-right grid gap-4 sm:grid-cols-3" style="--d: 0.24s">
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/><circle cx="12" cy="12" r="2.2"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Sessions</p>
                        <p class="mt-1 text-xl font-semibold">Live</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Students</p>
                        <p class="mt-1 text-xl font-semibold">Check-in</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="3"/><path d="M8 12h8M12 8v8"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Course</p>
                        <p class="mt-1 text-xl font-semibold">QR code</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>