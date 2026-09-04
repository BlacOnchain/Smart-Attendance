<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Assignments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 p-6">
    <div class="mx-auto max-w-5xl">
        <h1 class="text-2xl font-bold text-slate-900">Course &rarr; lecturer assignments</h1>
        <p class="mt-1 text-sm text-slate-500">Assign each course to the lecturer who teaches it. Unassigned courses show as "Unassigned" on lecturer dashboards.</p>

        @if (session('success'))
            <div class="mt-4 rounded-xl border border-emerald-300 bg-emerald-100 px-4 py-3 text-emerald-900 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200 bg-white">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="bg-slate-100 font-bold text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Course</th>
                        <th class="px-4 py-3">Level</th>
                        <th class="px-4 py-3">Semester</th>
                        <th class="px-4 py-3">Lecturer</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($courses as $course)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-bold">{{ $course->course_code }}</p>
                                <p class="text-xs text-slate-500">{{ $course->course_title }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $course->level }}L</td>
                            <td class="px-4 py-3">{{ $course->semester }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.course-assignments.update', $course->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <select name="lecturer_id" class="rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                                        <option value="">Unassigned</option>
                                        @foreach ($lecturers as $lecturer)
                                            <option value="{{ $lecturer->id }}" @selected($course->lecturer_id === $lecturer->id)>{{ $lecturer->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white hover:bg-emerald-700">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>