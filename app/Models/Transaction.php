<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'account',
        'from_to_account',
        'user_name',
        'description',
        'money',
        'currency',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function scopeFilter($query, array $filters): void
    {
        if($filters['search'] ?? false) {
            $query->where('description', 'like', "%{$filters['search']}%")
                ->orWhere('currency', 'like', "%{$filters['search']}%")
                ->orWhere('account', 'like', "%{$filters['search']}%")
                ->orWhere('user_name', 'like', "%{$filters['search']}%")
                ->orWhere('from_to_account', 'like', "%{$filters['search']}%");
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
