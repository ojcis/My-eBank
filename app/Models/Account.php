<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'balance',
        'currency'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id');
    }

    function cryptoCoins(): HasMany
    {
        return $this->hasMany(CryptoCoin::class, 'account_id', 'id');
    }

    function cryptoTransactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class, 'account_id', 'id');
    }
}
