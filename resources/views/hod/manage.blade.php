<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Department | Smart Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
<main class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div><p class="text-xs font-bold uppercase tracking-[.25em] text-emerald-600">HOD Portal</p><h1 class="mt-1 text-3xl font-black">Manage department</h1><p class="mt-1 text-sm text-slate-500">Create staff, maintain the course catalogue, and publish clash-checked timetable entries.</p></div>
        <a href="{{ route('hod.dashboard') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold">Back to dashboard</a>
    </div>
    @if(session('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 font-semibold text-emerald-800">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ $errors->first() }}</div>@endif

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-xl font-black">Create lecturer</h2>
            <form method="POST" action="{{ route('hod.lecturers.store') }}" class="mt-4 space-y-3">@csrf
                <input name="name" value="{{ old('name') }}" required placeholder="Full name" class="w-full rounded-xl border-slate-200">
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Email address" class="w-full rounded-xl border-slate-200">
                <input name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone number" class="w-full rounded-xl border-slate-200">
                <input type="password" name="password" required minlength="8" placeholder="Temporary password" class="w-full rounded-xl border-slate-200">
                <input type="password" name="password_confirmation" required minlength="8" placeholder="Confirm password" class="w-full rounded-xl border-slate-200">
                <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="is_hod" value="1"> Give HOD access</label>
                <button class="w-full rounded-xl bg-emerald-600 px-4 py-3 font-bold text-white">Create lecturer</button>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="text-xl font-black">Add or update course</h2>
            <form method="POST" action="{{ route('hod.courses.store') }}" class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">@csrf
                <input name="course_code" required placeholder="Course code" class="rounded-xl border-slate-200">
                <input name="course_title" required placeholder="Course title" class="rounded-xl border-slate-200 sm:col-span-2">
                <select name="level" required class="rounded-xl border-slate-200"><option value="">Level</option><option value="100">ND1</option><option value="200">ND2</option><option value="300">HND1</option><option value="400">HND2</option></select>
                <select name="semester" required class="rounded-xl border-slate-200"><option value="">Semester</option><option>First</option><option>Second</option></select>
                <input type="number" name="units" min="0" max="12" value="3" required placeholder="Units" class="rounded-xl border-slate-200">
                <select name="lecturer_id" class="rounded-xl border-slate-200"><option value="">Unassigned</option>@foreach($lecturers as $lecturer)<option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>@endforeach</select>
                <button class="rounded-xl bg-slate-900 px-4 py-3 font-bold text-white sm:col-span-2 lg:col-span-3">Save course</button>
            </form>
            <div class="mt-5 max-h-64 overflow-auto rounded-xl border border-slate-100"><table class="min-w-full text-left text-sm"><thead class="sticky top-0 bg-slate-100"><tr><th class="p-3">Course</th><th class="p-3">Level</th><th class="p-3">Lecturer</th></tr></thead><tbody>@foreach($courses as $course)<tr class="border-t"><td class="p-3"><strong>{{ $course->course_code }}</strong><br><span class="text-xs text-slate-500">{{ $course->course_title }}</span></td><td class="p-3">{{ $course->level }} / {{ $course->semester }}</td><td class="p-3">{{ $course->lecturer?->name ?? 'Unassigned' }}</td></tr>@endforeach</tbody></table></div>
        </section>
    </div>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-xl font-black">Publish timetable entry</h2>
        <p class="mt-1 text-sm text-slate-500">The system rejects overlapping entries for the same level or venue.</p>
        <form method="POST" action="{{ route('hod.timetables.store') }}" class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">@csrf
            <select name="course_code" required class="rounded-xl border-slate-200"><option value="">Course</option>@foreach($courses as $course)<option value="{{ $course->course_code }}">{{ $course->course_code }} - {{ $course->level }}</option>@endforeach</select>
            <select name="level" required class="rounded-xl border-slate-200"><option value="">Level</option><option value="100">ND1</option><option value="200">ND2</option><option value="300">HND1</option><option value="400">HND2</option></select>
            <select name="semester" required class="rounded-xl border-slate-200"><option value="">Semester</option><option>First</option><option>Second</option></select>
            <input name="academic_session" required value="{{ date('Y') . '/' . (date('Y') + 1) }}" class="rounded-xl border-slate-200" placeholder="Academic session">
            <select name="day_of_week" required class="rounded-xl border-slate-200"><option value="">Day</option>@foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)<option>{{ $day }}</option>@endforeach</select>
            <input type="time" name="start_time" required class="rounded-xl border-slate-200">
            <input type="time" name="end_time" required class="rounded-xl border-slate-200">
            <input name="venue" placeholder="Venue" class="rounded-xl border-slate-200">
            <select name="lecturer_id" class="rounded-xl border-slate-200"><option value="">Lecturer</option>@foreach($lecturers as $lecturer)<option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>@endforeach</select>
            <button class="rounded-xl bg-emerald-600 px-4 py-3 font-bold text-white sm:col-span-2 lg:col-span-3">Publish timetable</button>
        </form>
        <div class="mt-5 overflow-x-auto rounded-xl border border-slate-100"><table class="min-w-full text-left text-sm"><thead class="bg-slate-100"><tr><th class="p-3">Course</th><th class="p-3">Level</th><th class="p-3">Schedule</th><th class="p-3">Venue</th><th class="p-3"></th></tr></thead><tbody>@forelse($timetables as $slot)<tr class="border-t"><td class="p-3 font-bold">{{ $slot->course_code }}</td><td class="p-3">{{ $slot->level }} / {{ $slot->semester }}</td><td class="p-3">{{ $slot->day_of_week }} {{ substr($slot->start_time, 0, 5) }}-{{ substr($slot->end_time, 0, 5) }}</td><td class="p-3">{{ $slot->venue ?: 'TBA' }}</td><td class="p-3"><form method="POST" action="{{ route('hod.timetables.delete', $slot) }}">@csrf @method('DELETE')<button class="text-xs font-bold text-red-600">Delete</button></form></td></tr>@empty<tr><td colspan="5" class="p-5 text-center text-slate-500">No timetable entries yet.</td></tr>@endforelse</tbody></table></div>
    </section>
</main>
</body>
</html>
