<?php

namespace App\Http\Requests\Api\V1;

class UpdateSurveyRequest extends CreateSurveyRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
