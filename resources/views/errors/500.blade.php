<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporarily unavailable | Smart Attendance</title>
    <link rel="icon" href="{{ asset('favicon-32.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('favicon-192.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="grid min-h-screen place-items-center bg-emerald-50 px-6 text-slate-900">
    <main class="w-full max-w-lg rounded-3xl border border-emerald-100 bg-white p-8 text-center shadow-xl">
        <img src="{{ asset('images/logo-3d.svg') }}" alt="Smart Attendance logo" class="mx-auto h-16 w-16 rounded-2xl">
        <p class="mt-6 text-xs font-black uppercase tracking-[.25em] text-emerald-700">Smart Attendance</p>
        <h1 class="mt-3 text-3xl font-black">We are having a short problem</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">Your data has not been deleted. Please wait a moment and try again. If the problem continues, contact the department administrator.</p>
        <button onclick="location.reload()" class="mt-6 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700">Try again</button>
        <a href="{{ route('home') }}" class="ml-2 text-sm font-bold text-emerald-700">Home</a>
    </main>
</body>
</html>
