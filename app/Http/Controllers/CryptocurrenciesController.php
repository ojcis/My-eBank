<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeCard;
use App\Models\CryptoCoin;
use App\Models\CryptoTransaction;
use App\Services\CryptocurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CryptocurrenciesController extends Controller
{
    private CryptocurrencyService $cryptocurrencyService;

    public function __construct(CryptocurrencyService $cryptocurrencyService)
    {
        $this->cryptocurrencyService = $cryptocurrencyService;
    }

    public function index(Request $request): View
    {
        $cryptocurrencies=$this->cryptocurrencyService->all($request->search);
        $cryptocurrencyCollection=Collection::make($cryptocurrencies);
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageCryptocurrencies = $cryptocurrencyCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedCryptocurrencies = new LengthAwarePaginator($currentPageCryptocurrencies , count($cryptocurrencyCollection), $perPage);
        return view('cryptocurrencies.index', [
            'cryptocurrencies' => $paginatedCryptocurrencies->setPath(LengthAwarePaginator::resolveCurrentPath()),
            'search' => $request->search
        ]);
    }

    public function show(string $symbol): View
    {
        $accounts=Account::where('user_id', Auth::id())->get();
        return view('cryptocurrencies.coin', [
            'cryptocurrency' => $this->cryptocurrencyService->single($symbol),
            'accounts' => $accounts
        ]);
    }

    public function buy(string $symbol, Request $request): RedirectResponse
    {
        $account=Account::where('id', $request->account)->first();
        $this->isAuthUserAccount($account->user_id);
        $cryptoCurrency=$this->cryptocurrencyService->single($symbol);
        $purchase= new CryptoCoin([
            'logo' => $cryptoCurrency->getLogo(),
            'symbol' => $cryptoCurrency->getSymbol(),
            'name' => $cryptoCurrency->getName(),
            'price' => round($cryptoCurrency->getPrice()*100),
            'amount' => ($request->amount),
            'currency' => $cryptoCurrency->getCurrency()
        ]);
        $request->validate([
            'account' => ['required', 'integer', 'exists:accounts,id'],
            'amount' => ['required', 'numeric', 'min:0.001']
        ]);
        if ($account->currency != $purchase->currency){
            $newPrice=$this->cryptocurrencyService->single($purchase->symbol, $account->currency)->getPrice()*100;
            $purchase->price=$newPrice;
            $purchase->currency=$account->currency;
        }
        if ($account->balance<ceil($purchase->price*$purchase->amount)){
            return Redirect::back()->with('message', 'Not enough money!');
        }
        $purchase->account()->associate($account->id);
        Session::put([
            'account' => $account,
            'purchase' => $purchase,
            'route' => 'cryptocurrency.store',
            'operation' => 'confirm purchase'
        ]);
        return Redirect::route('codeConfirm.show');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'max:8', 'min:8'],
        ]);
        $codeNr=Session::get('codeNr');
        $code=CodeCard::where('user_id', Auth::id())->first()->$codeNr;
        if (! Hash::check($request->code, $code)){
            return Redirect::route('transferMoney.showConfirmationForm')->with('message', 'Wrong code!');
        }
        $purchase=Session::get('purchase');
        $account=Session::get('account');
        Session::forget(['purchase', 'account', 'codeNr', 'route', 'operation']);
        $account->balance-=$purchase->price*($purchase->amount);
        $account->save();
        $purchase->save();
        $this->createTransaction(
            $account,
            null,
            $purchase->price*($purchase->amount*(-1)),
            "Buy ($purchase->amount) $purchase->name"
        );
        $cryptoTransaction=new CryptoTransaction();
        $cryptoTransaction->fill([
            'transaction' => 'Buy',
            'logo' => $purchase->logo,
            'symbol' => $purchase->symbol,
            'name' => $purchase->name,
            'price' => $purchase->price,
            'amount' => $purchase->amount,
            'money' => $purchase->price*$purchase->amount*(-1),
            'currency' => $purchase->currency,
        ]);
        $cryptoTransaction->account()->associate($account->id);
        $cryptoTransaction->user()->associate($account->user_id);
        $cryptoTransaction->save();
        return Redirect("/accounts/$account->id")->with('success', 'Purchase was successful!');
    }

    public function sellForm(CryptoCoin $cryptoCoin): View
    {
        return view('cryptocurrencies.sell', [
            'cryptoCoin' => $cryptoCoin,
            'priceNow' => $this->cryptocurrencyService->single($cryptoCoin->symbol, $cryptoCoin->currency)->getPrice()*100
        ]);
    }

    public function sell(CryptoCoin $cryptoCoin, Request $request): RedirectResponse
    {
        Session::put([
            'cryptoCoin' => $cryptoCoin,
            'amount' => $request->amount,
            'route' => 'cryptocurrencies.update',
            'operation' => "Sell cryptocurrency"
        ]);
        return Redirect::route('codeConfirm.show');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'max:8', 'min:8'],
        ]);
        $codeNr=Session::get('codeNr');
        $code=CodeCard::where('user_id', Auth::id())->first()->$codeNr;
        if (! Hash::check($request->code, $code)){
            return Redirect::route('transferMoney.showConfirmationForm')->with('message', 'Wrong code!');
        }
        $cryptoCoin=Session::get('cryptoCoin');
        $amount=Session::get('amount');
        Session::forget(['cryptoCoin', 'amount', 'route', 'operation']);
        $account=Account::where('id', $cryptoCoin->account_id)->get()->first();
        $priceNow=$this->cryptocurrencyService->single($cryptoCoin->symbol, $account->currency)->getPrice()*100;
        $account->balance+=$amount*$priceNow;
        $account->save();
        $this->createTransaction(
            $account,
            null,
            $amount*$priceNow,
            "Sell ($amount) $cryptoCoin->name"
        );
        $cryptoTransaction=new CryptoTransaction();
        $cryptoTransaction->fill([
            'transaction' => 'Sell',
            'logo' => $cryptoCoin->logo,
            'symbol' => $cryptoCoin->symbol,
            'name' => $cryptoCoin->name,
            'price' => $priceNow,
            'amount' => $amount,
            'money' => $priceNow*$amount,
            'currency' => $account->currency,
        ]);
        $cryptoTransaction->account()->associate($account->id);
        $cryptoTransaction->user()->associate($account->user_id);
        $cryptoTransaction->save();
        $cryptoCoin->amount-=$amount;
        if($cryptoCoin->amount>0){
            $cryptoCoin->save();
        }else{
            $cryptoCoin->delete();
        }
        return Redirect("/accounts/$account->id")->with('success', 'Crypto currency sold successfully!');
    }
}
