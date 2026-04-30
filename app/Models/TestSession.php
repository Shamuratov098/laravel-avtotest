<?php

namespace App\Models;

use App\TestSessionStatus;
use App\TestSessionType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'category_id', 'type', 'status', 'total_questions', 'correct_count', 'started_at', 'completed_at'])]
class TestSession extends Model
{
    protected $casts = [
        'type' => TestSessionType::class,
        'status' => TestSessionStatus::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_questions' => 'integer',
        'correct_count' => 'integer',
    ];

    protected $attributes = [
        'status' => 'in_progress',
        'total_questions' => 10,
        'correct_count' => 0,
    ];

    public function scopeCompleted($query)
    {
        return $query->where('status', TestSessionStatus::COMPLETED);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', TestSessionStatus::IN_PROGRESS);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function formattedDuration(): ?string
    {
        if ($this->status !== TestSessionStatus::COMPLETED || ! $this->completed_at) {
            return null;
        }

        $seconds = (int) $this->started_at->diffInSeconds($this->completed_at);

        if ($seconds < 60) {
            return "{$seconds} sek";
        }

        if ($seconds < 3600) {
            $minutes = intdiv($seconds, 60);
            $remaining = $seconds % 60;
            return $remaining > 0 ? "{$minutes} daq {$remaining} sek" : "{$minutes} daq";
        }

        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        return $minutes > 0 ? "{$hours} soat {$minutes} daq" : "{$hours} soat";
    }
}
