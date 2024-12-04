<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CreateSurveyResponseRequest;
use App\Http\Resources\SurveyResponseResource;
use App\Models\Survey;

class SurveyResponseController
{
    public function store(CreateSurveyResponseRequest $request, Survey $survey)
    {
        if ($survey->isTakenByIP($request->ip())) {
            return response()->json(['message' => 'Survey already taken'], 409);
        }

        $responses = collect($request->validated('responses'))
            ->map(function ($response) use ($survey) {
                return $survey->responses()->create($response);
            });

        return response()->json(SurveyResponseResource::collection($responses), 201);
    }
}
