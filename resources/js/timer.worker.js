/**
 * timer.worker.js
 * Taruh file ini di: public/js/timer.worker.js
 *
 * Web Worker berjalan di thread terpisah — timer tetap akurat
 * meski tab browser tidak aktif / di-background.
 */

let intervalId = null;
let remaining  = 0;
let isRunning  = false;
let startTime  = null;
let initialDuration = 0;

// --- Flowtime mode ---
let flowtimeStart = null;
let flowtimeElapsed = 0;
let flowtimeRunning = false;

self.onmessage = function (e) {
    const { type, payload } = e.data;

    switch (type) {

        // ── COUNTDOWN (Fixed mode) ──────────────────────────────────────
        case 'START_COUNTDOWN':
            clearInterval(intervalId);
            remaining       = payload.seconds;
            initialDuration = payload.seconds;
            isRunning       = true;
            startTime       = Date.now();

            intervalId = setInterval(() => {
                // Koreksi drift: hitung berdasarkan waktu nyata
                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                remaining = Math.max(0, initialDuration - elapsed);

                self.postMessage({
                    type: 'TICK',
                    remaining,
                    progress: remaining / initialDuration,
                });

                if (remaining <= 0) {
                    clearInterval(intervalId);
                    isRunning = false;
                    self.postMessage({ type: 'DONE' });
                }
            }, 250); // Cek setiap 250ms agar lebih responsif
            break;

        case 'PAUSE_COUNTDOWN':
            clearInterval(intervalId);
            isRunning = false;
            // Simpan sisa waktu saat pause
            if (startTime) {
                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                remaining = Math.max(0, initialDuration - elapsed);
                initialDuration = remaining; // Reset untuk resume
            }
            self.postMessage({ type: 'PAUSED', remaining });
            break;

        case 'RESUME_COUNTDOWN':
            if (!isRunning && remaining > 0) {
                isRunning       = true;
                startTime       = Date.now();
                initialDuration = remaining;

                intervalId = setInterval(() => {
                    const elapsed = Math.floor((Date.now() - startTime) / 1000);
                    remaining = Math.max(0, initialDuration - elapsed);

                    self.postMessage({
                        type: 'TICK',
                        remaining,
                        progress: remaining / initialDuration,
                    });

                    if (remaining <= 0) {
                        clearInterval(intervalId);
                        isRunning = false;
                        self.postMessage({ type: 'DONE' });
                    }
                }, 250);
            }
            break;

        case 'RESET_COUNTDOWN':
            clearInterval(intervalId);
            isRunning = false;
            remaining = 0;
            self.postMessage({ type: 'RESET' });
            break;

        // ── FLOWTIME (Count-up mode) ────────────────────────────────────
        case 'START_FLOWTIME':
            clearInterval(intervalId);
            flowtimeStart   = Date.now();
            flowtimeElapsed = 0;
            flowtimeRunning = true;

            intervalId = setInterval(() => {
                flowtimeElapsed = Math.floor((Date.now() - flowtimeStart) / 1000);
                const breakTime = Math.floor(flowtimeElapsed / 5); // 1/5 rule

                self.postMessage({
                    type:        'FLOWTIME_TICK',
                    elapsed:     flowtimeElapsed,
                    breakTime,
                });
            }, 500);
            break;

        case 'STOP_FLOWTIME':
            clearInterval(intervalId);
            flowtimeRunning = false;

            const totalElapsed = Math.floor((Date.now() - flowtimeStart) / 1000);
            const calculatedBreak = Math.floor(totalElapsed / 5);

            self.postMessage({
                type:          'FLOWTIME_STOPPED',
                elapsed:       totalElapsed,
                breakDuration: calculatedBreak,
            });
            break;

        case 'RESET_FLOWTIME':
            clearInterval(intervalId);
            flowtimeRunning = false;
            flowtimeElapsed = 0;
            flowtimeStart   = null;
            self.postMessage({ type: 'FLOWTIME_RESET' });
            break;
    }
};