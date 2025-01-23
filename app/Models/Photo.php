<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'name', 'album_id']; // Поля, которые можно массово назначать

    // Связь с альбомом
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
