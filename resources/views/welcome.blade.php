<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Attendance — Next-Generation Academic Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        .animate-float {
            animation: floatSlow 4s ease-in-out infinite;
        }
        .nav-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
        }
        .content-card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            transition: all 0.25s ease;
        }
        .content-card:hover {
            border-color: #059669;
            box-shadow: 0 20px 35px -10px rgba(5, 150, 105, 0.1);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen font-sans antialiased">

    <!-- Navigation Header -->
    <header class="nav-glass sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-700 text-white shadow-md shadow-emerald-700/20">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tight text-slate-900">Smart Attendance</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-emerald-700 transition">Sign In</a>
                <a href="{{ route('login') }}" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition">
                    Access Portal
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="mx-auto max-w-5xl px-6 pt-20 pb-16 text-center">
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-1.5 text-xs font-extrabold text-emerald-800 border border-emerald-200 mb-6">
            <span class="h-2 w-2 rounded-full bg-emerald-600 animate-pulse"></span>
            Advanced University Telemetry & Verification Framework
        </div>
        
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-slate-900 leading-[1.15]">
            Modernizing campus accountability with <span class="text-emerald-600">rolling QR dynamics</span>
        </h1>
        
        <p class="mt-6 text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed font-medium">
            Replace manual sign-up sheets and proxy attendance with instantaneous, verifiable device check-ins, automated course mapping, and real-time audit generation.
        </p>
        
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="rounded-2xl bg-emerald-600 px-8 py-4 text-base font-bold text-white shadow-xl shadow-emerald-600/25 hover:bg-emerald-700 transition transform hover:-translate-y-0.5">
                Launch Portal & Log In
            </a>
            <a href="{{ route('register') }}" class="rounded-2xl border border-slate-300 bg-white px-8 py-4 text-base font-bold text-slate-800 hover:bg-slate-100 transition shadow-sm">
                Register Student Account
            </a>
        </div>
    </section>

    <!-- 6 Core Architectural Pillars (With Diagrams & High Contrast Visuals) -->
    <section class="mx-auto max-w-7xl px-6 py-16">
        <div class="text-center max-w-xl mx-auto mb-16">
            <h2 class="text-xs uppercase tracking-[0.3em] text-emerald-700 font-extrabold">Architectural Breakdown</h2>
            <h3 class="mt-2 text-3xl font-black text-slate-900">How the platform secures academic integrity</h3>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

            <!-- Point 1: Rolling QR Tokens -->
            <div class="content-card rounded-3xl p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">Pillar 01</span>
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-black text-slate-900">Dynamic Security Tokens</h4>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed font-medium">Lecturers project encrypted hashes that rotate every few seconds, making remote proxy check-ins impossible.</p>
                </div>
                <!-- Diagram Visual 1 -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-4 border border-slate-200 text-center animate-float">
                    <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                        Token Hash: <span class="text-emerald-700 font-mono">#AF89-X</span>
                    </div>
                </div>
            </div>

            <!-- Point 2: Automated Course Slips -->
            <div class="content-card rounded-3xl p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">Pillar 02</span>
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-black text-slate-900">Official Course Registration</h4>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed font-medium">Students select their level and semester courses to instantly generate formatted, printable slips.</p>
                </div>
                <!-- Diagram Visual 2 -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-4 border border-slate-200">
                    <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                        <div class="h-8 w-8 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">AJ</div>
                        <div class="text-left">
                            <p class="text-xs font-bold text-slate-900">Alex Johnson</p>
                            <p class="text-[10px] text-slate-500 font-medium">Computer Science &bull; 24 Units</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Point 3: Real-Time Telemetry -->
            <div class="content-card rounded-3xl p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">Pillar 03</span>
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-black text-slate-900">Engagement Analytics</h4>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed font-medium">Lecturers monitor live attendance rates and track student participation trends across semesters effortlessly.</p>
                </div>
                <!-- Diagram Visual 3 -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-4 border border-slate-200 space-y-2">
                    <div class="flex justify-between text-xs font-bold text-slate-700"><span>CSC 501 Attendance</span><span class="text-emerald-700">95%</span></div>
                    <div class="w-full bg-slate-200 rounded-full h-2"><div class="bg-emerald-600 h-2 rounded-full" style="width: 95%"></div></div>
                </div>
            </div>

            <!-- Point 4: Secure Multi-Step OTP Recovery -->
            <div class="content-card rounded-3xl p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">Pillar 04</span>
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-black text-slate-900">Frictionless OTP Recovery</h4>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed font-medium">Robust multi-step email verification safeguards user credentials and handles instant password resets securely.</p>
                </div>
                <!-- Diagram Visual 4 -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-4 border border-slate-200 flex justify-center gap-1.5">
                    <span class="h-8 w-6 bg-white border border-slate-300 rounded flex items-center justify-center text-xs font-bold text-emerald-700">4</span>
                    <span class="h-8 w-6 bg-white border border-slate-300 rounded flex items-center justify-center text-xs font-bold text-emerald-700">9</span>
                    <span class="h-8 w-6 bg-white border border-slate-300 rounded flex items-center justify-center text-xs font-bold text-emerald-700">2</span>
                    <span class="h-8 w-6 bg-white border border-slate-300 rounded flex items-center justify-center text-xs font-bold text-slate-400">•</span>
                </div>
            </div>

            <!-- Point 5: Camera QR Scanner -->
            <div class="content-card rounded-3xl p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">Pillar 05</span>
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-black text-slate-900">In-Browser Camera Scanner</h4>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed font-medium">Students use their smartphone or laptop cameras to scan lecture QR codes directly without downloading apps.</p>
                </div>
                <!-- Diagram Visual 5 -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-4 border border-slate-200 flex items-center justify-center">
                    <div class="h-10 w-28 rounded-xl bg-white border-2 border-dashed border-emerald-500 flex items-center justify-center text-[11px] font-bold text-emerald-700 shadow-sm">
                        Detecting QR...
                    </div>
                </div>
            </div>

            <!-- Point 6: Secure Cloud Sync -->
            <div class="content-card rounded-3xl p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">Pillar 06</span>
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round5" d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7 10l5 5 5-5M12 15V3"/></svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-black text-slate-900">Cloud-Synced Database</h4>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed font-medium">All attendance records and student updates synchronize instantly with secure cloud servers on Railway.</p>
                </div>
                <!-- Diagram Visual 6 -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-4 border border-slate-200 flex items-center justify-center gap-2">
                    <span class="text-xs font-bold text-slate-700 bg-white px-3 py-1 rounded-lg border border-slate-200 shadow-sm">PostgreSQL</span>
                    <span class="text-emerald-600 font-bold">&bull;&bull;&bull;</span>
                    <span class="text-xs font-bold text-slate-700 bg-white px-3 py-1 rounded-lg border border-slate-200 shadow-sm">Railway Cloud</span>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200 py-10 text-center text-xs font-bold text-slate-500 bg-white">
        <p>&copy; 2026 Smart Attendance University. All rights reserved. Built for secure academic excellence.</p>
    </footer>

</body>
</html>