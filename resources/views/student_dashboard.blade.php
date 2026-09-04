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
                        <!-- Loading spinner animation -->
                        <svg class="h-4 w-4 animate-spin text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>

                        <!-- Manual close button -->
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
                        // Automatically hide after 6 seconds with fade animation
                        setTimeout(() => {
                            if (banner) {
                                banner.style.opacity = '0';
                                banner.style.transform = 'translateY(-10px)';
                                setTimeout(() => {
                                    banner.style.display = 'none';
                                    sessionStorage.setItem(storageKey, 'true');
                                }, 700);
                            }
                        }, 6000); // 6 seconds
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
                    <!-- Leads straight to the QR scanner page -->
                    <a href="{{ route('student.camera') }}" class="btn-nudge inline-flex items-center justify-center rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600 whitespace-nowrap">
                        Check in now
                    </a>
                </div>
            </section>
        @endif
    @endif

    <!-- Compact welcome banner -->
    <section class="stagger-up rounded-2xl border border-emerald-800 bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-800 px-5 py-5 shadow-lg shadow-emerald-900/10 sm:px-6" style="--d: 0.05s">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 flex-wrap items-center gap-3">
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-[0.28em] text-emerald-200">Welcome back</p>
                    <h1 class="mt-1 truncate text-xl font-semibold text-white sm:text-2xl">{{ Auth::user()->name }}</h1>
                </div>
                @if ($activeSession)
                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-1 text-xs font-bold text-white">
                        <span class="h-1.5 w-1.5 rounded-full bg-white pulse-attention"></span>
                        LIVE
                    </span>
                @endif
            </div>
            <a href="{{ route('student.camera') }}" class="btn-nudge inline-flex items-center justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-50 whitespace-nowrap">
                Open QR Scanner
            </a>
        </div>
    </section>

    <!-- Stat cards -->
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <article class="stagger-up lift-hover rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm" style="--d: 0.1s">
            <p class="text-xs text-slate-500">Active Session</p>
            <p class="mt-2 text-2xl font-semibold {{ $activeSession ? 'text-emerald-600' : 'text-slate-900' }}">
                {{ $activeSession ? 'LIVE' : 'None' }}
            </p>
        </article>

        <article class="stagger-up lift-hover rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm" style="--d: 0.15s">
            <p class="text-xs text-slate-500">Attendance Count</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $attendanceCount }}</p>
        </article>

        <article class="stagger-up lift-hover rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm" style="--d: 0.2s">
            <p class="text-xs text-slate-500">Enrolled Courses</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $courses->count() }}</p>
        </article>

        <article class="stagger-up lift-hover rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm" style="--d: 0.25s">
            <p class="text-xs text-slate-500">Timetable Slots</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $timetableCount }}</p>
        </article>
    </section>

    <!-- Quick actions + Recent check-ins, side by side -->
    <section class="grid gap-4 lg:grid-cols-[1.3fr_0.9fr]">
        <div class="stagger-up rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm" style="--d: 0.3s">
            <p class="text-xs uppercase tracking-[0.24em] text-emerald-700 font-bold">Quick Actions</p>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('student.camera') }}" class="lift-hover rounded-xl border border-emerald-100 bg-emerald-50/40 p-4 hover:border-emerald-400">
                    <p class="text-sm font-semibold text-slate-900">Scan QR code</p>
                    <p class="mt-1 text-xs text-slate-500">Open the live scanner.</p>
                </a>
                <a href="{{ route('student.profile') }}" class="lift-hover rounded-xl border border-emerald-100 bg-emerald-50/40 p-4 hover:border-emerald-400">
                    <p class="text-sm font-semibold text-slate-900">My profile</p>
                    <p class="mt-1 text-xs text-slate-500">Details, photo, courses.</p>
                </a>
                <a href="{{ route('student.timetable') }}" class="lift-hover rounded-xl border border-emerald-100 bg-emerald-50/40 p-4 hover:border-emerald-400 sm:col-span-2">
                    <p class="text-sm font-semibold text-slate-900">Open timetable</p>
                    <p class="mt-1 text-xs text-slate-500">See your lecture days and class times.</p>
                </a>
            </div>
        </div>

        <div class="stagger-up rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm" style="--d: 0.35s">
            <p class="text-xs uppercase tracking-[0.24em] text-emerald-700 font-bold">Recent Check-ins</p>
            <div class="mt-4 space-y-2">
                @forelse ($recentAttendances->take(3) as $attendance)
                    <div class="flex items-center justify-between rounded-xl border border-emerald-100 bg-emerald-50/30 px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $attendance->session->course_code ?? 'Session' }}</p>
                            <p class="text-xs text-slate-500">{{ $attendance->scanned_at->format('M d, h:i A') }}</p>
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

    <!-- Single unified courses + attendance section -->
    <section class="stagger-up rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm" style="--d: 0.4s">
        <p class="text-xs uppercase tracking-[0.24em] text-emerald-700 font-bold">Your Courses</p>

        <div class="mt-4 grid gap-3 md:grid-cols-2">
            @forelse ($courseAttendanceStats as $stat)
                @php
                    $percentage = $stat->total > 0 ? round(($stat->attended / $stat->total) * 100) : 0;
                    $isLive = $activeSession && $activeSession->course_code === $stat->course_code;
                @endphp
                <div class="lift-hover rounded-xl border border-emerald-100 bg-emerald-50/30 p-4">
                    <div class="flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $stat->course_code }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $stat->course_title }}</p>
                        </div>
                        @if ($isLive)
                            <a href="{{ route('student.camera') }}" class="btn-nudge shrink-0 rounded-lg bg-emerald-600 px-2.5 py-1 text-xs font-semibold text-white hover:bg-emerald-700">
                                Live
                            </a>
                        @else
                            <span class="shrink-0 text-xs font-semibold text-slate-500">{{ $stat->attended }}/{{ $stat->total }}</span>
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