<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['test_session_id', 'question_id', 'chosen_answer', 'is_correct'])]
class TestResult extends Model
{
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(TestSession::class);
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
