<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionsController extends Controller
{
    public function index(): View
    {
        $transactions=Transaction::where('user_id', Auth::id())->latest()->paginate(15);
        return view('transactions.index', [
            'transactions' => $transactions
        ]);
    }

    public function show(Account $account): View
    {
        $transactions=Transaction::where('account_id', $account->id)->latest()->get();
        return view('transactions.account', [
            'transactions' => $transactions,
            'account' => $account
        ]);
    }
}
