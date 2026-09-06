<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Create Account | Smart Attendance</title>
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

        @keyframes riseIn        { from { opacity:0; transform: translateY(22px); } to { opacity:1; transform:none; } }
        @keyframes scaleIn       { from { opacity:0; transform: scale(.96) translateY(12px); } to { opacity:1; transform:none; } }
        @keyframes slideRightIn  { from { opacity:0; transform: translateX(30px); } to { opacity:1; transform:none; } }
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
            <!-- Register panel -->
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
                        <span class="tag-badge">Create account</span>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight">Get started</h2>
                        <p class="mt-2 text-sm leading-6" style="color:#5b6660">Set up your profile to register courses and start checking in.</p>

                        @if ($errors->any())
                            <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('register.submit') }}" method="POST" class="mt-7 space-y-4">
                            @csrf
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="field-label">First name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" required placeholder="Ada"
                                           class="glass-input w-full rounded-2xl px-4 py-3">
                                </div>
                                <div>
                                    <label class="field-label">Last name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" required placeholder="Lovelace"
                                           class="glass-input w-full rounded-2xl px-4 py-3">
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Email address</label>
                                <div class="relative">
                                    <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 6.5L12 13l8.5-6.5"/></svg>
                                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com"
                                           class="glass-input w-full rounded-2xl pl-11 pr-4 py-3">
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Phone number</label>
                                <div class="relative">
                                    <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6.5 3.5c1 2 1.7 3.4 2.5 4.3-.8 1-1.5 1.6-2 2 1 2.4 2.3 3.7 4.7 4.7.4-.5 1-1.2 2-2 .9.8 2.3 1.5 4.3 2.5v2.7c0 1-1 1.7-2 1.5-7-1.4-11.7-6.1-13.1-13.1-.2-1 .5-2 1.5-2h2.1z"/></svg>
                                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="080..."
                                           class="glass-input w-full rounded-2xl pl-11 pr-4 py-3">
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="field-label">Password</label>
                                    <div class="relative">
                                        <input type="password" id="passwordInput" name="password" required placeholder="••••••••"
                                               class="glass-input w-full rounded-2xl px-4 py-3 pr-11">
                                        <button type="button" onclick="togglePassword('passwordInput', 'eyeIcon1')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 hover:opacity-70" style="color:#7a8580" aria-label="Toggle password visibility">
                                            <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Confirm password</label>
                                    <div class="relative">
                                        <input type="password" id="passwordConfirmInput" name="password_confirmation" required placeholder="••••••••"
                                               class="glass-input w-full rounded-2xl px-4 py-3 pr-11">
                                        <button type="button" onclick="togglePassword('passwordConfirmInput', 'eyeIcon2')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 hover:opacity-70" style="color:#7a8580" aria-label="Toggle password visibility">
                                            <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <label class="flex items-center gap-2 pt-1 text-sm" style="color:#5b6660">
                                <input type="checkbox" required class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                I agree to the Terms and Conditions
                            </label>

                            <button type="submit" class="btn-nudge w-full rounded-2xl bg-emerald-600 px-4 py-3.5 font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition">
                                Create account
                            </button>
                        </form>

                        <p class="mt-6 text-center text-sm" style="color:#7a8580">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-emerald-700 hover:text-emerald-800">Sign in</a>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Marketing side -->
            <aside class="hidden lg:flex lg:flex-col lg:justify-between lg:px-14 lg:py-14">
                <div class="anim-slide-right max-w-xl" style="--d: 0.12s">
                    <span class="tag-badge">Smart Attendance</span>
                    <h2 class="mt-6 text-5xl font-bold leading-tight tracking-tight">Your department, one clean portal.</h2>
                    <p class="mt-5 text-lg leading-8" style="color:#4b564f">
                        Build your profile, pick your level and semester, and register the courses you're actually taking this term.
                    </p>
                </div>

                <div class="anim-scale glass-panel rounded-2xl p-5 flex items-center gap-3 max-w-sm" style="--d: 0.16s">
                    <div class="h-9 w-9 rounded-full bg-emerald-600 text-white text-xs font-semibold flex items-center justify-center shrink-0">JD</div>
                    <div>
                        <p class="text-sm font-semibold">Jonathan Davis</p>
                        <p class="text-xs" style="color:#7a8580">Computer Science · 400L</p>
                    </div>
                    <span class="ml-auto text-[11px] font-semibold px-2.5 py-1 rounded-full" style="background: rgba(5,150,105,0.1); color: var(--brand-dark)">Verified</span>
                </div>

                <div class="anim-slide-right grid gap-4 sm:grid-cols-3" style="--d: 0.24s">
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Profile</p>
                        <p class="mt-1 text-xl font-semibold">Setup</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 20V10M12 20V4M19 20v-7"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Level</p>
                        <p class="mt-1 text-xl font-semibold">ND / HND</p>
                    </div>
                    <div class="glass-chip lift-hover rounded-2xl p-5">
                        <div class="chip-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="2.5"/><path d="M4 9.5h16M9 4v4.5"/></svg></div>
                        <p class="text-sm" style="color:#5b6660">Timetable</p>
                        <p class="mt-1 text-xl font-semibold">Courses</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>