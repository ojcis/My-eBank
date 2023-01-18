<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Collections\CurrencyCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
            'account' => $account
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
        return Redirect::route('accounts');
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
        return back();
    }
}
