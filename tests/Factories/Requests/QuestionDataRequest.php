<?php

namespace Tests\Factories\Requests;

use Illuminate\Http\UploadedFile;

class QuestionDataRequest
{
    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): array
    {
        return $extra + [
            'text' => 'What is your favorite color?',
            'type' => 'text',
            'image' => UploadedFile::fake()->image('image.jpg'),
            'options' => [
                'Red',
                'Green',
                'Blue',
            ],
        ];
    }
}
