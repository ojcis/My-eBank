<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeCard;
use App\Models\Collections\CurrencyCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TransferMoneyController extends Controller
{
    public function index(): View
    {
        $accounts=Account::where('user_id', Auth::id())->get();
        return view('transferMoney.index', [
            'accounts' => $accounts
        ]);
    }

    public function confirmation(Request $request): RedirectResponse
    {
        $senderAccount=Account::where('number',$request->senderAccount)->first();
        $this->isAuthUserAccount($senderAccount->user_id);
        $request->validate([
            'senderAccount' => ['required', 'string', 'exists:accounts,number'],
            'receiverAccount' => ['required', 'string', 'exists:accounts,number', 'different:senderAccount'],
            'money' => ['required', 'numeric', 'min:0.01', 'max:'.$senderAccount->balance/100]
        ]);
        Session::put([
            'senderAccount' => $senderAccount,
            'receiverAccount' => Account::where('number',$request->receiverAccount)->first(),
            'money' => $request->money*100,
            'description' => $request->description,
            'route' => 'transferMoney.transfer',
            'operation' => 'transfer money'
        ]);
        return Redirect::route('codeConfirm.show');
    }

    public function transfer(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'max:8', 'min:8'],
        ]);
        $codeNr=Session::get('codeNr');
        $code=CodeCard::where('user_id', Auth::id())->first()->$codeNr;
        if (! Hash::check($request->code, $code)){
            return Redirect::route('transferMoney.showConfirmationForm')->with('message', 'Wrong code!');
        }
        $senderAccount=Session::get('senderAccount');
        $receiverAccount=Session::get('receiverAccount');
        $senderMoney=Session::get('money');
        $description=Session::get('description');
        Session::forget(['senderAccount', 'receiverAccount', 'money', 'codeNr', 'description', 'route', 'operation']);

        $receiverMoney=$senderMoney;
        if ($senderAccount->currecy != $receiverAccount->currency){
            $receiverMoney=(new CurrencyCollection())->currencyExchange($senderMoney, $senderAccount->currency, $receiverAccount->currency);
        }
        $senderAccount->balance-=$senderMoney;
        $senderAccount->save();
        $receiverAccount->balance+=$receiverMoney;
        $receiverAccount->save();

        $this->createTransaction($senderAccount, $receiverAccount, $senderMoney*(-1), $description);
        $this->createTransaction($receiverAccount, $senderAccount, $receiverMoney, $description);

        return Redirect::route('accounts')->with('success', 'Transaction was successful!');
    }
}
