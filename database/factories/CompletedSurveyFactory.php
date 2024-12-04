<?php

namespace Database\Factories;

use App\Models\CompletedSurvey;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CompletedSurveyFactory extends Factory
{
    protected $model = CompletedSurvey::class;

    public function definition(): array
    {
        return [
            'ip_address' => $this->faker->ipv4(),
            'survey_id' => Survey::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
