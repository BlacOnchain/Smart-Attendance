<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard - Smart Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen font-sans antialiased">

    <!-- Navigation Header -->
    <header class="bg-white border-b border-slate-200 px-6 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white font-bold text-sm shadow-sm">HOD</div>
                <div>
                    <h1 class="text-base font-extrabold text-slate-900 leading-tight">Department Administration</h1>
                    <p class="text-xs text-slate-500 font-medium">Head of Department Portal</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-red-600 transition shadow-sm">
                    Log Out
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">
        
        <!-- Welcome Banner -->
        <section class="rounded-[28px] bg-gradient-to-r from-emerald-600 to-teal-600 p-8 text-white shadow-lg shadow-emerald-600/10">
            <p class="text-xs uppercase tracking-[0.32em] text-emerald-100 font-bold">HOD Control Center</p>
            <h2 class="mt-2 text-3xl font-extrabold">Welcome back, {{ Auth::user()->name }}</h2>
            <p class="mt-2 text-sm text-emerald-50 max-w-xl font-medium">
                Manage departmental staff course allocations, oversee academic attendance metrics, and review system-wide logs from your administrative center.
            </p>
        </section>

        <!-- Metric Summary Cards -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Department Scope</p>
                <p class="text-xl font-black text-slate-900 mt-2">Computer Science</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Administrative Role</p>
                <p class="text-xl font-black text-emerald-700 mt-2">HOD Supreme</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Course Allocations</p>
                <a href="{{ route('admin.course-assignments') }}" class="inline-block text-sm font-bold text-emerald-600 hover:underline mt-2">Manage Assignments &rarr;</a>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">System Status</p>
                <p class="text-xl font-black text-emerald-600 mt-2">Fully Operational</p>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 py-8 mt-16 text-center text-xs font-bold text-slate-400 bg-white">
        <p>&copy; 2026 Smart Attendance University. Department Level Management System.</p>
    </footer>

</body>
</html>