<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable=[
        'transaction',
        'logo',
        'symbol',
        'name',
        'price',
        'amount',
        'money',
        'currency'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter($query, array $filters): void
    {
        if($filters['search'] ?? false) {
            $query->where('transaction', 'like', "%{$filters['search']}%")
                ->orWhere('logo', 'like', "%{$filters['search']}%")
                ->orWhere('symbol', 'like', "%{$filters['search']}%")
                ->orWhere('name', 'like', "%{$filters['search']}%")
                ->orWhere('currency', 'like', "%{$filters['search']}%");
        }
        if($filters['account'] ?? false) {
            $query->where('account_id', $filters['account']);
        }
        if($filters['currency'] ?? false) {
            $query->where('currency', 'like', $filters['currency']);
        }
        if($filters['from'] ?? false) {
            $query->where('created_at', '>', $filters['from']);
        }
        if($filters['to'] ?? false) {
            $query->where('created_at', '<', $filters['to']);
        }
    }
}
