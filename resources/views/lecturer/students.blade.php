@extends('lecturer.layout')

@section('content')
<div class="space-y-6">
    <section class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 shadow-sm" style="--d: 0s">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">Students</p>
                <h3 class="mt-1 text-2xl font-bold text-slate-900">Attendance summary</h3>
                <p class="text-sm text-slate-500">Every student who has checked in across your assigned courses.</p>
            </div>
            <div class="relative w-full sm:max-w-xs">
                <input
                    type="text"
                    id="studentSearchInput"
                    onkeyup="filterStudentTable()"
                    placeholder="Search by name or matric number..."
                    class="state-transition w-full rounded-2xl border border-emerald-200 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-emerald-500"
                >
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-emerald-100">
            <table class="w-full min-w-[480px] text-left text-sm" id="studentSummaryTable">
                <thead class="bg-emerald-50/60 text-emerald-800 font-bold">
                    <tr>
                        <th class="px-4 py-3">Student</th>
                        <th class="px-4 py-3">Times attended</th>
                        <th class="px-4 py-3">Last check-in</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50 bg-white">
                    @forelse ($studentAttendanceCounts as $entry)
                        <tr class="hover:bg-slate-50 transition student-row" data-search="{{ strtolower($entry->user->name . ' ' . ($entry->user->matric_number ?? '')) }}">
                            <td class="px-4 py-4">
                                <p class="font-bold text-slate-900">{{ $entry->user->name }}</p>
                                <p class="text-xs font-semibold text-slate-500">{{ $entry->user->matric_number ?? $entry->user->email }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                    {{ $entry->count }} {{ Str::plural('time', $entry->count) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-semibold text-slate-600">
                                {{ $entry->last_checked_in ? \Carbon\Carbon::parse($entry->last_checked_in)->format('M d, h:i A') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm font-semibold text-slate-400">No attendance recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <p id="noStudentResults" class="hidden px-4 py-6 text-center text-sm font-semibold text-slate-400">No students match your search.</p>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function filterStudentTable() {
        const query = document.getElementById('studentSearchInput').value.trim().toLowerCase();
        const rows = document.querySelectorAll('#studentSummaryTable .student-row');
        const noResults = document.getElementById('noStudentResults');
        let visibleCount = 0;

        rows.forEach((row) => {
            const matches = row.dataset.search.includes(query);
            row.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });

        if (rows.length > 0) {
            noResults.classList.toggle('hidden', visibleCount !== 0);
        }
    }
</script>
@endpush