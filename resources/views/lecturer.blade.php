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

        #sidebar {
            transition: transform 0.3s ease;
        }

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

        .stagger-up {
            animation: fadeInUp 0.5s ease both;
            animation-delay: var(--d, 0s);
        }

        .stagger-left {
            animation: fadeInLeft 0.45s ease both;
            animation-delay: var(--d, 0s);
        }

        .lift-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .lift-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.14);
        }

        .btn-nudge {
            transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }
        .btn-nudge:hover {
            transform: translateY(-2px);
        }

        .progress-fill {
            width: 0%;
            animation: progressGrow 0.8s ease 0.45s forwards;
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
                    <a href="#sessions" onclick="scrollToSection(event, 'sessions')" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-900">
                        <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
                        Sessions
                    </a>
                    <a href="#attendance" onclick="scrollToSection(event, 'attendance')" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-900">
                        <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
                        Attendance
                    </a>
                    <a href="#students" onclick="scrollToSection(event, 'students')" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-900">
                        <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
                        Students
                    </a>
                    <a href="#my-courses" onclick="scrollToSection(event, 'my-courses')" class="state-transition flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-900">
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
                            <p class="text-xs uppercase tracking-[0.3em] text-emerald-700 font-bold">Lecturer Dashboard</p>
                            <h2 class="text-lg font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <button class="btn-nudge rounded-full border border-emerald-200 p-2 text-slate-700 hover:text-emerald-800 bg-white shadow-sm">
                            <span class="sr-only">Notifications</span>
                            <span class="text-lg">🔔</span>
                        </button>
                        <div class="lift-hover hidden items-center gap-3 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-2 shadow-sm sm:flex hover:bg-emerald-100">
                            @if (Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-600 text-white font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
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
                    <div class="stagger-up mb-6 rounded-2xl border border-emerald-300 bg-emerald-100 px-4 py-3 text-emerald-900 font-semibold shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="stagger-up mb-6 rounded-2xl border border-red-300 bg-red-100 px-4 py-3 text-red-900 font-semibold shadow-sm">
                        {{ session('error') }}
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

                <section class="stagger-up rounded-[28px] border border-emerald-200 bg-gradient-to-r from-emerald-600 to-teal-600 p-8 shadow-lg shadow-emerald-500/10 text-white" style="--d: 0s">
                    <p class="text-xs uppercase tracking-[0.32em] text-emerald-100 font-bold">Welcome back</p>
                    <div class="mt-3 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold sm:text-4xl">Manage live attendance sessions</h1>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-50 font-medium">
                                Start a session for one of your assigned courses, show the QR code to students, and monitor attendance in real time.
                            </p>
                        </div>
                        @if ($myCourses->isNotEmpty())
                            <form action="{{ route('lecturer.session.start') }}" method="POST" class="grid gap-3 sm:grid-cols-[1fr_auto]">
                                @csrf
                                <select name="course_code" class="state-transition min-w-0 rounded-2xl border border-white/30 bg-white/10 px-4 py-3 text-white outline-none">
                                    <option value="" class="text-slate-900">Select course</option>
                                    @foreach ($myCourses as $course)
                                        <option value="{{ $course->course_code }}" class="text-slate-900">{{ $course->course_code }} - {{ $course->course_title }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-nudge rounded-2xl bg-white px-5 py-3 text-sm font-bold text-emerald-700 hover:bg-emerald-50">
                                    Start Session
                                </button>
                            </form>
                        @else
                            <div class="rounded-2xl border border-white/30 bg-white/10 px-4 py-3 text-sm font-semibold text-white">
                                No courses assigned yet — claim one below to get started.
                            </div>
                        @endif
                    </div>
                </section>

                <section class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <article class="stagger-up lift-hover rounded-[24px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.08s">
                        <p class="text-sm font-semibold text-slate-600">Active Session{{ $activeSessionsCount === 1 ? '' : 's' }}</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900">{{ $activeSessionsCount }}</h2>
                        <p class="mt-2 text-xs font-semibold text-slate-500">Sessions you currently have open.</p>
                    </article>

                    <article class="stagger-up lift-hover rounded-[24px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.13s">
                        <p class="text-sm font-semibold text-slate-600">Total Sessions</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900">{{ $totalSessions }}</h2>
                        <p class="mt-2 text-xs font-semibold text-slate-500">All sessions you've created.</p>
                    </article>

                    <article class="stagger-up lift-hover rounded-[24px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.18s">
                        <p class="text-sm font-semibold text-slate-600">Check-ins</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900">{{ $totalCheckIns }}</h2>
                        <p class="mt-2 text-xs font-semibold text-slate-500">Total attendance logs recorded.</p>
                    </article>

                    <article class="stagger-up lift-hover rounded-[24px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.23s">
                        <p class="text-sm font-semibold text-slate-600">Today</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900">{{ $todayCheckIns }}</h2>
                        <p class="mt-2 text-xs font-semibold text-slate-500">Attendance recorded today.</p>
                    </article>
                </section>

                <section id="quick-actions" class="stagger-up mt-6 rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.28s">
                    <div class="mb-5">
                        <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Quick Actions</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Session tools</h3>
                    </div>

                    @if ($activeSession)
                        <div class="grid gap-4 lg:grid-cols-[0.9fr_1.1fr]">
                            <div class="lift-hover rounded-3xl border border-emerald-100 bg-slate-50 p-6 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-slate-600">Live Session</p>
                                        <span class="pulse-attention h-2 w-2 rounded-full bg-emerald-500"></span>
                                    </div>
                                    <h4 class="mt-2 text-2xl font-bold text-slate-900">{{ $activeSession->course_code }}</h4>
                                    <p class="mt-2 text-sm font-medium text-slate-600 break-all">Token: <span class="font-mono text-slate-800">{{ $activeSession->session_token }}</span></p>
                                </div>

                                <div class="mt-5 flex flex-wrap gap-3">
                                    <a href="{{ route('student.scan', $activeSession->session_token) }}" target="_blank" class="btn-nudge rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                                        Open Student View
                                    </a>
                                    <form action="{{ route('lecturer.session.close', $activeSession->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-nudge rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700 hover:bg-red-100">
                                            Close Session
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="lift-hover rounded-3xl border border-emerald-100 bg-slate-50 p-6 flex flex-col items-center justify-center">
                                <div id="qrcode-active" class="rounded-2xl bg-white p-3 shadow-sm border border-emerald-100"></div>
                                <p class="mt-4 text-sm font-semibold text-slate-600">QR code for students to scan</p>
                                <p class="mt-1 text-xs font-semibold text-emerald-600">Refreshes automatically every 30 minutes</p>
                                <script>
                                    (function () {
                                        const container = document.getElementById('qrcode-active');
                                        const qr = new QRCode(container, {
                                            text: "{{ route('student.scan', $activeSession->session_token) }}",
                                            width: 180,
                                            height: 180
                                        });

                                        // Auto-rotate every 30 minutes (30 * 60 * 1000 ms)
                                        const rotateEveryMs = 30 * 60 * 1000;

                                        setInterval(async () => {
                                            try {
                                                const res = await fetch("{{ route('lecturer.session.rotate', $activeSession->id) }}", {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                        'Accept': 'application/json',
                                                    },
                                                });
                                                if (!res.ok) return;
                                                const data = await res.json();
                                                qr.clear();
                                                qr.makeCode(data.new_url);
                                            } catch (e) {
                                                // Silent retry on next tick
                                            }
                                        }, rotateEveryMs);
                                    })();
                                </script>
                            </div>
                        </div>
                    @else
                        <div class="rounded-3xl border border-dashed border-emerald-200 bg-slate-50 p-6 text-sm font-medium text-slate-500">
                            No live session right now. Start a course session above to generate a QR code.
                        </div>
                    @endif
                </section>

                <section id="students" class="stagger-up mt-6 rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.33s">
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Students</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">Attendance summary</h3>
                        </div>
                        <div class="relative w-full max-w-xs">
                            <input
                                type="text"
                                id="studentSearchInput"
                                onkeyup="filterStudentTable()"
                                placeholder="Search by name or matric number..."
                                class="state-transition w-full rounded-2xl border border-emerald-200 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-emerald-500"
                            >
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-emerald-100">
                        <table class="w-full min-w-[480px] text-left text-sm" id="studentSummaryTable">
                            <thead class="bg-emerald-50/60 text-emerald-800 font-bold">
                                <tr>
                                    <th class="px-4 py-3">Student</th>
                                    <th class="px-4 py-3">Times attended</th>
                                    <th class="px-4 py-3">Last check-in</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50 bg-white">
                                @forelse ($studentAttendanceCounts as $entry)
                                    <tr class="hover:bg-slate-50 transition student-row" data-search="{{ strtolower($entry->user->name . ' ' . ($entry->user->matric_number ?? '')) }}">
                                        <td class="px-4 py-4">
                                            <p class="font-bold text-slate-900">{{ $entry->user->name }}</p>
                                            <p class="text-xs font-semibold text-slate-500">{{ $entry->user->matric_number ?? $entry->user->email }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                                {{ $entry->count }} {{ Str::plural('time', $entry->count) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 font-semibold text-slate-600">
                                            {{ $entry->last_checked_in ? \Carbon\Carbon::parse($entry->last_checked_in)->format('M d, h:i A') : '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-6 text-center text-sm font-semibold text-slate-400">No attendance recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <p id="noStudentResults" class="hidden px-4 py-6 text-center text-sm font-semibold text-slate-400">No students match your search.</p>
                    </div>
                </section>

                <section id="sessions" class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                    <div class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.38s">
                        <div class="mb-5">
                            <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Sessions</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">Session history</h3>
                        </div>

                        <div class="overflow-x-auto rounded-2xl border border-emerald-100">
                            <table class="w-full min-w-[480px] text-left text-sm">
                                <thead class="bg-emerald-50/60 text-emerald-800 font-bold">
                                    <tr>
                                        <th class="px-4 py-3">Course</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Attendance</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-emerald-50 bg-white">
                                    @forelse ($sessions as $session)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-4 py-4">
                                                <p class="font-bold text-slate-900">{{ $session->course_code }}</p>
                                                <p class="text-xs font-semibold text-slate-500">Session ID #{{ $session->id }}</p>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="state-transition rounded-full px-3 py-1 text-xs font-bold {{ $session->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                                    {{ $session->is_active ? 'Active' : 'Closed' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 font-semibold text-slate-700">{{ $session->attendances_count }}</td>
                                            <td class="px-4 py-4">
                                                <div class="flex flex-wrap gap-2">
                                                    @if ($session->is_active)
                                                        <a href="{{ route('student.scan', $session->session_token) }}" target="_blank" class="btn-nudge rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                                            Open
                                                        </a>
                                                        <form action="{{ route('lecturer.session.close', $session->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btn-nudge rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-100">
                                                                Close
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-xs font-semibold text-slate-400">Session ended</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-sm font-semibold text-slate-400">No sessions yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="attendance" class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.43s">
                        <div class="mb-5">
                            <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Recent attendance</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">Latest check-ins</h3>
                        </div>

                        <div class="space-y-3">
                            @forelse ($recentAttendances as $attendance)
                                <div class="lift-hover rounded-2xl border border-emerald-100 bg-slate-50 p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $attendance->user->name ?? 'Unknown Student' }}</p>
                                            <p class="text-xs font-semibold text-slate-600">{{ $attendance->session->course_code ?? 'Session' }} • {{ $attendance->scanned_at->format('M d, h:i A') }}</p>
                                        </div>
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                            Checked in
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-emerald-200 bg-slate-50 p-4 text-xs font-semibold text-slate-500">
                                    No attendance records yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section id="my-courses" class="stagger-up mt-6 rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.48s">
                    <div class="mb-5">
                        <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">My Courses</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Courses assigned to you</h3>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($myCourses as $course)
                            <div class="lift-hover rounded-2xl border border-emerald-100 bg-emerald-50/30 p-4">
                                <p class="font-bold text-slate-900">{{ $course->course_code }}</p>
                                <p class="text-xs font-semibold text-slate-500">{{ $course->course_title }}</p>
                                <p class="mt-2 text-xs font-semibold text-emerald-700">{{ $course->level }}L &bull; {{ $course->semester }} semester</p>
                            </div>
                        @empty
                            <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-emerald-200 bg-slate-50 p-5 text-center text-sm font-medium text-slate-500">
                                You have no assigned courses yet — claim one from the list below.
                            </div>
                        @endforelse
                    </div>

                    @if ($unclaimedCourses->isNotEmpty())
                        <div class="mt-6 border-t border-emerald-100 pt-6">
                            <p class="text-xs uppercase tracking-[0.28em] text-amber-700 font-bold">Unclaimed courses</p>
                            <p class="mt-1 text-sm text-slate-500">No lecturer assigned yet — claim any of these as your own.</p>

                            <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($unclaimedCourses as $course)
                                    <form action="{{ route('lecturer.course.claim', $course->id) }}" method="POST" class="lift-hover rounded-2xl border border-amber-200 bg-amber-50/40 p-4">
                                        @csrf
                                        <p class="font-bold text-slate-900">{{ $course->course_code }}</p>
                                        <p class="text-xs font-semibold text-slate-500">{{ $course->course_title }}</p>
                                        <p class="mt-1 text-xs font-semibold text-amber-700">{{ $course->level }}L &bull; {{ $course->semester }} semester</p>
                                        <button type="submit" class="btn-nudge mt-3 w-full rounded-xl bg-amber-500 px-3 py-2 text-xs font-bold text-white hover:bg-amber-600">
                                            Claim this course
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>
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

        function scrollToSection(event, id) {
            event.preventDefault();
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            closeSidebar();
        }

        function filterStudentTable() {
            const query = document.getElementById('studentSearchInput').value.trim().toLowerCase();
            const rows = document.querySelectorAll('#studentSummaryTable .student-row');
            const noResults = document.getElementById('noStudentResults');
            let visibleCount = 0;

            rows.forEach((row) => {
                const matches = row.dataset.search.includes(query);
                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            if (rows.length > 0) {
                noResults.classList.toggle('hidden', visibleCount !== 0);
            }
        }
    </script>
</body>
</html>