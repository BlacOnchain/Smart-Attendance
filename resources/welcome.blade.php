<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Attendance — Automated University Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-white min-h-screen selection:bg-emerald-500 selection:text-white">

    <!-- Navigation Header -->
    <header class="mx-auto max-w-7xl px-6 py-6 flex items-center justify-between border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 font-extrabold text-slate-950 text-lg">SA</div>
            <span class="text-xl font-extrabold tracking-tight">Smart Attendance</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-white/80 hover:text-white transition">Sign In</a>
            <a href="{{ route('register') }}" class="rounded-xl bg-emerald-500 px-5 py-2.5 text-sm font-bold text-slate-950 hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">Get Started Free</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="mx-auto max-w-5xl px-6 pt-20 pb-16 text-center">
        <span class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-1.5 text-xs font-bold text-emerald-400 mb-6">
            ✨ Next-Generation QR Attendance System
        </span>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-tight">
            Automate lecture attendance with <span class="text-emerald-400">live QR check-ins</span>
        </h1>
        <p class="mt-6 text-lg text-white/60 max-w-2xl mx-auto leading-relaxed">
            Eliminate proxy attendance and paper sign-up sheets. Effortlessly track student engagement, verify real-time check-ins, and export complete reports instantly.
        </p>
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="rounded-2xl bg-emerald-500 px-8 py-4 font-bold text-slate-950 hover:bg-emerald-400 transition shadow-xl shadow-emerald-500/25">
                Launch Portal & Log In
            </a>
            <a href="{{ route('register') }}" class="rounded-2xl border border-white/20 bg-white/5 px-8 py-4 font-bold text-white hover:bg-white/10 transition">
                Create Account
            </a>
        </div>
    </section>

    <!-- Feature Grid Section -->
    <section class="mx-auto max-w-7xl px-6 py-20 border-t border-white/10">
        <div class="text-center max-w-xl mx-auto mb-16">
            <h2 class="text-xs uppercase tracking-[0.3em] text-emerald-400 font-bold">Powerful Features</h2>
            <h3 class="mt-2 text-3xl font-extrabold">Designed for modern universities</h3>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 transition hover:border-emerald-500/50">
                <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xl mb-6">01</div>
                <h4 class="text-xl font-bold">Dynamic QR Codes</h4>
                <p class="mt-2 text-sm text-white/60 leading-relaxed">Lecturers generate rolling security tokens that rotate dynamically, preventing students from checking in remotely.</p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 transition hover:border-emerald-500/50">
                <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xl mb-6">02</div>
                <h4 class="text-xl font-bold">Instant Course Registration</h4>
                <p class="mt-2 text-sm text-white/60 leading-relaxed">Students seamlessly pick their level and semester courses to automatically generate official official course slips.</p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 transition hover:border-emerald-500/50">
                <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xl mb-6">03</div>
                <h4 class="text-xl font-bold">Secure OTP Recovery</h4>
                <p class="mt-2 text-sm text-white/60 leading-relaxed">Robust multi-step email verification safeguards user credentials and handles instant password resets securely.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/10 py-8 text-center text-xs text-white/40">
        &copy; 2026 Smart Attendance University. All rights reserved.
    </footer>

</body>
</html>