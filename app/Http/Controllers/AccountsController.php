<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Collections\CurrencyCollection;
use App\Models\CryptoTransaction;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class AccountsController extends Controller
{
    public function index(): View
    {
        $accounts=Account::where('user_id', Auth::id())->get();
        return view('dashboard',[
            'accounts' => $accounts
        ]);
    }

    public function show(Account $account):View
    {
        $this->isAuthUserAccount($account->user_id);
        return view('account.index',[
            'account' => $account,
            'cryptocurrencies' => $account->cryptoCoins()->get()->all()
        ]);
    }

    public function create(): View
    {
        $currencies=(New CurrencyCollection())->getCurrencies();
        return view('account.create', [
            'currencies' => $currencies
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $account = new Account();
        $account->fill([
            'number' => rand(100000000, 999999999),
            'name' => $request->name,
            'currency' => $request->currency
        ]);
        $account->user()->associate(Auth::user());
        $account->save();
        $account->fill([
            'number' => "MeB-{$account->created_at->format('Ymd')}-{$account->id}-{$account->number}"
        ]);
        $account->save();
        return Redirect::route('accounts')->with('success', 'New account created successfully!');
    }

    public function edit(Account $account): View
    {
        $currencies=(New CurrencyCollection())->getCurrencies();
        return view('account.edit', [
            'account' => $account,
            'currencies' => $currencies
        ]);
    }

    public function update(Account $account, Request $request): RedirectResponse
    {
        $this->isAuthUserAccount($account->user_id);
        $newBalance=(new CurrencyCollection())->currencyExchange($account->balance, $account->currency, $request->currency);
        $account->name = $request->name;
        $account->currency = $request->currency;
        $account->balance = $newBalance;
        $account->save();
        return Redirect("/accounts/$account->id")->with('success', 'Account updated!');
    }

    public function delete(Account $account): RedirectResponse
    {
        if ($account->cryptoCoins()->get()->first()){
            return Redirect::back()->with('message', 'Sell your cryptocurrency before deleting account!');
        }
        if ($account->balance>0){
            return Redirect::back()->with('message', 'Transfer all yor money before deleting account!');
        }
        $this->isAuthUserAccount($account->user_id);
        Session::put([
            'account' => $account,
            'route' => 'account.destroy',
            'operation' => 'delete account'
        ]);
        return Redirect::route('codeConfirm.show');
    }

    public function destroy(): RedirectResponse
    {
        $account=Session::get('account');
        Transaction::where('account_id', $account->id)->delete();
        CryptoTransaction::where('account_id', $account->id)->delete();
        Session::forget(['purchase', 'account', 'codeNr', 'route', 'operation']);
        $account->delete();
        return Redirect::route('accounts')->with('success', 'Account deleted successfully!');
    }
}
