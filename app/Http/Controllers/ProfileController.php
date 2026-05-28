<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        $level = (int) $user->level;
        $currentXP = (int) $user->xp_points;
        
        $currentLevelBaseXP = $level <= 1 ? 0 : (int) round(100 * pow($level, 1.5));
        $nextLevelBaseXP = (int) round(100 * pow($level + 1, 1.5));
        
        $xpRequired = $nextLevelBaseXP - $currentLevelBaseXP;
        $xpEarnedInLevel = max(0, $currentXP - $currentLevelBaseXP);
        $xpProgress = $xpRequired > 0 ? min(100, round(($xpEarnedInLevel / $xpRequired) * 100)) : 100;
        
        $levelTitle = 'Novice Scholar 🌱';
        if ($level >= 50) $levelTitle = 'Grandmaster of Focus 👑';
        elseif ($level >= 35) $levelTitle = 'Flow State Guru 🌊';
        elseif ($level >= 20) $levelTitle = 'Time Master ⏳';
        elseif ($level >= 10) $levelTitle = 'Productivity Adept ⚡';
        elseif ($level >= 5) $levelTitle = 'Focused Learner 📖';

        return view('profile.edit', [
            'user' => $user,
            'currentXP' => $currentXP,
            'currentLevelBaseXP' => $currentLevelBaseXP,
            'nextLevelBaseXP' => $nextLevelBaseXP,
            'xpProgress' => $xpProgress,
            'levelTitle' => $levelTitle,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
