@extends('student')

@section('content')
@php
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    $scheduleByDay = [];

    foreach ($daysOfWeek as $day) {
        $scheduleByDay[$day] = [];
    }

    foreach ($timetables ?? [] as $timetable) {
        $day = ucfirst(strtolower(trim($timetable->day_of_week)));
        if (array_key_exists($day, $scheduleByDay)) {
            $scheduleByDay[$day][] = $timetable;
        }
    }
@endphp

<div class="space-y-6">
    <!-- Clean Static Header Banner -->
    <section class="stagger-up rounded-[28px] border border-emerald-200 bg-gradient-to-r from-emerald-600 to-teal-600 p-6 sm:p-8 shadow-lg shadow-emerald-500/10 text-white" style="--d: 0s">
        <div class="flex flex-wrap items-center gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.32em] text-emerald-100 font-bold">Official Student Timetable</p>
                <h1 class="mt-1 text-2xl font-extrabold sm:text-4xl text-white">{{ $selectedLevelLabel }} Timetable</h1>
                <p class="mt-2 text-sm leading-6 text-emerald-50 font-medium">
                    Synced with your profile &bull; {{ $selectedSemester }} Semester Schedule.
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-1.5 text-xs font-bold text-white">
                {{ $selectedLevelLabel }} &bull; {{ $selectedSemester }}
            </span>
        </div>
    </section>

    <!-- Weekly Schedule Timeline Grid: staggers left-to-right, matching the horizontal grid -->
    <div class="grid gap-6 lg:grid-cols-5 md:grid-cols-2">
        @foreach ($daysOfWeek as $day)
            <div class="stagger-left lift-hover rounded-[24px] border border-emerald-100 bg-white p-5 shadow-sm flex flex-col justify-between" style="--d: {{ $loop->index * 0.08 }}s">
                <div>
                    <!-- Day Header -->
                    <div class="flex items-center justify-between border-b border-emerald-100 pb-3 mb-4">
                        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wider">{{ $day }}</h3>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold text-emerald-700">
                            {{ count($scheduleByDay[$day]) }} Classes
                        </span>
                    </div>

                    <!-- Classes for this Day -->
                    <div class="space-y-3">
                        @forelse ($scheduleByDay[$day] as $slot)
                            @php
                                $courseDetail = null;
                                foreach ($levelCourses as $lc) {
                                    if ($lc['code'] === $slot->course_code) {
                                        $courseDetail = $lc;
                                        break;
                                    }
                                }
                                $isEnrolled = in_array($slot->course_code, $courseCodes ?? [], true);
                                if (!$courseDetail) continue;
                            @endphp

                            <div class="lift-hover rounded-2xl border border-emerald-100/80 bg-emerald-50/30 p-4">
                                <div class="flex items-start justify-between gap-2">
                                    <span class="font-extrabold text-slate-900 text-sm">{{ $slot->course_code }}</span>
                                    @if ($isEnrolled)
                                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800">Enrolled</span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-500">Not Added</span>
                                    @endif
                                </div>

                                <p class="mt-1 text-xs font-semibold text-slate-600 line-clamp-2">{{ $courseDetail['title'] }}</p>

                                <div class="mt-3 flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-white px-3 py-1.5 rounded-xl border border-emerald-100 w-fit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 p-6 text-center">
                                <p class="text-xs font-medium text-slate-400">No classes scheduled</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6 pt-3 border-t border-slate-100 text-[11px] font-semibold text-slate-400 text-center">
                    Smart Timetable Sync
                </div>
            </div>
        @endforeach
    </div>

    <!-- Reference Course List Table -->
    <div class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0.45s">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between mb-5">
            <div>
                <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Curriculum Overview</p>
                <h3 class="mt-1 text-xl font-bold text-slate-900">Courses in {{ $selectedLevelLabel }} ({{ $selectedSemester }} Semester)</h3>
            </div>
            <p class="text-sm font-semibold text-slate-500">{{ count($levelCourses) }} courses shown</p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-emerald-100 -mx-2 px-2 sm:mx-0 sm:px-0">
            <table class="min-w-[640px] w-full divide-y divide-emerald-100 text-left sm:min-w-full">
                <thead class="bg-emerald-50/60">
                    <tr>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Course Code & Title</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Units</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Registration Status</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Assigned Schedule Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50 bg-white">
                    @foreach ($levelCourses as $course)
                        @php
                            $schedule = $timetables[$course['code']] ?? null;
                            $isEnrolled = in_array($course['code'], $courseCodes ?? [], true);
                        @endphp
                        <tr class="state-transition align-middle hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <span class="font-bold text-slate-900">{{ $course['code'] }}</span>
                                <span class="mx-2 text-slate-300">—</span>
                                <span class="text-sm font-medium text-slate-600">{{ $course['title'] }}</span>
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-slate-700">{{ $course['units'] }}</td>
                            <td class="px-5 py-4">
                                @if ($isEnrolled)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">Enrolled</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Not added</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-slate-600">
                                @if ($schedule)
                                    <span class="font-bold text-emerald-800">{{ $schedule->day_of_week }}</span>:
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                                @else
                                    <span class="text-slate-400 italic">No schedule assigned yet</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection