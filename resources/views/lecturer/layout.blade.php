<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Attendance | Lecturer Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
            --brand-2: #059669;
        }

        * { font-family: 'IBM Plex Sans', system-ui, sans-serif; }
        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }

        body {
            background: linear-gradient(160deg, #e9f4f2 0%, #f6f8f2 30%, #fbfbf7 55%, #eef6f4 100%);
            color: var(--ink);
            overflow-x: hidden;
        }

        .app-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(560px 460px at 0% 0%, rgba(13,148,136,0.16), transparent 65%),
                radial-gradient(480px 400px at 100% 0%, rgba(5,150,105,0.10), transparent 65%);
        }

        #sidebar { transition: transform 0.3s ease; }

        .glass-panel {
            background: rgba(255,255,255,0.78);
            border: 1px solid rgba(255,255,255,0.9);
            backdrop-filter: blur(22px) saturate(170%);
            -webkit-backdrop-filter: blur(22px) saturate(170%);
        }

        .nav-icon {
            width: 34px; height: 34px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(13,148,136,0.08);
            color: #5b6660;
            flex-shrink: 0;
        }
        .nav-link.active .nav-icon { background: var(--brand); color: #fff; }
        .nav-link.active {
            border-color: rgba(13,148,136,0.35);
            background: rgba(13,148,136,0.1);
            color: var(--brand-dark);
        }

        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            color: var(--brand-dark);
            letter-spacing: 0.01em;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes softPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.55; } }
        @keyframes progressGrow { from { width: 0%; } to { width: var(--target-width); } }

        .stagger-up { animation: fadeInUp 0.55s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d, 0s); }
        .stagger-left { animation: fadeInLeft 0.5s cubic-bezier(.16,1,.3,1) both; animation-delay: var(--d, 0s); }
        .lift-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .lift-hover:hover { transform: translateY(-3px); box-shadow: 0 10px 26px -8px rgba(13,148,136,0.22); }
        .btn-nudge { transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease; }
        .btn-nudge:hover { transform: translateY(-2px); }
        .pulse-attention { animation: softPulse 1.6s ease-in-out infinite; }
        .progress-fill { width: 0%; animation: progressGrow 0.8s cubic-bezier(.16,1,.3,1) 0.45s forwards; }
        .state-transition { transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease; }

        @media (prefers-reduced-motion: reduce) {
            .stagger-up, .stagger-left, .pulse-attention, .progress-fill {
                animation: none !important; opacity: 1 !important; width: var(--target-width, 100%) !important;
            }
            .lift-hover, .btn-nudge, .lift-hover:hover, .btn-nudge:hover { transition: none !important; transform: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen text-slate-900">
    <div class="app-mesh"></div>

    <div class="relative z-10 min-h-screen lg:flex">
        <div id="sidebarBackdrop" onclick="closeSidebar()" class="fixed inset-0 z-30 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"></div>

        <aside id="sidebar" class="glass-panel fixed inset-y-0 left-0 z-40 w-72 -translate-x-full lg:sticky lg:top-0 lg:flex lg:h-screen lg:w-72 lg:translate-x-0 lg:flex-col" style="border-right: 1px solid var(--line)">
            <div class="flex items-center justify-between gap-3 px-5 py-5" style="border-bottom: 1px solid var(--line)">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl text-white" style="background: var(--brand)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/>
                            <path d="M9.5 12.5L11.3 14.3L15 10.2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="mono text-[11px] font-semibold" style="color: var(--brand-dark)">Smart Attendance</p>
                        <h1 class="text-lg font-bold" style="color: var(--ink)">Lecturer Portal</h1>
                    </div>
                </div>
                <button onclick="closeSidebar()" class="rounded-lg p-2 text-slate-500 hover:bg-teal-50 lg:hidden" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-5">
                <p class="px-3 pb-3 text-xs font-semibold" style="color: #7a8580">Navigation</p>
                <div class="space-y-1.5">
                    <a href="{{ route('lecturer.dashboard') }}" class="nav-link state-transition flex items-center gap-3 rounded-2xl border border-transparent px-3 py-3 text-sm font-semibold {{ request()->routeIs('lecturer.dashboard') ? 'active' : 'text-slate-700 hover:bg-teal-50/60' }}">
                        <span class="nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="7.5" height="7.5" rx="2"/><rect x="13" y="3.5" width="7.5" height="7.5" rx="2"/><rect x="3.5" y="13" width="7.5" height="7.5" rx="2"/><rect x="13" y="13" width="7.5" height="7.5" rx="2"/></svg></span>
                        Dashboard
                    </a>
                    <a href="{{ route('lecturer.students') }}" class="nav-link state-transition flex items-center gap-3 rounded-2xl border border-transparent px-3 py-3 text-sm font-semibold {{ request()->routeIs('lecturer.students') ? 'active' : 'text-slate-700 hover:bg-teal-50/60' }}">
                        <span class="nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 19c0-3.3 2.5-6 5.5-6s5.5 2.7 5.5 6"/><circle cx="17" cy="8.5" r="2.4"/><path d="M14.5 19c.1-2.6 1.6-4.7 3.5-5.3"/></svg></span>
                        Attendance Summary
                    </a>
                    <a href="{{ route('lecturer.courses') }}" class="nav-link state-transition flex items-center gap-3 rounded-2xl border border-transparent px-3 py-3 text-sm font-semibold {{ request()->routeIs('lecturer.courses') ? 'active' : 'text-slate-700 hover:bg-teal-50/60' }}">
                        <span class="nav-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="2.5"/><path d="M4 9.5h16M9 4v4.5"/></svg></span>
                        My Courses
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

        <div class="flex-1 min-w-0">
            <header class="glass-panel sticky top-0 z-20" style="border-bottom: 1px solid var(--line)">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button onclick="openSidebar()" class="rounded-lg border p-2 hover:bg-teal-50 lg:hidden" style="border-color: var(--line); color: var(--brand-dark)" aria-label="Open menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <p class="mono text-[11px] font-semibold" style="color: var(--brand-dark)">Lecturer Portal</p>
                            <h2 class="text-lg font-bold" style="color: var(--ink)">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="lift-hover hidden items-center gap-3 rounded-full border bg-white/70 px-3 py-2 shadow-sm sm:flex hover:bg-white" style="border-color: var(--line)">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full text-white font-bold" style="background: var(--brand)">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="leading-tight">
                                <p class="text-sm font-bold" style="color: var(--ink)">{{ Auth::user()->name }}</p>
                                <p class="mono text-[10px] font-semibold" style="color: var(--brand-dark)">{{ strtoupper(Auth::user()->role ?? 'lecturer') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div id="lecturerSuccessAlert" class="stagger-up mb-6 flex items-center justify-between rounded-2xl border border-emerald-300 bg-emerald-100 px-4 py-3 text-emerald-900 font-semibold shadow-sm transition-all duration-700 ease-in-out">
                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white text-xs font-bold">✓</span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-emerald-700 font-medium shrink-0 ml-4">
                            <svg class="h-4 w-4 animate-spin text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            setTimeout(() => {
                                const alertBox = document.getElementById('lecturerSuccessAlert');
                                if (alertBox) {
                                    alertBox.style.opacity = '0';
                                    alertBox.style.transform = 'translateY(-10px)';
                                    setTimeout(() => alertBox.remove(), 700);
                                }
                            }, 6000);
                        });
                    </script>
                @endif

                @if (session('error'))
                    <div id="lecturerErrorAlert" class="stagger-up mb-6 flex items-center justify-between rounded-2xl border border-red-300 bg-red-100 px-4 py-3 text-red-900 font-semibold shadow-sm transition-all duration-700 ease-in-out">
                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-600 text-white text-xs font-bold">✕</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            setTimeout(() => {
                                const alertBox = document.getElementById('lecturerErrorAlert');
                                if (alertBox) {
                                    alertBox.style.opacity = '0';
                                    alertBox.style.transform = 'translateY(-10px)';
                                    setTimeout(() => alertBox.remove(), 700);
                                }
                            }, 6000);
                        });
                    </script>
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
        function openSidebar() { sidebar.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); }
        function closeSidebar() { sidebar.classList.add('-translate-x-full'); backdrop.classList.add('hidden'); }
    </script>
    @stack('scripts')
</body>
</html>