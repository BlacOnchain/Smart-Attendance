@extends('lecturer.layout')

@section('content')
<div class="space-y-6">

    <!-- Assigned Courses Section -->
    <section class="stagger-up rounded-[28px] bg-white/80 p-6 sm:p-8 shadow-sm border" style="--d: 0s; border-color: var(--line)">
        <div class="mb-5">
            <p class="eyebrow">My teaching portfolio</p>
            <h3 class="mt-1 text-2xl font-bold" style="color: var(--ink)">Courses assigned to you</h3>
            <p class="mt-1 text-sm" style="color: #7a8580">Active courses you are currently managing and tracking attendance for.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($myCourses as $course)
                <div class="lift-hover rounded-2xl p-5 flex flex-col justify-between border" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.16)">
                    <div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                                </div>
                                <span class="font-bold text-lg tracking-wide" style="color: #065f46">{{ $course->course_code }}</span>
                            </div>
                            <span class="rounded-full bg-emerald-600 px-2.5 py-0.5 text-[11px] font-bold text-white">Assigned</span>
                        </div>
                        <p class="text-sm font-semibold mt-3" style="color: var(--ink)">{{ $course->course_title }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t flex items-center justify-between text-xs font-bold" style="border-color: rgba(5,150,105,0.16); color: #047857">
                        <span>{{ $course->level }}L &bull; {{ $course->semester }} semester</span>
                        <span>{{ $course->units ?? 3 }} Units</span>
                    </div>
                </div>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed p-6 text-center text-sm font-medium" style="border-color: var(--line); color: #9aa39c">
                    You have no assigned courses yet. Claim courses from the catalog below.
                </div>
            @endforelse
        </div>
    </section>

    <!-- Unclaimed / Department Course Catalog Section with Filters -->
    @if ($unclaimedCourses->isNotEmpty())
        <section class="stagger-up rounded-[28px] bg-white/80 p-6 sm:p-8 shadow-sm border" style="--d: 0.1s; border-color: var(--line)">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b pb-5" style="border-color: var(--line)">
                <div>
                    <p class="eyebrow">Course catalog</p>
                    <h3 class="mt-1 text-2xl font-bold" style="color: var(--ink)">Available department courses</h3>
                    <p class="mt-1 text-sm" style="color: #7a8580">Filter by level or search by code/title to claim courses.</p>
                </div>

                <div class="w-full sm:w-72 relative">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="absolute left-4 top-1/2 -translate-y-1/2" style="color: #9aa39c"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                    <input
                        type="text"
                        id="courseSearchInput"
                        onkeyup="filterCourses()"
                        placeholder="Search code or title..."
                        class="w-full rounded-2xl border pl-11 pr-4 py-2.5 text-sm outline-none transition"
                        style="border-color: var(--line); background: rgba(255,255,255,0.7); color: var(--ink)"
                    >
                </div>
            </div>

            <!-- Level Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 mt-5">
                <button type="button" onclick="filterByLevel('all')" id="filter-all" class="filter-btn rounded-xl px-4 py-2 text-xs font-bold text-white shadow-sm transition" style="background: var(--brand)">All Levels</button>
                <button type="button" onclick="filterByLevel('100')" id="filter-100" class="filter-btn rounded-xl border px-4 py-2 text-xs font-bold hover:bg-teal-50 transition" style="border-color: var(--line); background: rgba(255,255,255,0.6); color: #5b6660">100L / ND1</button>
                <button type="button" onclick="filterByLevel('200')" id="filter-200" class="filter-btn rounded-xl border px-4 py-2 text-xs font-bold hover:bg-teal-50 transition" style="border-color: var(--line); background: rgba(255,255,255,0.6); color: #5b6660">200L / ND2</button>
                <button type="button" onclick="filterByLevel('300')" id="filter-300" class="filter-btn rounded-xl border px-4 py-2 text-xs font-bold hover:bg-teal-50 transition" style="border-color: var(--line); background: rgba(255,255,255,0.6); color: #5b6660">300L / HND1</button>
                <button type="button" onclick="filterByLevel('400')" id="filter-400" class="filter-btn rounded-xl border px-4 py-2 text-xs font-bold hover:bg-teal-50 transition" style="border-color: var(--line); background: rgba(255,255,255,0.6); color: #5b6660">400L / HND2</button>
            </div>

            <!-- Course Cards Grid -->
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" id="unclaimedCoursesGrid">
                @foreach ($unclaimedCourses as $course)
                    @php
                        $rawLevel = trim((string) $course->level);
                        $normalizedLevel = in_array($rawLevel, ['100', '200', '300', '400']) ? $rawLevel : '100';
                    @endphp
                    <div class="lift-hover course-card rounded-2xl p-5 flex flex-col justify-between transition-all border"
                         style="background: rgba(13,148,136,0.05); border-color: rgba(13,148,136,0.18)"
                         data-level="{{ $normalizedLevel }}"
                         data-search="{{ strtolower($course->course_code . ' ' . $course->course_title) }}">
                        <div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-white" style="background: var(--brand)">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                                    </div>
                                    <span class="font-bold text-lg tracking-wide" style="color: var(--brand-dark)">{{ $course->course_code }}</span>
                                </div>
                                <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold" style="background: rgba(13,148,136,0.15); color: var(--brand-dark)">Available</span>
                            </div>
                            <p class="text-sm font-semibold mt-2.5 leading-snug" style="color: var(--ink)">{{ $course->course_title }}</p>
                            <p class="mt-3 text-xs font-bold bg-white px-2.5 py-1 rounded-lg border w-fit" style="color: var(--brand-dark); border-color: rgba(13,148,136,0.18)">
                                {{ $course->level }}L &bull; {{ $course->semester ?? 'First' }} semester
                            </p>
                        </div>
                        <form action="{{ route('lecturer.course.claim', $course->id) }}" method="POST" class="mt-5">
                            @csrf
                            <button type="submit" class="btn-nudge w-full rounded-xl px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:opacity-90" style="background: var(--brand)">
                                Claim this course
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div id="noCoursesFound" class="hidden mt-8 rounded-2xl border border-dashed p-8 text-center text-sm font-semibold" style="border-color: var(--line); color: #9aa39c">
                No unclaimed courses match your search or level filter.
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
    let currentLevel = 'all';

    function filterByLevel(level) {
        currentLevel = level;

        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.style.background = 'rgba(255,255,255,0.6)';
            btn.style.color = '#5b6660';
            btn.style.borderColor = 'var(--line)';
            btn.classList.add('border');
        });
        const activeBtn = document.getElementById('filter-' + level);
        if (activeBtn) {
            activeBtn.style.background = 'var(--brand)';
            activeBtn.style.color = '#fff';
            activeBtn.classList.remove('border');
        }

        applyFilters();
    }

    function filterCourses() {
        applyFilters();
    }

    function applyFilters() {
        const query = document.getElementById('courseSearchInput').value.trim().toLowerCase();
        const cards = document.querySelectorAll('.course-card');
        const noResults = document.getElementById('noCoursesFound');
        let visibleCount = 0;

        cards.forEach(card => {
            const levelMatch = (currentLevel === 'all' || card.dataset.level === currentLevel);
            const searchMatch = card.dataset.search.includes(query);

            if (levelMatch && searchMatch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResults) {
            noResults.classList.toggle('hidden', visibleCount !== 0);
        }
    }
</script>
@endpush