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

    protected function createTransaction(Account $main, ?string $secondaryAccount, int $money, ?string $description=null): void
    {
        Transaction::create([
            'user_id' => $main->user_id,
            'account_id' => $main->id,
            'account' => $main->number,
            'from_to_account' => $secondaryAccount,
            'description' => $description,
            'money' => $money,
            'currency' => $main->currency,
        ]);
    }
}
