<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class CodeCard extends Model
{
    use HasFactory;

    protected $attributes=[];

    public function createCodes(): array
    {
        $codes=[];
        for ($i=1; $i<=env('CODE_COUNT'); $i++){
            if ($i<10) {
                $codes[$i]=(int)(rand(1000000, 9999999) . $i);
            }else{
                $codes[$i]=(int)(rand(100000, 999999) . $i);
            }
            $this->attributes[$i]=Hash::make($codes[$i]);
        }
        return $codes;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
