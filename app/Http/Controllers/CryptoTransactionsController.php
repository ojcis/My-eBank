<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CryptoTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CryptoTransactionsController extends Controller
{
    public function index(): View
    {
        return view('cryptoTransactions.index', [
            'transactions' => CryptoTransaction::where('user_id', Auth::id())->latest()->paginate(10)
        ]);
    }

    public function show(Account $account): View
    {
        return view('cryptoTransactions.account', [
            'account' => $account,
            'transactions' => $account->cryptoTransactions()->latest()->get()->all()
        ]);
    }
}
