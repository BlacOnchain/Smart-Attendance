@extends('student')

@section('content')
<div class="space-y-6">

    <div class="stagger-up" style="--d: 0s">
        <p class="eyebrow">QR scanner</p>
        <h1 class="mt-2 text-3xl font-bold" style="color: var(--ink)">Scan lecture attendance code</h1>
        <p class="mt-2 text-sm leading-6 max-w-2xl" style="color: #5b6660">
            Point your camera at the QR code your lecturer displays. Once detected, we'll take you straight to the check-in page.
        </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_0.75fr]">

        <!-- Scanner card -->
        <section class="stagger-up rounded-[28px] bg-white/80 p-6 shadow-sm border" style="--d: 0.08s; border-color: var(--line)">
            <div class="relative mx-auto max-w-md">
                <!-- Camera frame — intentionally dark for camera visibility, not part of the light theme -->
                <div class="relative overflow-hidden rounded-[24px] border-2 border-emerald-200 bg-slate-950 aspect-square max-h-[60vh] flex items-center justify-center">
                    <div id="reader" class="h-full w-full"></div>

                    <div id="cornerMarkers" class="pointer-events-none absolute inset-6 pulse-attention">
                        <span class="absolute top-0 left-0 h-8 w-8 border-t-4 border-l-4 border-emerald-400 rounded-tl-xl"></span>
                        <span class="absolute top-0 right-0 h-8 w-8 border-t-4 border-r-4 border-emerald-400 rounded-tr-xl"></span>
                        <span class="absolute bottom-0 left-0 h-8 w-8 border-b-4 border-l-4 border-emerald-400 rounded-bl-xl"></span>
                        <span class="absolute bottom-0 right-0 h-8 w-8 border-b-4 border-r-4 border-emerald-400 rounded-br-xl"></span>
                    </div>
                </div>

                <!-- Status pill -->
                <div class="state-transition mt-5 flex items-center justify-center gap-2 rounded-2xl border px-4 py-3" id="statusPill">
                    <span id="statusDot" class="state-transition h-2.5 w-2.5 rounded-full bg-slate-400 pulse-attention"></span>
                    <p id="status" class="state-transition text-sm font-semibold text-slate-600">Waiting for a QR code...</p>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <aside class="stagger-up rounded-[28px] bg-white/80 p-6 shadow-sm border h-fit" style="--d: 0.16s; border-color: var(--line)">
            <p class="eyebrow">How it works</p>

            <div class="mt-5 space-y-5">
                <div class="flex gap-4">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-sm font-bold text-white">1</div>
                    <div>
                        <p class="font-semibold" style="color: var(--ink)">Open the scanner</p>
                        <p class="mt-1 text-sm" style="color: #7a8580">The camera appears here inside your student portal.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-sm font-bold text-white">2</div>
                    <div>
                        <p class="font-semibold" style="color: var(--ink)">Scan the lecturer QR</p>
                        <p class="mt-1 text-sm" style="color: #7a8580">Each session generates a unique live attendance link.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-sm font-bold text-white">3</div>
                    <div>
                        <p class="font-semibold" style="color: var(--ink)">Confirm attendance</p>
                        <p class="mt-1 text-sm" style="color: #7a8580">If the session is active, you'll be sent to the check-in page.</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 rounded-2xl p-4 border" style="background: rgba(5,150,105,0.05); border-color: rgba(5,150,105,0.14)">
                <p class="text-sm" style="color: #5b6660">
                    <span class="font-semibold" style="color: var(--ink)">Tip:</span> hold your phone steady, about 20–30cm from the screen showing the QR code.
                </p>
            </div>
        </aside>
    </div>
</div>

@push('styles')
<style>
    /*
       html5-qrcode injects its OWN buttons, links, and dropdowns directly
       inside #reader (Request Permissions, Start Scanning, camera selector,
       Scan an Image File toggle). Restyled to match the brand, unchanged
       in behavior.
    */

    #reader {
        border: none !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 20px;
    }

    #reader video {
        border-radius: 16px;
    }

    #reader button {
        background: linear-gradient(135deg, #059669, #047857) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 14px !important;
        padding: 12px 22px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        letter-spacing: 0.02em;
        cursor: pointer !important;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.35);
        transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    }

    #reader button:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 18px rgba(5, 150, 105, 0.45);
        background: linear-gradient(135deg, #047857, #065f46) !important;
    }

    #reader button:active {
        transform: translateY(0) scale(0.98);
    }

    #reader select {
        background: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #a7f3d0 !important;
        border-radius: 12px !important;
        padding: 10px 14px !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        cursor: pointer;
    }

    #reader a,
    #reader span[style*="text-decoration"] {
        color: #6ee7b7 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        text-decoration: underline !important;
        transition: color 0.15s ease;
    }

    #reader a:hover {
        color: #a7f3d0 !important;
    }

    #reader__dashboard_section_csr span,
    #reader__dashboard_section span,
    #reader__status_span,
    #reader__header_message {
        color: #e2e8f0 !important;
        font-weight: 500 !important;
        font-size: 13px !important;
        text-align: center;
    }

    #reader__camera_selection {
        margin-bottom: 8px !important;
    }

    #reader input[type="file"] {
        color: #e2e8f0 !important;
        font-size: 12px !important;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #reader > * {
        animation: fadeInUp 0.3s ease both;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const statusBox = document.getElementById('status');
    const statusDot = document.getElementById('statusDot');
    const statusPill = document.getElementById('statusPill');
    const cornerMarkers = document.getElementById('cornerMarkers');
    let hasScanned = false;

    function setStatus(message, state) {
        statusBox.textContent = message;

        const styles = {
            waiting: { pill: 'border-slate-200 bg-slate-50', dot: 'bg-slate-400 pulse-attention', text: 'text-slate-600' },
            success: { pill: 'border-emerald-300 bg-emerald-50', dot: 'bg-emerald-500', text: 'text-emerald-700' },
            error:   { pill: 'border-red-300 bg-red-50', dot: 'bg-red-500', text: 'text-red-700' },
        };

        const s = styles[state] || styles.waiting;
        statusPill.className = 'state-transition mt-5 flex items-center justify-center gap-2 rounded-2xl border px-4 py-3 ' + s.pill;
        statusDot.className = 'state-transition h-2.5 w-2.5 rounded-full ' + s.dot;
        statusBox.className = 'state-transition text-sm font-semibold ' + s.text;

        if (state === 'success' && cornerMarkers) {
            cornerMarkers.classList.remove('pulse-attention');
        }
    }

    function onScanSuccess(decodedText) {
        if (hasScanned) {
            return;
        }

        hasScanned = true;
        setStatus('QR code detected — opening attendance page...', 'success');

        try {
            const url = new URL(decodedText, window.location.origin);
            window.location.href = url.href;
        } catch (error) {
            setStatus('That QR code is not a valid attendance link.', 'error');
            hasScanned = false;
        }
    }

    function onScanError(errorMessage) {
        // Fired continuously while searching — intentionally silent.
    }

    const scanner = new Html5QrcodeScanner('reader', {
        fps: 10,
        qrbox: { width: 230, height: 230 },
    });

    scanner.render(onScanSuccess, onScanError);
</script>
@endpush
@endsection