<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
