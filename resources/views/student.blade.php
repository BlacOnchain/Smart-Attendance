<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#059669">
    <title>Smart Attendance | Student Portal</title>
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

        html {
            -webkit-text-size-adjust: 100%;
        }

        * { font-family: 'IBM Plex Sans', system-ui, sans-serif; }
        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }

        body {
            background: linear-gradient(160deg, #eef6f1 0%, #f6f8f2 30%, #fbfbf7 55%, #f3f7f1 100%);
            color: var(--ink);
            overflow-x: hidden;
        }

        /* Soft ambient color, anchored behind the sidebar/header corner —
           not animated here, since this chrome is visible on every page
           and a drifting background under constant UI would be distracting. */
        .app-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(560px 460px at 0% 0%, rgba(5,150,105,0.14), transparent 65%),
                radial-gradient(480px 400px at 100% 0%, rgba(13,148,136,0.10), transparent 65%);
        }

        #sidebar {
            transition: transform 0.3s ease;
            width: min(20rem, 86vw);
            padding-bottom: env(safe-area-inset-bottom);
        }

        @media (min-width: 1024px) {
            #sidebar {
                width: 18rem;
                padding-bottom: 0;
            }
        }

        a, button {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        .glass-panel {
            background: rgba(255,255,255,0.78);
            border: 1px solid rgba(255,255,255,0.9);
            backdrop-filter: blur(22px) saturate(170%);
            -webkit-backdrop-filter: blur(22px) saturate(170%);
        }

        .nav-icon {
            width: 34px; height: 34px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(5,150,105,0.08);
            color: #5b6660;
            flex-shrink: 0;
        }
        .nav-link.active .nav-icon {
            background: var(--brand);
            color: #fff;
        }
        .nav-link.active {
            border-color: rgba(5,150,105,0.35);
            background: rgba(5,150,105,0.1);
            color: var(--brand-dark);
        }

        /* ============================================================
           SHARED MOTION SYSTEM
           One vocabulary, reused by every page that extends this layout.
           Page-specific views only ever add small, additive extras —
           never a competing definition of the same pattern. Class names
           are unchanged from the previous version so every child page
           keeps working without edits; only the curves/values improved.
           ============================================================ */

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes progressGrow {
            from { width: 0%; }
            to   { width: var(--target-width); }
        }

        @keyframes softPulse {
            0%, 100% { opacity: 1; }
            50%      { opacity: 0.55; }
        }

        @keyframes ringPulse {
            0%   { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.45); }
            70%  { box-shadow: 0 0 0 16px rgba(5, 150, 105, 0); }
            100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0); }
        }

        .stagger-up {
            animation: fadeInUp 0.55s cubic-bezier(.16,1,.3,1) both;
            animation-delay: var(--d, 0s);
        }

        .stagger-left {
            animation: fadeInLeft 0.5s cubic-bezier(.16,1,.3,1) both;
            animation-delay: var(--d, 0s);
        }

        .lift-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .lift-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 26px -8px rgba(5, 150, 105, 0.22);
        }

        .btn-nudge {
            transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }
        .btn-nudge:hover {
            transform: translateY(-2px);
        }

        .progress-fill {
            width: 0%;
            animation: progressGrow 0.8s cubic-bezier(.16,1,.3,1) 0.45s forwards;
        }

        .pulse-attention {
            animation: softPulse 1.6s ease-in-out infinite;
        }

        .ring-pulse-once {
            animation: ringPulse 0.9s ease-out 1;
        }

        .state-transition {
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease;
        }

        @media (prefers-reduced-motion: reduce) {
            .stagger-up, .stagger-left, .pulse-attention, .progress-fill, .ring-pulse-once {
                animation: none !important;
                opacity: 1 !important;
                width: var(--target-width, 100%) !important;
            }
            .lift-hover, .btn-nudge, .lift-hover:hover, .btn-nudge:hover {
                transition: none !important;
                transform: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen text-slate-900">
    <div class="app-mesh"></div>

    <div class="relative z-10 min-h-screen lg:flex">

        <div id="sidebarBackdrop" onclick="closeSidebar()" class="fixed inset-0 z-30 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"></div>

        <aside id="sidebar" class="glass-panel fixed inset-y-0 left-0 z-40 -translate-x-full overflow-y-auto lg:sticky lg:top-0 lg:flex lg:h-screen lg:translate-x-0 lg:flex-col" style="border-right: 1px solid var(--line);">
            <div class="flex items-center justify-between gap-3 px-5 py-5" style="border-bottom: 1px solid var(--line); padding-top: max(1.25rem, env(safe-area-inset-top));">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/>
                            <path d="M9.5 12.5L11.3 14.3L15 10.2"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="mono truncate text-[11px] font-semibold" style="color: var(--brand-dark)">Smart Attendance</p>
                        <h1 class="truncate text-lg font-bold" style="color: var(--ink)">Student Portal</h1>
                    </div>
                </div>
                <button onclick="closeSidebar()" class="shrink-0 rounded-lg p-2.5 text-slate-500 hover:bg-emerald-50 lg:hidden" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-5">
                <p class="px-3 pb-3 text-xs font-semibold" style="color: #7a8580">Navigation</p>
                <div class="space-y-1.5">
                    <a href="{{ route('student.dashboard') }}" onclick="closeSidebar()" class="nav-link state-transition flex items-center gap-3 rounded-2xl border border-transparent px-3 py-3 text-sm font-semibold lg:py-2.5 {{ request()->routeIs('student.dashboard') ? 'active' : 'text-slate-700 hover:bg-emerald-50/60' }}">
                        <span class="nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="7.5" height="7.5" rx="2"/><rect x="13" y="3.5" width="7.5" height="7.5" rx="2"/><rect x="3.5" y="13" width="7.5" height="7.5" rx="2"/><rect x="13" y="13" width="7.5" height="7.5" rx="2"/></svg></span>
                        Dashboard
                    </a>
                    <a href="{{ route('student.profile') }}" onclick="closeSidebar()" class="nav-link state-transition flex items-center gap-3 rounded-2xl border border-transparent px-3 py-3 text-sm font-semibold lg:py-2.5 {{ request()->routeIs('student.profile') ? 'active' : 'text-slate-700 hover:bg-emerald-50/60' }}">
                        <span class="nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg></span>
                        My Profile
                    </a>
                    <a href="{{ route('student.timetable') }}" onclick="closeSidebar()" class="nav-link state-transition flex items-center gap-3 rounded-2xl border border-transparent px-3 py-3 text-sm font-semibold lg:py-2.5 {{ request()->routeIs('student.timetable') ? 'active' : 'text-slate-700 hover:bg-emerald-50/60' }}">
                        <span class="nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4.5" width="16" height="15" rx="2.5"/><path d="M4 9.5h16M9 4v3M15 4v3"/></svg></span>
                        Timetable
                    </a>
                    <a href="{{ route('student.camera') }}" onclick="closeSidebar()" class="nav-link state-transition flex items-center gap-3 rounded-2xl border border-transparent px-3 py-3 text-sm font-semibold lg:py-2.5 {{ request()->routeIs('student.camera') ? 'active' : 'text-slate-700 hover:bg-emerald-50/60' }}">
                        <span class="nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="6" width="17" height="13" rx="2.5"/><circle cx="12" cy="12.5" r="3.2"/><path d="M8.5 6L10 4h4l1.5 2"/></svg></span>
                        QR Scanner
                    </a>
                </div>
            </nav>

            <div class="p-4" style="border-top: 1px solid var(--line)">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-nudge flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="min-w-0 flex-1">
            <header class="glass-panel sticky top-0 z-20" style="border-bottom: 1px solid var(--line); padding-top: env(safe-area-inset-top);">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        <button onclick="openSidebar()" class="shrink-0 rounded-lg border p-2.5 hover:bg-emerald-50 lg:hidden" style="border-color: var(--line); color: var(--brand-dark)" aria-label="Open menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="min-w-0">
                            <p class="mono hidden text-[11px] font-semibold sm:block" style="color: var(--brand-dark)">Student Dashboard</p>
                            <h2 class="truncate text-base font-bold sm:text-lg" style="color: var(--ink)">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                        <button class="btn-nudge rounded-full border p-2.5 text-slate-700 hover:text-emerald-800 bg-white/70 shadow-sm" style="border-color: var(--line)">
                            <span class="sr-only">Notifications</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 01-3.4 0"/></svg>
                        </button>
                        <a href="{{ route('student.profile') }}" class="lift-hover hidden items-center gap-3 rounded-full border bg-white/70 px-3 py-2 shadow-sm sm:flex hover:bg-white" style="border-color: var(--line)">
                            @if (Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-600 text-white font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="max-w-[9rem] leading-tight">
                                <p class="truncate text-sm font-bold" style="color: var(--ink)">{{ Auth::user()->name }}</p>
                                <p class="mono truncate text-[10px] font-semibold" style="color: var(--brand-dark)">{{ strtoupper(Auth::user()->role ?? 'student') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="stagger-up mb-6 rounded-2xl border border-emerald-300 bg-emerald-100 px-4 py-3 text-emerald-900 font-semibold shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="stagger-up mb-6 rounded-2xl border border-red-300 bg-red-100 px-4 py-3 text-red-900 font-semibold shadow-sm">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }

        // If the viewport crosses into the desktop breakpoint while the
        // mobile drawer is open (rotating a tablet, resizing a window),
        // clear the mobile-only state so it doesn't get stuck.
        let lastWasDesktop = window.innerWidth >= 1024;
        window.addEventListener('resize', () => {
            const isDesktop = window.innerWidth >= 1024;
            if (isDesktop && !lastWasDesktop) {
                closeSidebar();
            }
            lastWasDesktop = isDesktop;
        });
    </script>

    @stack('scripts')
</body>
</html>