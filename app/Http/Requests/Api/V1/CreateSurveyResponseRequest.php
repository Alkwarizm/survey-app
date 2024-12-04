<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CreateSurveyResponseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'responses' => ['required', 'array'],
            'responses.*.question_id' => ['required', 'exists:questions,id'],
            'responses.*.text' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
