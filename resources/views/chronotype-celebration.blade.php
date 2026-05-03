<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight tracking-wide">
            Your Personalized Study Schedule
        </h2>
    </x-slot>

    <style>
        :root {
            --col-bg: #0d0f14;
            --col-surface: #151820;
            --col-border: #1e2330;
            --col-muted: #3a3f52;
            --col-text: #e4e8f5;
            --col-subtle: #6b7394;
            --accent: #74a0ff;
            --accent-dim: rgba(74, 158, 255, 0.1);
            --success: #4ade80;
            --success-dim: rgba(74, 222, 128, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--col-text);
            background: var(--col-bg);
            overflow-x: hidden;
        }

        .celebration-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
        }

        .celebration-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(900px 420px at 12% -8%, rgba(76, 128, 255, .17), transparent 60%),
                        radial-gradient(760px 420px at 100% 0%, rgba(248, 90, 173, .10), transparent 62%);
            z-index: -1;
        }

        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        .celebration-title {
            font-size: 3rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--accent), var(--success));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 0.8s ease-out;
        }

        .celebration-subtitle {
            font-size: 1.25rem;
            color: var(--col-subtle);
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chronotype-reveal {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 20px;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out 0.4s both;
            position: relative;
            overflow: hidden;
        }

        .chronotype-reveal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--success));
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .chronotype-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .chronotype-label {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .chronotype-description {
            color: var(--col-subtle);
            font-size: 1rem;
        }

        .study-schedule {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .study-session {
            background: var(--col-bg);
            border: 1px solid var(--col-border);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            animation: slideIn 0.6s ease-out;
        }

        .study-session:hover {
            border-color: var(--accent);
            transform: translateX(5px);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .session-icon {
            font-size: 2rem;
            flex-shrink: 0;
        }

        .session-content {
            flex: 1;
        }

        .session-time {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            color: var(--text);
        }

        .session-name {
            color: var(--accent);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .session-description {
            color: var(--col-subtle);
            font-size: 0.875rem;
        }

        .session-intensity {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .intensity-high {
            background: var(--accent-dim);
            color: var(--accent);
        }

        .intensity-medium {
            background: rgba(74, 158, 255, 0.05);
            color: var(--col-subtle);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #5a8fee;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(74, 158, 255, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--col-subtle);
            border: 1px solid var(--col-border);
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .research-note {
            background: var(--success-dim);
            border: 1px solid var(--success);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            color: var(--col-text);
            animation: fadeInUp 0.8s ease-out 0.8s both;
        }

        .research-note strong {
            color: var(--success);
        }

        @media (max-width: 768px) {
            .celebration-title {
                font-size: 2rem;
            }
            
            .chronotype-reveal {
                padding: 2rem;
            }
            
            .study-session {
                flex-direction: column;
                text-align: center;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>

    <div class="celebration-container" x-data="chronotypeCelebration()" x-init="loadChronotypeData()">
        <div class="celebration-bg"></div>
        
        <div class="success-icon">🎉</div>
        <h1 class="celebration-title">Your Perfect Study Schedule</h1>
        <p class="celebration-subtitle">Based on your unique chronotype and age, here are your optimal study times</p>

        <div class="chronotype-reveal" x-show="chronotypeData">
            <div class="chronotype-header">
                <div class="chronotype-label" x-text="chronotypeData.age_category"></div>
                <div class="chronotype-description">Personalized recommendations based on scientific research</div>
            </div>

            <div class="research-note">
                <strong>💡 Research-Based:</strong> These recommendations are based on circadian rhythm studies and age-related productivity patterns from Evans, Kelley & Kelley (2017).
            </div>

            <div class="study-schedule">
                <template x-for="(session, index) in chronotypeData.optimal_hours" :key="index">
                    <div class="study-session" :style="`animation-delay: ${index * 0.1}s`">
                        <div class="session-icon" x-text="getSessionIcon(session.start)"></div>
                        <div class="session-content">
                            <div class="session-time" x-text="formatTimeRange(session.start, session.end)"></div>
                            <div class="session-name" x-text="session.name"></div>
                            <div class="session-description" x-text="session.description"></div>
                        </div>
                        <div class="session-intensity" :class="`intensity-${session.intensity}`" x-text="session.intensity"></div>
                    </div>
                </template>
            </div>
        </div>

        <div class="action-buttons">
            <a href="/dashboard" class="btn-primary">Go to Dashboard</a>
            <a href="/analytics" class="btn-secondary">View Analytics</a>
        </div>
    </div>

    <script>
    function chronotypeCelebration() {
        return {
            chronotypeData: null,

            async loadChronotypeData() {
                try {
                    const response = await fetch('/api/user-chronotype');
                    const data = await response.json();
                    
                    if (data.chronotype_completed) {
                        this.chronotypeData = {
                            age_category: this.getAgeCategoryLabel(data.age),
                            chronotype: data.chronotype,
                            optimal_hours: data.optimal_study_hours || []
                        };
                    } else {
                        // Redirect to chronotype quiz if not completed
                        window.location.href = '/chronotype';
                    }
                } catch (error) {
                    console.error('Error loading chronotype data:', error);
                    window.location.href = '/chronotype';
                }
            },

            getAgeCategoryLabel(age) {
                if (!age || isNaN(age)) return 'Age not specified';
                
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
