@extends('student')

@section('content')
<div class="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
    <section class="rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.32em] text-emerald-700 font-bold">Course Setup</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900">Complete your student profile</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600 font-medium">
            Add your academic details and pick the courses you are enrolled in. This makes attendance tracking accurate.
        </p>

        <form action="{{ route('student.save') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <input type="text" name="matric_number" value="{{ old('matric_number') }}" placeholder="Matric Number" class="rounded-2xl border border-emerald-200 bg-slate-50 px-4 py-3 font-medium text-slate-900 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white">
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number" class="rounded-2xl border border-emerald-200 bg-slate-50 px-4 py-3 font-medium text-slate-900 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white">
            </div>

            <input type="text" name="department" value="{{ old('department') }}" placeholder="Department" class="w-full rounded-2xl border border-emerald-200 bg-slate-50 px-4 py-3 font-medium text-slate-900 outline-none placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white">

            <select name="level" class="w-full rounded-2xl border border-emerald-200 bg-slate-50 px-4 py-3 font-medium text-slate-900 outline-none focus:border-emerald-500 focus:bg-white">
                <option value="">Select Level</option>
                @foreach ($levelOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('level', $level) == $value)>{{ $label }}</option>
                @endforeach
            </select>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Select enrolled courses</label>
                <select name="courses[]" multiple class="h-56 w-full rounded-2xl border border-emerald-200 bg-slate-50 px-4 py-3 font-medium text-slate-900 outline-none focus:border-emerald-500">
                    @forelse ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_title }}</option>
                    @empty
                        <option disabled>No courses available</option>
                    @endforelse
                </select>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 font-bold text-white transition hover:bg-emerald-700 shadow-sm">
                Save and Continue
            </button>
        </form>
    </section>

    <aside class="rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Why this matters</p>
        <div class="mt-5 space-y-4">
            <div class="rounded-2xl border border-emerald-100 bg-slate-50 p-4">
                <p class="font-bold text-slate-900">Matric Number</p>
                <p class="mt-1 text-sm font-medium text-slate-600">Used to uniquely identify your attendance record.</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-slate-50 p-4">
                <p class="font-bold text-slate-900">Course list</p>
                <p class="mt-1 text-sm font-medium text-slate-600">Lets the dashboard show the right classes and active sessions.</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-slate-50 p-4">
                <p class="font-bold text-slate-900">Phone and department</p>
                <p class="mt-1 text-sm font-medium text-slate-600">Useful for profile verification and future notifications.</p>
            </div>
        </div>
    </aside>
</div>
@endsection