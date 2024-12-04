<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Question extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'options' => 'array',
        'type' => QuestionType::class,
    ];

    public function imageUrl(): ?string
    {
        return $this->getFirstMedia('question_images')?->getFullUrl();
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
