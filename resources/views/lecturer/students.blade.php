@extends('lecturer.layout')

@section('content')
<div class="space-y-6">
    <section class="stagger-up rounded-[28px] bg-white/80 p-6 shadow-sm border" style="--d: 0s; border-color: var(--line)">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="eyebrow">Students</p>
                <h3 class="mt-1 text-2xl font-bold" style="color: var(--ink)">Attendance summary</h3>
                <p class="text-sm" style="color: #7a8580">Every student who has checked in across your assigned courses.</p>
            </div>
            <div class="relative w-full sm:max-w-xs">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="absolute left-4 top-1/2 -translate-y-1/2" style="color: #9aa39c"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input
                    type="text"
                    id="studentSearchInput"
                    onkeyup="filterStudentTable()"
                    placeholder="Search by name or matric number..."
                    class="state-transition w-full rounded-2xl border pl-11 pr-4 py-2.5 text-sm outline-none"
                    style="border-color: var(--line); background: rgba(255,255,255,0.7); color: var(--ink)"
                >
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border" style="border-color: var(--line)">
            <table class="w-full min-w-[480px] text-left text-sm" id="studentSummaryTable">
                <thead style="background: rgba(13,148,136,0.06)">
                    <tr>
                        <th class="px-4 py-3 eyebrow">Student</th>
                        <th class="px-4 py-3 eyebrow">Times attended</th>
                        <th class="px-4 py-3 eyebrow">Last check-in</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-white/60" style="border-color: var(--line)">
                    @forelse ($studentAttendanceCounts as $entry)
                        <tr class="hover:bg-teal-50/40 transition student-row" data-search="{{ strtolower($entry->user->name . ' ' . ($entry->user->matric_number ?? '')) }}">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-white text-xs font-bold" style="background: var(--brand)">
                                        {{ strtoupper(substr($entry->user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold truncate" style="color: var(--ink)">{{ $entry->user->name }}</p>
                                        <p class="text-xs font-semibold" style="color: #9aa39c">{{ $entry->user->matric_number ?? $entry->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                    {{ $entry->count }} {{ Str::plural('time', $entry->count) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-semibold" style="color: #5b6660">
                                {{ $entry->last_checked_in ? \Carbon\Carbon::parse($entry->last_checked_in)->format('M d, h:i A') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm font-semibold" style="color: #9aa39c">No attendance recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <p id="noStudentResults" class="hidden px-4 py-6 text-center text-sm font-semibold" style="color: #9aa39c">No students match your search.</p>
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