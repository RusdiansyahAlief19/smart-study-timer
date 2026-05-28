<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ChronotypeController;
use App\Models\StudySession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TimerController extends Controller
{
    /**
     * Tampilkan halaman dashboard timer.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return view('dashboard');
        }

        // Sesi hari ini untuk tampilan awal (Blade) [cite: 19]
        $todaySessions = StudySession::where('user_id', $user->id)
            ->completed()
            ->today()
            ->count();

        // Total detik belajar hari ini (untuk dikonversi formatTime di JS) [cite: 40, 114]
        $totalSecondsToday = StudySession::where('user_id', $user->id)
            ->completed()
            ->today()
            ->sum('study_duration');

        $todayMinutes = round($totalSecondsToday / 60);

        // Data mingguan tetap sama untuk chart
        $weeklyData = StudySession::where('user_id', $user->id)
            ->completed()
            ->whereBetween('session_date', [now()->subDays(6), now()])
            ->selectRaw('session_date, COUNT(*) as count, SUM(study_duration) as total_seconds')
            ->groupBy('session_date')
            ->orderBy('session_date')
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->session_date)->format('Y-m-d'));

        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[] = [
                'day'     => now()->subDays($i)->format('D'),
                'minutes' => isset($weeklyData[$date]) ? round($weeklyData[$date]->total_seconds / 60) : 0,
            ];
        }

        return view('dashboard', compact('user', 'todaySessions', 'todayMinutes', 'chartData'));
    }

    /**
     * Tampilkan halaman history sesi belajar.
     */
    public function history()
    {
        $user = Auth::user();

        $recentSessions = StudySession::query()
            ->where('user_id', $user->id)
            ->completed()
            ->orderByDesc('session_date')
            ->orderByDesc('id')
            ->paginate(12);

        $summary = [
            'total_sessions' => (int) $user->total_sessions,
            'current_streak' => (int) $user->streak_count,
            'longest_streak' => (int) $user->longest_streak,
            'total_focus_minutes' => (int) round(
                StudySession::query()
                    ->where('user_id', $user->id)
                    ->completed()
                    ->sum('study_duration') / 60
            ),
        ];

        return view('history', compact('recentSessions', 'summary'));
    }

    /**
     * Simpan sesi belajar & kembalikan stats terbaru untuk Alpine.js[cite: 39, 60].
     */
    public function storeSession(Request $request): JsonResponse
    {
        // Sesuaikan validasi dengan payload Alpine.js { duration_minutes, type } 
        $validated = $request->validate([
            'duration_minutes' => 'required|integer|min:1',
            'type'             => 'required|string',
            'focus_note'       => 'nullable|string|max:120',
            'session_note'     => 'nullable|string|max:180',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'requires_auth' => true,
                'message' => 'Masuk untuk menyimpan history dan streak.',
            ], 401);
        }
        $today = today();

        // Simpan ke database [cite: 66]
        StudySession::create([
            'user_id'        => $user->id,
            'mode'           => 'fixed', // default
            'study_duration' => $validated['duration_minutes'] * 60, // simpan dalam detik
            'break_duration' => 0, 
            'status'         => 'completed',
            'session_date'   => $today,
            'preset'         => $validated['type'],
            'focus_note'     => $validated['focus_note'] ?? null,
            'session_note'   => $validated['session_note'] ?? null,
        ]);

        // Logika// Update Streak [cite: 67]
        $newStreak = $user->streak_count;
        $lastDate = $user->last_streak_date ? Carbon::parse($user->last_streak_date) : null;

        if (!$lastDate) {
            $newStreak = 1;
        } elseif ($lastDate->isYesterday()) {
            $newStreak++;
        } elseif (!$lastDate->isToday()) {
            $newStreak = 1;
        }

        $longestStreak = max((int) $user->longest_streak, $newStreak);

        // Calculate XP and Level
        $xpGained = $this->calculateXP($validated['duration_minutes'], $validated['type']);
        $currentXP = (int) $user->xp_points + $xpGained;
        $newLevel = $this->calculateLevel($currentXP);



        $user->update([
            'streak_count'     => $newStreak,
            'last_streak_date' => $today,
            'total_sessions'   => (int) $user->total_sessions + 1,
            'longest_streak'   => $longestStreak,
            'xp_points'        => $currentXP,
            'level'            => $newLevel,
        ]);

        // Kembalikan JSON sesuai kebutuhan dashboard.blade.php [cite: 64]
        return response()->json([
            'sessions_today'    => StudySession::where('user_id', $user->id)->completed()->today()->count(),
            'total_focus_today' => (int) StudySession::where('user_id', $user->id)->completed()->today()->sum('study_duration'),
            'streak'            => $user->streak_count,
            'longest_streak'    => $user->longest_streak,
            'total_sessions'    => $user->total_sessions,
            'streak_progress'   => $this->getStreakProgress($user),
            'xp_points'         => $currentXP,
            'level'             => $newLevel,
            'message'           => $this->getMotivationalMessage($newStreak),
        ]);
    }

    /**
     * Endpoint GET /api/sessions/stats [cite: 61]
     */
    public function stats(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'sessions_today' => 0,
                'total_focus_today' => 0,
                'streak' => 0,
                'longest_streak' => 0,
                'total_sessions' => 0,
                'streak_progress' => [],
                'xp_points' => 0,
                'level' => 1,
                'requires_auth' => true,
            ]);
        }
        
        return response()->json([
            'sessions_today'    => StudySession::where('user_id', $user->id)->completed()->today()->count(),
            'total_focus_today' => (int) StudySession::where('user_id', $user->id)->completed()->today()->sum('study_duration'),
            'streak'            => $user->streak_count,
            'longest_streak'    => (int) $user->longest_streak,
            'total_sessions'    => (int) $user->total_sessions,
            'streak_progress'   => $this->getStreakProgress($user),
            'xp_points'         => (int) $user->xp_points,
            'level'             => (int) $user->level,
        ]);
    }

    private function getStreakProgress(User $user, int $days = 7): array
    {
        $from = now()->subDays($days - 1)->toDateString();
        $to = now()->toDateString();

        $sessionsByDate = StudySession::query()
            ->where('user_id', $user->id)
            ->completed()
            ->whereBetween('session_date', [$from, $to])
            ->selectRaw('session_date, COUNT(*) as sessions, SUM(study_duration) as total_seconds')
            ->groupBy('session_date')
            ->orderBy('session_date')
            ->get()
            ->keyBy(fn ($item) => Carbon::parse($item->session_date)->toDateString());

        return collect(range($days - 1, 0))
            ->map(function (int $i) use ($sessionsByDate) {
                $date = now()->subDays($i);
                $key = $date->toDateString();
                $item = $sessionsByDate->get($key);

                return [
                    'date' => $key,
                    'label' => $date->translatedFormat('D'),
                    'sessions' => $item ? (int) $item->sessions : 0,
                    'focus_minutes' => $item ? (int) round(((int) $item->total_seconds) / 60) : 0,
                    'active' => (bool) $item,
                ];
            })
            ->values()
            ->all();
    }

    private function getMotivationalMessage(int $streak): string
    {
        if ($streak >= 7) return "🚀 Seminggu penuh! Habit luar biasa.";
        if ($streak >= 3) return "✨ Momentum sedang terbentuk!";
        return "💪 Sesi selesai! Terus jaga konsistensimu.";
    }

    /**
     * Tampilkan halaman analytics.
     */
    public function analytics()
    {
        return view('analytics');
    }

    /**
     * API endpoint untuk data analytics.
     */
    public function analyticsData(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'stats' => [
                    'totalFocusHours' => 0,
                    'totalSessions' => 0,
                    'currentStreak' => 0,
                    'avgSessionLength' => 0,
                    'focusChange' => 0,
                    'sessionsChange' => 0,
                    'streakChange' => 0,
                    'sessionLengthChange' => 0
                ],
                'heatmap' => [],
                'subjects' => [],
                'bestTimes' => []
            ]);
        }

        // Calculate stats
        $totalSeconds = StudySession::where('user_id', $user->id)
            ->completed()
            ->sum('study_duration');
        
        $totalSessions = StudySession::where('user_id', $user->id)
            ->completed()
            ->count();

        $totalFocusHours = round($totalSeconds / 3600, 1);
        $avgSessionLength = $totalSessions > 0 ? round($totalSeconds / $totalSessions / 60) : 0;
        $currentStreak = $user->streak_count;

        // Generate heatmap data based on period
        $period = $request->get('period', 'month');
        $heatmapData = [];

        // Always use month logic
                // Show specific month and year
                $month = $request->get('month', now()->month);
                $year = $request->get('year', now()->year);
                
                $startDate = Carbon::create($year, $month, 1);
                $endDate = $startDate->copy()->endOfMonth();
                
                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    $sessions = StudySession::where('user_id', $user->id)
                        ->where('session_date', $currentDate->toDateString())
                        ->completed()
                        ->count();
                    
                    $minutes = StudySession::where('user_id', $user->id)
                        ->where('session_date', $currentDate->toDateString())
                        ->completed()
                        ->sum('study_duration') / 60;

                    $level = 0;
                    if ($sessions >= 1) $level = 1;
                    if ($sessions >= 3) $level = 2;
                    if ($sessions >= 5) $level = 3;
                    if ($sessions >= 7) $level = 4;

                    $heatmapData[] = [
                        'date' => $currentDate->toDateString(),
                        'day' => $currentDate->format('D'),
                        'level' => $level,
                        'sessions' => $sessions,
                        'minutes' => round($minutes)
                    ];
                    $currentDate->addDay();
                }

        // If no data found, ensure we have month data
        if (empty($heatmapData)) {
            $month = $request->get('month', now()->month);
            $year = $request->get('year', now()->year);
            
            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            
            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                $sessions = StudySession::where('user_id', $user->id)
                    ->where('session_date', $currentDate->toDateString())
                    ->completed()
                    ->count();
                
                $minutes = StudySession::where('user_id', $user->id)
                    ->where('session_date', $currentDate->toDateString())
                    ->completed()
                    ->sum('study_duration') / 60;

                $level = 0;
                if ($sessions >= 1) $level = 1;
                if ($sessions >= 3) $level = 2;
                if ($sessions >= 5) $level = 3;
                if ($sessions >= 7) $level = 4;

                $heatmapData[] = [
                    'date' => $currentDate->toDateString(),
                    'day' => $currentDate->format('D'),
                    'level' => $level,
                    'sessions' => $sessions,
                    'minutes' => round($minutes)
                ];
                $currentDate->addDay();
            }
        }

        // Extract subjects from session notes
        $subjectData = [];
        $sessions = StudySession::where('user_id', $user->id)
            ->completed()
            ->whereNotNull('session_note')
            ->where('session_note', '!=', '')
            ->get();

        if ($sessions->isEmpty()) {
            // No learning sessions yet
            $subjectData = [];
        } else {
            // Extract hashtags from session notes
            $subjectCounts = [];
            foreach ($sessions as $session) {
                preg_match_all('/#\w+/', $session->session_note, $matches);
                foreach ($matches[0] as $subject) {
                    $subject = strtolower($subject);
                    if (!isset($subjectCounts[$subject])) {
                        $subjectCounts[$subject] = 0;
                    }
                    $subjectCounts[$subject]++;
                }
            }

            // Sort by session count and take top subjects
            arsort($subjectCounts);
            $subjectCounts = array_slice($subjectCounts, 0, 10, true);

            // Assign colors to subjects
            $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#84cc16', '#f97316', '#ec4899', '#6366f1'];
            $colorIndex = 0;

            foreach ($subjectCounts as $subject => $count) {
                $subjectData[] = [
                    'name' => $subject,
                    'sessions' => $count,
                    'color' => $colors[$colorIndex % count($colors)]
                ];
                $colorIndex++;
            }
        }

        // Get best study times from chronotype data
        $chronotypeController = new ChronotypeController();
        $bestTimes = $chronotypeController->getBestStudyTimes();

        return response()->json([
            'stats' => [
                'totalFocusHours' => $totalFocusHours,
                'totalSessions' => $totalSessions,
                'currentStreak' => $currentStreak,
                'avgSessionLength' => $avgSessionLength,
                'focusChange' => 15, // Mock data
                'sessionsChange' => 20, // Mock data
                'streakChange' => $currentStreak,
                'sessionLengthChange' => 5 // Mock data
            ],
            'heatmap' => $heatmapData,
            'subjects' => $subjectData,
            'bestTimes' => $bestTimes
        ]);
    }

    /**
     * Calculate XP based on session duration and method.
     */
    private function calculateXP(int $minutes, string $method): int
    {
        // Berdasarkan permintaan, 1 menit = 2 XP untuk SEMUA metode
        return $minutes * 2;
    }

    /**
     * Calculate level based on XP.
     */
    private function calculateLevel(int $xp): int
    {
        // Level formula: 100 XP * level^1.5
        $level = 1;
        while ($this->xpForLevel($level + 1) <= $xp) {
            $level++;
        }
        return $level;
    }

    /**
     * XP required for a specific level.
     */
    private function xpForLevel(int $level): int
    {
        return (int) round(100 * pow($level, 1.5));
    }


    /**
     * Get smart recommendations for the user.
     */
    public function getRecommendations(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'recommendations' => [
                    [
                        'type' => 'method',
                        'title' => '🍅 Try Pomodoro',
                        'description' => 'Perfect for beginners! 25 minutes focus, 5 minutes break.',
                        'action' => 'pomodoro'
                    ]
                ]
            ]);
        }

        $recommendations = [];
        $stats = $this->getUserStats($user);

        // Method recommendations based on performance
        if ($stats['avg_session_length'] < 20) {
            $recommendations[] = [
                'type' => 'method',
                'title' => '⚡ Try 2-Min Rule',
                'description' => 'Build momentum with quick 2-minute sessions to overcome procrastination.',
                'action' => '2min'
            ];
        } elseif ($stats['avg_session_length'] > 45) {
            $recommendations[] = [
                'type' => 'method',
                'title' => '🌊 Try Flowtime',
                'description' => 'Your sessions are long! Flowtime lets you work until you naturally need a break.',
                'action' => 'flowtime'
            ];
        } elseif ($stats['completion_rate'] < 0.7) {
            $recommendations[] = [
                'type' => 'method',
                'title' => '🍅 Try Pomodoro',
                'description' => 'Struggling to complete sessions? Pomodoro provides structure with regular breaks.',
                'action' => 'pomodoro'
            ];
        }

        // Time-based recommendations
        $currentHour = now()->hour;
        if ($currentHour >= 22 || $currentHour <= 6) {
            $recommendations[] = [
                'type' => 'timing',
                'title' => '🌙 Late Night Study?',
                'description' => 'Consider shorter sessions. Your brain needs rest for optimal learning.',
                'action' => 'short_session'
            ];
        } elseif ($currentHour >= 14 && $currentHour <= 16) {
            $recommendations[] = [
                'type' => 'timing',
                'title' => '🌞 Afternoon Slump?',
                'description' => 'Perfect time for 52/17 method! Longer focus to power through the afternoon.',
                'action' => '5217'
            ];
        }

        // Streak-based recommendations
        if ($stats['current_streak'] === 0) {
            $recommendations[] = [
                'type' => 'motivation',
                'title' => '🎯 Start Your Streak!',
                'description' => 'Just one 25-minute session today to begin your journey to consistency.',
                'action' => 'start_streak'
            ];
        } elseif ($stats['current_streak'] >= 7) {
            $recommendations[] = [
                'type' => 'motivation',
                'title' => '🔥 Week Warrior!',
                'description' => 'Amazing streak! Try a challenging method like 2-3-5-7 to test your limits.',
                'action' => '2357'
            ];
        }

        // Subject balance recommendations
        if ($stats['subject_diversity'] < 3) {
            $recommendations[] = [
                'type' => 'variety',
                'title' => '📚 Mix It Up!',
                'description' => 'Try studying different subjects. Variety improves retention and prevents burnout.',
                'action' => 'new_subject'
            ];
        }

        // Energy management
        if ($stats['sessions_today'] >= 5) {
            $recommendations[] = [
                'type' => 'rest',
                'title' => '💤 Time to Rest',
                'description' => 'Great productivity today! Your brain needs consolidation time. Take a longer break.',
                'action' => 'rest'
            ];
        }

        return response()->json([
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Tampilkan halaman credits tim.
     */
    public function credits()
    {
        return view('credits');
    }

    /**
     * Get user statistics for recommendations.
     */
    private function getUserStats($user): array
    {
        $totalSessions = StudySession::where('user_id', $user->id)
            ->completed()
            ->count();

        $totalSeconds = StudySession::where('user_id', $user->id)
            ->completed()
            ->sum('study_duration');

        $avgSessionLength = $totalSessions > 0 ? $totalSeconds / $totalSessions / 60 : 0;
        
        // Calculate completion rate (sessions started vs completed)
        $completionRate = 0.85; // Mock data - would need session start tracking

        // Subject diversity (count of different tags/subjects)
        $subjectDiversity = 3; // Mock data - would parse session notes

        return [
            'total_sessions' => $totalSessions,
            'avg_session_length' => $avgSessionLength,
            'completion_rate' => $completionRate,
            'subject_diversity' => $subjectDiversity,
            'current_streak' => $user->streak_count,
            'sessions_today' => StudySession::where('user_id', $user->id)
                ->where('session_date', today())
                ->count()
        ];
    }
}