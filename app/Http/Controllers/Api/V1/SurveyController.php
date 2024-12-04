<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CreateOrUpdateSurvey;
use App\Http\Requests\Api\V1\CreateSurveyRequest;
use App\Http\Requests\Api\V1\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

class SurveyController
{
    public function __construct(protected CreateOrUpdateSurvey $createOrUpdateSurvey) {}

    public function index()
    {
        $includes = array_filter(
            explode(',', request()->query('include', '')),
            fn ($value) => ! is_null($value) && $value !== ''
        );

        $surveys = blank($includes)
            ? Survey::all()
            : Survey::query()->with($includes)->get();

        return response()->json(SurveyResource::collection($surveys));
    }

    public function store(CreateSurveyRequest $request)
    {
        $survey = $this->createOrUpdateSurvey
            ->execute($request->validated());

        return response()->json(new SurveyResource($survey), 201);
    }

    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $survey = $this->createOrUpdateSurvey
            ->execute($request->validated(), $survey);

        return response()->json(new SurveyResource($survey));
    }

    public function destroy(Survey $survey)
    {
        DB::transaction(function () use ($survey) {
            $survey->delete();
        });

        return response()->noContent();
    }
}
