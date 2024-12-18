<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'survey_id' => Survey::factory(),
            'type' => $this->faker->randomElement([
                QuestionType::IMAGE->value,
                QuestionType::TEXT->value,
                QuestionType::SINGLE_CHOICE->value,
                QuestionType::MULTIPLE_CHOICE->value,
            ]),
            'text' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
