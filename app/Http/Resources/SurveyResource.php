<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Survey */
class SurveyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            'responses' => SurveyResponseResource::collection($this->whenLoaded('responses')),
        ];
    }
}
