<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\Collections\CurrencyCollection;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

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
            'route' => 'transferMoney.transfer'
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
        Session::forget(['senderAccount', 'receiverAccount', 'money', 'codeNr', 'route']);

        $receiverMoney=$senderMoney;
        if ($senderAccount->currecy != $receiverAccount->currency){
            $receiverMoney=(new CurrencyCollection())->currencyExchange($senderMoney, $senderAccount->currency, $receiverAccount->currency);
        }
        $senderAccount->balance-=$senderMoney;
        $senderAccount->save();
        $receiverAccount->balance+=$receiverMoney;
        $receiverAccount->save();

        $this->createTransaction($senderAccount, $receiverAccount, $senderMoney*(-1));
        $this->createTransaction($receiverAccount, $senderAccount, $receiverMoney);

        return Redirect::route('accounts')->with('message', 'Transaction was successful!');
    }

    private function createTransaction(Account $main, Account $secondary, int $money): void
    {
        Transaction::create([
            'user_id' => $main->user_id,
            'account_id' => $main->id,
            'account' => $main->number,
            'from_to_account' => $secondary->number,
            'money' => $money,
            'currency' => $main->currency,
        ]);
    }
}
