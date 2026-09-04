@extends('lecturer.layout')

@section('content')
<div class="space-y-6">

    <!-- Assigned Courses Section -->
    <section class="stagger-up rounded-[28px] border border-emerald-100 bg-white p-6 sm:p-8 shadow-sm" style="--d: 0s">
        <div class="mb-5">
            <p class="text-xs uppercase tracking-[0.28em] text-emerald-700 font-bold">My Teaching Portfolio</p>
            <h3 class="mt-1 text-2xl font-bold text-slate-900">Courses assigned to you</h3>
            <p class="mt-1 text-sm text-slate-500">Active courses you are currently managing and tracking attendance for.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($myCourses as $course)
                <div class="lift-hover rounded-2xl border border-emerald-200 bg-emerald-50/40 p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-emerald-900 text-lg tracking-wide">{{ $course->course_code }}</span>
                            <span class="rounded-full bg-emerald-600 px-2.5 py-0.5 text-[11px] font-bold text-white">Assigned</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $course->course_title }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-emerald-100/60 flex items-center justify-between text-xs font-bold text-emerald-800">
                        <span>{{ $course->level }}L &bull; {{ $course->semester }} semester</span>
                        <span>{{ $course->units ?? 3 }} Units</span>
                    </div>
                </div>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-emerald-200 bg-slate-50 p-6 text-center text-sm font-medium text-slate-500">
                    You have no assigned courses yet. Claim courses from the catalog below.
                </div>
            @endforelse
        </div>
    </section>

    <!-- Unclaimed / Department Course Catalog Section with Filters -->
    @if ($unclaimedCourses->isNotEmpty())
        <section class="stagger-up rounded-[28px] border border-teal-100 bg-white p-6 sm:p-8 shadow-sm" style="--d: 0.1s">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-teal-100 pb-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.28em] text-teal-700 font-bold">Course Catalog</p>
                    <h3 class="mt-1 text-2xl font-bold text-slate-900">Available Department Courses</h3>
                    <p class="mt-1 text-sm text-slate-500">Filter by level or search by code/title to claim courses.</p>
                </div>

                <!-- Search Input -->
                <div class="w-full sm:w-72">
                    <input 
                        type="text" 
                        id="courseSearchInput" 
                        onkeyup="filterCourses()" 
                        placeholder="Search code or title..." 
                        class="w-full rounded-2xl border border-teal-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-teal-500 focus:bg-white transition"
                    >
                </div>
            </div>

            <!-- Level Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 mt-5">
                <button type="button" onclick="filterByLevel('all')" id="filter-all" class="filter-btn rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-sm transition">All Levels</button>
                <button type="button" onclick="filterByLevel('100')" id="filter-100" class="filter-btn rounded-xl border border-teal-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-teal-50 transition">100L / ND1</button>
                <button type="button" onclick="filterByLevel('200')" id="filter-200" class="filter-btn rounded-xl border border-teal-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-teal-50 transition">200L / ND2</button>
                <button type="button" onclick="filterByLevel('300')" id="filter-300" class="filter-btn rounded-xl border border-teal-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-teal-50 transition">300L / HND1</button>
                <button type="button" onclick="filterByLevel('400')" id="filter-400" class="filter-btn rounded-xl border border-teal-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-teal-50 transition">400L / HND2</button>
            </div>

            <!-- Course Cards Grid -->
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" id="unclaimedCoursesGrid">
                @foreach ($unclaimedCourses as $course)
                    @php
                        $rawLevel = trim((string) $course->level);
                        $normalizedLevel = in_array($rawLevel, ['100', '200', '300', '400']) ? $rawLevel : '100';
                    @endphp
                    <div class="lift-hover course-card rounded-2xl border border-teal-200/80 bg-teal-50/20 p-5 flex flex-col justify-between transition-all"
                         data-level="{{ $normalizedLevel }}"
                         data-search="{{ strtolower($course->course_code . ' ' . $course->course_title) }}">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="font-extrabold text-teal-900 text-lg tracking-wide">{{ $course->course_code }}</span>
                                <span class="rounded-full bg-teal-100 px-2.5 py-0.5 text-[11px] font-bold text-teal-800">Available</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-800 mt-1.5 leading-snug">{{ $course->course_title }}</p>
                            <p class="mt-3 text-xs font-bold text-teal-800 bg-white px-2.5 py-1 rounded-lg border border-teal-200/60 w-fit">
                                {{ $course->level }}L &bull; {{ $course->semester ?? 'First' }} semester
                            </p>
                        </div>
                        <form action="{{ route('lecturer.course.claim', $course->id) }}" method="POST" class="mt-5">
                            @csrf
                            <button type="submit" class="btn-nudge w-full rounded-xl bg-teal-700 px-4 py-2.5 text-xs font-bold text-white hover:bg-teal-800 shadow-sm transition">
                                Claim this course
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- No Results State -->
            <div id="noCoursesFound" class="hidden mt-8 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-sm font-semibold text-slate-400">
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
        
        // Update active tab styling to teal theme
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.className = 'filter-btn rounded-xl border border-teal-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-teal-50 transition';
        });
        const activeBtn = document.getElementById('filter-' + level);
        if (activeBtn) {
            activeBtn.className = 'filter-btn rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-sm transition';
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