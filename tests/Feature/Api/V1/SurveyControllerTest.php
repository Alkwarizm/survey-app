<?php

use App\Models\Question;
use App\Models\Survey;

it('throws 422 creating a survey with invalid data', function (string $field, array $requestData) {
    $this->postJson('api/v1/surveys', $requestData)
        ->assertStatus(422)
        ->assertInvalid([$field]);
})->with([
    ['title', ['title' => null]],
    ['title', ['title' => '']],
]);

it('creates a survey', function () {
    $this->postJson('api/v1/surveys', ['title' => 'My Survey'])
        ->assertStatus(201)
        ->assertJson(['title' => 'My Survey']);
});

it('throws 422 updating a survey with invalid data', function (string $field, array $requestData) {
    $survey = Survey::factory()->create();

    $this->putJson("api/v1/surveys/{$survey->uuid}", $requestData)
        ->assertStatus(422)
        ->assertInvalid([$field]);
})->with([
    ['title', ['title' => null]],
    ['title', ['title' => '']],
]);

it('updates a survey', function () {
    $survey = Survey::factory()->create();

    $this->putJson("api/v1/surveys/{$survey->uuid}", ['title' => 'My updated Survey'])
        ->assertStatus(200)
        ->assertJson(['title' => 'My updated Survey']);
});

it('deletes a survey', function () {
    $survey = Survey::factory()->create();

    $this->deleteJson("api/v1/surveys/{$survey->uuid}")
        ->assertStatus(204);

    $this->assertDatabaseMissing('surveys', ['uuid' => $survey->uuid]);
});

it('lists surveys', function () {
    Survey::factory()->count(3)->create();

    $this->getJson('api/v1/surveys')
        ->assertStatus(200)
        ->assertJsonCount(3);
});

it('lists surveys with questions', function () {
    $survey = Survey::factory()->create();
    $questions = Question::factory()->count(3)->create(['survey_id' => $survey->id]);

    $this->getJson('api/v1/surveys?include=questions')
        ->assertStatus(200)
        ->assertJson([
            [
                'title' => $survey->title,
                'questions' => [
                    ['text' => $questions[0]->text],
                    ['text' => $questions[1]->text],
                    ['text' => $questions[2]->text],
                ],
            ],
        ]);
});

it('lists surveys with responses', function () {
    $survey = Survey::factory()->create();
    $questions = Question::factory()->count(3)->create(['survey_id' => $survey->id]);
    $responses = [
        ['question_id' => $questions[0]->id, 'text' => 'Option 1'],
        ['question_id' => $questions[1]->id, 'text' => 'Option 2'],
        ['question_id' => $questions[2]->id, 'text' => 'Option 3'],
    ];

    $this->postJson("api/v1/surveys/{$survey->uuid}/responses", ['responses' => $responses]);

    $this->getJson('api/v1/surveys?include=responses')
        ->assertStatus(200)
        ->assertJson([
            [
                'title' => $survey->title,
                'responses' => [
                    ['question' => $questions[0]->text, 'response' => 'Option 1'],
                    ['question' => $questions[1]->text, 'response' => 'Option 2'],
                    ['question' => $questions[2]->text, 'response' => 'Option 3'],
                ],
            ],
        ]);
});
