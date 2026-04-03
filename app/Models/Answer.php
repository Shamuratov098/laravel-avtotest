<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['question_id', 'option_number', 'answer_text'])]
class Answer extends Model
{
    protected function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
