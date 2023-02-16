<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function isAuthUserAccount(int $accountUserId): void
    {
        if ($accountUserId !== Auth::id()){
            abort(403);
        }
    }

    protected function createTransaction(Account $main, ?Account $secondaryAccount, int $money, ?string $description=null): void
    {
        if ($secondaryAccount) {
            $number=$secondaryAccount->number;
            $name=$secondaryAccount->user->name;
        }else{
            $number=null;
            $name=null;
        }
        Transaction::create([
            'user_id' => $main->user_id,
            'account_id' => $main->id,
            'account' => $main->number,
            'from_to_account' => $number,
            'user_name' => $name,
            'description' => $description,
            'money' => $money,
            'currency' => $main->currency,
        ]);
    }
}
