<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timer Popup</title>
    <style>
        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: #0d0f14;
            color: #e4e8f5;
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .box {
            width: min(92vw, 330px);
            background: rgba(20, 24, 35, .95);
            border: 1px solid #293049;
            border-radius: 16px;
            padding: 16px;
            text-align: center;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .45);
        }
        .phase {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: #8ca1de;
        }
        .time {
            font-size: 46px;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 8px 0 4px;
            color: #f4f8ff;
        }
        .task {
            font-size: 12px;
            color: #9aa4c5;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="phase" id="phase">Waiting</div>
        <div class="time" id="time">25:00</div>
        <div class="task" id="task">No active task</div>
    </div>

    <script>
        function render() {
            const raw = localStorage.getItem('timer_popup_state');
            if (!raw) return;
            try {
                const state = JSON.parse(raw);
                document.getElementById('phase').textContent = state.phaseLabel || 'Timer';
                document.getElementById('time').textContent = state.timeText || '0:00';
                document.getElementById('task').textContent = state.taskText || 'No active task';
                document.title = `${state.timeText || '0:00'}`;
            } catch (_) {}
        }

        render();
        window.addEventListener('storage', (e) => {
            if (e.key === 'timer_popup_state') render();
        });
        setInterval(render, 1000);
    </script>
</body>
</html>
