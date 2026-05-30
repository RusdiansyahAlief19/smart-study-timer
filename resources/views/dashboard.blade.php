<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight tracking-wide">
            {{ __('Buddle — Focus Mode') }}
        </h2>
    </x-slot>

    {{-- Google Fonts: Inter (simple sans-serif) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Night mode (default) */
            --col-bg:        #0d0f14;
            --col-surface:   #151820;
            --col-border:    #1e2330;
            --col-muted:     #3a3f52;
            --col-text:      #e4e8f5;
            --col-subtle:    #6b7394;

            /* per-method accent vars */
            --accent-h: 214;
            --accent-s: 80%;
            --accent-l: 60%;
            --accent: hsl(var(--accent-h), var(--accent-s), var(--accent-l));
            --accent-dim: hsla(var(--accent-h), var(--accent-s), var(--accent-l), .15);
            --accent-ring: hsla(var(--accent-h), var(--accent-s), var(--accent-l), .30);
            --hero-glow: hsla(var(--accent-h), var(--accent-s), var(--accent-l), .38);
            --hero-grad-a: #111726;
            --hero-grad-b: #0a0f1d;
        }

        /* Light mode variables */
        [data-theme="light"] {
            --col-bg:        #caf0f8;
            --col-surface:   #f0f9ff;
            --col-border:    #e0e7ff;
            --col-muted:     #64748b;
            --col-text:      #03045e;
            --col-subtle:    #475569;
            --hero-grad-a: #caf0f8;
            --hero-grad-b: #ffffff;
            
            /* Dark blue accent colors for light mode */
            --accent-h: 220;
            --accent-s: 90%;
            --accent-l: 45%;
            --accent: hsl(var(--accent-h), var(--accent-s), var(--accent-l));
            --accent-dim: hsla(var(--accent-h), var(--accent-s), var(--accent-l), .15);
            --accent-ring: hsla(var(--accent-h), var(--accent-s), var(--accent-l), .30);
            --hero-glow: hsla(var(--accent-h), var(--accent-s), var(--accent-l), .38);
        }

        /* Dark/Light mode toggle switch */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 50px;
            padding: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .theme-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .theme-toggle-slider {
            width: 48px;
            height: 24px;
            background: var(--col-muted);
            border-radius: 24px;
            position: relative;
            transition: background 0.3s ease;
        }

        .theme-toggle-slider::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        [data-theme="light"] .theme-toggle-slider {
            background: #3b82f6;
        }

        [data-theme="light"] .theme-toggle-slider::before {
            transform: translateX(24px);
        }

        .theme-toggle-icon {
            font-size: 14px;
            color: var(--col-text);
        }

        /* ── method-specific accents ───────────────────────────── */
        [data-method="pomodoro"]{ --accent-h: 4;   --accent-s: 80%; --accent-l: 60%; }
        [data-method="5217"]    { --accent-h: 214; --accent-s: 80%; --accent-l: 60%; }
        [data-method="flowtime"]{ --accent-h: 270; --accent-s: 70%; --accent-l: 65%; }
        [data-method="animedoro"]{ --accent-h: 340; --accent-s: 75%; --accent-l: 62%; }
        [data-method="2min"]    { --accent-h: 155; --accent-s: 70%; --accent-l: 50%; }
        [data-method="2357"]    { --accent-h: 38;  --accent-s: 90%; --accent-l: 58%; }

        body {
            background:
                radial-gradient(900px 450px at 12% -10%, rgba(44, 90, 255, .18), transparent 58%),
                radial-gradient(780px 420px at 100% 2%, rgba(255, 66, 156, .12), transparent 62%),
                linear-gradient(165deg, var(--hero-grad-a), var(--hero-grad-b) 48%, #090c16);
            font-family: 'Inter', sans-serif;
            color: var(--col-text);
            transition: background 0.3s ease;
        }

        [data-theme="light"] body,
        body[data-theme="light"] {
            background:
                radial-gradient(900px 450px at 12% -10%, rgba(3, 4, 94, .08), transparent 58%),
                radial-gradient(780px 420px at 100% 2%, rgba(71, 85, 105, .06), transparent 62%),
                linear-gradient(165deg, var(--hero-grad-a), var(--hero-grad-b) 48%, #caf0f8) !important;
        }
        .timer-font { font-family: 'Inter', sans-serif; }
        .hero-title {
            font-size: clamp(1.2rem, 1.8vw, 1.55rem);
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #f5f8ff;
            text-shadow: 0 10px 32px rgba(10, 15, 30, .65);
        }

        [data-theme="light"] .hero-title {
            color: #1e293b;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Additional light mode fixes for dashboard components */
        [data-theme="light"] .method-card {
            background: #ffffff;
            border-color: #e0e7ff;
            color: #03045e;
        }

        [data-theme="light"] .method-card h4 {
            color: #03045e !important;
        }

        [data-theme="light"] .method-card p {
            color: #475569 !important;
        }

        [data-theme="light"] .method-card .badge {
            background: hsla(220, 90%, 45%, 0.15) !important;
            color: #03045e !important;
        }

        [data-theme="light"] .method-card.active {
            border-color: #03045e !important;
            box-shadow: 0 0 0 3px hsla(220, 90%, 45%, 0.3), 0 8px 32px -8px hsla(220, 90%, 45%, 0.15) !important;
        }

        [data-theme="light"] .timer-panel {
            background: rgba(255, 255, 255, 0.95);
            border-color: #e0e7ff;
            color: #03045e;
        }

        [data-theme="light"] .timer-value {
            color: #03045e !important;
        }

        [data-theme="light"] .phase-pill {
            color: #03045e !important;
        }

        [data-theme="light"] .phase-pill.focus {
            background: hsla(220, 90%, 45%, 0.15) !important;
            color: #03045e !important;
        }

        [data-theme="light"] .phase-pill.break {
            background: hsla(155, 65%, 45%, 0.15) !important;
            color: #34d399 !important;
        }

        [data-theme="light"] .phase-pill.idle {
            background: #f0f9ff !important;
            color: #03045e !important;
        }

        [data-theme="light"] .side-panel {
            background: #ffffff;
            border-color: #e0e7ff;
            color: #03045e;
        }

        [data-theme="light"] .side-panel h4 {
            color: #03045e !important;
        }

        [data-theme="light"] .task-input {
            background: #ffffff;
            border-color: #e0e7ff;
            color: #03045e;
        }

        [data-theme="light"] .task-input:focus {
            border-color: #03045e !important;
        }

        [data-theme="light"] .task-input::placeholder {
            color: #64748b;
        }

        [data-theme="light"] .music-btn {
            border-color: #e0e7ff;
            color: #03045e;
        }

        [data-theme="light"] .music-btn:hover {
            border-color: #03045e !important;
            color: #03045e !important;
        }

        [data-theme="light"] .music-btn.active {
            border-color: #03045e !important;
            background: hsla(220, 90%, 45%, 0.15) !important;
            color: #03045e !important;
        }

        /* Additional light mode text fixes */
        [data-theme="light"] .hero-subtitle {
            color: #6b7280 !important;
        }

        [data-theme="light"] .text-xs {
            color: #000000 !important;
        }

        [data-theme="light"] .font-semibold {
            color: #000000 !important;
        }

        /* Timer ring and buttons in light mode */
        [data-theme="light"] .ring-fill {
            stroke: #03045e !important;
        }

        [data-theme="light"] .btn-play {
            background: #03045e !important;
            box-shadow: 0 10px 30px hsla(220, 90%, 45%, 0.3) !important;
        }

        [data-theme="light"] .btn-play:hover {
            filter: brightness(1.15) !important;
        }

        [data-theme="light"] .btn-pause {
            background: #475569 !important;
            box-shadow: 0 10px 30px hsla(220, 90%, 45%, 0.3) !important;
        }

        [data-theme="light"] .duration-input:focus {
            border-color: #03045e !important;
        }
        .hero-subtitle {
            letter-spacing: .2em;
            text-transform: uppercase;
            font-size: 10px;
            color: var(--col-subtle);
        }
        .ambient-bg {
            pointer-events: none;
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }
        .ambient-bg::before,
        .ambient-bg::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            filter: blur(60px);
            opacity: .5;
            animation: float-glow 9s ease-in-out infinite;
        }
        .ambient-bg::before {
            width: 300px; height: 300px;
            top: -80px; left: -40px;
            background: rgba(65, 135, 255, .35);
        }
        .ambient-bg::after {
            width: 260px; height: 260px;
            right: -40px; top: 16%;
            background: var(--hero-glow);
            animation-delay: 1.2s;
        }
        .noise-overlay {
            pointer-events: none;
            position: absolute;
            inset: 0;
            z-index: 1;
            opacity: .06;
            background-image: radial-gradient(circle at 1px 1px, #ffffff 1px, transparent 0);
            background-size: 3px 3px;
        }

        .method-card {
            background: var(--col-surface);
            border: 1.5px solid var(--col-border);
            border-radius: 16px;
            padding: 18px;
            cursor: pointer;
            transition: border-color .2s, box-shadow .25s, transform .25s, background .25s;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(8px);
            animation: card-rise .45s ease both;
        }
        .method-card::before {
            content: '';
            position: absolute; inset: 0;
            background: var(--accent-dim);
            opacity: 0;
            transition: opacity .2s;
        }
        .method-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 32px -18px rgba(0, 0, 0, .9);
        }
        .method-card:hover::before { opacity: 0.6; }
        .method-card.active {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-ring), 0 8px 32px -8px var(--accent-dim);
        }
        .method-card.active::before { opacity: 1; }
        .method-card .badge {
            font-size: 9px; letter-spacing: .1em; text-transform: uppercase;
            padding: 3px 8px; border-radius: 20px;
            background: var(--accent-dim); color: var(--accent);
        }
        .method-card h4 { font-weight: 800; font-size: .95rem; color: var(--accent); }

        .timer-panel {
            background: linear-gradient(180deg, rgba(22, 27, 41, .88), rgba(15, 19, 30, .95));
            border: 1px solid rgba(91, 106, 151, .26);
            border-radius: 28px;
            padding: 56px 26px 44px;
            text-align: center;
            position: relative;
            z-index: 2;
            box-shadow: inset 0 0 0 1px rgba(190, 210, 255, .04), 0 26px 65px -38px rgba(0, 0, 0, .95);
        }
        .timer-panel::after {
            content: "";
            position: absolute;
            inset: 12px;
            border-radius: 22px;
            border: 1px solid rgba(167, 184, 224, .08);
            pointer-events: none;
        }

        .ring-track  { stroke: var(--col-muted); }
        .ring-fill   { stroke: var(--accent); transition: stroke-dashoffset 1s linear, stroke .4s; }
        .ring-fill.running { animation: ring-breath 1.8s ease-in-out infinite; }

        .phase-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 16px; border-radius: 99px; font-size: 11px;
            font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            transition: all .3s ease;
        }
        .phase-pill.focus { background: hsla(0,75%,55%,.15); color: #f87171; }
        .phase-pill.break { background: hsla(155,65%,45%,.15); color: #34d399; }
        .phase-pill.idle  { background: var(--col-border); color: var(--col-subtle); }

        .seq-dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--col-muted); transition: background .3s, transform .3s;
        }
        .seq-dot.done  { background: var(--accent); }
        .seq-dot.active { background: var(--accent); transform: scale(1.4);
                          box-shadow: 0 0 8px var(--accent); }

        .btn-play, .btn-pause, .btn-stop {
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            transition: transform .2s ease, filter .2s ease, box-shadow .2s ease;
            border: none; cursor: pointer;
        }
        .btn-play  { width:72px; height:72px; background: var(--accent); color:#fff;
                     box-shadow: 0 10px 30px var(--accent-ring); }
        .btn-play:hover  { filter: brightness(1.15); transform: scale(1.07) translateY(-1px); }
        .btn-pause { width:72px; height:72px; background: #ca8a04; color:#fff;
                     box-shadow: 0 10px 30px rgba(202,138,4,.3); }
        .btn-pause:hover { filter: brightness(1.15); transform: scale(1.07) translateY(-1px); }
        .btn-stop  { width:52px; height:52px; background: var(--col-border); color:var(--col-subtle); }
        .btn-stop:hover { background: #7f1d1d; color:#fca5a5; transform: translateY(-1px); }

        .timer-ring {
            width: min(280px, 82vw);
            height: auto;
        }
        .timer-value {
            font-size: clamp(2.8rem, 12vw, 4.5rem);
            line-height: .9;
            color: #f7fbff;
            text-shadow:
                0 0 32px rgba(173, 196, 255, .14),
                0 14px 34px rgba(8, 11, 22, .82);
            font-variant-numeric: tabular-nums;
            letter-spacing: -.03em;
            font-weight: 800;
        }

        .side-panel {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 20px; padding: 28px;
            position: static;
        }
        .music-btn {
            border-radius: 12px; padding: 11px 8px;
            font-size: 13px; display: flex; align-items: center; justify-content: center;
            gap: 6px; border: 1.5px solid var(--col-border);
            background: transparent; color: var(--col-text); cursor: pointer;
            transition: all .15s;
        }
        .music-btn:hover { border-color: var(--accent); color: var(--accent); }
        .music-btn.active { border-color: var(--accent); background: var(--accent-dim); color: var(--accent); }
        .task-input {
            width:100%; background: var(--col-bg); border: 1.5px solid var(--col-border);
            border-radius: 12px; padding: 14px 16px; color: var(--col-text);
            font-family: 'Inter', sans-serif; font-size: 14px; outline: none;
            transition: border-color .2s;
        }
        .task-input::placeholder { color: var(--col-muted); }
        .task-input:focus { border-color: var(--accent); }
        
        /* Session Notes Editor */
        .session-notes-editor {
            background: var(--col-bg); border: 1.5px solid var(--col-border);
            border-radius: 12px; margin: 12px 0;
            overflow: hidden;
        }
        .notes-toolbar {
            display: flex; gap: 2px; padding: 8px; border-bottom: 1px solid var(--col-border);
            background: var(--col-surface);
        }
        .notes-btn {
            padding: 4px 8px; border: none; background: transparent; color: var(--col-subtle);
            border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600;
            transition: all .2s; font-family: 'Inter', sans-serif;
        }
        .notes-btn:hover { background: var(--col-muted); color: var(--col-text); }
        .notes-btn.active { background: var(--accent-dim); color: var(--accent); }
        .notes-content {
            padding: 12px 16px; min-height: 80px; max-height: 150px; overflow-y: auto;
            outline: none; line-height: 1.5; font-size: 13px;
            font-family: 'Inter', sans-serif; color: var(--col-text);
        }
        .notes-content:focus { border-color: var(--accent); }
        .notes-content:empty:before {
            content: attr(data-placeholder);
            color: var(--col-muted); font-style: italic;
        }
        .notes-footer {
            display: flex; justify-content: space-between; align-items: center;
            padding: 8px 16px; border-top: 1px solid var(--col-border);
            background: var(--col-surface);
        }
        .notes-counter {
            font-size: 11px; color: var(--col-subtle);
        }
        .notes-tags {
            display: flex; gap: 4px; flex-wrap: wrap;
        }
        .note-tag {
            display: inline-block; padding: 2px 6px; margin: 1px;
            background: var(--accent-dim); color: var(--accent);
            border-radius: 8px; font-size: 10px; font-weight: 500;
        }

        #toast {
            position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(80px);
            background: var(--col-surface); border: 1px solid var(--col-border);
            border-radius: 12px; padding: 14px 24px; font-size: 13px;
            box-shadow: 0 12px 40px rgba(0,0,0,.5); z-index: 999;
            transition: transform .35s cubic-bezier(.34,1.56,.64,1), opacity .35s;
            opacity: 0; white-space: nowrap;
        }
        #toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

        @keyframes pulse-ring { 0%,100%{opacity:.7} 50%{opacity:1} }
        @keyframes card-rise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes ring-breath { 0%,100% { filter: drop-shadow(0 0 0 var(--accent-ring)); } 50% { filter: drop-shadow(0 0 9px var(--accent)); } }
        @keyframes float-glow { 0%,100% { transform: translateY(0); } 50% { transform: translateY(16px); } }

        /* ── Task ring label ── */
        .task-ring-label {
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 11px;
            letter-spacing: .04em;
            color: var(--accent);
            opacity: .85;
            margin-top: 6px;
        }

        /* ── Completion Modal ── */
        .completion-modal-bg {
            position: fixed; inset: 0;
            background: rgba(0,0,0,.65);
            backdrop-filter: blur(8px);
            z-index: 900;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .3s;
        }
        .completion-modal-bg.open {
            opacity: 1; pointer-events: all;
        }
        .completion-modal {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 24px;
            padding: 40px 32px 32px;
            width: 100%; max-width: 380px;
            text-align: center;
            transform: translateY(16px) scale(.97);
            transition: transform .3s cubic-bezier(.34,1.56,.64,1);
        }
        .completion-modal-bg.open .completion-modal {
            transform: translateY(0) scale(1);
        }
        .modal-task-name {
            background: var(--accent-dim);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 13px; font-weight: 700;
            color: var(--accent);
            margin: 12px 0 24px;
            word-break: break-word;
        }
        .modal-btn {
            flex: 1; padding: 14px 8px;
            border-radius: 14px; font-size: 14px; font-weight: 700;
            border: none; cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .15s;
        }
        .modal-btn-yes { background: hsla(155,65%,45%,.2); color: #34d399; border: 1.5px solid #34d399; }
        .modal-btn-yes:hover { background: hsla(155,65%,45%,.35); transform: scale(1.03); }
        .modal-btn-no  { background: hsla(0,75%,55%,.15); color: #f87171; border: 1.5px solid #f87171; }
        .modal-btn-no:hover  { background: hsla(0,75%,55%,.25); transform: scale(1.03); }

        /* ── Task history chips ── */
        .history-chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 10px; border-radius: 99px; font-size: 11px;
            background: var(--col-bg); border: 1px solid var(--col-border);
            color: var(--col-subtle); cursor: pointer;
            transition: all .15s; white-space: nowrap;
        }
        .history-chip:hover { border-color: var(--accent); color: var(--accent); }
        .history-chip .dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
        .dot-done   { background: #34d399; }
        .dot-undone { background: #f87171; }

        /* ── Quick suggestion pills ── */
        .suggest-pill {
            font-size: 11px; padding: 4px 10px; border-radius: 99px;
            background: transparent; border: 1px solid var(--col-border);
            color: var(--col-subtle); cursor: pointer; transition: all .15s;
            font-family: 'Inter', sans-serif;
        }
        .suggest-pill:hover { border-color: var(--accent); color: var(--accent); }

        /* ── Char counter ── */
        .char-counter { font-size: 10px; color: var(--col-muted); text-align: right; margin-top: 4px; }
        .char-counter.warn { color: #f59e0b; }
        .duration-input {
            width: 92px;
            background: var(--col-bg);
            border: 1.5px solid var(--col-border);
            border-radius: 10px;
            padding: 8px 10px;
            color: var(--col-text);
            font-size: 12px;
            outline: none;
        }
        .duration-input:focus { border-color: var(--accent); }
        .mini-timer {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 1000;
            background: rgba(14, 17, 27, .92);
            border: 1px solid var(--col-border);
            border-radius: 14px;
            backdrop-filter: blur(8px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .45);
            padding: 10px 12px;
            min-width: 170px;
        }
        .mini-timer .mini-time {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.02em;
            color: #f4f8ff;
        }

        .progress-stat {
            border: 1px solid var(--col-border);
            border-radius: 12px;
            background: var(--col-bg);
            padding: 10px 12px;
        }
        .streak-day {
            border: 1px solid var(--col-border);
            border-radius: 10px;
            background: var(--col-bg);
            padding: 8px 6px;
            min-width: 54px;
            text-align: center;
        }
        .streak-day.active {
            border-color: var(--accent);
            background: var(--accent-dim);
        }
        .history-list-item {
            border: 1px solid var(--col-border);
            border-radius: 12px;
            padding: 10px;
            background: var(--col-bg);
        }

        @media (max-width: 640px) {
            .method-card { padding: 14px; border-radius: 14px; }
            .method-card h4 { font-size: .88rem; }
            .method-card .badge { font-size: 8px; padding: 2px 7px; }
            .timer-panel { padding: 28px 14px 24px; border-radius: 18px; }
            .btn-play, .btn-pause { width: 62px; height: 62px; }
            .btn-stop { width: 46px; height: 46px; }
            .side-panel { padding: 18px; border-radius: 16px; }
            .completion-modal { max-width: 92vw; padding: 28px 20px 22px; border-radius: 18px; }
            #toast { max-width: 90vw; white-space: normal; text-align: center; }
            .streak-day { min-width: 46px; padding: 7px 4px; }
        }
    </style>

    <div class="py-10 min-h-screen relative overflow-hidden" x-data="timerApp({{ auth()->check() ? 'true' : 'false' }})" x-init="init()" :data-method="method">
        <div class="ambient-bg"></div>
        <div class="noise-overlay"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 relative z-[2]">
            <div class="text-center space-y-2">
                <p class="hero-subtitle">Deep Focus Interface</p>
                <h1 class="hero-title">Build Momentum, One Session at a Time</h1>
            </div>
            <div x-show="!isAuthenticated" class="rounded-xl border px-4 py-3 text-xs" style="border-color:#4e4329;background:rgba(80, 65, 28, .18);color:#f3d98d;">
                Kamu sedang di mode guest. Timer bisa dipakai normal, tapi history/streak dan simpan progress perlu login.
                <a href="{{ route('login') }}" class="underline ml-1">Login sekarang</a>
            </div>

            {{-- ── Method Selection Grid ── --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <div class="method-card" :class="{ active: method === 'pomodoro' }" @click="selectMethod('pomodoro')">
                    <div class="flex justify-between items-start mb-2">
                        <h4>Pomodoro</h4>
                        <span class="badge" x-text="customDurations.pomodoro.f + ' min'">25 min</span>
                    </div>
                    <p class="text-xs leading-relaxed" style="color:var(--col-subtle)">Fokus <span x-text="customDurations.pomodoro.f">25</span> menit, istirahat <span x-text="customDurations.pomodoro.b">5</span> menit. Metode klasik terpopuler.</p>
                </div>
                <div class="method-card" :class="{ active: method === '5217' }" @click="selectMethod('5217')">
                    <div class="flex justify-between items-start mb-2">
                        <h4>52/17</h4>
                        <span class="badge" x-text="customDurations['5217'].f + ' min'">52 min</span>
                    </div>
                    <p class="text-xs leading-relaxed" style="color:var(--col-subtle)">Fokus <span x-text="customDurations['5217'].f">52</span> menit, istirahat <span x-text="customDurations['5217'].b">17</span> menit. Ritme riset DeskTime.</p>
                </div>
                <div class="method-card" :class="{ active: method === 'flowtime' }" @click="selectMethod('flowtime')">
                    <div class="flex justify-between items-start mb-2">
                        <h4>Flowtime</h4>
                        <span class="badge">∞</span>
                    </div>
                    <p class="text-xs leading-relaxed" style="color:var(--col-subtle)">Tanpa batas. Istirahat dihitung otomatis dari durasi fokus.</p>
                </div>
                <div class="method-card" :class="{ active: method === 'animedoro' }" @click="selectMethod('animedoro')">
                    <div class="flex justify-between items-start mb-2">
                        <h4>Animedoro</h4>
                        <span class="badge">40–60 min</span>
                    </div>
                    <p class="text-xs leading-relaxed" style="color:var(--col-subtle)">Fokus panjang, istirahat 20 menit.</p>
                </div>
                <div class="method-card" :class="{ active: method === '2min' }" @click="selectMethod('2min')">
                    <div class="flex justify-between items-start mb-2">
                        <h4>2-Min Rule</h4>
                        <span class="badge">2 min</span>
                    </div>
                    <p class="text-xs leading-relaxed" style="color:var(--col-subtle)">Lawan prokrastinasi dengan tugas 2 menit.</p>
                </div>
                <div class="method-card" :class="{ active: method === '2357' }" @click="selectMethod('2357')">
                    <div class="flex justify-between items-start mb-2">
                        <h4>2-3-5-7</h4>
                        <span class="badge">Sequential</span>
                    </div>
                    <p class="text-xs leading-relaxed" style="color:var(--col-subtle)">Sesi berurutan ideal untuk active recall.</p>
                </div>
            </div>

            <div class="side-panel" style="padding:16px 18px;">
                <div class="flex flex-wrap items-center gap-3">
                    <div x-data="{ showInfo: false }" class="relative flex items-center gap-2">
                        <p class="text-xs font-semibold" style="color:var(--col-subtle)">Custom Duration</p>
                        <button @click="showInfo = !showInfo" @click.away="showInfo = false" class="text-xs opacity-50 hover:opacity-100 transition-opacity" style="color:var(--col-subtle)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        </button>
                        
                        <!-- Popover Info -->
                        <div x-show="showInfo" x-transition.opacity style="display: none; background:var(--col-surface); border-color:var(--col-border); color:var(--col-text);" class="absolute left-0 top-6 z-50 p-4 rounded-xl shadow-xl border w-72 text-xs leading-relaxed">
                            <p class="mb-2 font-bold" style="color:var(--col-text)">Kenapa cuma untuk Pomodoro & 52/17?</p>
                            <ul class="list-disc pl-4 space-y-2" style="color:var(--col-subtle)">
                                <li><strong>Flowtime:</strong> Timer menghitung naik tanpa batas.</li>
                                <li><strong>2-Min Rule:</strong> Trik psikologis ini akan hilang kekuatannya jika bukan 2 menit.</li>
                                <li><strong>2-3-5-7:</strong> Rantai berurutan angka prima akan rusak jika diubah bebas.</li>
                                <li><strong>Animedoro:</strong> Aturan bakunya adalah 40 menit kerja + 20 menit hiburan.</li>
                            </ul>
                        </div>
                    </div>
                    <span class="text-[11px]" style="color:var(--col-muted)">Pomodoro / 52-17</span>
                    <label class="text-xs" style="color:var(--col-subtle)">Focus
                        <input type="number" min="1" max="180" class="duration-input ml-1" x-model.number="customFocusMinutes">
                    </label>
                    <label class="text-xs" style="color:var(--col-subtle)">Break
                        <input type="number" min="0" max="60" class="duration-input ml-1" x-model.number="customBreakMinutes">
                    </label>
                    <button class="music-btn" style="padding:8px 12px" @click="applyCustomDuration()">Apply</button>
                </div>
            </div>

            {{-- ── Animedoro duration picker ── --}}
            <div x-show="method === 'animedoro'" x-transition class="flex items-center gap-3 px-1">
                <span class="text-xs" style="color:var(--col-subtle)">Durasi fokus:</span>
                <template x-for="opt in [40,45,50,55,60]" :key="opt">
                    <button @click="setAnimedoroDuration(opt)"
                            :class="animedoroDuration === opt ? 'active music-btn' : 'music-btn'"
                            style="padding:6px 14px; font-size:12px;" x-text="opt + 'm'"></button>
                </template>
            </div>

            {{-- ── Main Timer Panel ── --}}
            <div class="timer-panel">
                <div class="flex justify-center mb-8">
                    <span :class="phase === 'focus' ? 'phase-pill focus' : phase === 'break' ? 'phase-pill break' : 'phase-pill idle'">
                        <span x-text="phase === 'focus' ? '🔥 Sedang Fokus' : phase === 'break' ? '☕ Waktu Istirahat' : '⏸ Siap'"></span>
                    </span>
                </div>

                <div x-show="method === '2357'" class="flex justify-center items-center gap-4 mb-6">
                    <template x-for="(s, i) in seqSteps" :key="i">
                        <div class="flex flex-col items-center gap-1.5">
                            <div class="seq-dot" :class="{ done: i < seqIndex, active: i === seqIndex }"></div>
                            <span class="text-xs" style="color:var(--col-subtle)" x-text="s + 'm'"></span>
                        </div>
                    </template>
                </div>

                {{-- XP and Level Display --}}
                @auth
                    <div class="flex justify-center gap-4 mb-4">
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="border-color:#4a4125;color:#f0d792;">
                            <span>⚡</span>
                            <span class="font-semibold" x-text="xpPoints + ' XP'"></span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="border-color:#7c3aed;color:#a78bfa;">
                            <span>🎯</span>
                            <span class="font-semibold" x-text="level"></span>
                        </div>
                    </div>
                @endauth

                <div class="relative flex items-center justify-center my-4">
                    <svg class="timer-ring" width="280" height="280" viewBox="0 0 280 280">
                        <circle class="ring-track" cx="140" cy="140" r="124" stroke-width="8" fill="none" transform="rotate(-90 140 140)"/>
                        <circle class="ring-fill" :class="{ running: running }"
                                :style="phase === 'break' ? 'stroke: #10b981;' : ''"
                                cx="140" cy="140" r="124" stroke-width="8" fill="none" stroke-linecap="round"
                                :stroke-dasharray="780" :stroke-dashoffset="780 - (780 * ringProgress / 100)"
                                transform="rotate(-90 140 140)"/>
                    </svg>
                    <div class="absolute flex flex-col items-center select-none">
                        <span class="timer-font timer-value font-extrabold tracking-tighter" :style="phase === 'break' ? 'color: #10b981;' : ''" x-text="formatTime(displayTime)"></span>
                        <span class="text-xs mt-2 uppercase tracking-widest font-bold" :style="phase === 'break' ? 'color: #10b981;' : 'color:var(--col-subtle)'" x-text="phaseLabel"></span>
                        {{-- Task label di dalam ring ──────────────────────────── --}}
                        <span class="task-ring-label" x-show="task.trim() && phase !== 'idle'" x-text="task"
                              x-transition:enter="transition ease-out duration-300"
                              x-transition:enter-start="opacity-0 translate-y-1"
                              x-transition:enter-end="opacity-100 translate-y-0"></span>
                    </div>
                </div>

                <div class="flex justify-center items-center gap-5 mt-6">
                    <button class="btn-play" x-show="!running" @click="start()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                    </button>
                    <button class="btn-pause" x-show="running" @click="pause()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6"/></svg>
                    </button>
                    <button class="btn-stop" @click="stop()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="flex justify-center gap-8 mt-8">
                    <div class="text-center" :class="{ 'opacity-45': !isAuthenticated }" :title="!isAuthenticated ? 'Login untuk sinkronisasi data' : ''">
                        <div class="timer-font text-xl font-bold" style="color:var(--accent)" x-text="sessionsToday"></div>
                        <div class="text-xs mt-1" style="color:var(--col-subtle)">Sesi Hari Ini</div>
                    </div>
                    <div class="text-center" :class="{ 'opacity-45': !isAuthenticated }" :title="!isAuthenticated ? 'Login untuk sinkronisasi data' : ''">
                        <div class="timer-font text-xl font-bold" style="color:var(--accent)" x-text="formatTime(totalFocusToday)"></div>
                        <div class="text-xs mt-1" style="color:var(--col-subtle)">Total Fokus</div>
                    </div>
                    <div class="text-center" :class="{ 'opacity-45': !isAuthenticated }" :title="!isAuthenticated ? 'Login untuk sinkronisasi data' : ''">
                        <div class="timer-font text-xl font-bold" style="color:var(--accent)" x-text="streak + ' hari 🔥'"></div>
                        <div class="text-xs mt-1" style="color:var(--col-subtle)">Streak</div>
                    </div>
                </div>
                <div x-show="!isAuthenticated" class="mt-4">
                    <button @click="requireLogin('streak dan history')" class="text-xs px-4 py-2 rounded-lg border" style="border-color:#4e4329;color:#f3d98d;background:rgba(80, 65, 28, .12);">
                        🔒 Login untuk menyimpan progress akun
                    </button>
                </div>
                <div class="mt-4">
                    <button @click="console.log('Button clicked! showRecapModal before:', showRecapModal); showRecapModal = true; console.log('showRecapModal after:', showRecapModal);" class="text-xs px-4 py-2 rounded-lg border" style="border-color:var(--col-border);color:var(--col-text);">
                        Lihat Recap Harian
                    </button>
                    <button @click="openTimerPopup()" class="text-xs px-4 py-2 rounded-lg border ml-2" style="border-color:var(--col-border);color:var(--col-text);">
                        Open popup timer
                    </button>
                    <button @click="toggleNotifications()" class="text-xs px-4 py-2 rounded-lg border ml-2" style="border-color:var(--col-border);color:var(--col-text);">
                        <span x-show="!notificationsEnabled">Aktifkan Notifikasi</span>
                        <span x-show="notificationsEnabled">Nonaktifkan</span>
                    </button>
                </div>
            </div>

            {{-- ── Side Panels ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="side-panel">
                    <div class="flex items-center gap-2 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                        <h4 class="font-bold text-sm">Ambient Audio</h4>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button @click="playMusic('instrumental')" :class="{ active: currentMusic === 'instrumental' }" class="music-btn">☕ Instrumental</button>
                        <button @click="playMusic('rain')" :class="{ active: currentMusic === 'rain' }" class="music-btn">🌧️ Rain</button>
                    </div>
                    <div class="flex items-center gap-3 mt-4">
                        <span class="text-xs" style="color:var(--col-subtle)">Volume</span>
                        <input type="range" min="0" max="1" step="0.05" x-model="audioVolume" class="flex-1 accent-current" style="accent-color:var(--accent)">
                        <button @click="stopMusic()" class="text-xs px-3 py-1 rounded-lg" style="background:var(--col-border);color:var(--col-subtle)">Mute</button>
                    </div>
                </div>

                <div class="side-panel">
                    <div class="flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <h4 class="font-bold text-sm">Fokus Utama</h4>
                        {{-- Indikator live saat timer jalan ── --}}
                        <span
                            x-show="task.trim() && phase === 'focus'"
                            class="ml-auto text-xs px-2 py-0.5 rounded-full"
                            style="background:var(--accent-dim);color:var(--accent);animation:pulse-ring 2s infinite"
                        >● aktif</span>
                    </div>

                    {{-- Simple Task Input (Fixed) ── --}}
                    <div class="relative">
                        <input
                            type="text" class="task-input pr-8"
                            x-model="task"
                            placeholder="Saya ingin menyelesaikan… #subject #topic"
                            maxlength="200"
                            @keydown.enter="task.trim() && phase === 'idle' && start()"
                        >
                        <button
                            x-show="task.trim()"
                            @click="task = ''"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm"
                            style="color:var(--col-muted); background:none; border:none; cursor:pointer; line-height:1"
                            title="Hapus"
                        >✕</button>
                    </div>
                    <div class="char-counter" :class="{ 'warn': task.length > 180 }">
                        <span x-text="task.length"></span>/200
                    </div>

                    {{-- Quick suggestions ── --}}
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="text-xs" style="color:var(--col-muted)">Contoh:</span>
                        <template x-for="s in quickSuggestions" :key="s">
                            <button class="suggest-pill" @click="task = s" x-text="s"></button>
                        </template>
                    </div>

                    {{-- Riwayat tugas sebelumnya ── --}}
                    <div x-show="!isAuthenticated" class="mt-4 rounded-xl border px-3 py-3 text-xs" style="border-color:#4e4329;background:rgba(80, 65, 28, .12);color:#f3d98d;">
                        Riwayat lintas perangkat khusus akun.
                        <a href="{{ route('login') }}" class="underline ml-1">Login untuk membuka</a>
                    </div>

                    <div x-show="isAuthenticated && taskHistory.length > 0" class="mt-4">
                        <p class="text-xs mb-2" style="color:var(--col-muted)">Terakhir:</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(h, i) in taskHistory.slice(0,4)" :key="i">
                                <button class="history-chip" @click="task = h.text" :title="historyTitle(h)">
                                    <span class="dot" :class="h.done ? 'dot-done' : 'dot-undone'"></span>
                                    <span x-text="h.text.length > 22 ? h.text.slice(0,22)+'…' : h.text"></span>
                                </button>
                            </template>
                        </div>

                        <div class="mt-3 space-y-2">
                            <template x-for="(h, i) in taskHistory.slice(0,3)" :key="'detail-'+i">
                                <div class="history-list-item">
                                    <div class="flex justify-between items-center gap-2">
                                        <p class="text-xs font-bold" x-text="h.text"></p>
                                        <span class="text-[10px]" :style="h.done ? 'color:#34d399' : 'color:#f87171'" x-text="h.done ? 'selesai' : 'belum'"></span>
                                    </div>
                                    <p class="text-[10px] mt-1" style="color:var(--col-subtle)" x-text="historyMeta(h)"></p>
                            </template>
                        </div>

                        <div class="mt-5 pt-4 border-t border-[var(--col-border)] flex items-center justify-between">
                            <span class="text-xs" style="color:var(--col-subtle)">Notifikasi Desktop</span>
                            
                            <button @click="toggleNotifications()" title="Klik untuk mematikan"
                                    class="text-xs px-3 py-1.5 rounded-lg bg-[var(--accent-dim)] text-[var(--accent)] hover:opacity-80 transition-all">
                                Aktifkan Notifikasi
                            </button>
                        </div>
                    </div>
                    </div>
                </div>

                {{-- ══════════════ RECAP MODAL ══════════════ --}}
                <div class="completion-modal-bg" :class="{ open: showRecapModal }" @click.self="showRecapModal = false">
                    <div class="completion-modal" style="text-align:center; max-width: 400px;">
                        <div style="font-size:3rem;margin-bottom:10px">📊</div>
                        <h3 class="font-bold text-xl mb-4 text-white">Recap Belajar Hari Ini</h3>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-4 rounded-xl" style="background:var(--col-bg); border:1px solid var(--col-border);">
                                <div class="text-xs mb-1" style="color:var(--col-subtle)">Waktu Fokus</div>
                                <div class="text-lg font-bold text-blue-400" x-text="formatTime(totalFocusToday)"></div>
                            </div>
                            <div class="p-4 rounded-xl" style="background:var(--col-bg); border:1px solid var(--col-border);">
                                <div class="text-xs mb-1" style="color:var(--col-subtle)">Total Sesi</div>
                                <div class="text-lg font-bold text-green-400" x-text="sessionsToday + ' Sesi'"></div>
                            </div>
                            <div class="p-4 rounded-xl" style="background:var(--col-bg); border:1px solid var(--col-border);">
                                <div class="text-xs mb-1" style="color:var(--col-subtle)">XP Didapat</div>
                                <div class="text-lg font-bold text-yellow-400" x-text="xpPoints + ' XP'"></div>
                            </div>
                            <div class="p-4 rounded-xl" style="background:var(--col-bg); border:1px solid var(--col-border);">
                                <div class="text-xs mb-1" style="color:var(--col-subtle)">Current Streak</div>
                                <div class="text-lg font-bold text-orange-400" x-text="streak + ' Hari 🔥'"></div>
                            </div>
                        </div>

                        <div class="p-3 rounded-lg text-sm mb-6" style="background:var(--col-bg); border:1px solid var(--col-border); text-align:left;">
                            <span style="color:var(--col-subtle)">Fokus terakhir:</span>
                            <span class="ml-2 text-white font-medium" x-text="task.trim() || 'Tidak ada catatan'"></span>
                        </div>

                        <div class="flex gap-3 justify-center">
                            <button @click="exportDailyRecap()" class="text-xs px-6 py-2 rounded-xl font-bold transition-all" style="background:var(--col-bg); color:var(--col-text); border:1px solid var(--col-border);">
                                <span x-text="copyTextState"></span>
                            </button>
                            <button @click="showRecapModal = false" class="text-xs px-6 py-2 rounded-xl font-bold transition-all" style="background:var(--accent); color:white;">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ══════════════ COMPLETION MODAL ══════════════ --}}
                <div class="completion-modal-bg" :class="{ open: showModal }" @click.self="showModal = false">
                    <div class="completion-modal">
                        <div style="font-size:2.5rem;margin-bottom:6px">🎯</div>
                        <h3 class="font-bold text-lg mb-1">Sesi Fokus Selesai!</h3>
                        <p class="text-xs mb-2" style="color:var(--col-subtle)">
                            <span x-text="'Durasi: ' + formatTime(lastSessionDuration)"></span>
                            <span x-show="pendingBreakSec > 0" x-text="' • Istirahat: ' + Math.round(pendingBreakSec / 60) + ' mnt'"></span>
                        </p>

                        <div x-show="task.trim()">
                            <p class="text-xs" style="color:var(--col-subtle)">Apakah kamu berhasil menyelesaikan:</p>
                            <div class="modal-task-name" x-text="task"></div>
                            
                            <!-- Enhanced Session Notes -->
                            <div class="session-notes-editor">
                                <div class="notes-toolbar">
                                    <button @click="formatNote('bold')" class="notes-btn" title="Bold">B</button>
                                    <button @click="formatNote('italic')" class="notes-btn" title="Italic" style="font-style: italic;">I</button>
                                    <button @click="formatNote('underline')" class="notes-btn" title="Underline" style="text-decoration: underline;">U</button>
                                    <button @click="insertNoteTag()" class="notes-btn" title="Add Tag">#</button>
                                    <button @click="clearNotes()" class="notes-btn" title="Clear">Clear</button>
                                </div>
                                <div 
                                    class="notes-content" 
                                    contenteditable="true"
                                    x-ref="notesEditor"
                                    x-html="sessionNote"
                                    @input="updateSessionNote()"
                                    @keydown="handleNotesKeydown($event)"
                                    @paste="handleNotesPaste($event)"
                                    data-placeholder="Catatan sesi: aku ngerjain apa tadi? #subject #difficulty"
                        <div class="notes-footer">
                                    <span class="notes-counter">
                                        <span x-text="getNotesLength()"></span>/300
                                    </span>
                                    <div class="notes-tags" x-show="getNotesTags().length > 0">
                                        <template x-for="tag in getNotesTags()" :key="tag">
                                            <span class="note-tag" x-text="tag"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button class="modal-btn modal-btn-yes" @click="markTaskDone(true)">✓ Berhasil!</button>
                                <button class="modal-btn modal-btn-no"  @click="markTaskDone(false)">✗ Belum</button>
                            </div>
                            <div class="flex items-center gap-2 mt-3 justify-center w-full">
                                <button class="text-xs px-4 py-2 rounded-xl font-bold transition-all" style="background:var(--col-surface); color:var(--col-text); border: 2px solid var(--col-border); flex-1;" @click="snoozeFocus(snoozeMinutes)">
                                    ⏳ Snooze
                                </button>
                                <input type="number" x-model="snoozeMinutes" min="1" max="60" class="w-16 px-2 py-2 rounded-xl text-center text-xs font-bold" style="background:var(--col-bg); border: 2px solid var(--col-border); color:var(--col-text);">
                                <span class="text-xs" style="color:var(--col-subtle)">m</span>
                            </div>
                        </div>

                        <div x-show="!task.trim()" class="flex flex-col gap-3 mt-2">
                            <button class="modal-btn modal-btn-yes w-full" @click="completeSessionModal()">
                                <template x-if="pendingBreakSec > 0">
                                    <span>☕ Mulai Istirahat <span x-text="'(' + Math.round(pendingBreakSec/60) + 'm)'"></span></span>
                                </template>
                                <template x-if="pendingBreakSec === 0">
                                    <span>✓ Selesai Sesi</span>
                                </template>
                            </button>
                            <div class="flex items-center gap-2 w-full">
                                <button class="text-xs px-4 py-2 rounded-xl font-bold transition-all" style="background:var(--col-surface); color:var(--col-text); border: 2px solid var(--col-border); flex-1;" @click="snoozeFocus(snoozeMinutes)">
                                    ⏳ Snooze Fokus
                                </button>
                                <input type="number" x-model="snoozeMinutes" min="1" max="60" class="w-16 px-2 py-2 rounded-xl text-center text-xs font-bold" style="background:var(--col-bg); border: 2px solid var(--col-border); color:var(--col-text);">
                                <span class="text-xs" style="color:var(--col-subtle)">m</span>
                            </div>
                            <button @click="completeSessionModal()" class="mt-4 text-xs" style="color:var(--col-muted);background:none;border:none;cursor:pointer">
                                Lewati
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ══════════════ BREAK COMPLETION MODAL ══════════════ --}}
                <div class="completion-modal-bg" :class="{ open: showBreakModal }" @click.self="showBreakModal = false">
                    <div class="completion-modal">
                        <div style="font-size:2.5rem;margin-bottom:6px">☕</div>
                        <h3 class="font-bold text-lg mb-2">Waktu Istirahat Selesai!</h3>
                        <p class="text-xs mb-4" style="color:var(--col-subtle)">
                            Apakah kamu sudah siap untuk kembali fokus?
                        </p>
                        <div class="flex flex-col gap-3">
                            <button class="modal-btn modal-btn-yes w-full" style="background: var(--accent);" @click="showBreakModal = false; applyMethod(); start();">
                                ▶️ Mulai Fokus Selanjutnya
                            </button>
                            <div class="flex items-center gap-2 w-full">
                                <button class="text-xs px-4 py-2 rounded-xl font-bold transition-all" style="background:var(--col-surface); color:var(--col-text); border: 2px solid var(--col-border); flex-1;" @click="snoozeBreak(snoozeMinutes)">
                                    ⏳ Tambah Istirahat
                                </button>
                                <input type="number" x-model="snoozeMinutes" min="1" max="60" class="w-16 px-2 py-2 rounded-xl text-center text-xs font-bold" style="background:var(--col-bg); border: 2px solid var(--col-border); color:var(--col-text);">
                                <span class="text-xs" style="color:var(--col-subtle)">m</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Enhanced Chronotype Widget -->
    @auth
        <div x-data="chronotypeWidget()" x-init="loadChronotypeData()" class="chronotype-widget" x-show="showWidget && !chronotypeCompleted">
            <div class="flex items-center justify-between p-6 rounded-xl border-2" style="background: var(--col-surface); border-color: var(--accent);">
                <div class="flex items-center gap-4">
                    <div style="font-size: 3rem;">🧠</div>
                    <div>
                        <div style="font-weight: 700; font-size: 1.25rem; margin-bottom: 0.5rem;">Discover Your Best Study Time</div>
                        <div style="font-size: 1rem; color: var(--col-subtle);">Answer 3 quick questions to find your optimal study hours based on science</div>
                    </div>
                </div>
                <button @click="window.location.href='/chronotype'" class="px-6 py-3 rounded-xl text-base font-bold transition transform hover:scale-105" style="background: var(--accent); color: white; box-shadow: 0 4px 20px rgba(74, 158, 255, 0.3);">
                    Start Quiz
                </button>
            </div>
        </div>

        <div x-data="chronotypeWidget()" x-init="loadChronotypeData()" class="chronotype-widget-enhanced" x-show="chronotypeCompleted">
            <div class="p-8 rounded-2xl border-2" style="background: var(--col-surface); border-color: var(--accent); position: relative; overflow: hidden;">
                <!-- Shimmer Effect -->
                <div class="shimmer-effect"></div>
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <div style="font-size: 4rem; margin-bottom: 1rem; animation: pulse 2s infinite;">🧠</div>
                    <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; background: linear-gradient(135deg, var(--accent), #4ade80); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        Your Best Study Times
                    </h2>
                    <div class="chronotype-info" style="font-size: 1.1rem; color: var(--col-subtle); margin-bottom: 2rem;">
                        Personalized for: <span x-text="getAgeCategoryLabel(age)" style="color: var(--accent); font-weight: 600;"></span>
                    </div>
                </div>

                <!-- Study Sessions Grid -->
                <div class="study-sessions-enhanced" style="display: grid; gap: 1.5rem; margin-bottom: 2rem;">
                    <template x-for="(hour, index) in optimalHours" :key="hour.start">
                        <div class="study-session-enhanced" :style="`animation: slideInUp 0.6s ease-out ${index * 0.1}s both`">
                            <div class="session-header-enhanced">
                                <div class="session-icon-enhanced" x-text="getSessionIcon(hour.start)"></div>
                                <div class="session-time-enhanced" x-text="formatTimeRange(hour.start, hour.end)"></div>
                                <div class="session-intensity-enhanced" :class="`intensity-${hour.intensity}`" x-text="hour.intensity.toUpperCase()"></div>
                            </div>
                            <div class="session-content-enhanced">
                                <div class="session-name-enhanced" x-text="hour.name"></div>
                                <div class="session-description-enhanced" x-text="hour.description"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Research Note -->
                <div class="research-note-enhanced" style="background: var(--accent-dim); border: 1px solid var(--accent); border-radius: 12px; padding: 1rem; margin-bottom: 2rem;">
                    <strong>💡 Science-Based:</strong> These recommendations are based on circadian rhythm research and age-related productivity patterns.
                </div>

                <!-- Action Button -->
                <div class="text-center">
                    <button @click="retakeQuiz()" class="px-6 py-3 rounded-xl text-base font-medium transition" style="background: transparent; border: 2px solid var(--col-border); color: var(--col-subtle); hover:border-color: var(--accent); hover:color: var(--accent);">
                        Retake Quiz
                    </button>
                </div>
            </div>
        </div>
    @endauth

    <style>
        .chronotype-widget-enhanced {
            max-width: 800px;
            margin: 2rem auto;
        }

        .shimmer-effect {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .study-session-enhanced {
            background: var(--col-bg);
            border: 1px solid var(--col-border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .study-session-enhanced:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(74, 158, 255, 0.2);
        }

        .session-header-enhanced {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .session-icon-enhanced {
            font-size: 2.5rem;
        }

        .session-time-enhanced {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text);
        }

        .session-intensity-enhanced {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .intensity-high {
            background: var(--accent-dim);
            color: var(--accent);
        }

        .intensity-medium {
            background: rgba(74, 158, 255, 0.05);
            color: var(--col-subtle);
        }

        .session-content-enhanced {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .session-name-enhanced {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .session-description-enhanced {
            font-size: 0.95rem;
            color: var(--col-subtle);
            line-height: 1.4;
        }

        .research-note-enhanced strong {
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .chronotype-widget-enhanced {
                margin: 1rem;
                padding: 1rem;
            }

            .session-header-enhanced {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }

            .session-content-enhanced {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    <div id="toast"></div>
    <div class="mini-timer" x-show="showMiniTimer">
        <div class="flex items-center justify-between mb-1">
            <p class="text-[10px] uppercase tracking-wider" style="color:var(--col-subtle);" x-text="phaseLabel"></p>
            <button class="text-[10px]" style="color:var(--col-muted);" @click="showMiniTimer = false">hide</button>
        </div>
        <p class="mini-time timer-font" x-text="formatTime(displayTime)"></p>
        <div class="flex items-center gap-2 mt-2">
            <button class="music-btn" style="padding:4px 8px;" @click="running ? pause() : start()" x-text="running ? 'Pause' : 'Play'"></button>
            <button class="music-btn" style="padding:4px 8px;" @click="stop()">Stop</button>
        </div>
    </div>

    <script>
    function timerApp(isAuthenticated) {
        return {
            /* ── state ── */
            method: 'pomodoro', 
            phase: 'idle', 
            running: false, 
            interval: null,
            focusDuration: 25 * 60, 
            breakDuration: 5 * 60, 
            displayTime: 25 * 60, 
            ringProgress: 100,
            elapsedFocus: 0, 
            breakTimeLeft: 0, 
            animedoroDuration: 40,
            seqSteps: [2, 3, 5, 7], 
            seqIndex: 0, 
            seqBreakSec: 30,
            sessionsToday: 0, 
            totalFocusToday: 0, 
            streak: 0,
            longestStreak: 0,
            totalSessionsLifetime: 0,
            streakProgress: [],
            xpPoints: {{ Auth::check() ? (Auth::user()->xp_points ?? 0) : 0 }},
            level: {{ Auth::check() ? (Auth::user()->level ?? 1) : 1 }},
            currentMusic: null, 
            audioVolume: 0.5,
            task: localStorage.getItem('focus_task') || '',
            notificationsEnabled: false,
            notificationRequested: false,
            isAuthenticated: !!isAuthenticated,
            showMiniTimer: true,
            customFocusMinutes: 25,
            customBreakMinutes: 5,
            customDurations: {
                pomodoro: { f: 25, b: 5 },
                '5217': { f: 52, b: 17 },
            },
            pendingSessionMinutes: 0,
            pendingSessionType: '',
            sessionNote: '',
            showModal: false,
            showBreakModal: false,
            snoozeMinutes: 5,
            showRecapModal: false,
            copyTextState: '📋 Salin Teks',
            popupWindow: null,

            // ── Fokus Utama 2.0 ──────────────────────────────────────────
            lastSessionDuration: 0,
            lastSessionMethod: '',
            pendingBreakSec: 0,
            taskHistory: JSON.parse(localStorage.getItem('task_history') || '[]'),
            quickSuggestions: ['Baca materi', 'Kerjakan soal', 'Review catatan', 'Deep work'],

            get phaseLabel() {
                const map = { 
                    'pomodoro': 'Pomodoro', 
                    '5217': '52 / 17', 
                    'flowtime': 'flowtime', 
                    'animedoro': 'animedoro', 
                    '2min': '2-min rule', 
                    '2357': `sesi ${this.seqIndex + 1}/4` 
                };
                const methodStr = map[this.method] || '';
                if (this.phase === 'focus') return `🎯 FOKUS - ${methodStr}`;
                if (this.phase === 'break') return `☕ ISTIRAHAT - ${methodStr}`;
                return `⏸️ STANDBY - ${methodStr}`;
            },

            init() {
                this.loadStats();
                this.applyMethod();
                this.bindShortcuts();
                this.syncPopupState();
                this.initTheme();
                this.requestNotificationPermission();
                
                // Make timer app instance globally available for task editor
                window.timerAppInstance = this;
                
                if ('Notification' in window && Notification.permission === 'granted') {
                    this.notificationsEnabled = true;
                }

                // Restore state if exists
                const savedState = localStorage.getItem('timer_bg_state');
                if (savedState) {
                    try {
                        const s = JSON.parse(savedState);
                        this.method = s.method;
                        this.applyMethod();
                        this.phase = s.phase;
                        this.focusDuration = s.focusDuration;
                        this.breakDuration = s.breakDuration;
                        this.task = s.task || '';
                        this.seqIndex = s.seqIndex || 0;
                        
                        if (this.method === 'flowtime' && s.startTime) {
                            this.expectedStartTime = s.startTime;
                            this.elapsedFocus = Math.floor((Date.now() - s.startTime) / 1000);
                            this.displayTime = this.elapsedFocus;
                            this.running = true;
                            this.interval = setInterval(() => this.tick(), 1000);
                        } else if (s.endTime) {
                            this.expectedEndTime = s.endTime;
                            let remaining = Math.floor((s.endTime - Date.now()) / 1000);
                            if (remaining > 0) {
                                if (this.phase === 'focus') this.displayTime = remaining;
                                else this.breakTimeLeft = remaining;
                                this.running = true;
                                this.interval = setInterval(() => this.tick(), 1000);
                            } else {
                                if (this.phase === 'focus') {
                                    this.displayTime = 0;
                                    this.focusComplete();
                                } else {
                                    this.breakTimeLeft = 0;
                                    this.breakComplete();
                                }
                            }
                        }
                    } catch(e) {
                        this.clearTimerState();
                    }
                }
            },

            initTheme() {
                // Load saved theme or default to dark (night mode)
                const savedTheme = localStorage.getItem('theme') || 'dark';
                this.setTheme(savedTheme);
            },

            toggleTheme() {
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                this.setTheme(newTheme);
            },

            setTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
            },

            openTimerPopup() {
                const features = 'width=360,height=280,resizable=yes,scrollbars=no';
                this.popupWindow = window.open('{{ route('timer.popup') }}', 'timerPopupWindow', features);
                if (!this.popupWindow) {
                    // Silent - no toast
                    return;
                }
                // Silent - no toast
                this.syncPopupState();
            },

            syncPopupState() {
                const payload = {
                    phaseLabel: this.phaseLabel || 'Timer',
                    timeText: this.formatTime(this.displayTime),
                    taskText: this.task?.trim() ? this.task.trim() : 'No active task',
                };
                localStorage.setItem('timer_popup_state', JSON.stringify(payload));
            },

            bindShortcuts() {
                let spacePressed = false;
                let spaceTimeout;
                
                document.addEventListener('keydown', (e) => {
                    // Only allow shortcuts when not in input fields and not typing
                    const isInputField = e.target.matches('input, textarea, button, [contenteditable]');
                    const isTyping = e.target.matches('input:focus, textarea:focus, [contenteditable]:focus');
                    
                    if (isInputField && isTyping) return;
                    
                    // Handle Space with debounce to prevent accidental triggers
                    if (e.code === 'Space') {
                        e.preventDefault();
                        
                        if (!spacePressed) {
                            spacePressed = true;
                            this.running ? this.pause() : this.start();
                            
                            // Clear previous timeout and set new one
                            clearTimeout(spaceTimeout);
                            spaceTimeout = setTimeout(() => {
                                spacePressed = false;
                            }, 500); // 500ms debounce
                        }
                        return;
                    }
                    
                    // Other shortcuts with Ctrl/Cmd modifier for safety
                    if (e.ctrlKey || e.metaKey) {
                        switch(e.code) {
                            case 'KeyR':
                                e.preventDefault();
                                // Silent reset - no confirmation
                                this.stop();
                                break;
                            case 'KeyM':
                                e.preventDefault();
                                this.stopMusic();
                                break;
                            case 'KeyS':
                                e.preventDefault();
                                this.openTimerPopup();
                                break;
                        }
                    }
                });
                
                // Reset space flag on keyup
                document.addEventListener('keyup', (e) => {
                    if (e.code === 'Space') {
                        clearTimeout(spaceTimeout);
                        spaceTimeout = setTimeout(() => {
                            spacePressed = false;
                        }, 200);
                    }
                });
            },

            requestNotificationPermission() {
                // Only request if permission is default and not already requested
                if ('Notification' in window && Notification.permission === 'default' && !this.notificationRequested) {
                    this.notificationRequested = true; // Prevent multiple requests
                    
                    // Show user-friendly permission request
                    this.toast('🔔 Enable notifications to get timer alerts!');
                    
                    Notification.requestPermission().then(permission => {
                        if (permission === 'granted') {
                            this.notificationsEnabled = true;
                            this.toast('✅ Notifications enabled! You\'ll get alerts when timer ends.');
                            
                            // Test notification disabled to prevent popup
                            // setTimeout(() => {
                            //     if ('Notification' in window && Notification.permission === 'granted') {
                            //         new Notification('🎉 Notifications Ready!', {
                            //             body: 'You\'ll get alerts when your timer ends.',
                            //             icon: '/favicon.ico',
                            //             badge: '/favicon.ico',
                            //             silent: false,
                            //             vibrate: [200, 100, 200]
                            //         });
                            //     }
                            // }, 1000);
                        } else if (permission === 'denied') {
                            this.toast('❌ Notifications blocked. Enable in browser settings for alerts.');
                        }
                    });
                } else if ('Notification' in window && Notification.permission === 'granted') {
                    this.notificationsEnabled = true;
                }
            },

            showNotification(title, body, icon = null, sound = 'complete') {
                // Play sound effect
                this.playNotificationSound(sound);
                
                // Show SweetAlert2 Modal as in-app visual alert
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: title,
                        text: body,
                        icon: 'success',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#4a9eff',
                        background: document.documentElement.getAttribute('data-theme') === 'light' ? '#ffffff' : '#1e293b',
                        color: document.documentElement.getAttribute('data-theme') === 'light' ? '#1e293b' : '#e4e8f5',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl'
                        }
                    });
                }

                // Show OS native notification
                if ('Notification' in window && Notification.permission === 'granted') {
                    if ('serviceWorker' in navigator) {
                        navigator.serviceWorker.ready.then(registration => {
                            registration.showNotification(title, {
                                body: body,
                                icon: icon || '/favicon.ico',
                                badge: '/favicon.ico',
                                tag: 'timer-notification',
                                requireInteraction: true,
                                vibrate: [200, 100, 200],
                                data: {
                                    url: window.location.href,
                                    timestamp: Date.now()
                                }
                            });
                        });
                    } else {
                        const notification = new Notification(title, {
                            body: body,
                            icon: icon || '/favicon.ico',
                            badge: '/favicon.ico',
                            tag: 'timer-notification',
                            requireInteraction: true,
                            vibrate: [200, 100, 200]
                        });
                        notification.onclick = function(event) {
                            event.preventDefault();
                            window.focus();
                            notification.close();
                        };
                    }
                }
            },
            
            playNotificationSound(type = 'complete') {
                try {
                    const audio = new Audio();
                    
                    switch(type) {
                        case 'complete':
                            audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT';
                            break;
                        case 'break':
                            audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT';
                            break;
                        case 'achievement':
                            audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT';
                            break;
                        default:
                            audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT';
                    }
                    
                    audio.volume = 0.3;
                    audio.play().catch(e => console.log('Audio play failed:', e));
                } catch (error) {
                    console.log('Sound notification failed:', error);
                }
            },

            requireLogin(featureName = 'fitur ini') {
                this.toast(`Login dulu untuk akses ${featureName}.`);
                setTimeout(() => {
                    window.location.href = '{{ route('login') }}';
                }, 900);
            },

            async loadStats() {
                try {
                    const r = await fetch('/api/stats');
                    if (r.ok) {
                        const d = await r.json();
                        this.sessionsToday = d.sessions_today ?? 0;
                        this.totalFocusToday = d.total_focus_today ?? 0;
                        this.streak = d.streak ?? 0;
                        this.longestStreak = d.longest_streak ?? 0;
                        this.totalSessionsLifetime = d.total_sessions ?? 0;
                        this.streakProgress = d.streak_progress ?? [];
                        if (d.xp_points !== undefined) this.xpPoints = d.xp_points;
                        if (d.level !== undefined) this.level = d.level;
                    }
                } catch(_) {}
            },

            selectMethod(m) {
                if (this.running || this.phase !== 'idle') {
                    this.stop();
                }
                this.method = m;
                if (this.customDurations[m]) {
                    this.customFocusMinutes = this.customDurations[m].f;
                    this.customBreakMinutes = this.customDurations[m].b;
                }
                this.applyMethod();
            },

            applyMethod() {
                this.phase = 'idle'; 
                this.seqIndex = 0; 
                this.elapsedFocus = 0;
                
                const M = {
                    'pomodoro': { f: this.customDurations.pomodoro.f * 60, b: this.customDurations.pomodoro.b * 60 },
                    '5217':     { f: this.customDurations['5217'].f * 60, b: this.customDurations['5217'].b * 60 },
                    'flowtime': { f: 0,       b: 0       },
                    'animedoro':{ f: this.animedoroDuration * 60, b: 20 * 60 },
                    '2min':     { f: 2 * 60,  b: 5 * 60  }, // Tambahkan istirahat 5 menit untuk 2-min rule
                    '2357':     { f: this.seqSteps[0] * 60, b: this.seqBreakSec },
                };
                
                const cfg = M[this.method];
                this.focusDuration = cfg.f;
                this.breakDuration = cfg.b;
                this.displayTime = (this.method === 'flowtime') ? 0 : cfg.f;
                this.ringProgress = (this.method === 'flowtime') ? 0 : 100;
                this.syncPopupState();
            },

            applyCustomDuration() {
                if (!['pomodoro', '5217'].includes(this.method)) {
                    // Silent - no toast
                    return;
                }
                if (this.running) {
                    this.stop();
                }
                this.customFocusMinutes = Math.max(1, Math.min(180, Number(this.customFocusMinutes) || 25));
                this.customBreakMinutes = Math.max(1, Math.min(30, Number(this.customBreakMinutes) || 5));
                this.customDurations[this.method].f = this.customFocusMinutes;
                this.customDurations[this.method].b = this.customBreakMinutes;
                this.applyMethod();
                // Silent - no toast
            },

            setAnimedoroDuration(min) {
                this.animedoroDuration = min;
                if (this.method === 'animedoro') {
                    this.applyMethod();
                }
            },

            expectedEndTime: null,
            expectedStartTime: null,

            saveTimerState() {
                if (!this.running) return;
                let state = {
                    method: this.method,
                    phase: this.phase,
                    focusDuration: this.focusDuration,
                    breakDuration: this.breakDuration,
                    task: this.task,
                    seqIndex: this.seqIndex
                };
                
                if (this.method === 'flowtime') {
                    if (!this.expectedStartTime) this.expectedStartTime = Date.now() - (this.elapsedFocus * 1000);
                    state.startTime = this.expectedStartTime;
                } else if (this.phase === 'focus') {
                    if (!this.expectedEndTime) this.expectedEndTime = Date.now() + (this.displayTime * 1000);
                    state.endTime = this.expectedEndTime;
                } else if (this.phase === 'break') {
                    if (!this.expectedEndTime) this.expectedEndTime = Date.now() + (this.breakTimeLeft * 1000);
                    state.endTime = this.expectedEndTime;
                }
                localStorage.setItem('timer_bg_state', JSON.stringify(state));
            },

            clearTimerState() {
                localStorage.removeItem('timer_bg_state');
                this.expectedEndTime = null;
                this.expectedStartTime = null;
            },

            start() {
                if (this.running) return;
                
                // Fix Autoplay Policy: Inisiasi AudioContext saat user klik tombol Start
                try {
                    if (!window.globalAudioCtx) {
                        const AudioCtx = window.AudioContext || window.webkitAudioContext;
                        if (AudioCtx) window.globalAudioCtx = new AudioCtx();
                    }
                    if (window.globalAudioCtx && window.globalAudioCtx.state === 'suspended') {
                        window.globalAudioCtx.resume();
                    }
                } catch(e) {}
                
                if (this.phase === 'idle') {
                    this.phase = 'focus';
                    if (this.method !== 'flowtime') { 
                        this.displayTime = this.focusDuration; 
                        this.ringProgress = 100; 
                    } else { 
                        this.displayTime = 0; 
                        this.elapsedFocus = 0; 
                    }
                    // Notif kontekstual saat mulai
                    if (this.task.trim()) {
                        this.notify('🎯 Sesi Dimulai', `Fokus: ${this.task}`);
                    }
                }
                
                if (this.method === 'flowtime') {
                    this.expectedStartTime = Date.now() - (this.elapsedFocus * 1000);
                } else if (this.phase === 'focus') {
                    this.expectedEndTime = Date.now() + (this.displayTime * 1000);
                } else if (this.phase === 'break') {
                    this.expectedEndTime = Date.now() + (this.breakTimeLeft * 1000);
                }

                this.running = true;
                this.saveTimerState();
                this.interval = setInterval(() => this.tick(), 1000);
                this.syncPopupState();
            },

            pause() { 
                clearInterval(this.interval); 
                this.interval = null; 
                this.running = false; 
                this.clearTimerState();
                this.syncPopupState();
            },

            stop() {
                this.pause();
                if (this.method === 'flowtime' && this.elapsedFocus > 0) {
                    this.saveSession(Math.round(this.elapsedFocus / 60), this.method);
                }
                this.applyMethod();
                this.syncPopupState();
            },

            tick() { 
                if (this.phase === 'focus') {
                    this.tickFocus(); 
                } else if (this.phase === 'break') {
                    this.tickBreak(); 
                }
                this.syncPopupState();
            },

            tickFocus() {
                if (this.method === 'flowtime') {
                    if (this.expectedStartTime) {
                        this.elapsedFocus = Math.floor((Date.now() - this.expectedStartTime) / 1000);
                    } else {
                        this.elapsedFocus++; 
                    }
                    this.displayTime = this.elapsedFocus;
                    this.ringProgress = Math.min(100, (this.elapsedFocus / (90 * 60)) * 100);
                } else {
                    if (this.expectedEndTime) {
                        this.displayTime = Math.max(0, Math.floor((this.expectedEndTime - Date.now()) / 1000));
                    } else {
                        this.displayTime--; 
                    }

                    if (this.displayTime > 0) {
                        this.ringProgress = (this.displayTime / this.focusDuration) * 100;
                    } else { 
                        this.focusComplete(); 
                    }
                }
            },

            focusComplete() {
                this.pause();
                const focusSec = this.focusDuration;
                this.playAlertSound();

                if (this.method === '2357') {
                    if (this.seqIndex < this.seqSteps.length - 1) {
                        this.saveSession(Math.round(focusSec / 60), this.method);
                        
                        this.notify("✅ Sesi Selesai", `Sesi ${this.seqIndex + 1} selesai. Jeda ${this.seqBreakSec}s.`);
                        
                        this.startBreak(this.seqBreakSec);
                        return;
                    } else {
                        this.notify("🎉 Selesai!", "Rangkaian sesi 2-3-5-7 telah selesai.");
                        this.openCompletionModal(focusSec, 0);
                        return;
                    }
                }

                if (this.method === '2min') {
                    this.notify("⚡ Selesai!", this.task.trim() ? `"${this.task}" selesai dalam 2 menit!` : "Tugas 2 menit selesai.");
                    this.openCompletionModal(focusSec, 0);
                    return;
                }

                const brk = (this.method === 'flowtime') ? this.calcBreak(this.elapsedFocus) : this.breakDuration;
                const notifBody = this.task.trim()
                    ? `"${this.task}" — ${this.formatTime(focusSec)} fokus. Waktunya istirahat!`
                    : `Fokus ${this.formatTime(focusSec)}. Istirahat!`;
                this.notify("⏰ Fokus Selesai!", notifBody);
                this.pendingSessionMinutes = Math.round(focusSec / 60);
                this.pendingSessionType = this.method;
                this.openCompletionModal(focusSec, brk);
            },

            calcBreak(sec) {
                const m = sec / 60;
                return m < 25 ? 5 * 60 : m < 50 ? 8 * 60 : m < 90 ? 12 * 60 : 17 * 60;
            },

            startBreak(sec) {
                this.phase = 'break'; 
                this.breakTimeLeft = sec; 
                this.displayTime = sec; 
                this.ringProgress = 100;
                
                this.expectedEndTime = Date.now() + (sec * 1000);
                
                this.running = true; 
                this.saveTimerState();
                this.interval = setInterval(() => this.tick(), 1000);
            },

            tickBreak() {
                if (this.expectedEndTime) {
                    this.breakTimeLeft = Math.max(0, Math.floor((this.expectedEndTime - Date.now()) / 1000));
                } else {
                    this.breakTimeLeft--; 
                }
                this.displayTime = this.breakTimeLeft;
                
                if (this.breakTimeLeft > 0) {
                    const total = (this.method === '2357' ? this.seqBreakSec : (this.method === 'flowtime' ? this.calcBreak(this.elapsedFocus) : this.breakDuration));
                    this.ringProgress = (this.breakTimeLeft / total) * 100;
                } else { 
                    this.breakComplete(); 
                }
            },

            breakComplete() {
                this.pause();
                this.playAlertSound();
                
                if (this.method === '2357') {
                    this.seqIndex++; 
                    this.focusDuration = this.seqSteps[this.seqIndex] * 60;
                    this.phase = 'focus'; 
                    this.displayTime = this.focusDuration; 
                    this.ringProgress = 100;
                    
                    this.notify("▶️ Sesi Berikutnya", `Mulai sesi ${this.seqSteps[this.seqIndex]}m!`);
                    
                    this.start();
                    return;
                }
                
                this.showBreakModal = true;
                this.notify("🚀 Istirahat Selesai!", "Siap untuk sesi berikutnya?");
            },

            /* ── WEB NOTIFICATION HELPER ── */
            toggleNotifications() {
                this.notificationsEnabled = !this.notificationsEnabled;
                if (this.notificationsEnabled && 'Notification' in window && Notification.permission !== 'granted') {
                    this.requestNotificationPermission();
                } else {
                    this.toast(this.notificationsEnabled ? 'Notifikasi aktif.' : 'Notifikasi dimatikan.');
                }
            },

            testNotification() {
                const body = this.task.trim()
                    ? `Notifikasi berjalan! Fokus kamu: "${this.task}"`
                    : 'Notifikasi berjalan dengan lancar.';
                this.showNotification('Test Berhasil! 🚀', body, null, 'achievement');
            },

            notify(title, body) {
                if (!this.notificationsEnabled || !('Notification' in window) || Notification.permission !== 'granted') return;
                this.showNotification(title, body);
            },

            /* ── COMPLETION MODAL ── */
            openCompletionModal(durationSec, breakSec) {
                this.lastSessionDuration = durationSec;
                this.lastSessionMethod = this.method;
                this.pendingBreakSec = breakSec;
                this.pendingSessionMinutes = Math.max(1, Math.round(durationSec / 60));
                this.pendingSessionType = this.method;
                this.sessionNote = '';
                this.showModal = true;
            },

            markTaskDone(success) {
                if (this.task.trim()) {
                    // Simpan ke riwayat
                    const entry = {
                        text: this.task.trim(),
                        done: success,
                        at: Date.now(),
                        method: this.lastSessionMethod || this.method,
                        duration_min: Math.max(1, Math.round(this.lastSessionDuration / 60)),
                    };
                    this.taskHistory = [entry, ...this.taskHistory].slice(0, 10); // max 10
                    localStorage.setItem('task_history', JSON.stringify(this.taskHistory));

                    // Notif kontekstual
                    if (success) {
                        this.notify('✅ Luar Biasa!', `"${this.task}" berhasil diselesaikan!`);
                        // Silent - no toast
                    } else {
                        this.notify('💪 Terus Semangat!', `Lanjutkan "${this.task}" di sesi berikutnya.`);
                        // Silent - no toast
                    }
                }
                this.flushPendingSession();
                this.showModal = false;
                this.startBreakFromModal();
            },

            flushPendingSession() {
                if (this.pendingSessionMinutes > 0) {
                    this.saveSession(this.pendingSessionMinutes, this.pendingSessionType, this.sessionNote.trim() || null);
                    this.pendingSessionMinutes = 0;
                    this.pendingSessionType = '';
                    this.sessionNote = '';
                }
            },

            startBreakFromModal() {
                if (this.pendingBreakSec > 0) {
                    this.startBreak(this.pendingBreakSec);
                } else {
                    this.applyMethod();
                }
            },

            completeSessionModal() {
                this.showModal = false;
                this.flushPendingSession();
                this.startBreakFromModal();
                this.showNotification('🎯 Focus Session Complete!', 'Great job! Time for a well-deserved break.', null, 'complete');
            },

            snoozeFocus(minutes) {
                this.showModal = false;
                const addedSecs = parseInt(minutes) * 60;
                // Add to duration so it gets saved properly at the end
                this.focusDuration += addedSecs;
                this.displayTime = addedSecs;
                this.phase = 'focus';
                this.start();
            },

            snoozeBreak(minutes) {
                this.showBreakModal = false;
                const addedSecs = parseInt(minutes) * 60;
                this.startBreak(addedSecs);
            },

            /* ── persist & audio & utils ── */
            async saveSession(min, type, sessionNote = null) {
                if (min <= 0) return;
                if (!this.isAuthenticated) {
                    // Silent - no toast
                    return;
                }
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
                    const r = await fetch('/api/sessions', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': csrf 
                        },
                        body: JSON.stringify({
                            duration_minutes: min,
                            type,
                            focus_note: this.task.trim() ? this.task.trim() : null,
                            session_note: sessionNote
                        })
                    });
                    
                    if (r.ok) {
                        const d = await r.json();
                        this.sessionsToday = d.sessions_today; 
                        this.totalFocusToday = d.total_focus_today; 
                        this.streak = d.streak;
                        this.longestStreak = d.longest_streak ?? this.longestStreak;
                        this.totalSessionsLifetime = d.total_sessions ?? this.totalSessionsLifetime;
                        this.streakProgress = d.streak_progress ?? this.streakProgress;
                        if (d.xp_points !== undefined) this.xpPoints = d.xp_points;
                        if (d.level !== undefined) this.level = d.level;
                    } else {
                        const d = await r.json().catch(() => ({}));
                        if (r.status === 401 || d.requires_auth) {
                            // Silent - no toast
                        }
                    }
                } catch(e) {}
            },

            historyMeta(h) {
                const methodName = this.phaseName(h.method);
                const when = new Date(h.at).toLocaleString('id-ID', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' });
                return `${methodName} • ${h.duration_min ?? '-'} min • ${when}`;
            },

            historyTitle(h) {
                return `${h.done ? '✓ Berhasil' : '✗ Belum'} • ${this.historyMeta(h)}`;
            },

            phaseName(method) {
                const map = {
                    'pomodoro': 'Pomodoro',
                    '5217': '52/17',
                    'flowtime': 'Flowtime',
                    'animedoro': 'Animedoro',
                    '2min': '2-Min Rule',
                    '2357': '2-3-5-7',
                };
                return map[method] || method || 'Unknown';
            },

            _getAudio() {
                let a = document.getElementById('bg-audio');
                if (!a) { 
                    a = document.createElement('audio'); 
                    a.id = 'bg-audio'; 
                    a.loop = true; 
                    document.body.appendChild(a); 
                }
                return a;
            },
            
            playMusic(t) {
                const a = this._getAudio();
                if (this.currentMusic === t && !a.paused) return;
                
                this.currentMusic = t; 
                a.src = `/audio/${t}.mp3`; 
                a.volume = parseFloat(this.audioVolume);
                
                a.play().catch(() => {
                    // Silent - no toast
                });
            },
            
            stopMusic() { 
                const a = document.getElementById('bg-audio'); 
                if(a) a.pause(); 
                this.currentMusic = null; 
            },
            
            setVolume(v) { 
                const a = document.getElementById('bg-audio'); 
                if(a) a.volume = parseFloat(v); 
            },
            
            formatTime(sec) { 
                const s = Math.max(0, Math.round(sec));
                const m = Math.floor(s / 60);
                const r = s % 60;
                return `${m}:${r < 10 ? '0' : ''}${r}`;
            },
            
            toast(msg) {
                const el = document.getElementById('toast'); 
                el.textContent = msg; 
                el.classList.add('show');
                clearTimeout(this._toastTimer);
                this._toastTimer = setTimeout(() => el.classList.remove('show'), 3500);
            },

            playAlertSound() {
                try {
                    if (!window.globalAudioCtx) {
                        const AudioCtx = window.AudioContext || window.webkitAudioContext;
                        if (!AudioCtx) return;
                        window.globalAudioCtx = new AudioCtx();
                    }
                    const ctx = window.globalAudioCtx;
                    if (ctx.state === 'suspended') {
                        ctx.resume();
                    }
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, ctx.currentTime);
                    gain.gain.setValueAtTime(0.001, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.07, ctx.currentTime + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.35);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.36);
                } catch (_) {}
            },

            exportDailyRecap() {
                const summary = `Recap Hari Ini\n- Fokus: ${this.formatTime(this.totalFocusToday)}\n- Sesi: ${this.sessionsToday}\n- Streak: ${this.streak} hari\n- XP: ${this.xpPoints}\n- Fokus utama terakhir: ${this.task.trim() || '-'}`;
                if (navigator.clipboard?.writeText) {
                    navigator.clipboard.writeText(summary).then(() => {
                        this.copyTextState = '✅ Tersalin!';
                        setTimeout(() => { this.copyTextState = '📋 Salin Teks'; }, 2000);
                    });
                }
            },

            // Session Notes Editor Functions
            formatNote(command) {
                document.execCommand(command, false, null);
                this.$refs.notesEditor?.focus();
            },

            insertNoteTag() {
                const selection = window.getSelection();
                const range = selection.getRangeAt(0);
                const tagNode = document.createTextNode('#tag');
                range.insertNode(tagNode);
                range.setStartAfter(tagNode);
                range.collapse(true);
                selection.removeAllRanges();
                selection.addRange(range);
                this.updateSessionNote();
            },

            clearNotes() {
                this.sessionNote = '';
                if (this.$refs.notesEditor) {
                    this.$refs.notesEditor.innerHTML = '';
                }
            },

            updateSessionNote() {
                if (this.$refs.notesEditor) {
                    this.sessionNote = this.$refs.notesEditor.innerHTML;
                }
            },

            handleNotesKeydown(event) {
                // Allow Shift+Enter for new lines, prevent Enter from closing modal
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    // Insert line break
                    document.execCommand('insertLineBreak');
                }
            },

            handleNotesPaste(event) {
                event.preventDefault();
                const text = event.clipboardData.getData('text/plain');
                document.execCommand('insertText', false, text);
                this.updateSessionNote();
            },

            getNotesLength() {
                if (!this.$refs.notesEditor) return 0;
                const text = this.$refs.notesEditor.innerText || '';
                return text.length;
            },

            getNotesTags() {
                if (!this.$refs.notesEditor) return [];
                const text = this.$refs.notesEditor.innerText || '';
                const tagMatches = text.match(/#\w+/g) || [];
                return [...new Set(tagMatches)];
            }
        };
    }

    // Chronotype Widget Function
    function chronotypeWidget() {
        return {
            showWidget: false,
            chronotypeCompleted: false,
            age: 0,
            chronotypeLabel: '',
            optimalHours: [],

            async loadChronotypeData() {
                try {
                    const response = await fetch('/api/user-chronotype');
                    const data = await response.json();
                    
                    this.chronotypeCompleted = data.chronotype_completed || false;
                    
                    if (this.chronotypeCompleted) {
                        this.age = data.age;
                        this.chronotypeLabel = this.getChronotypeLabel(data.chronotype);
                        this.optimalHours = await this.getOptimalHours();
                    }
                    
                    this.showWidget = true;
                } catch (error) {
                    console.error('Error loading chronotype data:', error);
                    this.showWidget = true;
                }
            },

            getChronotypeLabel(chronotype) {
                const labels = {
                    'early_bird': 'Early Bird',
                    'night_owl': 'Night Owl',
                    'intermediate': 'Intermediate'
                };
                return labels[chronotype] || 'Unknown';
            },

            getAgeCategoryLabel(age) {
                // Handle NaN or invalid age
                if (!age || isNaN(age) || age === null || age === undefined) {
                    return 'Age not specified';
                }
                
                const ageNum = parseInt(age);
                if (ageNum >= 13 && ageNum <= 15) return 'The Awakening (13-15 years)';
                if (ageNum >= 16 && ageNum <= 18) return 'The Drifter (16-18 years)';
                if (ageNum >= 19 && ageNum <= 21) return 'The Night Owl (19-21 years)';
                if (ageNum >= 22 && ageNum <= 24) return 'The Late Fox (22-24 years)';
                if (ageNum >= 25 && ageNum <= 28) return 'The Shifter (25-28 years)';
                if (ageNum >= 29 && ageNum <= 35) return 'The Prime Wolf (29-35 years)';
                if (ageNum >= 36 && ageNum <= 45) return 'The Morning Lion (36-45 years)';
                if (ageNum >= 46) return 'The Early Lark (46+ years)';
                return 'The Prime Wolf';
            },

            formatTimeRange(start, end) {
                const formatHour = (hour) => {
                    const h = hour % 24;
                    const ampm = h >= 12 ? 'PM' : 'AM';
                    const displayHour = h === 0 ? 12 : h > 12 ? h - 12 : h;
                    return `${displayHour}:00 ${ampm}`;
                };
                
                return `${formatHour(start)} - ${formatHour(end)}`;
            },

            async getOptimalHours() {
                try {
                    const response = await fetch('/api/best-study-times');
                    const times = await response.json();
                    
                    console.log('Best study times response:', times);
                    
                    return times.map(time => ({
                        start: time.hour,
                        end: time.hour + 2, // Assuming 2-hour sessions
                        label: time.label,
                        intensity: time.intensity || 'medium',
                        name: this.getSessionName(time.hour),
                        description: this.getSessionDescription(time.hour)
                    }));
                } catch (error) {
                    console.error('Error loading optimal hours:', error);
                    return [];
                }
            },

            getSessionName(hour) {
                const sessionNames = {
                    5: 'Aurora Scholar',
                    7: 'Golden Hour Learner',
                    9: 'Sharp Mind',
                    11: 'Flow Rider',
                    13: 'Brave Soul',
                    15: 'Second Wave',
                    17: 'Golden Dusk',
                    19: 'Night Scholar',
                    21: 'Midnight Thinker',
                    23: 'Lone Warrior'
                };
                return sessionNames[hour] || 'Study Session';
            },

            getSessionDescription(hour) {
                const descriptions = {
                    5: 'Meditative learning, minimal distractions',
                    7: 'Natural cortisol peak, optimal focus',
                    9: 'Peak analytical thinking and problem solving',
                    11: 'Optimal for deep work and momentum',
                    13: 'Requires extra effort, good for active learning',
                    15: 'Energy rising, great for review and consolidation',
                    17: 'Enhanced memory and memorization',
                    19: 'Quiet environment, ideal for deep reading',
                    21: 'Creativity and associative thinking peak',
                    23: 'High risk, poor memory retention'
                };
                return descriptions[hour] || 'Study time';
            },

            async retakeQuiz() {
                if (confirm('Are you sure you want to retake the chronotype quiz? This will reset your current study time preferences.')) {
                    try {
                        const response = await fetch('/chronotype/reset', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.ok) {
                            window.location.href = '/chronotype';
                        }
                    } catch (error) {
                        console.error('Error resetting chronotype:', error);
                    }
                }
            },

            getSessionIcon(hour) {
                const icons = {
                    5: '🌅',  // Aurora Scholar
                    7: '🌤️',  // Golden Hour Learner
                    9: '🧠',  // Sharp Mind
                    11: '🚀', // Flow Rider
                    13: '💪', // Brave Soul
                    15: '🌊', // Second Wave
                    17: '🌆', // Golden Dusk
                    19: '🌙', // Night Scholar
                    21: '✨', // Midnight Thinker
                    23: '🦉'  // Lone Warrior
                };
                return icons[hour] || '📚';
            }
        };
    }

    </script>
</x-app-layout>