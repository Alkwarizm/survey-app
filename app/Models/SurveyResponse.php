<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
