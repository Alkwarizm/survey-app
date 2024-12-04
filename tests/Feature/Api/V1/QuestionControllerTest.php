<?php


use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\Factories\Requests\QuestionDataRequest;

it('throws 422 creating questions for a survey with invalid data', function (string $field, array $questions) {
    $survey = Survey::factory()->create();

    $this->postJson("api/v1/surveys/{$survey->uuid}/questions", ['questions' => $questions])
        ->assertStatus(422)
        ->assertInvalid([$field]);

})->with([
    ['questions.0.type', 'questions' => [QuestionDataRequest::new()->create(['type' => null])]],
    ['questions.0.type', 'questions' => [QuestionDataRequest::new()->create(['type' => 'invalid'])]],
    ['questions.0.text', 'questions' => [QuestionDataRequest::new()->create(['text' => null])]],
    ['questions.0.text', 'questions' => [QuestionDataRequest::new()->create(['text' => null])]],
    ['questions.0.options', 'questions' => [QuestionDataRequest::new()->create(['type' => 'single_choice', 'options' => null])]],
    ['questions.0.options', 'questions' => [QuestionDataRequest::new()->create(['type' => 'single_choice', 'options' => []])]],
    ['questions.0.options', 'questions' => [QuestionDataRequest::new()->create(['type' => 'multiple_choice', 'options' => null])]],
    ['questions.0.options', 'questions' => [QuestionDataRequest::new()->create(['type' => 'multiple_choice', 'options' => []])]],
    ['questions.0.image', 'questions' => [QuestionDataRequest::new()->create(['type' => 'image', 'image' => null])]],
]);

it('creates questions for a survey', function (string $type, array $options, mixed $image = null) {
    $survey = Survey::factory()->create();

    $attributes = is_null($image) ? [
        'type' => $type,
        'options' => $options,
    ]: [
        'type' => $type,
        'options' => $options,
        'image' => $image,
    ];

    $this->postJson("api/v1/surveys/{$survey->uuid}/questions", ['questions' => [QuestionDataRequest::new()->create($attributes)]])
        ->assertStatus(201)
        ->assertJson([['text' => 'What is your favorite color?']]);

    if ($image) {
        $this->assertDatabaseHas(Media::class, [
            'model_type' => Question::class,
            'collection_name' => 'question_images',
            'file_name' => 'image.jpg',
        ]);
    }
})->with([
    ['type' => 'image', 'options' => [], 'image' => UploadedFile::fake()->image('image.jpg')],
    ['type' => 'single_choice', 'options' => ['Red', 'Blue', 'Green']],
    ['type' => 'multiple_choice', 'options' => ['Option 1', 'Option 2', 'Option 3']],
]);
