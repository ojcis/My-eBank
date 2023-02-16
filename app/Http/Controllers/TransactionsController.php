<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Collections\CurrencyCollection;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionsController extends Controller
{
    public function index(Request $request): View
    {
        $transactions=Transaction::where('user_id', Auth::id())
            ->latest()
            ->filter(['search'=>$request->search])
            ->filter(['account'=>$request->account])
            ->filter(['currency' => $request->currency])
            ->filter(['from' => $request->from])
            ->filter(['to' => $request->to])
            ->paginate(15);
        return view('transactions.index', [
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

    public function show(Request $request, Account $account): View
    {
        $transactions=Transaction::where('account_id', $account->id)
            ->latest()
            ->filter(['search'=>$request->search])
            ->filter(['currency' => $request->currency])
            ->filter(['from' => $request->from])
            ->filter(['to' => $request->to])
            ->paginate(15);
        return view('transactions.account', [
            'transactions' => $transactions,
            'currencies' => (New CurrencyCollection())->getCurrencies(),
            'account' => $account,
            'search' => $request->search,
            'filters' => [
                'currency' => $request->currency,
                'from' => $request->from,
                'to' => $request->to
            ]
        ]);
    }
}
