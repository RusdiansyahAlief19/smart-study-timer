<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mode',
        'preset',
        'focus_note',
        'session_note',
        'study_duration',
        'break_duration',
        'status',
        'session_date',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Format durasi ke menit:detik
     */
    public function getFormattedStudyDurationAttribute(): string
    {
        return gmdate('i:s', $this->study_duration);
    }

    /**
     * Scope untuk sesi yang selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope untuk hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('session_date', today());
    }
}