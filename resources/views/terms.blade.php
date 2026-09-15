<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions | Smart Attendance</title>
    <meta name="description" content="Terms and conditions for using the Smart Attendance QR-code attendance system.">
    <link rel="icon" href="{{ asset('favicon-32.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('favicon-192.png') }}">
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
            <img src="{{ asset('images/logo-3d.svg') }}" alt="Smart Attendance logo" class="h-9 w-9 rounded-xl object-cover">
            <span class="font-semibold">Smart Attendance</span>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-6 py-12">
        <p class="mono text-xs font-semibold" style="color: var(--brand-dark)">LAST UPDATED: SEPTEMBER 2026</p>
        <h1 class="mt-2 text-3xl font-bold">Terms and Conditions</h1>
        <p class="mt-4 text-sm leading-7" style="color: #5b6660">
            These terms govern your use of Smart Attendance, a QR-code based attendance tracking system. By creating an account, you agree to the terms below.
        </p>

        <div class="mt-8 space-y-8 text-sm leading-7" style="color: #3a423d">
            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">1. What this platform is</h2>
                <p class="mt-2">Smart Attendance lets students check in to lectures by scanning a live QR code displayed by their lecturer, and lets lecturers open, monitor, and close attendance sessions for their assigned courses. It is a departmental attendance tool, not a general-purpose service.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">2. Your account</h2>
                <p class="mt-2">You're responsible for keeping your password secure and for all activity that happens under your account. If you suspect someone else has accessed your account, change your password immediately or contact whoever administers your department's use of this platform.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">3. Attendance integrity</h2>
                <p class="mt-2">Attendance codes rotate automatically and are tied to a live session. Attempting to share a code with someone not physically present, or checking in on behalf of another student, is a misuse of the system and may be treated the same as any other form of attendance fraud by your institution.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">4. What we store about you</h2>
                <p class="mt-2">Your name, email, matric number, phone number, department, level, course enrollments, attendance records, and (if you upload one) a profile photo. Full detail on how this is used and protected is in our <a href="{{ route('privacy') }}" class="font-semibold underline" style="color: var(--brand-dark)">Privacy Policy</a>.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">5. Availability</h2>
                <p class="mt-2">This platform is provided as-is. We aim to keep it available during class hours but don't guarantee uninterrupted access — treat it as a convenience layer on top of, not a replacement for, your institution's official attendance policy.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold" style="color: var(--ink)">6. Changes to these terms</h2>
                <p class="mt-2">We may update these terms as the platform evolves. Continued use after a change means you accept the updated terms.</p>
            </section>
        </div>

        <div class="mt-12 pt-6 border-t" style="border-color: var(--line)">
            <a href="{{ route('register') }}" class="text-sm font-semibold" style="color: var(--brand-dark)">&larr; Back to sign up</a>
        </div>
    </main>
</body>
</html>
