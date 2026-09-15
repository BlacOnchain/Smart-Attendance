<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | Smart Attendance</title>
    <meta name="description" content="How Smart Attendance collects, stores, and protects student and lecturer data.">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #10201a; --paper: #fbfbf7; --line: #e4e6df; --brand: #059669; --brand-dark: #047857; }
        * { font-family: 'IBM Plex Sans', system-ui, sans-serif; }
        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }
        body { background: var(--paper); color: var(--ink); }
    </style>
</head>
<body class="min-h-screen">
    <header class="border-b sticky top-0 bg-white/90 backdrop-blur z-10" style="border-color: var(--line)">
        <div class="mx-auto max-w-3xl px-6 py-4 flex items-center gap-3">
            <img src="{{ asset('images/smart-attendance-logo.png') }}" alt="Smart Attendance logo" class="h-9 w-9 rounded-xl object-cover">
            <span class="font-semibold">Smart Attendance</span>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-6 py-12">
        <p class="mono text-xs font-semibold" style="color: var(--brand-dark)">LAST UPDATED: SEPTEMBER 2026</p>
        <h1 class="mt-2 text-3xl font-bold">Privacy Policy</h1>
        <p class="mt-4 text-sm leading-7" style="color: #5b6660">
            This describes exactly what Smart Attendance collects and why — written plainly, not in dense legal language.
        </p>

        <div class="mt-8 space-y-8 text-sm leading-7" style="color: #3a423d">
            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">What we collect</h2>
                <ul class="mt-2 space-y-1.5 list-disc pl-5">
                    <li><strong>Account details:</strong> name, email address, phone number, matric number, department, level, and semester.</li>
                    <li><strong>Profile photo</strong> — only if you choose to upload one.</li>
                    <li><strong>Attendance records:</strong> which sessions you checked into and when.</li>
                    <li><strong>Login activity:</strong> when you sign in, an approximate location (city/country, derived from your IP address — never your exact address), and a general device description (e.g. "Chrome on Windows"). The precise IP address is stored internally for security purposes but is never displayed anywhere in the app.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">Why we collect it</h2>
                <p class="mt-2">Purely to run the attendance system: matching check-ins to the right student, showing lecturers who attended their sessions, letting you recover your password securely, and letting you see and manage which devices are logged into your account.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">Who can see it</h2>
                <p class="mt-2">Lecturers can see attendance records and names for students enrolled in their own assigned courses. Other students cannot see your attendance history, phone number, or login activity. Nobody outside the platform has access to your data.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">Password resets</h2>
                <p class="mt-2">Resetting your password requires a one-time 6-digit code sent to your registered email, which expires after 10 minutes and can only be used once.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">Managing your sessions</h2>
                <p class="mt-2">Your profile page shows every device currently signed into your account, with its approximate location and device type. You can remotely log out any device other than the one you're currently using.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">Data retention</h2>
                <p class="mt-2">Your account data is kept for as long as your account exists. If you'd like your data removed, contact whoever administers your department's use of this platform.</p>
            </section>
        </div>

        <div class="mt-12 pt-6 border-t" style="border-color: var(--line)">
            <a href="{{ route('register') }}" class="text-sm font-semibold" style="color: var(--brand-dark)">&larr; Back to sign up</a>
        </div>
    </main>
</body>
</html>
