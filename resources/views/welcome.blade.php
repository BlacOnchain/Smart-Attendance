<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Attendance — University Attendance Software</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
        }
        .showcase-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.04), 0 5px 15px -5px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }
        .showcase-card:hover {
            border-color: #059669;
            box-shadow: 0 25px 50px -12px rgba(5, 150, 105, 0.08);
        }
    </style>
</head>
<body class="bg-white text-slate-900 min-h-screen font-sans antialiased selection:bg-emerald-600 selection:text-white">

    <!-- Navigation Header -->
    <header class="nav-glass sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/20">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <span class="text-lg font-extrabold tracking-tight text-slate-900">Smart Attendance</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-emerald-700 transition">Sign In</a>
                <a href="{{ route('login') }}" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition">
                    Access Portal
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="mx-auto max-w-5xl px-6 pt-20 pb-16 text-center">
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-1.5 text-xs font-bold text-emerald-800 border border-emerald-200/80 mb-6">
            <span class="h-2 w-2 rounded-full bg-emerald-600 animate-pulse"></span>
            Next-Generation Academic Verification Platform
        </div>
        
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-slate-900 leading-[1.12]">
            University attendance clock-in software
        </h1>
        
        <p class="mt-6 text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Eliminate proxy sign-ups and manual paper registers. Automatically generate verified academic timelines and course logs from real-time student check-ins.
        </p>
        
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3 text-xs sm:text-sm font-semibold text-slate-500">
            <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Verified Presence</span>
            <span class="text-slate-300">•</span>
            <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Rolling QR Tokens</span>
            <span class="text-slate-300">•</span>
            <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Instant Course Slips</span>
        </div>

        <div class="mt-10">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-8 py-4 text-base font-bold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition">
                Start tracking attendance — it's free!
            </a>
            <p class="mt-3 text-xs text-slate-400 font-medium">Unlimited students &bull; Secure cloud database &bull; No setup fees</p>
        </div>
    </section>

    <!-- 6-Point Alternating Zig-Zag Showcase -->
    <div class="max-w-6xl mx-auto px-6 py-12 space-y-24">

        <!-- Point 01 -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-6xl font-black text-slate-200 block mb-2">01</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Stop proxy sign-ups with rotating cryptographic tokens</h3>
                <p class="mt-4 text-slate-600 leading-relaxed text-sm sm:text-base">
                    Manual attendance lists are easily manipulated. Our platform projects live session codes that rotate dynamically every few seconds, ensuring students are physically present inside the lecture hall to log check-ins.
                </p>
            </div>
            <div class="showcase-card rounded-3xl p-6 bg-slate-50/50">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Live Lecture Session</span>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-bold text-emerald-800">Active Sync</span>
                </div>
                <div class="py-8 flex flex-col items-center justify-center text-center">
                    <div class="h-32 w-32 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center mb-4">
                        <svg class="h-16 w-16 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-700">Token refreshes in <span class="text-emerald-600 font-extrabold">24s</span></p>
                </div>
            </div>
        </section>

        <!-- Point 02 -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div class="showcase-card rounded-3xl p-6 bg-slate-50/50 order-2 md:order-1">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Student Profile Slip</span>
                    <span class="text-xs font-bold text-emerald-600">Official Document</span>
                </div>
                <div class="py-6 space-y-3">
                    <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200">
                        <div class="h-12 w-12 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center">MK</div>
                        <div>
                            <p class="font-bold text-sm text-slate-900">Michael Kelvin</p>
                            <p class="text-xs text-slate-500">Computer Science &bull; 500 Level</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center">
                            <p class="text-[10px] text-slate-400 uppercase font-bold">Registered Units</p>
                            <p class="text-base font-extrabold text-emerald-600 mt-0.5">24 Units</p>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-slate-200 text-center">
                            <p class="text-[10px] text-slate-400 uppercase font-bold">Status</p>
                            <p class="text-base font-extrabold text-slate-900 mt-0.5">Verified</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <span class="text-6xl font-black text-slate-200 block mb-2">02</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Seamless course registration & printable slips</h3>
                <p class="mt-4 text-slate-600 leading-relaxed text-sm sm:text-base">
                    Students can select their academic level, department, and semester courses in seconds. The platform automatically aggregates registered units and generates professional, print-ready course registration slips.
                </p>
            </div>
        </section>

        <!-- Point 03 -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-6xl font-black text-slate-200 block mb-2">03</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Real-time engagement tracking and instant reports</h3>
                <p class="mt-4 text-slate-600 leading-relaxed text-sm sm:text-base">
                    Lecturers gain complete visibility into student attendance histories. Monitor participation trends across semesters, inspect individual student logs, and export tidy records whenever required.
                </p>
            </div>
            <div class="showcase-card rounded-3xl p-6 bg-slate-50/50">
                <div class="space-y-3">
                    <div class="flex items-center justify-between bg-white p-3.5 rounded-2xl border border-slate-200">
                        <span class="text-xs font-bold text-slate-700">CSC 501 Attendance Rate</span>
                        <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">94%</span>
                    </div>
                    <div class="flex items-center justify-between bg-white p-3.5 rounded-2xl border border-slate-200">
                        <span class="text-xs font-bold text-slate-700">CSC 503 Attendance Rate</span>
                        <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">88%</span>
                    </div>
                    <div class="flex items-center justify-between bg-white p-3.5 rounded-2xl border border-slate-200">
                        <span class="text-xs font-bold text-slate-700">CSC 505 Attendance Rate</span>
                        <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">96%</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Point 04 -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div class="showcase-card rounded-3xl p-6 bg-slate-50/50 order-2 md:order-1">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Account Recovery</span>
                    <span class="text-xs font-bold text-emerald-600">Secure OTP</span>
                </div>
                <div class="py-8 flex flex-col items-center justify-center text-center">
                    <div class="flex gap-2 mb-3">
                        <span class="h-10 w-10 bg-white border border-slate-300 rounded-xl flex items-center justify-center font-bold text-emerald-700 shadow-sm">7</span>
                        <span class="h-10 w-10 bg-white border border-slate-300 rounded-xl flex items-center justify-center font-bold text-emerald-700 shadow-sm">4</span>
                        <span class="h-10 w-10 bg-white border border-slate-300 rounded-xl flex items-center justify-center font-bold text-emerald-700 shadow-sm">2</span>
                        <span class="h-10 w-10 bg-white border border-slate-300 rounded-xl flex items-center justify-center font-bold text-slate-400 shadow-sm">•</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">6-digit verification code sent to Gmail</p>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <span class="text-6xl font-black text-slate-200 block mb-2">04</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Frictionless multi-step OTP password recovery</h3>
                <p class="mt-4 text-slate-600 leading-relaxed text-sm sm:text-base">
                    Secure student and lecturer accounts against unauthorized access. Our multi-step email verification workflow safely manages credential updates and instant password resets without administrative delays.
                </p>
            </div>
        </section>

        <!-- Point 05 -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-6xl font-black text-slate-200 block mb-2">05</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">In-browser camera scanning for instant check-ins</h3>
                <p class="mt-4 text-slate-600 leading-relaxed text-sm sm:text-base">
                    Students don't need to install external apps. The built-in HTML5 camera scanner activates directly inside the mobile or desktop portal, capturing lecture codes instantly with smooth visual feedback.
                </p>
            </div>
            <div class="showcase-card rounded-3xl p-6 bg-slate-50/50">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">QR Scanner Viewport</span>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-bold text-emerald-800">Ready</span>
                </div>
                <div class="py-8 flex flex-col items-center justify-center text-center">
                    <div class="h-28 w-44 rounded-2xl bg-slate-900 border-2 border-emerald-500 flex items-center justify-center shadow-inner relative">
                        <span class="absolute top-2 left-2 h-3 w-3 border-t-2 border-l-2 border-emerald-400"></span>
                        <span class="absolute top-2 right-2 h-3 w-3 border-t-2 border-r-2 border-emerald-400"></span>
                        <span class="absolute bottom-2 left-2 h-3 w-3 border-b-2 border-l-2 border-emerald-400"></span>
                        <span class="absolute bottom-2 right-2 h-3 w-3 border-b-2 border-r-2 border-emerald-400"></span>
                        <p class="text-[11px] text-emerald-400 font-bold animate-pulse">Align QR Code</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Point 06 -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div class="showcase-card rounded-3xl p-6 bg-slate-50/50 order-2 md:order-1">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Cloud Infrastructure</span>
                    <span class="text-xs font-bold text-emerald-600">PostgreSQL</span>
                </div>
                <div class="py-8 flex items-center justify-center gap-4 text-center">
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                        <p class="text-xs font-bold text-slate-800">Railway Cloud</p>
                        <p class="text-[10px] text-emerald-600 font-semibold mt-0.5">99.9% Uptime</p>
                    </div>
                    <span class="text-slate-400 font-bold">⇄</span>
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                        <p class="text-xs font-bold text-slate-800">GitHub Actions</p>
                        <p class="text-[10px] text-emerald-600 font-semibold mt-0.5">Auto-Deploy</p>
                    </div>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <span class="text-6xl font-black text-slate-200 block mb-2">06</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Cloud-synced architecture hosted securely on Railway</h3>
                <p class="mt-4 text-slate-600 leading-relaxed text-sm sm:text-base">
                    Every attendance log, user registration, and course update is backed by a robust PostgreSQL cloud database. Automatic synchronization ensures zero data loss and flawless multi-device reliability.
                </p>
            </div>
        </section>

    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-200 py-10 mt-20 text-center text-xs font-bold text-slate-500 bg-slate-50">
        <p>&copy; 2026 Smart Attendance University. All rights reserved. Built for secure academic excellence.</p>
    </footer>

</body>
</html>