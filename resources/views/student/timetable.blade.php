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
    <!-- Header Banner -->
    <section class="stagger-up rounded-[28px] p-6 sm:p-8 shadow-lg text-white relative overflow-hidden" style="--d: 0s; background: linear-gradient(135deg, #059669, #0d9488 60%, #047857); box-shadow: 0 24px 50px -18px rgba(5,150,105,0.4);">
        <div class="pointer-events-none absolute inset-0 opacity-40" style="background: radial-gradient(420px 300px at 90% -10%, rgba(255,255,255,0.25), transparent 70%);"></div>
        <div class="relative flex flex-wrap items-center gap-3">
            <div>
                <p class="mono text-[11px] font-semibold text-emerald-50/90">Official student timetable</p>
                <h1 class="mt-1 text-2xl font-bold sm:text-4xl text-white">{{ $selectedLevelLabel }} Timetable</h1>
                <p class="mt-2 text-sm leading-6 text-emerald-50/90 font-medium">
                    Synced with your profile &bull; {{ $selectedSemester }} Semester Schedule.
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-1.5 text-xs font-bold text-white">
                {{ $selectedLevelLabel }} &bull; {{ $selectedSemester }}
            </span>
        </div>
    </section>

    <!-- Weekly Schedule Grid -->
    <div class="grid gap-6 lg:grid-cols-5 md:grid-cols-2">
        @foreach ($daysOfWeek as $day)
            <div class="stagger-left lift-hover rounded-[24px] bg-white/80 p-5 shadow-sm border flex flex-col justify-between" style="--d: {{ $loop->index * 0.08 }}s; border-color: var(--line)">
                <div>
                    <div class="flex items-center justify-between border-b pb-3 mb-4" style="border-color: var(--line)">
                        <h3 class="font-bold text-base" style="color: var(--ink)">{{ $day }}</h3>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold text-emerald-700">
                            {{ count($scheduleByDay[$day]) }} classes
                        </span>
                    </div>

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

                            <div class="lift-hover rounded-2xl p-4 border" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.14)">
                                <div class="flex items-start justify-between gap-2">
                                    <span class="font-bold text-sm" style="color: var(--ink)">{{ $slot->course_code }}</span>
                                    @if ($isEnrolled)
                                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800">Enrolled</span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-500">Not added</span>
                                    @endif
                                </div>

                                <p class="mt-1 text-xs font-semibold line-clamp-2" style="color: #5b6660">{{ $courseDetail['title'] }}</p>

                                <div class="mt-3 flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-white px-3 py-1.5 rounded-xl border w-fit" style="border-color: var(--line)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed p-6 text-center" style="border-color: var(--line)">
                                <p class="text-xs font-medium" style="color: #9aa39c">No classes scheduled</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6 pt-3 border-t text-[11px] font-semibold text-center mono" style="border-color: var(--line); color: #9aa39c">
                    Smart timetable sync
                </div>
            </div>
        @endforeach
    </div>

    <!-- Reference Course List Table -->
    <div class="stagger-up rounded-[28px] bg-white/80 p-6 shadow-sm border" style="--d: 0.45s; border-color: var(--line)">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between mb-5">
            <div>
                <p class="eyebrow">Curriculum overview</p>
                <h3 class="mt-1 text-xl font-bold" style="color: var(--ink)">Courses in {{ $selectedLevelLabel }} ({{ $selectedSemester }} Semester)</h3>
            </div>
            <p class="text-sm font-semibold" style="color: #7a8580">{{ count($levelCourses) }} courses shown</p>
        </div>

        <div class="overflow-x-auto rounded-2xl border -mx-2 px-2 sm:mx-0 sm:px-0" style="border-color: var(--line)">
            <table class="min-w-[640px] w-full divide-y text-left sm:min-w-full" style="border-color: var(--line)">
                <thead style="background: rgba(5,150,105,0.06)">
                    <tr>
                        <th class="px-5 py-3 text-xs font-bold text-emerald-800 eyebrow">Course code & title</th>
                        <th class="px-5 py-3 text-xs font-bold text-emerald-800 eyebrow">Units</th>
                        <th class="px-5 py-3 text-xs font-bold text-emerald-800 eyebrow">Registration status</th>
                        <th class="px-5 py-3 text-xs font-bold text-emerald-800 eyebrow">Assigned schedule time</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-white/60" style="border-color: var(--line)">
                    @foreach ($levelCourses as $course)
                        @php
                            $schedule = $timetables[$course['code']] ?? null;
                            $isEnrolled = in_array($course['code'], $courseCodes ?? [], true);
                        @endphp
                        <tr class="state-transition align-middle hover:bg-emerald-50/40">
                            <td class="px-5 py-4">
                                <span class="font-bold" style="color: var(--ink)">{{ $course['code'] }}</span>
                                <span class="mx-2 text-slate-300">—</span>
                                <span class="text-sm font-medium" style="color: #5b6660">{{ $course['title'] }}</span>
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold" style="color: #5b6660">{{ $course['units'] }}</td>
                            <td class="px-5 py-4">
                                @if ($isEnrolled)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">Enrolled</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Not added</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm font-medium" style="color: #5b6660">
                                @if ($schedule)
                                    <span class="font-bold text-emerald-800">{{ $schedule->day_of_week }}</span>:
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                                @else
                                    <span class="italic" style="color: #9aa39c">No schedule assigned yet</span>
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