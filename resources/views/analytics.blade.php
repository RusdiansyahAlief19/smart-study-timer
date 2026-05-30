<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight tracking-wide">
            Buddle Analytics
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
            --accent: #4a9eff;
            --accent-dim: rgba(74, 158, 255, 0.15);
        }

        /* Light mode styles for analytics page */
        [data-theme="light"] {
            --col-bg: #caf0f8;
            --col-surface: #f0f9ff;
            --col-border: #e0e7ff;
            --col-muted: #64748b;
            --col-text: #03045e;
            --col-subtle: #475569;
            --accent: hsl(220, 90%, 45%);
            --accent-dim: hsla(220, 90%, 45%, 0.15);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--col-text);
            background: var(--col-bg);
        }

        .analytics-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--accent);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--col-subtle);
            margin-bottom: 0.25rem;
        }

        .stat-change {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            display: inline-block;
        }

        .stat-change.positive {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .stat-change.negative {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .chart-container {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2.5rem;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .chart-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--col-text);
        }

        .chart-period {
            display: flex;
            gap: 0.5rem;
        }

        .period-btn {
            padding: 0.5rem 1rem;
            border: 1px solid var(--col-border);
            background: transparent;
            color: var(--col-subtle);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .period-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .period-btn.active {
            background: var(--accent-dim);
            border-color: var(--accent);
            color: var(--accent);
        }

        .heatmap-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.25rem;
            margin: 1rem 0;
        }

        .heatmap-day {
            aspect-ratio: 1;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.625rem;
            color: var(--col-text);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .heatmap-day:hover {
            transform: scale(1.1);
        }

        .heatmap-day.level-0 { background: var(--col-bg); }
        .heatmap-day.level-1 { background: rgba(74, 158, 255, 0.2); }
        .heatmap-day.level-2 { background: rgba(74, 158, 255, 0.4); }
        .heatmap-day.level-3 { background: rgba(74, 158, 255, 0.6); }
        .heatmap-day.level-4 { background: rgba(74, 158, 255, 0.8); }
        .heatmap-day.selected { 
            border: 2px solid var(--accent); 
            box-shadow: 0 0 10px rgba(74, 158, 255, 0.5);
        }

        .subject-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
            justify-content: center;
        }

        .subject-tag {
            padding: 0.5rem 1rem;
            background: var(--accent-dim);
            color: var(--accent);
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .subject-tag:hover {
            background: var(--accent);
            color: white;
        }

        .progress-ring {
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
        }

        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>

    <div class="analytics-container" x-data="analyticsApp()" x-init="init()">
        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value" x-text="stats.totalFocusHours">0</div>
                <div class="stat-label">Total Focus Hours</div>
                <div class="stat-change positive" x-show="stats.focusChange > 0">
                    ↑ <span x-text="stats.focusChange"></span>% from last week
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value" x-text="stats.totalSessions">0</div>
                <div class="stat-label">Total Sessions</div>
                <div class="stat-change positive" x-show="stats.sessionsChange > 0">
                    ↑ <span x-text="stats.sessionsChange"></span>% from last week
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value" x-text="stats.currentStreak">0</div>
                <div class="stat-label">Current Streak</div>
                <div class="stat-change positive" x-show="stats.streakChange > 0">
                    🔥 <span x-text="stats.streakChange"></span> day streak!
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value" x-text="stats.avgSessionLength">0</div>
                <div class="stat-label">Avg Session (min)</div>
                <div class="stat-change" :class="stats.sessionLengthChange > 0 ? 'positive' : 'negative'">
                    <span x-text="stats.sessionLengthChange > 0 ? '↑' : '↓'"></span> 
                    <span x-text="Math.abs(stats.sessionLengthChange)"></span>%
                </div>
            </div>
        </div>

        <!-- Activity Heatmap -->
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Activity Heatmap</h3>
                                
                <!-- Date Selector for Month/Year -->
                <div class="date-selector" style="margin-top: 1rem; display: flex; gap: 1rem; align-items: center;">
                    <select x-model="selectedMonth" @change="generateHeatmapData()" class="date-select" style="padding: 0.5rem; background: var(--col-surface); border: 1px solid var(--col-border); color: var(--col-text); border-radius: 6px;">
                        <option value="0">January</option>
                        <option value="1">February</option>
                        <option value="2">March</option>
                        <option value="3">April</option>
                        <option value="4">May</option>
                        <option value="5">June</option>
                        <option value="6">July</option>
                        <option value="7">August</option>
                        <option value="8">September</option>
                        <option value="9">October</option>
                        <option value="10">November</option>
                        <option value="11">December</option>
                    </select>
                    
                    <select x-model="selectedYear" @change="generateHeatmapData()" class="date-select" style="padding: 0.5rem; background: var(--col-surface); border: 1px solid var(--col-border); color: var(--col-text); border-radius: 6px;">
                        <template x-for="year in availableYears">
                            <option :value="year" x-text="year"></option>
                        </template>
                    </select>
                </div>
            </div>
            
            <div class="heatmap-container">
                <template x-for="day in heatmapData" :key="day.date">
                    <div 
                        class="heatmap-day"
                        :class="`level-${day.level} ${selectedDate === day.date ? 'selected' : ''}`"
                        :title="`${day.date}: ${day.sessions} sessions, ${day.minutes} min`"
                        @click="selectDate(day.date)"
                        x-text="day.day"
                        style="cursor: pointer;"
                    ></div>
                </template>
            </div>
            
            <!-- Selected Date Detail -->
            <div x-show="selectedDate" class="selected-date-detail" style="margin-top: 1rem; padding: 1rem; background: var(--col-surface); border-radius: 8px; border: 1px solid var(--accent);">
                <h4 style="margin: 0 0 0.5rem 0; color: var(--accent);">📅 Detail: <span x-text="selectedDate"></span></h4>
                <p style="margin: 0; font-size: 0.875rem; color: var(--col-subtle);">Klik pada tanggal lain untuk melihat detailnya</p>
            </div>
            
            <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1rem;">
                <span style="font-size: 0.875rem; color: var(--col-subtle);">Less</span>
                <div style="display: flex; gap: 0.25rem;">
                    <div class="heatmap-day level-0" style="width: 20px; height: 20px;"></div>
                    <div class="heatmap-day level-1" style="width: 20px; height: 20px;"></div>
                    <div class="heatmap-day level-2" style="width: 20px; height: 20px;"></div>
                    <div class="heatmap-day level-3" style="width: 20px; height: 20px;"></div>
                    <div class="heatmap-day level-4" style="width: 20px; height: 20px;"></div>
                </div>
                <span style="font-size: 0.875rem; color: var(--col-subtle);">More</span>
            </div>
        </div>

        <!-- Subject Distribution -->
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Subject Distribution</h3>
            </div>
            
            <div class="subject-tags">
                <template x-for="subject in subjectData" :key="subject.name">
                    <div 
                        class="subject-tag"
                        :style="`background: ${subject.color}20; color: ${subject.color};`"
                        x-text="`${subject.name} (${subject.sessions} sessions)`"
                    ></div>
                </template>
                
                <!-- Message when no subjects yet -->
                <div x-show="subjectData.length === 0" class="no-subjects-message" style="text-align: center; padding: 2rem; color: var(--col-subtle);">
                    <div style="font-size: 1.1rem; font-weight: 500; margin-bottom: 0.5rem;">You're not learning yet</div>
                    <div style="font-size: 0.9rem;">Start your first study session and add hashtags like #math or #programming to track your subjects!</div>
                </div>
            </div>
        </div>

        <!-- Focus Patterns -->
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Best Study Times</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                <template x-for="time in bestStudyTimes" :key="time.hour">
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: var(--col-bg); border-radius: 8px;">
                        <span x-text="time.label"></span>
                        <span style="color: var(--accent); font-weight: 600;" x-text="`${time.sessions} sessions`"></span>
                    </div>
                </template>
            </div>
        </div>

    </div>

    <script>
    function analyticsApp() {
        return {
            period: 'month',
            stats: {
                totalFocusHours: 0,
                totalSessions: 0,
                currentStreak: 0,
                avgSessionLength: 0,
                focusChange: 0,
                sessionsChange: 0,
                streakChange: 0,
                sessionLengthChange: 0
            },
            heatmapData: [],
            subjectData: [],
            bestStudyTimes: [],
            selectedDate: null,
            selectedMonth: new Date().getMonth(),
            selectedYear: new Date().getFullYear(),
            availableYears: [],

            async init() {
                // Generate available years (current year and 2 years back)
                const currentYear = new Date().getFullYear();
                this.availableYears = [currentYear, currentYear - 1, currentYear - 2];
                
                await this.loadAnalytics();
                this.generateHeatmapData();
            },

            async loadAnalytics() {
                try {
                    const response = await fetch('/api/analytics');
                    const data = await response.json();
                    
                    this.stats = data.stats;
                    this.heatmapData = data.heatmap;
                    this.subjectData = data.subjects;
                    this.bestStudyTimes = data.bestTimes;
                } catch (error) {
                    console.error('Failed to load analytics:', error);
                    this.loadMockData();
                }
            },

            loadMockData() {
                // Mock data for demonstration
                this.stats = {
                    totalFocusHours: 24.5,
                    totalSessions: 48,
                    currentStreak: 7,
                    avgSessionLength: 31,
                    focusChange: 15,
                    sessionsChange: 20,
                    streakChange: 7,
                    sessionLengthChange: 5
                };

                // Generate heatmap data
                this.heatmapData = [];
                const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                for (let i = 0; i < 35; i++) {
                    const date = new Date();
                    date.setDate(date.getDate() - (34 - i));
                    
                    this.heatmapData.push({
                        date: date.toISOString().split('T')[0],
                        day: days[date.getDay()],
                        level: Math.floor(Math.random() * 5),
                        sessions: Math.floor(Math.random() * 8),
                        minutes: Math.floor(Math.random() * 180)
                    });
                }

                // Mock subject data
                this.subjectData = [
                    { name: '#math', sessions: 15, color: '#3b82f6' },
                    { name: '#programming', sessions: 12, color: '#10b981' },
                    { name: '#reading', sessions: 8, color: '#f59e0b' },
                    { name: '#research', sessions: 6, color: '#ef4444' },
                    { name: '#study', sessions: 7, color: '#8b5cf6' }
                ];

                // Mock best study times
                this.bestStudyTimes = [
                    { hour: 9, label: '9:00 AM', sessions: 12 },
                    { hour: 14, label: '2:00 PM', sessions: 8 },
                    { hour: 19, label: '7:00 PM', sessions: 15 },
                    { hour: 21, label: '9:00 PM', sessions: 10 }
                ];
            },

            setPeriod(period) {
                this.period = period;
                this.selectedDate = null; // Reset selected date when changing period
                this.generateHeatmapData();
            },
            
            selectDate(date) {
                this.selectedDate = date;
                // Load data for specific date
                this.loadDateAnalytics(date);
            },
            
            async generateHeatmapData() {
                try {
                    const params = new URLSearchParams();
                    params.append('period', 'month');
                    params.append('month', parseInt(this.selectedMonth) + 1);
                    params.append('year', this.selectedYear);
                    
                    const response = await fetch(`/api/analytics?${params.toString()}`);
                    const data = await response.json();
                    
                    // Use real heatmap data from API
                    this.heatmapData = data.heatmap || [];
                } catch (error) {
                    console.error('Error loading heatmap data:', error);
                    // Fallback to empty array
                    this.heatmapData = [];
                }
            },
            
            loadDateAnalytics(date) {
                // Find data for the selected date from existing heatmap data
                const dateData = this.heatmapData.find(day => day.date === date);
                
                if (dateData) {
                    this.showToast(`Detail untuk ${date}: ${dateData.sessions} sesi, ${dateData.minutes} menit fokus`);
                } else {
                    this.showToast(`Detail untuk ${date}: Tidak ada sesi belajar`);
                }
            },
            
            showToast(message) {
                // Simple toast implementation
                const toast = document.createElement('div');
                toast.textContent = message;
                toast.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: var(--accent);
                    color: white;
                    padding: 12px 20px;
                    border-radius: 8px;
                    z-index: 1000;
                    animation: slideIn 0.3s ease;
                `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        };
    }
    </script>
</x-app-layout>
