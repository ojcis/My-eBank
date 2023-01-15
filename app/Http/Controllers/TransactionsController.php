<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TransactionsController extends Controller
{
    public function index(): View
    {
        $transactions=Transaction::where('user_id',Auth::id())->get();
        return view('transaction.index', [
            'transactions' => $transactions
        ]);
    }

    public function showSendForm(): View
    {
        $accounts=Account::where('user_id', Auth::id())->get();
        return view('transaction.send', [
            'accounts' => $accounts
        ]);
    }

    public function send(Request $request): RedirectResponse
    {
        $senderAccount=Account::find($request->senderAccount);
        $senderAccount->balance-=($request->money*100);
        $senderAccount->save();
        $receiverAccount=Account::where('number',$request->receiverAccount)->first();
        $receiverAccount->balance+=($request->money*100);
        $receiverAccount->save();

        Transaction::create([
            'user_id' => Auth::id(),
            'account_id' => $request->senderAccount,
            'from_to_account_id' => $receiverAccount->id,
            'money' => ($request->money*(-100)),
            'currency' => $senderAccount->currency,
        ]);

        Transaction::create([
            'user_id' => $receiverAccount->user_id,
            'account_id' => $receiverAccount->id,
            'from_to_account_id' => $request->senderAccount,
            'money' => ($request->money*100),
            'currency' => $senderAccount->currency,
        ]);

        return Redirect::route('accounts');
    }
}
