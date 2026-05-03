<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChronotypeController extends Controller
{
    /**
     * Show chronotype onboarding form
     */
    public function show()
    {
        $user = Auth::user();
        
        // Redirect if already completed
        if ($user->chronotype_completed) {
            return redirect()->route('dashboard');
        }
        
        return view('chronotype-onboarding');
    }

    /**
     * Process chronotype onboarding
     */
    public function store(Request $request)
    {
        try {
            // Log incoming data for debugging
            \Log::info('Chronotype submission data:', $request->all());
            
            $request->validate([
                'wake_up_time' => 'required|date_format:H:i',
                'productivity_peak' => 'required|string|in:aurora,golden_hour,sharp_mind,flow_rider,brave_soul,second_wave,golden_dusk,night_scholar,midnight_thinker,lone_warrior,late_warrior',
                'age' => 'required|integer|min:13|max:100'
            ]);

            $user = Auth::user();
            if (!$user) {
                \Log::error('User not authenticated');
                return response()->json(['error' => 'User not authenticated'], 401);
            }
            
            // Determine chronotype based on wake up time and productivity peak
            $chronotype = $this->determineChronotype($request->wake_up_time, $request->productivity_peak);
            
            // Calculate optimal study hours based on research
            $optimalHours = $this->calculateOptimalStudyHours($chronotype, $request->age, $request->wake_up_time);
            
            // Update user profile
            $user->update([
                'wake_up_time' => $request->wake_up_time,
                'productivity_peak' => $request->productivity_peak,
                'age' => $request->age,
                'chronotype' => $chronotype,
                'optimal_study_hours' => $optimalHours,
                'chronotype_completed' => true
            ]);

            return response()->json(['success' => true, 'chronotype' => $chronotype, 'optimal_hours' => $optimalHours]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', ['errors' => $e->errors(), 'data' => $request->all()]);
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Server error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show chronotype celebration page
     */
    public function celebration()
    {
        $user = Auth::user();
        
        if (!$user->chronotype_completed) {
            return redirect()->route('chronotype.show');
        }
        
        return view('chronotype-celebration');
    }

    /**
     * Reset chronotype data for retaking quiz
     */
    public function reset()
    {
        $user = Auth::user();
        
        // Reset chronotype data
        $user->update([
            'wake_up_time' => null,
            'productivity_peak' => null,
            'age' => null,
            'chronotype' => null,
            'optimal_study_hours' => null,
            'chronotype_completed' => false
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Determine chronotype based on wake up time and productivity peak
     */
    private function determineChronotype($wakeUpTime, $productivityPeak)
    {
        $wakeUpHour = Carbon::parse($wakeUpTime)->hour;
        
        // Map session values to time periods
        $earlySessions = ['aurora', 'golden_hour', 'sharp_mind'];
        $lateSessions = ['night_scholar', 'midnight_thinker', 'lone_warrior', 'late_warrior'];
        
        // Early bird: wakes up before 7 AM and productive in early sessions
        if ($wakeUpHour <= 7 && in_array($productivityPeak, $earlySessions)) {
            return 'early_bird';
        }
        
        // Night owl: wakes up after 9 AM or productive in late sessions
        if ($wakeUpHour >= 9 || in_array($productivityPeak, $lateSessions)) {
            return 'night_owl';
        }
        
        // Intermediate: everything else
        return 'intermediate';
    }

    /**
     * Calculate optimal study hours based on chronotype, age, and research
     */
    private function calculateOptimalStudyHours($chronotype, $age, $wakeUpTime)
    {
        $optimalHours = [];
        
        // Determine age category and study sessions
        $ageCategory = $this->getAgeCategory($age);
        $studySessions = $this->getStudySessionsForAge($ageCategory);
        
        // Filter sessions based on chronotype
        $filteredSessions = $this->filterSessionsByChronotype($studySessions, $chronotype);
        
        // Convert to optimal hours format
        foreach ($filteredSessions as $session) {
            $optimalHours[] = [
                'start' => $session['start'],
                'end' => $session['end'],
                'intensity' => $session['intensity'],
                'name' => $session['name'],
                'description' => $session['description']
            ];
        }

        return $optimalHours;
    }

    /**
     * Get age category with specific name
     */
    private function getAgeCategory($age)
    {
        if ($age >= 13 && $age <= 15) return 'awakening';
        if ($age >= 16 && $age <= 18) return 'drifter';
        if ($age >= 19 && $age <= 21) return 'night_owl_age';
        if ($age >= 22 && $age <= 24) return 'late_fox';
        if ($age >= 25 && $age <= 28) return 'shifter';
        if ($age >= 29 && $age <= 35) return 'prime_wolf';
        if ($age >= 36 && $age <= 45) return 'morning_lion';
        if ($age >= 46) return 'early_lark';
        
        return 'prime_wolf'; // default
    }

    /**
     * Get study sessions based on age category
     */
    private function getStudySessionsForAge($ageCategory)
    {
        // All available study sessions with their descriptions
        $allSessions = [
            ['start' => 5, 'end' => 7, 'intensity' => 'low', 'name' => 'Aurora Scholar', 'description' => 'Meditative learning, minimal distractions'],
            ['start' => 7, 'end' => 9, 'intensity' => 'high', 'name' => 'Golden Hour Learner', 'description' => 'Natural cortisol peak, optimal focus'],
            ['start' => 9, 'end' => 11, 'intensity' => 'high', 'name' => 'Sharp Mind', 'description' => 'Peak analytical thinking and problem solving'],
            ['start' => 11, 'end' => 13, 'intensity' => 'high', 'name' => 'Flow Rider', 'description' => 'Optimal for deep work and momentum'],
            ['start' => 13, 'end' => 15, 'intensity' => 'medium', 'name' => 'Brave Soul', 'description' => 'Requires extra effort, good for active learning'],
            ['start' => 15, 'end' => 17, 'intensity' => 'medium', 'name' => 'Second Wave', 'description' => 'Energy rising, great for review and consolidation'],
            ['start' => 17, 'end' => 19, 'intensity' => 'medium', 'name' => 'Golden Dusk', 'description' => 'Enhanced memory and memorization'],
            ['start' => 19, 'end' => 21, 'intensity' => 'high', 'name' => 'Night Scholar', 'description' => 'Quiet environment, ideal for deep reading'],
            ['start' => 21, 'end' => 23, 'intensity' => 'medium', 'name' => 'Midnight Thinker', 'description' => 'Creativity and associative thinking peak'],
            ['start' => 23, 'end' => 1, 'intensity' => 'low', 'name' => 'Lone Warrior', 'description' => 'High risk, poor memory retention'],
            ['start' => 1, 'end' => 3, 'intensity' => 'low', 'name' => 'Lone Warrior', 'description' => 'Very high risk, avoid if possible']
        ];

        // Age-specific optimal sessions
        $sessions = [
            'awakening' => [
                $allSessions[2], // Sharp Mind (9-11)
                $allSessions[3], // Flow Rider (11-13)
                $allSessions[5], // Second Wave (15-17)
            ],
            'drifter' => [
                $allSessions[2], // Sharp Mind (9-11)
                $allSessions[3], // Flow Rider (11-13)
                $allSessions[5], // Second Wave (15-17)
            ],
            'night_owl_age' => [
                $allSessions[3], // Flow Rider (11-13)
                $allSessions[5], // Second Wave (15-17)
                $allSessions[7], // Night Scholar (19-21)
            ],
            'late_fox' => [
                $allSessions[2], // Sharp Mind (9-11)
                $allSessions[3], // Flow Rider (11-13)
                $allSessions[5], // Second Wave (15-17)
            ],
            'shifter' => [
                $allSessions[1], // Golden Hour Learner (7-9)
                $allSessions[2], // Sharp Mind (9-11)
                $allSessions[5], // Second Wave (15-17)
            ],
            'prime_wolf' => [
                $allSessions[1], // Golden Hour Learner (7-9)
                $allSessions[2], // Sharp Mind (9-11)
                $allSessions[3], // Flow Rider (11-13)
            ],
            'morning_lion' => [
                $allSessions[0], // Aurora Scholar (5-7)
                $allSessions[1], // Golden Hour Learner (7-9)
                $allSessions[2], // Sharp Mind (9-11)
            ],
            'early_lark' => [
                $allSessions[0], // Aurora Scholar (5-7)
                $allSessions[1], // Golden Hour Learner (7-9)
                $allSessions[2], // Sharp Mind (9-11)
            ]
        ];

        return $sessions[$ageCategory] ?? $sessions['prime_wolf'];
    }

    /**
     * Filter sessions based on chronotype
     */
    private function filterSessionsByChronotype($sessions, $chronotype)
    {
        if ($chronotype === 'early_bird') {
            // Early birds prefer morning sessions
            return array_filter($sessions, function($session) {
                return $session['start'] <= 12;
            });
        } elseif ($chronotype === 'night_owl') {
            // Night owls prefer later sessions
            return array_filter($sessions, function($session) {
                return $session['start'] >= 10;
            });
        }
        
        // Intermediate can handle all sessions
        return $sessions;
    }

    /**
     * Get user chronotype data for dashboard widget
     */
    public function getUserChronotype()
    {
        $user = Auth::user();
        
        return response()->json([
            'chronotype_completed' => $user->chronotype_completed,
            'age' => $user->age,
            'chronotype' => $user->chronotype,
            'wake_up_time' => $user->wake_up_time,
            'productivity_peak' => $user->productivity_peak,
            'optimal_study_hours' => $user->optimal_study_hours
        ]);
    }

    /**
     * Get best study times for analytics
     */
    public function getBestStudyTimes()
    {
        $user = Auth::user();
        
        if (!$user->chronotype_completed) {
            // Return default times if chronotype not completed
            return [
                ['hour' => 9, 'label' => '9:00 AM', 'sessions' => 0, 'intensity' => 'low'],
                ['hour' => 14, 'label' => '2:00 PM', 'sessions' => 0, 'intensity' => 'low'],
                ['hour' => 19, 'label' => '7:00 PM', 'sessions' => 0, 'intensity' => 'low'],
                ['hour' => 21, 'label' => '9:00 PM', 'sessions' => 0, 'intensity' => 'low']
            ];
        }

        $bestTimes = [];
        $optimalHours = $user->optimal_study_hours;

        foreach ($optimalHours as $hour) {
            $bestTimes[] = [
                'hour' => $hour['start'],
                'label' => Carbon::createFromTime($hour['start'] % 24)->format('g:i A'),
                'sessions' => $this->getActualSessionsCount($hour['start']),
                'intensity' => $hour['intensity']
            ];
        }

        // Sort by intensity and actual sessions
        usort($bestTimes, function($a, $b) {
            $intensityOrder = ['high' => 3, 'medium' => 2, 'low' => 1];
            if ($intensityOrder[$a['intensity']] !== $intensityOrder[$b['intensity']]) {
                return $intensityOrder[$b['intensity']] - $intensityOrder[$a['intensity']];
            }
            return $b['sessions'] - $a['sessions'];
        });

        return array_slice($bestTimes, 0, 4);
    }

    /**
     * Get actual session count for a specific hour
     */
    private function getActualSessionsCount($hour)
    {
        $user = Auth::user();
        
        return StudySession::where('user_id', $user->id)
            ->completed()
            ->whereRaw('HOUR(created_at) = ?', [$hour])
            ->count();
    }
}
