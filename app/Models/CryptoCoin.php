<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CryptoCoin extends Model
{
    use HasFactory;

    protected $fillable=[
        'logo',
        'symbol',
        'name',
        'price',
        'amount',
        'currency'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
