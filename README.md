# Survey App

## Description
Develop a simple survey app. This should strictly be an api with publicly available endpoints.
- The survey should have a title 
- Setup the survey by having questions. The questions should have types and the types should be text, single choice, multiple choice and image 
- Complete the survey by providing responses to the questions 
- Submit the survey with results 
- View the survey questions and results

## Requirements
- PHPv8.3
- Laravel 11.3

## Setup
- Clone the repository
- Run `composer install`
- Create a copy of `.env.example` and rename it to `.env`
- Run `php artisan key:generate`
- Run `php artisan migrate`

## Usage
Endpoints
- `POST /api/v1/surveys` - Create a survey (CRUD, has get, put, delete)
```php
{
    "title": "Survey Title",
}
```
- `POST /api/v1/surveys/{survey}/questions` - Create questions for a survey
```php
{
    "questions": [
        [
            "text": "Question Title",
            "type": "text",
            "options": []
        ],
        [
            "text": "Question Title",
            "type": "single_choice",
            "options": ["Option 1", "Option 2"]
        ],
        [
            "text": "Question Title",
            "type": "multiple_choice",
            "options": ["Option 1", "Option 2"]
        ],
        [
            "text": "Question Title",
            "type": "image",
            "image": "image.jpg"
        ]
    ]
}
```

- `POST /api/v1/surveys/{survey}/responses` - Submit responses to a survey
```php
{
    "responses": [
        [
            "question_id": 1,
            "response": "Response"
        ],
        [
            "question_id": 2,
            "response": "Option 1"
        ],
        [
            "question_id": 3,
            "response": ["Option 1", "Option 2"]
        ],
        [
            "question_id": 4,
            "response": "text"
        ]
    ]
}
```
## Tests
- Run `php artisan test`
