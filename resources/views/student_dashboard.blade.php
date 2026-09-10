@extends('student')

@section('content')
<div class="space-y-5">

    @if ($activeSession)
        @if ($hasCheckedInActive)
            <section id="checkedInBanner" class="state-transition stagger-up rounded-2xl border border-emerald-300 bg-emerald-50 px-5 py-4 shadow-sm transition-all duration-700 ease-in-out" style="--d: 0s">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white font-bold">✓</span>
                        <p class="text-sm font-semibold text-slate-900">You're checked in for {{ $activeSession->course_code }}</p>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <svg class="h-4 w-4 animate-spin text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>

                        <button type="button" onclick="dismissCheckedInBanner()" class="btn-nudge rounded-full p-1.5 text-emerald-700 hover:bg-emerald-100" aria-label="Dismiss">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <script>
                function dismissCheckedInBanner() {
                    const banner = document.getElementById('checkedInBanner');
                    if (banner) {
                        banner.style.opacity = '0';
                        banner.style.transform = 'translateY(-10px)';
                        setTimeout(() => banner.remove(), 700);
                        const sessionId = "{{ $activeSession->id }}";
                        sessionStorage.setItem(`checked_in_dismissed_${sessionId}`, 'true');
                    }
                }

                document.addEventListener('DOMContentLoaded', () => {
                    const sessionId = "{{ $activeSession->id }}";
                    const storageKey = `checked_in_dismissed_${sessionId}`;
                    const banner = document.getElementById('checkedInBanner');

                    if (sessionStorage.getItem(storageKey)) {
                        if (banner) banner.style.display = 'none';
                    } else {
                        setTimeout(() => {
                            if (banner) {
                                banner.style.opacity = '0';
                                banner.style.transform = 'translateY(-10px)';
                                setTimeout(() => {
                                    banner.style.display = 'none';
                                    sessionStorage.setItem(storageKey, 'true');
                                }, 700);
                            }
                        }, 6000);
                    }
                });
            </script>
        @else
            <section class="stagger-up rounded-2xl border border-amber-300 bg-amber-50 px-5 py-4 shadow-sm" style="--d: 0s">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <span class="pulse-attention flex h-9 w-9 items-center justify-center rounded-full bg-amber-500 text-white">!</span>
                        <p class="text-sm font-semibold text-slate-900">{{ $activeSession->course_code }} is live — you haven't checked in</p>
                    </div>
                    <a href="{{ route('student.camera') }}" class="btn-nudge inline-flex items-center justify-center rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600 whitespace-nowrap">
                        Check in now
                    </a>
                </div>
            </section>
        @endif
    @endif

    <!-- Welcome banner -->
    <section class="stagger-up rounded-[28px] px-5 py-6 shadow-lg sm:px-8 sm:py-7 text-white relative overflow-hidden" style="--d: 0.05s; background: linear-gradient(135deg, #059669, #0d9488 60%, #047857); box-shadow: 0 24px 50px -18px rgba(5,150,105,0.4);">
        <div class="pointer-events-none absolute inset-0 opacity-40" style="background: radial-gradient(420px 300px at 90% -10%, rgba(255,255,255,0.25), transparent 70%);"></div>
        <div class="relative flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 flex-wrap items-center gap-3">
                <div class="min-w-0">
                    <p class="mono text-[11px] font-semibold text-emerald-50/90">Welcome back</p>
                    <h1 class="mt-1 truncate text-xl font-bold text-white sm:text-2xl">{{ Auth::user()->name }}</h1>
                </div>
                @if ($activeSession)
                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-1 text-xs font-bold text-white">
                        <span class="h-1.5 w-1.5 rounded-full bg-white pulse-attention"></span>
                        LIVE
                    </span>
                @endif
            </div>
            <a href="{{ route('student.camera') }}" class="btn-nudge inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-50 whitespace-nowrap">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="6" width="17" height="13" rx="2.5"/><circle cx="12" cy="12.5" r="3.2"/><path d="M8.5 6L10 4h4l1.5 2"/></svg>
                Open QR Scanner
            </a>
        </div>
    </section>

    <!-- Stat cards -->
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <article class="stagger-up lift-hover rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.1s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/><circle cx="12" cy="12" r="2.2"/></svg></div>
            <p class="text-xs" style="color: #7a8580">Active session</p>
            <p class="mt-1 text-2xl font-bold {{ $activeSession ? 'text-emerald-600' : '' }}" style="{{ $activeSession ? '' : 'color: var(--ink)' }}">
                {{ $activeSession ? 'LIVE' : 'None' }}
            </p>
        </article>

        <article class="stagger-up lift-hover rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.15s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 6L9 17l-5-5"/></svg></div>
            <p class="text-xs" style="color: #7a8580">Attendance count</p>
            <p class="mt-1 text-2xl font-bold" style="color: var(--ink)">{{ $attendanceCount }}</p>
        </article>

        <article class="stagger-up lift-hover rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.2s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16" rx="2.5"/><path d="M4 9.5h16M9 4v4.5"/></svg></div>
            <p class="text-xs" style="color: #7a8580">Enrolled courses</p>
            <p class="mt-1 text-2xl font-bold" style="color: var(--ink)">{{ $courses->count() }}</p>
        </article>

        <article class="stagger-up lift-hover rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.25s; border-color: var(--line)">
            <div class="nav-icon mb-3"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="3.5" width="17" height="17" rx="2.5"/><path d="M3.5 9.5h17M8.5 3.5v6"/></svg></div>
            <p class="text-xs" style="color: #7a8580">Timetable slots</p>
            <p class="mt-1 text-2xl font-bold" style="color: var(--ink)">{{ $timetableCount }}</p>
        </article>
    </section>

    <!-- Student journey -->
    <section class="stagger-up rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.28s; border-color: var(--line)">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="eyebrow">Your attendance journey</p>
                <h2 class="mt-1 text-xl font-bold" style="color: var(--ink)">Set up once, check in in seconds</h2>
            </div>
            <p class="text-xs font-medium" style="color: #7a8580">Start with your profile, then follow the live session.</p>
        </div>

        <div class="journey-track relative mt-6 grid grid-cols-4 gap-2 sm:gap-5">
            <span class="journey-dot absolute top-[22px] h-1.5 w-1.5 rounded-full bg-emerald-600 shadow-[0_0_0_4px_rgba(5,150,105,.12)]"></span>
            <a href="{{ route('student.profile') }}" class="journey-node rounded-2xl border bg-white/80 p-3 text-center sm:p-4" style="border-color: var(--line)">
                <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg>
                </span>
                <p class="mt-3 text-xs font-bold sm:text-sm">Profile</p>
                <p class="mt-1 hidden text-[11px] sm:block" style="color: #7a8580">Set your details</p>
            </a>
            <a href="{{ route('student.timetable') }}" class="journey-node rounded-2xl border bg-white/80 p-3 text-center sm:p-4" style="border-color: var(--line)">
                <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-700">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="4" y="4.5" width="16" height="15" rx="2.5"/><path d="M4 9.5h16M9 4v3M15 4v3"/></svg>
                </span>
                <p class="mt-3 text-xs font-bold sm:text-sm">Schedule</p>
                <p class="mt-1 hidden text-[11px] sm:block" style="color: #7a8580">Find your class</p>
            </a>
            <a href="{{ route('student.camera') }}" class="journey-node is-current rounded-2xl border bg-white/80 p-3 text-center sm:p-4" style="border-color: var(--line)">
                <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3.5" y="6" width="17" height="13" rx="2.5"/><circle cx="12" cy="12.5" r="3.2"/><path d="M8.5 6L10 4h4l1.5 2"/></svg>
                </span>
                <p class="mt-3 text-xs font-bold sm:text-sm">Scan</p>
                <p class="mt-1 hidden text-[11px] sm:block" style="color: #7a8580">Check in live</p>
            </a>
            <a href="#courseAttendance" class="journey-node rounded-2xl border bg-white/80 p-3 text-center sm:p-4" style="border-color: var(--line)">
                <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 12l4 4L19 6"/><circle cx="12" cy="12" r="9"/></svg>
                </span>
                <p class="mt-3 text-xs font-bold sm:text-sm">History</p>
                <p class="mt-1 hidden text-[11px] sm:block" style="color: #7a8580">Track progress</p>
            </a>
        </div>
    </section>

    <!-- Quick actions + Recent check-ins, side by side -->
    <section class="grid gap-4 lg:grid-cols-[1.3fr_0.9fr]">
        <div class="stagger-up rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.3s; border-color: var(--line)">
            <p class="eyebrow">Quick actions</p>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('student.camera') }}" class="lift-hover rounded-xl p-4 hover:border-emerald-400 border" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.14)">
                    <p class="text-sm font-semibold" style="color: var(--ink)">Scan QR code</p>
                    <p class="mt-1 text-xs" style="color: #7a8580">Open the live scanner.</p>
                </a>
                <a href="{{ route('student.profile') }}" class="lift-hover rounded-xl p-4 hover:border-emerald-400 border" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.14)">
                    <p class="text-sm font-semibold" style="color: var(--ink)">My profile</p>
                    <p class="mt-1 text-xs" style="color: #7a8580">Details, photo, courses.</p>
                </a>
                <a href="{{ route('student.timetable') }}" class="lift-hover rounded-xl p-4 hover:border-emerald-400 border sm:col-span-2" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.14)">
                    <p class="text-sm font-semibold" style="color: var(--ink)">Open timetable</p>
                    <p class="mt-1 text-xs" style="color: #7a8580">See your lecture days and class times.</p>
                </a>
            </div>
        </div>

        <div class="stagger-up rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.35s; border-color: var(--line)">
            <p class="eyebrow">Recent check-ins</p>
            <div class="mt-4 space-y-2">
                @forelse ($recentAttendances->take(3) as $attendance)
                    <div class="flex items-center justify-between rounded-xl p-4 border" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.14)">
                        <div>
                            <p class="text-sm font-semibold" style="color: var(--ink)">{{ $attendance->session->course_code ?? 'Session' }}</p>
                            <p class="text-xs" style="color: #7a8580">{{ $attendance->scanned_at->format('M d, h:i A') }}</p>
                        </div>
                        <span class="text-emerald-600 text-lg">✓</span>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-emerald-200 bg-emerald-50/20 px-4 py-6 text-center text-sm text-slate-500">
                        No check-ins yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Courses + attendance section -->
    <section id="courseAttendance" class="stagger-up rounded-2xl bg-white/80 p-5 shadow-sm border" style="--d: 0.4s; border-color: var(--line)">
        <p class="eyebrow">Your courses</p>

        <div class="mt-4 grid gap-3 md:grid-cols-2">
            @forelse ($courseAttendanceStats as $stat)
                @php
                    $percentage = $stat->total > 0 ? round(($stat->attended / $stat->total) * 100) : 0;
                    $isLive = $activeSession && $activeSession->course_code === $stat->course_code;
                @endphp
                <div class="lift-hover rounded-xl p-4 border" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.14)">
                    <div class="flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold" style="color: var(--ink)">{{ $stat->course_code }}</p>
                            <p class="truncate text-xs" style="color: #7a8580">{{ $stat->course_title }}</p>
                        </div>
                        @if ($isLive)
                            <a href="{{ route('student.camera') }}" class="btn-nudge shrink-0 rounded-lg bg-emerald-600 px-2.5 py-1 text-xs font-semibold text-white hover:bg-emerald-700">
                                Live
                            </a>
                        @else
                            <span class="shrink-0 text-xs font-semibold" style="color: #9aa39c">{{ $stat->attended }}/{{ $stat->total }}</span>
                        @endif
                    </div>
                    <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-emerald-100">
                        <div class="progress-fill h-full rounded-full bg-emerald-600" style="--target-width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 rounded-xl border border-dashed border-emerald-200 bg-emerald-50/20 p-5 text-center text-sm text-slate-500">
                    No courses enrolled yet — set them up in your profile.
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection