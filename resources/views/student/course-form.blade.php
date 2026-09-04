<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Course Registration Form - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
        body { overflow-x: hidden; }
        a, button {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-6 px-3 text-slate-900 sm:py-10 sm:px-4">
    <div class="mx-auto max-w-3xl bg-white rounded-3xl border border-emerald-200 shadow-xl p-5 sm:p-8 md:p-12">

        <!-- School Header -->
        <div class="flex flex-col gap-4 border-b border-emerald-100 pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-700">Smart Attendance University</h1>
                <h2 class="text-lg font-extrabold text-slate-900 sm:text-xl">Official Course Registration Form</h2>
            </div>
            <button onclick="window.print()" class="no-print w-full rounded-2xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-emerald-700 sm:w-auto">
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
        <div class="mt-8 flex flex-col sm:flex-row items-center gap-6 rounded-2xl border border-emerald-100 bg-emerald-50/30 p-5 sm:p-6">
            <img src="{{ $photoUrl }}" alt="Student Photo" class="h-24 w-24 shrink-0 rounded-2xl object-cover border-2 border-emerald-600 shadow-sm">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full text-sm min-w-0">
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Student Name</p>
                    <p class="truncate font-bold text-slate-900 text-base mt-0.5">{{ $user->name }}</p>
                </div>
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Matric Number</p>
                    <p class="truncate font-bold text-slate-900 text-base mt-0.5">{{ $user->matric_number ?? 'Not Set' }}</p>
                </div>
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Department</p>
                    <p class="truncate font-bold text-slate-900 text-base mt-0.5">{{ $user->department ?? 'Not Set' }}</p>
                </div>
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wider text-slate-500 font-bold">Level & Semester</p>
                    <p class="truncate font-bold text-emerald-700 text-base mt-0.5">{{ $levelLabel ?? 'N/A' }} &bull; {{ $selectedSemester }} Semester</p>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses Table -->
        <div class="mt-8">
            <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700 mb-4">Registered Courses</h3>

            <!-- Horizontal scroll only kicks in on screens too narrow for
                 four columns; nothing squeezes or wraps awkwardly. -->
            <div class="overflow-x-auto rounded-2xl border border-emerald-100 -mx-1 px-1 sm:mx-0 sm:px-0">
                <table class="w-full min-w-[480px] text-left text-sm">
                    <thead class="bg-emerald-600 text-white font-bold">
                        <tr>
                            <th class="px-4 py-3 sm:px-5 sm:py-3.5">S/N</th>
                            <th class="px-4 py-3 sm:px-5 sm:py-3.5">Course Code</th>
                            <th class="px-4 py-3 sm:px-5 sm:py-3.5">Course Title</th>
                            <th class="px-4 py-3 text-center sm:px-5 sm:py-3.5">Units</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50 bg-white">
                        @php $totalUnits = 0; @endphp
                        @forelse ($enrolledCourses as $index => $course)
                            @php $totalUnits += ($course->units ?? 3); @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3.5 font-semibold text-slate-500 sm:px-5 sm:py-4">{{ $index + 1 }}</td>
                                <td class="px-4 py-3.5 font-bold text-slate-900 sm:px-5 sm:py-4">{{ $course->course_code }}</td>
                                <td class="px-4 py-3.5 font-medium text-slate-700 sm:px-5 sm:py-4">{{ $course->course_title }}</td>
                                <td class="px-4 py-3.5 text-center font-bold text-emerald-700 sm:px-5 sm:py-4">{{ $course->units ?? 3 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-6 text-center text-slate-500 font-semibold">No courses registered yet. Please select courses on your profile page.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-emerald-50/60 font-bold text-slate-900 border-t border-emerald-100">
                        <tr>
                            <td colspan="3" class="px-4 py-3.5 text-right uppercase tracking-wider text-xs text-emerald-800 sm:px-5">Total Units Registered:</td>
                            <td class="px-4 py-3.5 text-center text-emerald-800 text-base sm:px-5">{{ $totalUnits }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Signatures Section -->
        <div class="mt-14 grid grid-cols-1 gap-8 text-sm sm:mt-16 sm:grid-cols-2">
            <div class="border-t border-slate-300 pt-3">
                <p class="font-bold text-slate-800">Student's Signature & Date</p>
            </div>
            <div class="border-t border-slate-300 pt-3">
                <p class="font-bold text-slate-800">HOD / Level Coordinator Signature</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-10 text-center no-print">
            <a href="{{ route('student.profile') }}" class="inline-flex items-center justify-center rounded-2xl border border-emerald-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 transition shadow-sm">
                &larr; Back to Profile
            </a>
        </div>

    </div>
</body>
</html>