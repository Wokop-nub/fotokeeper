<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Filament\Models\Contracts\FilamentUser;
// use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return $this->is_admin;
    // }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function trashId(): int
    {
        return $this->albums()
            ->where('name', 'Корзина')
            ->first()
            ->id;
    }
}
