<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Snippet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'code_content',
        'language',
        'description',
        'notes',
        'source_url',
        'tags',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
