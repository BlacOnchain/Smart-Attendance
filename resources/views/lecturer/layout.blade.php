<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Attendance | Lecturer Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            background:
                radial-gradient(circle at top left, rgba(34, 197, 94, 0.12), transparent 28%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.08), transparent 25%),
                linear-gradient(180deg, #f7fff9 0%, #eefaf1 100%);
        }
        #sidebar { transition: transform 0.3s ease; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .stagger-up { animation: fadeInUp 0.5s ease both; animation-delay: var(--d, 0s); }
        .lift-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .lift-hover:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(5, 150, 105, 0.14); }
        .btn-nudge { transition: transform 0.15s ease, box-shadow 0.15s ease; }
        .btn-nudge:hover { transform: translateY(-2px); }
        .pulse-attention { animation: softPulse 1.6s ease-in-out infinite; }
        @keyframes softPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.55; } }
        .state-transition { transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen text-slate-900">
    <div class="min-h-screen lg:flex">
        <div id="sidebarBackdrop" onclick="closeSidebar()" class="fixed inset-0 z-30 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-emerald-100 bg-white/80 backdrop-blur-xl lg:sticky lg:top-0 lg:flex lg:h-screen lg:w-72 lg:translate-x-0 lg:flex-col lg:border-b-0 lg:border-r">
            <div class="flex items-center justify-between gap-3 border-b border-emerald-100 px-5 py-5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/smart-attendance-logo.png') }}" alt="Smart Attendance logo" class="h-11 w-11 rounded-2xl object-cover">
                    <div>
                        <p class="text-xs uppercase tracking-[0.32em] text-emerald-700 font-bold">Smart Attendance</p>
                        <h1 class="text-lg font-bold text-slate-900">Lecturer Portal</h1>
                    </div>
                </div>
                <button onclick="closeSidebar()" class="rounded-lg p-2 text-slate-500 hover:bg-emerald-50 lg:hidden" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-5">
                <p class="px-3 pb-3 text-xs uppercase tracking-[0.28em] text-slate-700 font-bold">Navigation</p>
                <div class="space-y-2">
                    <a href="{{ route('lecturer.dashboard') }}" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('lecturer.dashboard') ? 'border border-emerald-300 bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
                        Dashboard
                    </a>
                    <a href="{{ route('lecturer.students') }}" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('lecturer.students') ? 'border border-emerald-300 bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
                        Attendance Summary
                    </a>
                    <a href="{{ route('lecturer.courses') }}" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('lecturer.courses') ? 'border border-emerald-300 bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }}">
                        <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
                        My Courses
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

        <div class="flex-1">
            <header class="border-b border-emerald-100 bg-white/90 backdrop-blur-xl shadow-sm sticky top-0 z-20">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button onclick="openSidebar()" class="rounded-lg border border-emerald-200 p-2 text-emerald-700 hover:bg-emerald-50 lg:hidden" aria-label="Open menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-emerald-700 font-bold">Lecturer Portal</p>
                            <h2 class="text-lg font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="lift-hover hidden items-center gap-3 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-2 shadow-sm sm:flex hover:bg-emerald-100">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-600 text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="leading-tight">
                                <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-emerald-800 font-semibold uppercase tracking-wider">{{ Auth::user()->role ?? 'lecturer' }}</p>
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
                            }, 6000); // Disappears after 6 seconds
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