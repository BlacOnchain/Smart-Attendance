<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Reports | Smart Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div><p class="text-xs font-bold uppercase tracking-[.25em] text-emerald-600">HOD Portal</p><h1 class="mt-1 text-3xl font-black">Attendance reports</h1></div>
            <div class="flex gap-2"><a href="{{ route('hod.dashboard') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold">Dashboard</a><a href="{{ route('hod.reports.export', request()->query()) }}" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white">Export CSV</a></div>
        </div>
        <form method="GET" class="grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 sm:grid-cols-2 lg:grid-cols-5">
            <input name="level" value="{{ $filters['level'] ?? '' }}" placeholder="Level e.g. ND1" class="rounded-xl border-slate-200">
            <input name="course_code" value="{{ $filters['course_code'] ?? '' }}" placeholder="Course code" class="rounded-xl border-slate-200">
            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="rounded-xl border-slate-200">
            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="rounded-xl border-slate-200">
            <button class="rounded-xl bg-slate-900 px-4 py-2 font-bold text-white">Filter</button>
        </form>
        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-6">
            <h2 class="text-xl font-black">Course attendance</h2>
            <div class="mt-4 overflow-x-auto"><table class="min-w-full text-left text-sm"><thead><tr class="border-b text-slate-500"><th class="p-3">Course</th><th class="p-3">Sessions</th><th class="p-3">Check-ins</th><th class="p-3">Students</th><th class="p-3">Average</th></tr></thead><tbody>@forelse($courseReports as $row)<tr class="border-b"><td class="p-3 font-bold">{{ $row->course_code }}</td><td class="p-3">{{ $row->sessions }}</td><td class="p-3">{{ $row->check_ins }}</td><td class="p-3">{{ $row->students }}</td><td class="p-3 font-bold text-emerald-700">{{ $row->average }}%</td></tr>@empty<tr><td colspan="5" class="p-6 text-center text-slate-500">No attendance matches these filters.</td></tr>@endforelse</tbody></table></div>
        </section>
        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-6">
            <h2 class="text-xl font-black">Student check-in activity</h2>
            <div class="mt-4 overflow-x-auto"><table class="min-w-full text-left text-sm"><thead><tr class="border-b text-slate-500"><th class="p-3">Student</th><th class="p-3">Level</th><th class="p-3">Check-ins</th><th class="p-3">Rate</th></tr></thead><tbody>@forelse($studentReports as $row)<tr class="border-b"><td class="p-3"><strong>{{ $row->name }}</strong><br><span class="text-xs text-slate-500">{{ $row->email }}</span></td><td class="p-3">{{ $row->level }}</td><td class="p-3">{{ $row->attended }}</td><td class="p-3 font-bold text-emerald-700">{{ $row->percentage }}%</td></tr>@empty<tr><td colspan="4" class="p-6 text-center text-slate-500">No student activity matches these filters.</td></tr>@endforelse</tbody></table></div>
        </section>
    </main>
</body>
</html>
