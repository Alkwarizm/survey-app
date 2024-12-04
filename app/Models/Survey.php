<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
