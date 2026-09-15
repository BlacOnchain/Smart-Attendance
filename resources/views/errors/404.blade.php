<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page not found | Smart Attendance</title>
    <meta name="description" content="The Smart Attendance page you requested could not be found.">
    <link rel="icon" href="{{ asset('favicon-32.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('favicon-192.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;600;700;800&family=IBM+Plex+Mono:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #10201a; --paper: #fbfbf7; --line: #e4e6df; --brand: #059669; --brand-dark: #047857; }
        * { font-family: 'IBM Plex Sans', system-ui, sans-serif; }
        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }
        body {
            background: linear-gradient(160deg, #eef6f1 0%, #f6f8f2 40%, #fbfbf7 70%, #f3f7f1 100%);
            color: var(--ink);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <img src="{{ asset('images/logo-3d.svg') }}" alt="Smart Attendance logo" class="mx-auto mb-6 h-14 w-14 rounded-2xl object-cover">
        <p class="mono text-xs font-bold" style="color: var(--brand-dark)">404</p>
        <h1 class="mt-2 text-2xl font-bold">This page doesn't exist</h1>
        <p class="mt-3 text-sm leading-6" style="color: #5b6660">
            The link might be broken, or the page may have moved. Let's get you back somewhere useful.
        </p>
        <a href="{{ route('home') }}" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">
            Back to home
        </a>
    </div>
</body>
</html>
