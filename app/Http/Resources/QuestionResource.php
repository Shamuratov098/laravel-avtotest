<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'question_text' => $this->resource->question_text,
            'image_url' => $this->resource->image_src,

            'answers' => $this->getShuffledAnswers(),
        ];
    }

    private function getShuffledAnswers(): array
    {
        return $this->answers
            ->shuffle()
            ->values()
            ->map(function ($answer, $index) {
                $answer->option_number = $index + 1;

                return new AnswerResource($answer);
            })
            ->toArray(request());
    }
}
