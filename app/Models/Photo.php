<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'album_id',
        'filename',
    ];

    // Связь с альбомом
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
