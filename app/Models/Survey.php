<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Survey extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function isTakenByIP(?string $ip): bool
    {
        return $this->completedSurveys()->where('ip_address', $ip)->exists();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function responses(): HasManyThrough
    {
        return $this->hasManyThrough(SurveyResponse::class, Question::class);
    }

    public function completedSurveys(): HasMany
    {
        return $this->hasMany(CompletedSurvey::class);
    }
}
