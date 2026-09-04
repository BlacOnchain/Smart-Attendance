<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Smart Attendance | Sign In</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                radial-gradient(circle at 12% 18%, rgba(16, 185, 129, 0.35), transparent 40%),
                radial-gradient(circle at 88% 8%, rgba(45, 212, 191, 0.22), transparent 35%),
                radial-gradient(circle at 50% 95%, rgba(5, 150, 105, 0.28), transparent 45%),
                linear-gradient(160deg, #031b10 0%, #063d26 45%, #0a2e22 100%);
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
        .orb-1 { width: 420px; height: 420px; background: #10b981; top: -140px; left: -100px; animation-duration: 26s; }
        .orb-2 { width: 340px; height: 340px; background: #2dd4bf; bottom: -100px; right: -80px; animation-duration: 21s; animation-delay: -6s; }
        .orb-3 { width: 240px; height: 240px; background: #34d399; top: 38%; left: 58%; animation-duration: 30s; animation-delay: -12s; }

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
            border-color: rgba(52, 211, 153, 0.7);
            background: rgba(255, 255, 255, 0.085);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.16);
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

        @keyframes scaleUp {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }
        .animate-scale-up { animation: scaleUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

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

        /* OTP SLOT INPUTS + ORBIT COLLAPSE VERIFICATION ANIMATION */
        .otp-slot {
            width: 44px;
            height: 54px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .otp-slot:focus {
            border-color: rgba(16, 185, 129, 0.75);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.16);
        }
        .otp-slot.filled {
            border-color: rgba(16, 185, 129, 0.6);
            background: rgba(16, 185, 129, 0.1);
        }
        .otp-slot.error {
            border-color: rgba(248, 113, 113, 0.85);
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
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        .orbit-ring {
            width: 110px;
            height: 110px;
            fill: none;
            stroke: rgba(16, 185, 129, 0.4);
            stroke-width: 1.5;
            stroke-dasharray: 2 6;
            animation: orbitSpin 2.4s linear infinite;
        }
        @keyframes orbitSpin {
            to { transform: rotate(360deg); }
        }
        .orbit_hub {
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 18px 4px rgba(16, 185, 129, 0.55);
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
                        <p class="text-xs uppercase tracking-[0.34em] text-emerald-200/80">Smart Attendance</p>
                        <h1 class="font-display text-2xl font-bold text-white">Student Sign In</h1>
                    </div>
                </div>

                <div class="glass-card stagger-up rounded-[28px] p-6 sm:p-10" style="--d: 0.08s">
                    <h2 class="font-display text-3xl font-bold text-white">Welcome back</h2>
                    <p class="mt-2 text-sm leading-6 text-white/60">Use your student account to open your dashboard and timetable.</p>

                    @if (session('success'))
                        <div class="mt-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 rounded-2xl border border-red-400/30 bg-red-500/10 p-4 text-sm text-red-200">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST" autocomplete="off" class="mt-7 space-y-4">
                        @csrf
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Email Address</label>
                            <input type="email" name="email" id="emailInput" value="" autocomplete="off" required placeholder="you@example.com"
                                   class="glass-input w-full rounded-2xl px-4 py-3">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Password</label>
                            <div class="relative">
                                <input type="password" id="passwordInput" name="password" autocomplete="new-password" required placeholder="••••••••"
                                       class="glass-input w-full rounded-2xl px-4 py-3 pr-11">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-white/50 hover:text-white/80" aria-label="Toggle password visibility">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-sm pt-1">
                            <label class="flex items-center gap-2 text-white/55">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/30 bg-white/5 text-emerald-500 focus:ring-emerald-400">
                                Remember me
                            </label>
                            <button type="button" onclick="openForgotModal()" class="font-medium text-emerald-300 hover:text-emerald-200 bg-transparent border-none cursor-pointer">Forgot password?</button>
                        </div>

                        <button type="submit" class="btn-shine btn-nudge w-full rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-400 px-4 py-3.5 font-semibold text-slate-950 shadow-lg shadow-emerald-500/20">
                            Sign in
                        </button>
                    </form>

                    <a href="{{ route('lecturer.login') }}" class="lift-hover mt-4 block w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-center font-semibold text-white/85">
                        Log in as Lecturer
                    </a>

                    <p class="mt-6 text-center text-sm text-white/50">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-medium text-emerald-300 hover:text-emerald-200">Sign up</a>
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
                <h2 class="font-display mt-9 text-5xl font-bold leading-tight text-white">Simple attendance for schools.</h2>
                <p class="mt-5 text-lg leading-8 text-emerald-50/70">
                    A clean student and lecturer portal for attendance, timetable access, and live QR sessions.
                </p>
            </div>

            <div class="stagger-up grid gap-4 sm:grid-cols-3" style="--d: 0.2s">
                <div class="glass-badge lift-hover rounded-3xl p-5">
                    <p class="text-sm text-emerald-100/70">Students</p>
                    <p class="font-display mt-2 text-2xl font-semibold text-white">Profiles</p>
                </div>
                <div class="glass-badge lift-hover rounded-3xl p-5">
                    <p class="text-sm text-emerald-100/70">Lecturers</p>
                    <p class="font-display mt-2 text-2xl font-semibold text-white">Sessions</p>
                </div>
                <div class="glass-badge lift-hover rounded-3xl p-5">
                    <p class="text-sm text-emerald-100/70">School</p>
                    <p class="font-display mt-2 text-2xl font-semibold text-white">Timetable</p>
                </div>
            </div>
        </aside>
    </div>

    <!-- FORGOT PASSWORD MODAL OVERLAY -->
    <div id="forgotModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 backdrop-blur-md px-4">
        <div class="w-full max-w-md rounded-[32px] border border-emerald-500/20 bg-slate-900 p-8 text-white shadow-2xl animate-scale-up">

            <!-- Step 1: Enter Email -->
            <div id="forgotStep1">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-2xl font-bold">Reset Password</h3>
                    <button onclick="closeForgotModal()" class="text-white/50 hover:text-white text-lg font-bold">✕</button>
                </div>
                <p class="text-sm text-white/60 mb-6">Enter your registered email address and we will send you a 6-digit verification code.</p>

                <div id="step1Error" class="hidden mb-4 rounded-xl bg-red-500/20 border border-red-500/30 p-3 text-xs text-red-200"></div>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Email Address</label>
                        <input type="email" id="resetEmail" required placeholder="you@example.com" class="glass-input w-full rounded-2xl px-4 py-3">
                    </div>
                    <button type="button" onclick="sendOtpRequest()" id="sendOtpBtn" class="w-full rounded-2xl bg-emerald-500 px-4 py-3.5 font-bold text-slate-950 hover:bg-emerald-400 transition">
                        Send Verification Code
                    </button>
                </div>
            </div>

            <!-- Step 2: Enter OTP Code — 6 slots with orbit collapse verification animation -->
            <div id="forgotStep2" class="hidden">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-display text-2xl font-bold text-white">Enter Verification Code</h3>
                    <button onclick="closeForgotModal()" class="text-white/50 hover:text-white text-lg font-bold">✕</button>
                </div>
                <p class="text-sm text-white/60 mb-5">Enter the 6-digit code sent to your email inbox.</p>

                <div id="step2Error" class="hidden mb-4 rounded-xl bg-red-500/20 border border-red-500/30 p-3 text-xs text-red-200 text-left"></div>

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
                    <h3 class="font-display text-2xl font-bold">New Password</h3>
                    <button onclick="closeForgotModal()" class="text-white/50 hover:text-white text-lg font-bold">✕</button>
                </div>
                <p class="text-sm text-white/60 mb-6">Create a secure new password for your account.</p>

                <div id="step3Error" class="hidden mb-4 rounded-xl bg-red-500/20 border border-red-500/30 p-3 text-xs text-red-200"></div>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">New Password</label>
                        <input type="password" id="newPassword" required placeholder="••••••••" class="glass-input w-full rounded-2xl px-4 py-3">
                    </div>
                    <div>
                        <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Confirm New Password</label>
                        <input type="password" id="newPasswordConfirmation" required placeholder="••••••••" class="glass-input w-full rounded-2xl px-4 py-3">
                    </div>
                    <button type="button" onclick="resetPasswordRequest()" id="resetPassBtn" class="w-full rounded-2xl bg-emerald-500 px-4 py-3.5 font-bold text-slate-950 hover:bg-emerald-400 transition">
                        Update Password
                    </button>
                </div>
            </div>

            <!-- Step 4: Success Confirmation -->
            <div id="forgotStep4" class="hidden text-center py-6">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-3xl mb-4">
                    ✓
                </div>
                <h3 class="font-display text-2xl font-bold">Password Updated!</h3>
                <p class="mt-2 text-sm text-white/60">Your password has been changed successfully. Redirecting you...</p>
            </div>

        </div>
    </div>

    <script>
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