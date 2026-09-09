<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Course Registration Form - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #10201a;
            --line: #e4e6df;
            --brand: #059669;
            --brand-dark: #047857;
        }
        * { font-family: 'IBM Plex Sans', system-ui, sans-serif; }
        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }

        /* Print-safe by design: no backdrop-filter, no box-shadow-heavy glass,
           no animation. Those either vanish or render incorrectly on paper. */
        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
        body { overflow-x: hidden; background: #fbfbf7; color: var(--ink); }
        a, button {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
    </style>
</head>
<body class="min-h-screen py-6 px-3 sm:py-10 sm:px-4">
    <div class="mx-auto max-w-3xl bg-white rounded-3xl shadow-xl p-5 sm:p-8 md:p-12" style="border: 1px solid var(--line)">

        <!-- School Header -->
        <div class="flex flex-col gap-4 border-b pb-6 sm:flex-row sm:items-center sm:justify-between" style="border-color: var(--line)">
            <div>
                <h1 class="mono text-xs font-bold" style="color: var(--brand-dark)">SMART ATTENDANCE UNIVERSITY</h1>
                <h2 class="text-lg font-bold sm:text-xl" style="color: var(--ink)">Official Course Registration Form</h2>
            </div>
            <button onclick="window.print()" class="no-print w-full rounded-2xl px-5 py-2.5 text-sm font-bold text-white shadow-md hover:opacity-90 sm:w-auto" style="background: var(--brand)">
                Print / Download PDF
            </button>
        </div>

        @php
            $photoUrl = $user->profile_photo_url
                ?? ($user->profile_photo_path ? asset('storage/' . $user->profile_photo_path)
                : ($user->profile_photo ? asset('storage/' . $user->profile_photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=059669&color=fff&size=128'));
        @endphp

        <!-- Student Bio Grid with Profile Picture -->
        <div class="mt-8 flex flex-col sm:flex-row items-center gap-6 rounded-2xl p-5 sm:p-6" style="background: rgba(5,150,105,0.05); border: 1px solid rgba(5,150,105,0.16)">
            <img src="{{ $photoUrl }}" alt="Student Photo" class="h-24 w-24 shrink-0 rounded-2xl object-cover border-2 shadow-sm" style="border-color: var(--brand)">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full text-sm min-w-0">
                <div class="min-w-0">
                    <p class="mono text-xs" style="color: #7a8580">Student name</p>
                    <p class="truncate font-bold text-base mt-0.5" style="color: var(--ink)">{{ $user->name }}</p>
                </div>
                <div class="min-w-0">
                    <p class="mono text-xs" style="color: #7a8580">Matric number</p>
                    <p class="truncate font-bold text-base mt-0.5" style="color: var(--ink)">{{ $user->matric_number ?? 'Not Set' }}</p>
                </div>
                <div class="min-w-0">
                    <p class="mono text-xs" style="color: #7a8580">Department</p>
                    <p class="truncate font-bold text-base mt-0.5" style="color: var(--ink)">{{ $user->department ?? 'Not Set' }}</p>
                </div>
                <div class="min-w-0">
                    <p class="mono text-xs" style="color: #7a8580">Level & semester</p>
                    <p class="truncate font-bold text-base mt-0.5" style="color: var(--brand-dark)">{{ $levelLabel ?? 'N/A' }} &bull; {{ $selectedSemester }} Semester</p>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses Table -->
        <div class="mt-8">
            <h3 class="mono text-sm font-bold mb-4" style="color: var(--brand-dark)">Registered courses</h3>

            <div class="overflow-x-auto rounded-2xl -mx-1 px-1 sm:mx-0 sm:px-0" style="border: 1px solid var(--line)">
                <table class="w-full min-w-[480px] text-left text-sm">
                    <thead class="text-white font-bold" style="background: var(--brand)">
                        <tr>
                            <th class="px-4 py-3 sm:px-5 sm:py-3.5">S/N</th>
                            <th class="px-4 py-3 sm:px-5 sm:py-3.5">Course Code</th>
                            <th class="px-4 py-3 sm:px-5 sm:py-3.5">Course Title</th>
                            <th class="px-4 py-3 text-center sm:px-5 sm:py-3.5">Units</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white" style="border-color: var(--line)">
                        @php $totalUnits = 0; @endphp
                        @forelse ($enrolledCourses as $index => $course)
                            @php $totalUnits += ($course->units ?? 3); @endphp
                            <tr>
                                <td class="px-4 py-3.5 font-semibold sm:px-5 sm:py-4" style="color: #9aa39c">{{ $index + 1 }}</td>
                                <td class="px-4 py-3.5 font-bold sm:px-5 sm:py-4" style="color: var(--ink)">{{ $course->course_code }}</td>
                                <td class="px-4 py-3.5 font-medium sm:px-5 sm:py-4" style="color: #5b6660">{{ $course->course_title }}</td>
                                <td class="px-4 py-3.5 text-center font-bold sm:px-5 sm:py-4" style="color: var(--brand-dark)">{{ $course->units ?? 3 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-6 text-center font-semibold" style="color: #9aa39c">No courses registered yet. Please select courses on your profile page.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="font-bold border-t" style="background: rgba(5,150,105,0.08); border-color: var(--line); color: var(--ink)">
                        <tr>
                            <td colspan="3" class="mono px-4 py-3.5 text-right text-xs sm:px-5" style="color: var(--brand-dark)">Total units registered:</td>
                            <td class="px-4 py-3.5 text-center text-base sm:px-5" style="color: var(--brand-dark)">{{ $totalUnits }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Signatures Section -->
        <div class="mt-14 grid grid-cols-1 gap-8 text-sm sm:mt-16 sm:grid-cols-2">
            <div class="border-t pt-3" style="border-color: #cbd0c6">
                <p class="font-bold" style="color: var(--ink)">Student's Signature & Date</p>
            </div>
            <div class="border-t pt-3" style="border-color: #cbd0c6">
                <p class="font-bold" style="color: var(--ink)">HOD / Level Coordinator Signature</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-10 text-center no-print">
            <a href="{{ route('student.profile') }}" class="inline-flex items-center justify-center rounded-2xl px-6 py-3 text-sm font-semibold transition shadow-sm" style="border: 1px solid var(--line); background: white; color: var(--ink)">
                &larr; Back to Profile
            </a>
        </div>

    </div>
</body>
</html>