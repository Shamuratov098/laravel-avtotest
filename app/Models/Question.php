<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category_id', 'question_text', 'image_url', 'correct_answer', 'explanation', 'order_in_category', 'is_active'])]
class Question extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'bool',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
