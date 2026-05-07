<?php
use App\Http\Controllers\TimerController;
use App\Http\Controllers\ChronotypeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [TimerController::class, 'index'])->name('dashboard');
Route::view('/timer-popup', 'timer-popup')->name('timer.popup');
Route::post('/api/sessions', [TimerController::class, 'storeSession'])->name('timer.store');
Route::get('/api/stats', [TimerController::class, 'stats'])->name('timer.stats');
Route::get('/analytics', [TimerController::class, 'analytics'])->name('analytics');
Route::get('/api/analytics', [TimerController::class, 'analyticsData'])->name('analytics.data');
Route::get('/credits', [TimerController::class, 'credits'])->name('credits');
Route::get('/api/recommendations', [TimerController::class, 'getRecommendations'])->name('recommendations');
Route::get('/chronotype', [ChronotypeController::class, 'show'])->name('chronotype.show');
Route::post('/chronotype', [ChronotypeController::class, 'store'])->name('chronotype.store');
Route::get('/chronotype/celebration', [ChronotypeController::class, 'celebration'])->name('chronotype.celebration');
Route::post('/chronotype/reset', [ChronotypeController::class, 'reset'])->name('chronotype.reset');
Route::get('/api/user-chronotype', [ChronotypeController::class, 'getUserChronotype'])->name('chronotype.user-data');
Route::get('/api/best-study-times', [ChronotypeController::class, 'getBestStudyTimes'])->name('chronotype.best-times');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/history', [TimerController::class, 'history'])->name('history');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
