<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $correct = (int)$this->resource->correct_count;
        $total = (int)$this->resource->total_questions;
        $wrong = $total - $correct;
        $percent = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'session_id' => $this->resource->id,
            'type' => $this->resource->type,
            'category_id' => $this->resource->category_id,

            'total_questions' => $total,
            'correct_count' => $correct,
            'wrong_count' => $wrong,
            'score_percent' => $percent,
            'passed' => $percent >= 90,

            'started_at' => $this->resource->started_at,
            'completed_at' => $this->resource->completed_at,
            'duration_minutes' => $this->resource->started_at->diffInMinutes($this->resource->completed_at),
        ];
    }
}
