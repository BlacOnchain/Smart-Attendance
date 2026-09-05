<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Attendance — Next-Generation Academic Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-6px) rotate(0.5deg); }
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.04); }
        }
        .animate-float {
            animation: float 5s ease-in-out infinite;
        }
        .glow-sphere {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, rgba(5, 150, 105, 0.04) 50%, transparent 70%);
            z-index: 0;
            pointer-events: none;
            animation: pulseGlow 7s ease-in-out infinite;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.15);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.18);
            box-shadow: 0 15px 35px -10px rgba(5, 150, 105, 0.08);
        }
        .glass-badge {
            background: rgba(16, 185, 129, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.25);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-emerald-50/40 via-white to-emerald-50/20 text-slate-900 min-h-screen relative overflow-x-hidden font-sans">

    <!-- Ambient Background Glows -->
    <div class="glow-sphere top-[-60px] left-[-60px]"></div>
    <div class="glow-sphere top-[40%] right-[-60px]"></div>

    <!-- Glassmorphic Responsive Navigation Header -->
    <header class="glass-nav sticky top-0 z-50 px-4 sm:px-6 py-3.5 transition-all">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <!-- Custom Vector Logo -->
                <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-700 shadow-md shadow-emerald-600/20">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4" />
                    </svg>
                    <div class="absolute -bottom-1 -right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-emerald-500 text-[8px] font-bold text-white shadow">✓</div>
                </div>
                <span class="text-base sm:text-xl font-extrabold tracking-tight text-emerald-950 truncate">Smart Attendance</span>
            </div>
            <div class="flex items-center gap-2 sm:gap-4">
                <a href="{{ route('login') }}" class="text-xs sm:text-sm font-bold text-emerald-900 hover:text-emerald-700 transition px-2 py-1">Sign In</a>
                <a href="{{ route('login') }}" class="rounded-xl sm:rounded-2xl bg-emerald-600 px-3.5 sm:px-6 py-2 text-xs sm:text-sm font-bold text-white shadow-md shadow-emerald-600/25 hover:bg-emerald-700 transition-all">
                    Access Portal
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative z-10 mx-auto max-w-5xl px-4 sm:px-6 pt-12 sm:pt-20 pb-12 text-center">
        <div class="inline-flex items-center gap-2 rounded-full glass-badge px-4 py-1.5 text-[11px] sm:text-xs font-bold text-emerald-800 mb-6 shadow-sm">
            <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-600 animate-pulse"></span>
            Advanced University Telemetry & Verification Framework
        </div>
        
        <h1 class="text-3xl sm:text-5xl md:text-7xl font-black tracking-tight text-emerald-950 leading-[1.15]">
            Modernizing campus accountability with <span class="text-emerald-600">rolling QR dynamics</span>
        </h1>
        
        <p class="mt-5 text-base sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed font-medium">
            Replace manual sign-up sheets and proxy attendance with instantaneous, verifiable device check-ins, automated course mapping, and real-time audit generation.
        </p>
        
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 w-full px-4 sm:px-0">
            <a href="{{ route('login') }}" class="w-full sm:w-auto rounded-2xl bg-emerald-600 px-8 py-3.5 text-sm sm:text-base font-bold text-white shadow-xl shadow-emerald-600/30 hover:bg-emerald-700 transition-all text-center">
                Launch Portal & Log In
            </a>
            <a href="{{ route('register') }}" class="w-full sm:w-auto rounded-2xl border border-emerald-300 bg-white px-8 py-3.5 text-sm sm:text-base font-bold text-emerald-900 hover:bg-emerald-50 transition-all text-center shadow-sm">
                Register Student Account
            </a>
        </div>
    </section>

    <!-- Interactive Telemetry Mockup Banner -->
    <section class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 pb-12 sm:pb-20">
        <div class="glass-card rounded-[24px] sm:rounded-[32px] p-5 sm:p-10 border border-emerald-200 relative overflow-hidden animate-float">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 via-transparent to-teal-500/10 pointer-events-none"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 items-center">
                <div class="space-y-3 text-left">
                    <span class="text-[11px] sm:text-xs font-extrabold uppercase tracking-[0.25em] text-emerald-700">Live Telemetry Engine</span>
                    <h3 class="text-xl sm:text-3xl font-extrabold text-emerald-950">Cryptographic token rotation prevents unauthorized check-ins</h3>
                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-medium">
                        Every lecture session broadcasts time-bound security identifiers. Students verify physical presence instantly via camera scanning, sealing logs directly into the database.
                    </p>
                </div>
                
                <div class="glass-card rounded-2xl p-4 sm:p-6 border border-emerald-300 bg-white shadow-xl">
                    <div class="flex items-center justify-between pb-3 border-b border-emerald-100">
                        <span class="text-[11px] sm:text-xs font-bold text-emerald-800 uppercase tracking-widest">Active Verification Node</span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] sm:text-[11px] font-extrabold text-emerald-800">Secure Sync</span>
                    </div>
                    <div class="py-4 sm:py-6 flex flex-col items-center justify-center text-center">
                        <div class="h-24 w-24 sm:h-28 sm:w-28 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center mb-3 shadow-inner">
                            <svg class="h-12 w-12 sm:h-14 sm:w-14 text-emerald-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-bold">Secure Hash Stream Active</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Diagram Section -->
    <section class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 py-12 border-t border-emerald-100">
        <div class="text-center max-w-xl mx-auto mb-10 sm:mb-16">
            <h2 class="text-xs uppercase tracking-[0.3em] text-emerald-700 font-bold">Seamless Academic Workflow</h2>
            <h3 class="mt-2 text-2xl sm:text-3xl font-extrabold text-emerald-950">How the architecture operates</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="glass-card rounded-3xl p-5 sm:p-6 border border-emerald-200">
                <div class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-emerald-600 text-white font-black text-base sm:text-lg mb-3 sm:mb-4">1</div>
                <h4 class="font-extrabold text-emerald-950 text-sm sm:text-base">Session Initiation</h4>
                <p class="mt-1.5 text-xs text-slate-600 leading-relaxed font-medium">Lecturer initializes a class session, launching rolling cryptographic QR codes on display.</p>
            </div>

            <div class="glass-card rounded-3xl p-5 sm:p-6 border border-emerald-200">
                <div class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-emerald-600 text-white font-black text-base sm:text-lg mb-3 sm:mb-4">2</div>
                <h4 class="font-extrabold text-emerald-950 text-sm sm:text-base">Instant Camera Scan</h4>
                <p class="mt-1.5 text-xs text-slate-600 leading-relaxed font-medium">Students open the portal scanner, capturing the active token within physical range.</p>
            </div>

            <div class="glass-card rounded-3xl p-5 sm:p-6 border border-emerald-200">
                <div class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-emerald-600 text-white font-black text-base sm:text-lg mb-3 sm:mb-4">3</div>
                <h4 class="font-extrabold text-emerald-950 text-sm sm:text-base">Cloud Logging</h4>
                <p class="mt-1.5 text-xs text-slate-600 leading-relaxed font-medium">The platform logs attendance securely against matric records and active student courses.</p>
            </div>

            <div class="glass-card rounded-3xl p-5 sm:p-6 border border-emerald-200">
                <div class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-emerald-600 text-white font-black text-base sm:text-lg mb-3 sm:mb-4">4</div>
                <h4 class="font-extrabold text-emerald-950 text-sm sm:text-base">Official Course Slips</h4>
                <p class="mt-1.5 text-xs text-slate-600 leading-relaxed font-medium">Students generate print-ready registration slips with live academic metrics instantly.</p>
            </div>
        </div>
    </section>

    <!-- Feature Grid Section -->
    <section class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 py-12 border-t border-emerald-100">
        <div class="text-center max-w-xl mx-auto mb-10 sm:mb-16">
            <h2 class="text-xs uppercase tracking-[0.3em] text-emerald-700 font-bold">Engineered For Excellence</h2>
            <h3 class="mt-2 text-2xl sm:text-3xl font-extrabold text-emerald-950">Built for elite university standards</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <!-- Card 1 -->
            <div class="glass-card rounded-[24px] sm:rounded-[28px] p-6 sm:p-8 border border-emerald-200">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mb-5 sm:mb-6 shadow-md shadow-emerald-600/30">
                    <svg class="h-6 w-6 sm:h-7 sm:w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h4 class="text-lg sm:text-xl font-extrabold text-emerald-950">Dynamic Security Tokens</h4>
                <p class="mt-2.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">Rolling hashes eliminate proxy check-ins by requiring students to be physically present in the lecture theatre.</p>
            </div>

            <!-- Card 2 -->
            <div class="glass-card rounded-[24px] sm:rounded-[28px] p-6 sm:p-8 border border-emerald-200">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mb-5 sm:mb-6 shadow-md shadow-emerald-600/30">
                    <svg class="h-6 w-6 sm:h-7 sm:w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h4 class="text-lg sm:text-xl font-extrabold text-emerald-950">Automated Course Forms</h4>
                <p class="mt-2.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">Seamlessly map academic levels and active semesters to generate official, formatted course registration slips.</p>
            </div>

            <!-- Card 3 -->
            <div class="glass-card rounded-[24px] sm:rounded-[28px] p-6 sm:p-8 border border-emerald-200">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mb-5 sm:mb-6 shadow-md shadow-emerald-600/30">
                    <svg class="h-6 w-6 sm:h-7 sm:w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h4 class="text-lg sm:text-xl font-extrabold text-emerald-950">Multi-Step OTP Recovery</h4>
                <p class="mt-2.5 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">Advanced email verification safeguards user credentials and provides friction-free, secure password resets.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-emerald-200 py-8 px-4 text-center text-[11px] sm:text-xs font-semibold text-emerald-900/60 bg-white/50 backdrop-blur-sm">
        <p>&copy; 2026 Smart Attendance University. All rights reserved. Designed for elite academic institutions.</p>
    </footer>

</body>
</html>