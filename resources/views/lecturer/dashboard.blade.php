@extends('lecturer.layout')

@section('content')
<div class="space-y-6">
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
                    No courses assigned yet — claim one in the "My Courses" tab.
                </div>
            @endif
        </div>
    </section>

    <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <article class="stagger-up lift-hover rounded-[24px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.08s">
            <p class="text-sm font-semibold text-slate-600">Active Sessions</p>
            <h2 class="mt-3 text-3xl font-extrabold text-slate-900">{{ $activeSessionsCount }}</h2>
            <p class="mt-2 text-xs font-semibold text-slate-500">Sessions currently open.</p>
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

    <section id="quick-actions" class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.28s">
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
                                } catch (e) {}
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

    <section class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
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
                                    @if ($session->is_active)
                                        <form action="{{ route('lecturer.session.close', $session->id) }}" method="POST">
                                            @csrf
                                            <button class="btn-nudge rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-100">Close</button>
                                        </form>
                                    @else
                                        <span class="text-xs font-semibold text-slate-400">Session ended</span>
                                    @endif
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

        <div class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.43s">
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
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">Checked in</span>
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
</div>
@endsection