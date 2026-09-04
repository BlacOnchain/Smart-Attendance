<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#059669">
    <title>Smart Attendance | Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            -webkit-text-size-adjust: 100%;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(34, 197, 94, 0.12), transparent 28%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.08), transparent 25%),
                linear-gradient(180deg, #f7fff9 0%, #eefaf1 100%);
            overflow-x: hidden;
        }

        #sidebar {
            transition: transform 0.3s ease;
            /* Never wider than the viewport itself on very small phones,
               but a fixed, comfortable width from tablet up. */
            width: min(20rem, 86vw);
            padding-bottom: env(safe-area-inset-bottom);
        }

        @media (min-width: 1024px) {
            #sidebar {
                width: 18rem;
                padding-bottom: 0;
            }
        }

        /* Buttons and links stay a comfortable tap size on touch devices
           and don't show the gray flash Android/iOS add on tap. */
        a, button {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        /* ============================================================
           SHARED MOTION SYSTEM
           One vocabulary, reused by every page that extends this layout.
           Page-specific views only ever add small, additive extras —
           never a competing definition of the same pattern.
           ============================================================ */

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-16px); }
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

        /* Entrance: sections arrive top-to-bottom (Dashboard, Profile) */
        .stagger-up {
            animation: fadeInUp 0.5s ease both;
            animation-delay: var(--d, 0s);
        }

        /* Entrance: elements arrive left-to-right (Timetable's day grid) */
        .stagger-left {
            animation: fadeInLeft 0.45s ease both;
            animation-delay: var(--d, 0s);
        }

        /* Tactile hover for every clickable card */
        .lift-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .lift-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.14);
        }

        /* Same tiny nudge on every primary button */
        .btn-nudge {
            transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }
        .btn-nudge:hover {
            transform: translateY(-2px);
        }

        /* Attendance / progress bars fill in on load, once, with intent */
        .progress-fill {
            width: 0%;
            animation: progressGrow 0.8s ease 0.45s forwards;
        }

        /* Consistent "needs attention" cue — live banners, waiting states */
        .pulse-attention {
            animation: softPulse 1.6s ease-in-out infinite;
        }

        /* One-shot ring pulse for confirmation moments (e.g. new photo picked) */
        .ring-pulse-once {
            animation: ringPulse 0.9s ease-out 1;
        }

        /* Smooth state transitions for anything that changes color/text on the fly */
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
    <div class="min-h-screen lg:flex">

        <div id="sidebarBackdrop" onclick="closeSidebar()" class="fixed inset-0 z-30 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 -translate-x-full border-r border-emerald-100 bg-white/80 backdrop-blur-xl overflow-y-auto lg:sticky lg:top-0 lg:flex lg:h-screen lg:translate-x-0 lg:flex-col lg:border-b-0 lg:border-r">
            <div class="flex items-center justify-between gap-3 border-b border-emerald-100 px-5 py-5" style="padding-top: max(1.25rem, env(safe-area-inset-top));">
                <div class="flex min-w-0 items-center gap-3">
                    <img src="{{ asset('images/smart-attendance-logo.png') }}" alt="Smart Attendance logo" class="h-11 w-11 shrink-0 rounded-2xl object-cover">
                    <div class="min-w-0">
                        <p class="truncate text-xs uppercase tracking-[0.32em] text-emerald-700 font-bold">Smart Attendance</p>
                        <h1 class="truncate text-lg font-bold text-slate-900">Student Portal</h1>
                    </div>
                </div>
                <button onclick="closeSidebar()" class="shrink-0 rounded-lg p-2.5 text-slate-500 hover:bg-emerald-50 lg:hidden" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-5">
                <p class="px-3 pb-3 text-xs uppercase tracking-[0.28em] text-slate-700 font-bold">Navigation</p>
                <div class="space-y-2">
                    <a href="{{ route('student.dashboard') }}" onclick="closeSidebar()" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-semibold lg:py-3 {{ request()->routeIs('student.dashboard') ? 'border border-emerald-300 bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-current"></span>
                        Dashboard
                    </a>
                    <a href="{{ route('student.profile') }}" onclick="closeSidebar()" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-semibold lg:py-3 {{ request()->routeIs('student.profile') ? 'border border-emerald-300 bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-current"></span>
                        My Profile
                    </a>
                    <a href="{{ route('student.timetable') }}" onclick="closeSidebar()" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-semibold lg:py-3 {{ request()->routeIs('student.timetable') ? 'border border-emerald-300 bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-current"></span>
                        Timetable
                    </a>
                    <a href="{{ route('student.camera') }}" onclick="closeSidebar()" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3.5 text-sm font-semibold lg:py-3 {{ request()->routeIs('student.camera') ? 'border border-emerald-300 bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-current"></span>
                        QR Scanner
                    </a>
                </div>
            </nav>

            <div class="border-t border-emerald-100 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-nudge flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-600"></span>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="min-w-0 flex-1">
            <header class="border-b border-emerald-100 bg-white/90 backdrop-blur-xl shadow-sm sticky top-0 z-20" style="padding-top: env(safe-area-inset-top);">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        <button onclick="openSidebar()" class="shrink-0 rounded-lg border border-emerald-200 p-2.5 text-emerald-700 hover:bg-emerald-50 lg:hidden" aria-label="Open menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="min-w-0">
                            <p class="hidden text-xs uppercase tracking-[0.3em] text-emerald-700 font-bold sm:block">Student Dashboard</p>
                            <h2 class="truncate text-base font-bold text-slate-900 sm:text-lg">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-2 sm:gap-4">
                        <button class="btn-nudge rounded-full border border-emerald-200 p-2.5 text-slate-700 hover:text-emerald-800 bg-white shadow-sm">
                            <span class="sr-only">Notifications</span>
                            <span class="text-lg">🔔</span>
                        </button>
                        <a href="{{ route('student.profile') }}" class="lift-hover hidden items-center gap-3 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-2 shadow-sm sm:flex hover:bg-emerald-100">
                            @if (Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-600 text-white font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="max-w-[9rem] leading-tight">
                                <p class="truncate text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="truncate text-xs text-emerald-800 font-semibold uppercase tracking-wider">{{ Auth::user()->role ?? 'student' }}</p>
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