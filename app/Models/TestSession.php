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

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected function results(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }
}
