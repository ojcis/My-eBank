<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Collections\CurrencyCollection;
use App\Models\CryptoTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CryptoTransactionsController extends Controller
{
    public function index(Request $request): View
    {
        $transactions=CryptoTransaction::where('user_id', Auth::id())
            ->latest()
            ->filter(['search'=>$request->search])
            ->filter(['account'=>$request->account])
            ->filter(['currency' => $request->currency])
            ->filter(['from' => $request->from])
            ->filter(['to' => $request->to])
            ->paginate(10);
        return view('cryptoTransactions.index', [
            'accounts' => Account::where('user_id', Auth::id())->get()->all(),
            'transactions' => $transactions,
            'currencies' => (New CurrencyCollection())->getCurrencies(),
            'search' => $request->search,
            'filters' => [
                'account' => $request->account,
                'currency' => $request->currency,
                'from' => $request->from,
                'to' => $request->to
            ]
        ]);
    }

    public function show(Account $account, Request $request): View
    {
        $transactions=CryptoTransaction::where('account_id', $account->id)
            ->latest()
            ->filter(['search'=>$request->search])
            ->filter(['currency' => $request->currency])
            ->filter(['from' => $request->from])
            ->filter(['to' => $request->to])
            ->paginate(10);
        return view('cryptoTransactions.account', [
            'account' => $account,
            'transactions' => $transactions,
            'currencies' => (New CurrencyCollection())->getCurrencies(),
            'search' => $request->search,
            'filters' => [
                'currency' => $request->currency,
                'from' => $request->from,
                'to' => $request->to
            ]
        ]);
    }
}
