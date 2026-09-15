<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Thank You | Smart Attendance</title>
    <meta name="description" content="Thank you for using Smart Attendance.">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="flex min-h-screen items-center justify-center bg-emerald-50 px-4 text-slate-900">
    <main class="w-full max-w-md rounded-[2rem] border border-emerald-100 bg-white p-8 text-center shadow-xl shadow-emerald-900/10 sm:p-10">
        <img src="{{ asset('images/smart-attendance-logo.svg') }}" alt="Smart Attendance logo" class="mx-auto h-20 w-20 rounded-3xl object-cover">
        <p class="mt-6 text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">Request received</p>
        <h1 class="mt-2 text-3xl font-extrabold">Thank you</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">Your action was completed successfully. You can return to the portal whenever you are ready.</p>
        <a href="{{ route('home') }}" class="mt-7 inline-flex rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-emerald-700">Back to home</a>
    </main>
</body>
</html>
