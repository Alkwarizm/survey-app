<?php

namespace App\Actions;

use App\Models\Survey;

class CreateOrUpdateSurvey
{
    public function execute(array $data, ?Survey $survey = null): Survey
    {
        $survey = $survey ?? new Survey();

        $survey->fill($data);

        $survey->save();

        return $survey->fresh();
    }
}
