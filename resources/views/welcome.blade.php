<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Attendance — Next-Generation Academic Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        .animate-float-slow {
            animation: float 6s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: float 7s ease-in-out 2s infinite;
        }
        .glass-card {
            background: rgba(15, 23, 42,  0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .glass-pill {
            background: rgba(16, 185, 129, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.25);
        }
        .glow-bg {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(13, 148, 136, 0.05) 50%, transparent 70%);
            z-index: 0;
            pointer-events: none;
            animation: pulseGlow 8s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-slate-950 relative overflow-x-hidden font-sans">

    <!-- Background Ambient Glows -->
    <div class="glow-bg top-[-100px] left-[-150px]"></div>
    <div class="glow-bg top-[40%] right-[-150px]"></div>

    <!-- Navigation Header -->
    <header class="relative z-20 mx-auto max-w-7xl px-6 py-6 flex items-center justify-between border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 font-extrabold text-slate-950 text-lg shadow-lg shadow-emerald-500/20">SA</div>
            <span class="text-xl font-extrabold tracking-tight text-white">Smart Attendance</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white transition">Sign In</a>
            <a href="{{ route('register') }}" class="rounded-2xl bg-emerald-500 px-5 py-2.5 text-sm font-bold text-slate-950 hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/25">Get Started Free</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative z-10 mx-auto max-w-5xl px-6 pt-24 pb-20 text-center">
        <div class="inline-flex items-center gap-2.5 rounded-full glass-pill px-5 py-2 text-xs font-bold text-emerald-400 mb-8 shadow-sm">
            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Next-Generation Academic Verification Architecture
        </div>
        
        <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white leading-[1.15]">
            Redefining lecture accountability with <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">dynamic QR check-ins</span>
        </h1>
        
        <p class="mt-8 text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
            Eliminate proxy check-ins and outdated paper registers. Seamlessly verify real-time student engagement, manage official course units, and generate instant audit reports.
        </p>
        
        <div class="mt-12 flex flex-wrap items-center justify-center gap-5">
            <a href="{{ route('login') }}" class="rounded-2xl bg-emerald-500 px-8 py-4 font-bold text-slate-950 hover:bg-emerald-400 transition-all transform hover:-translate-y-0.5 shadow-xl shadow-emerald-500/30">
                Launch Portal & Log In
            </a>
            <a href="{{ route('register') }}" class="rounded-2xl glass-card px-8 py-4 font-bold text-white hover:bg-white/10 transition-all transform hover:-translate-y-0.5">
                Create Student Account
            </a>
        </div>
    </section>

    <!-- 3D Interactive Feature Preview Mockup Banner -->
    <section class="relative z-10 mx-auto max-w-6xl px-6 pb-24">
        <div class="glass-card rounded-[32px] p-6 sm:p-10 border border-white/15 relative overflow-hidden animate-float-slow">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 via-transparent to-teal-500/15 pointer-events-none"></div>
            
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="space-y-4">
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-400">Live Telemetry</span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Instant session tracking with cryptographic security tokens</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Every lecture generates rolling verification hashes that dynamically refresh. Students must be physically present within range to log attendance successfully.
                    </p>
                </div>
                
                <div class="glass-card rounded-2xl p-5 border border-emerald-500/30 bg-slate-900/80 shadow-2xl">
                    <div class="flex items-center justify-between pb-3 border-b border-white/10">
                        <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Active QR Engine</span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/20 px-3 py-1 text-[11px] font-bold text-emerald-300">Live Sync</span>
                    </div>
                    <div class="py-6 flex flex-col items-center justify-center text-center">
                        <div class="h-28 w-28 rounded-2xl bg-gradient-to-tr from-emerald-600/30 to-teal-500/30 border border-emerald-500/40 flex items-center justify-center mb-4 shadow-inner">
                            <svg class="h-14 w-14 text-emerald-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <p class="text-xs text-slate-400 font-medium">Token rotates every 30 seconds automatically</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Grid Section with Glassmorphism Cards -->
    <section class="relative z-10 mx-auto max-w-7xl px-6 py-20 border-t border-white/10">
        <div class="text-center max-w-xl mx-auto mb-16">
            <h2 class="text-xs uppercase tracking-[0.3em] text-emerald-400 font-bold">Engineered For Excellence</h2>
            <h3 class="mt-3 text-3xl sm:text-4xl font-extrabold text-white">Built for modern university standards</h3>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            <!-- Card 1 -->
            <div class="glass-card rounded-[28px] p-8 transition-all duration-300 hover:border-emerald-500/50 hover:-translate-y-1">
                <div class="h-14 w-14 rounded-2xl bg-gradient-to-tr from-emerald-600/30 to-teal-400/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-black text-xl mb-6 shadow-md">01</div>
                <h4 class="text-xl font-bold text-white">Rolling Security Tokens</h4>
                <p class="mt-3 text-sm text-slate-300 leading-relaxed font-normal">Lecturers project live QR identifiers that constantly rotate, completely eliminating proxy check-ins and attendance fraud.</p>
            </div>

            <!-- Card 2 -->
            <div class="glass-card rounded-[28px] p-8 transition-all duration-300 hover:border-emerald-500/50 hover:-translate-y-1">
                <div class="h-14 w-14 rounded-2xl bg-gradient-to-tr from-emerald-600/30 to-teal-400/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-black text-xl mb-6 shadow-md">02</div>
                <h4 class="text-xl font-bold text-white">Seamless Course Registration</h4>
                <p class="mt-3 text-sm text-slate-300 leading-relaxed font-normal">Students easily map their academic level and active semester courses to instantly generate formatted official registration slips.</p>
            </div>

            <!-- Card 3 -->
            <div class="glass-card rounded-[28px] p-8 transition-all duration-300 hover:border-emerald-500/50 hover:-translate-y-1">
                <div class="h-14 w-14 rounded-2xl bg-gradient-to-tr from-emerald-600/30 to-teal-400/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-black text-xl mb-6 shadow-md">03</div>
                <h4 class="text-xl font-bold text-white">Robust OTP Recovery</h4>
                <p class="mt-3 text-sm text-slate-300 leading-relaxed font-normal">Advanced multi-step email verification safeguards user credentials and facilitates secure, frictionless password resets.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-white/10 py-10 text-center text-xs text-slate-400">
        <p>&copy; 2026 Smart Attendance University. All rights reserved. Designed for elite academic institutions.</p>
    </footer>

</body>
</html>