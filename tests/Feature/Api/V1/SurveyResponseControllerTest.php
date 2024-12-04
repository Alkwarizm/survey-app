<?php


use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Survey;

it('saves responses for a survey', function () {
    $survey = Survey::factory()->create();
    $questions = Question::factory()->count(3)->create([
        'survey_id' => $survey->id,
        'type' => QuestionType::SINGLE_CHOICE,
    ]);

    $response = $this->postJson("api/v1/surveys/{$survey->uuid}/responses", [
        'responses' => [
            [
                'question_id' => $questions[0]->id,
                'text' => 'Option 1',
            ],
            [
                'question_id' => $questions[1]->id,
                'text' => 'Option 2',
            ],
            [
                'question_id' => $questions[2]->id,
                'text' => 'Option 3',
            ],
        ],
    ]);

    $response->assertCreated();
    $response->assertJson([
        [
            'question' => $questions[0]->text,
            'response' => 'Option 1',
        ],
        [
            'question' => $questions[1]->text,
            'response' => 'Option 2',
        ],
        [
            'question' => $questions[2]->text,
            'response' => 'Option 3',
        ],
    ]);
    $this->assertDatabaseHas('survey_responses', [
        'question_id' => $questions[0]->id,
        'text' => 'Option 1',
    ]);
    $this->assertDatabaseHas('survey_responses', [
        'question_id' => $questions[1]->id,
        'text' => 'Option 2',
    ]);
    $this->assertDatabaseHas('survey_responses', [
        'question_id' => $questions[2]->id,
        'text' => 'Option 3',
    ]);
});
