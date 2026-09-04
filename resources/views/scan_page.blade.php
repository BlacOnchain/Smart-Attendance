<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Attendance Check-in | Smart Attendance</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow-x: hidden;
        }
        @keyframes scaleUp {
            0% { opacity: 0; transform: scale(0.85); }
            100% { opacity: 1; transform: scale(1); }
        }
        .animate-scale-up {
            animation: scaleUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4">

    <!-- Center Popup Modal Container -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4">
        <div class="w-full max-w-md rounded-[32px] border border-emerald-500/20 bg-slate-900 p-8 text-center shadow-2xl animate-scale-up">
            
            @if($expired)
                <!-- Expired State -->
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/30 text-3xl mb-5">
                    ⏳
                </div>
                <h2 class="text-2xl font-bold text-white">QR Code Expired</h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-400">
                    This attendance code has expired or rotated. Please point your camera at the current QR code on your lecturer's screen and scan again.
                </p>
                <div class="mt-8">
                    <a href="{{ route('student.camera') }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-500 px-6 py-3.5 text-sm font-bold text-slate-950 hover:bg-emerald-400 transition">
                        Open Scanner Again
                    </a>
                </div>
            @else
                <!-- Loading State (Shown momentarily on page load) -->
                <div id="loadingState">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 mb-5">
                        <svg class="h-10 w-10 animate-spin text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Recording Attendance</h2>
                    <p class="mt-2 text-sm text-slate-400">Course: <span class="font-semibold text-slate-200">{{ $session->course_code }}</span></p>
                    <p class="mt-3 text-sm text-slate-400">Verifying secure session...</p>
                </div>

                <!-- Result State (Fades in automatically) -->
                <div id="resultState" class="hidden">
                    <div id="resultIcon" class="mx-auto flex h-20 w-20 items-center justify-center rounded-full text-4xl mb-5">
                        <!-- Dynamic Icon -->
                    </div>
                    <h2 id="resultTitle" class="text-2xl font-bold text-white"></h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-300" id="resultMessage"></p>
                    <p class="mt-6 text-xs text-slate-500">Redirecting to your dashboard shortly...</p>
                </div>
            @endif

        </div>
    </div>

    @unless($expired)
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const loadingState = document.getElementById('loadingState');
            const resultState = document.getElementById('resultState');
            const resultIcon = document.getElementById('resultIcon');
            const resultTitle = document.getElementById('resultTitle');
            const resultMessage = document.getElementById('resultMessage');

            try {
                const response = await fetch("{{ route('student.log', $token) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();
                loadingState.classList.add('hidden');
                resultState.classList.remove('hidden');

                if (response.status === 409) {
                    // Already checked in (Duplicate prevention working correctly)
                    resultIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/30 text-3xl mb-5';
                    resultIcon.innerHTML = 'ℹ️';
                    resultTitle.textContent = 'Already Checked In';
                    resultMessage.textContent = data.message || 'You have already marked your attendance for this session.';
                } else if (response.ok) {
                    // Fresh successful check-in
                    resultIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 text-3xl mb-5';
                    resultIcon.innerHTML = '✓';
                    resultTitle.textContent = 'Success!';
                    resultMessage.textContent = `Attendance for {{ $session->course_code }} has been successfully marked!`;
                } else if (response.status === 410 || response.status === 404) {
                    // Expired or inactive session
                    resultIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/30 text-3xl mb-5';
                    resultIcon.innerHTML = '⏳';
                    resultTitle.textContent = 'QR Code Expired';
                    resultMessage.textContent = data.message || 'This QR code has expired. Please rescan the active code.';
                } else {
                    // Other general errors
                    resultIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-500/10 text-red-400 border border-red-500/30 text-3xl mb-5';
                    resultIcon.innerHTML = '✕';
                    resultTitle.textContent = 'Notice';
                    resultMessage.textContent = data.message || 'Unable to record attendance at this time.';
                }
            } catch (error) {
                loadingState.classList.add('hidden');
                resultState.classList.remove('hidden');
                resultIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-500/10 text-red-400 border border-red-500/30 text-3xl mb-5';
                resultIcon.innerHTML = '✕';
                resultTitle.textContent = 'Connection Error';
                resultMessage.textContent = 'Something went wrong while sending attendance. Please try again.';
            }

            // Redirect back to the student dashboard after 3.5 seconds
            setTimeout(() => {
                window.location.href = "{{ route('student.dashboard') }}";
            }, 3500);
        });
    </script>
    @endunless

</body>
</html>