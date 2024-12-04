<?php

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
