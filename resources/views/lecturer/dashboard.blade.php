@extends('lecturer.layout')

@section('content')
<div class="space-y-6">
    <!-- Hero banner -->
    <section class="stagger-up rounded-[28px] p-6 sm:p-8 text-white relative overflow-hidden shadow-lg" style="--d: 0s; background: linear-gradient(135deg, #0d9488, #059669 60%, #0f766e); box-shadow: 0 24px 50px -18px rgba(13,148,136,0.4);">
        <div class="pointer-events-none absolute inset-0 opacity-40" style="background: radial-gradient(420px 300px at 90% -10%, rgba(255,255,255,0.25), transparent 70%);"></div>
        <p class="eyebrow relative text-emerald-50/90">Welcome back</p>
        <div class="relative mt-3 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold sm:text-4xl text-white">Manage live attendance sessions</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-50/90 font-medium">
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
                    <button type="submit" class="btn-nudge rounded-2xl bg-white px-5 py-3 text-sm font-bold hover:bg-emerald-50" style="color: var(--brand-dark)">
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

    <!-- Stat cards -->
    <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <article class="stagger-up lift-hover rounded-[24px] bg-white/80 p-6 shadow-sm border" style="--d: 0.08s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/><circle cx="12" cy="12" r="2.2"/></svg></div>
            <p class="text-sm font-semibold" style="color: #5b6660">Active sessions</p>
            <h2 class="mt-2 text-3xl font-bold" style="color: var(--ink)">{{ $activeSessionsCount }}</h2>
            <p class="mt-1 text-xs font-semibold" style="color: #9aa39c">Sessions currently open.</p>
        </article>
        <article class="stagger-up lift-hover rounded-[24px] bg-white/80 p-6 shadow-sm border" style="--d: 0.13s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="4.5" width="17" height="15" rx="2.5"/><path d="M3.5 9.5h17M8.5 4.5v4"/></svg></div>
            <p class="text-sm font-semibold" style="color: #5b6660">Total sessions</p>
            <h2 class="mt-2 text-3xl font-bold" style="color: var(--ink)">{{ $totalSessions }}</h2>
            <p class="mt-1 text-xs font-semibold" style="color: #9aa39c">All sessions you've created.</p>
        </article>
        <article class="stagger-up lift-hover rounded-[24px] bg-white/80 p-6 shadow-sm border" style="--d: 0.18s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 6L9 17l-5-5"/></svg></div>
            <p class="text-sm font-semibold" style="color: #5b6660">Check-ins</p>
            <h2 class="mt-2 text-3xl font-bold" style="color: var(--ink)">{{ $totalCheckIns }}</h2>
            <p class="mt-1 text-xs font-semibold" style="color: #9aa39c">Total attendance logs recorded.</p>
        </article>
        <article class="stagger-up lift-hover rounded-[24px] bg-white/80 p-6 shadow-sm border" style="--d: 0.23s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg></div>
            <p class="text-sm font-semibold" style="color: #5b6660">Today</p>
            <h2 class="mt-2 text-3xl font-bold" style="color: var(--ink)">{{ $todayCheckIns }}</h2>
            <p class="mt-1 text-xs font-semibold" style="color: #9aa39c">Attendance recorded today.</p>
        </article>
    </section>

    <!-- Quick actions / live session panel -->
    <section id="quick-actions" class="stagger-up rounded-[28px] bg-white/80 p-6 shadow-sm border" style="--d: 0.28s; border-color: var(--line)">
        <div class="mb-5">
            <p class="eyebrow">Quick actions</p>
            <h3 class="mt-1 text-xl font-bold" style="color: var(--ink)">Session tools</h3>
        </div>

        @if ($activeSession)
            <div class="grid gap-4 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="lift-hover rounded-3xl p-6 flex flex-col justify-between border" style="background: rgba(13,148,136,0.05); border-color: rgba(13,148,136,0.16)">
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold" style="color: #5b6660">Live session</p>
                            <span class="pulse-attention h-2 w-2 rounded-full" style="background: var(--brand)"></span>
                        </div>
                        <h4 class="mt-2 text-2xl font-bold" style="color: var(--ink)">{{ $activeSession->course_code }}</h4>
                        <p class="mt-2 text-sm font-medium break-all" style="color: #5b6660">Token: <span class="mono" style="color: var(--ink)">{{ $activeSession->session_token }}</span></p>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('student.scan', $activeSession->session_token) }}" target="_blank" class="btn-nudge rounded-2xl px-4 py-3 text-sm font-bold text-white hover:opacity-90" style="background: var(--brand)">
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

                <!-- Illustrated QR panel — phone-style mockup frame around the live code -->
                <div class="lift-hover rounded-3xl p-6 flex flex-col items-center justify-center border relative overflow-hidden" style="background: rgba(13,148,136,0.05); border-color: rgba(13,148,136,0.16)">
                    <div class="pointer-events-none absolute inset-0 opacity-60" style="background: radial-gradient(220px 180px at 50% 0%, rgba(13,148,136,0.12), transparent 70%)"></div>
                    <div class="relative rounded-[28px] border-4 p-3" style="border-color: var(--ink); background: var(--ink)">
                        <div id="qrcode-active" class="rounded-2xl bg-white p-3"></div>
                    </div>
                    <p class="relative mt-4 text-sm font-semibold" style="color: #5b6660">QR code for students to scan</p>
                    <p class="relative mt-1 text-xs font-semibold mono" style="color: var(--brand-dark)">Refreshes automatically every 30 minutes</p>
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
            <div class="rounded-3xl border border-dashed p-6 text-sm font-medium" style="border-color: var(--line); color: #7a8580; background: rgba(13,148,136,0.03)">
                No live session right now. Start a course session above to generate a QR code.
            </div>
        @endif
    </section>

    <!-- Session history + recent attendance -->
    <section class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="stagger-up rounded-[28px] bg-white/80 p-6 shadow-sm border" style="--d: 0.38s; border-color: var(--line)">
            <div class="mb-5">
                <p class="eyebrow">Sessions</p>
                <h3 class="mt-1 text-xl font-bold" style="color: var(--ink)">Session history</h3>
            </div>
            <div class="overflow-x-auto rounded-2xl border" style="border-color: var(--line)">
                <table class="w-full min-w-[480px] text-left text-sm">
                    <thead style="background: rgba(13,148,136,0.06)">
                        <tr>
                            <th class="px-4 py-3 eyebrow">Course</th>
                            <th class="px-4 py-3 eyebrow">Status</th>
                            <th class="px-4 py-3 eyebrow">Attendance</th>
                            <th class="px-4 py-3 eyebrow">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white/60" style="border-color: var(--line)">
                        @forelse ($sessions as $session)
                            <tr class="hover:bg-teal-50/40 transition">
                                <td class="px-4 py-4">
                                    <p class="font-bold" style="color: var(--ink)">{{ $session->course_code }}</p>
                                    <p class="text-xs font-semibold" style="color: #9aa39c">Session ID #{{ $session->id }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="state-transition rounded-full px-3 py-1 text-xs font-bold {{ $session->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $session->is_active ? 'Active' : 'Closed' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 font-semibold" style="color: #5b6660">{{ $session->attendances_count }}</td>
                                <td class="px-4 py-4">
                                    @if ($session->is_active)
                                        <form action="{{ route('lecturer.session.close', $session->id) }}" method="POST">
                                            @csrf
                                            <button class="btn-nudge rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-100">Close</button>
                                        </form>
                                    @else
                                        <span class="text-xs font-semibold" style="color: #9aa39c">Session ended</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm font-semibold" style="color: #9aa39c">No sessions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="stagger-up rounded-[28px] bg-white/80 p-6 shadow-sm border" style="--d: 0.43s; border-color: var(--line)">
            <div class="mb-5">
                <p class="eyebrow">Recent attendance</p>
                <h3 class="mt-1 text-xl font-bold" style="color: var(--ink)">Latest check-ins</h3>
            </div>
            <div class="space-y-3">
                @forelse ($recentAttendances as $attendance)
                    <div class="lift-hover rounded-2xl p-4 border flex items-center gap-3" style="background: rgba(13,148,136,0.04); border-color: rgba(13,148,136,0.14)">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-white text-xs font-bold" style="background: var(--brand)">
                            {{ strtoupper(substr($attendance->user->name ?? 'S', 0, 1)) }}
                        </div>
                        <div class="flex items-center justify-between gap-3 flex-1 min-w-0">
                            <div class="min-w-0">
                                <p class="font-bold truncate" style="color: var(--ink)">{{ $attendance->user->name ?? 'Unknown Student' }}</p>
                                <p class="text-xs font-semibold" style="color: #7a8580">{{ $attendance->session->course_code ?? 'Session' }} • {{ $attendance->scanned_at->format('M d, h:i A') }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">Checked in</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed p-4 text-xs font-semibold" style="border-color: var(--line); color: #9aa39c">
                        No attendance records yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection