<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function codeCard(): HasOne
    {
        return $this->hasOne(CodeCard::class, 'user_id', 'id');
    }

    function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }

    function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }
}
