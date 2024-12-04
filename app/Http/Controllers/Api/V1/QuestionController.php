<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\QuestionType;
use App\Http\Requests\Api\V1\CreateSurveyQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Survey;

class QuestionController
{
    public function __invoke(CreateSurveyQuestionRequest $request, Survey $survey)
    {
        $questions = collect($request->validated('questions'))
            ->map(function ($question) use ($survey) {
                $new = $survey->questions()->create($question);

                if ($new->type === QuestionType::IMAGE) {
                    $new->addMedia($question['image'])
                        ->toMediaCollection('question_images');
                }

                return $new;
            });

        return response()->json(QuestionResource::collection($questions), 201);
    }
}
