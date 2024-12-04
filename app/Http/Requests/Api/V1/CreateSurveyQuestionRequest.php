<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\QuestionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateSurveyQuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'questions' => ['required', 'array'],
            'questions.*.type' => ['required', 'string', new Enum(QuestionType::class)],
            'questions.*.text' => ['required', 'string', 'min:3', 'max:255'],
            'questions.*.options' => ['required_if:questions.*.type,single_choice,multiple_choice', 'array'],
            'questions.*.options.*' => ['required', 'string', 'min:1', 'max:50'],
            'questions.*.image' => ['required_if:questions.*.type,image', 'image'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
