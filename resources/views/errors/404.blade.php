<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page not found | Smart Attendance</title>
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
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-600 text-white mb-6">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L20 6.5V17.5L12 22L4 17.5V6.5L12 2Z"/><path d="M9.5 12.5L11.3 14.3L15 10.2"/>
            </svg>
        </div>
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