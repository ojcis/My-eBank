<?php

namespace App\Models\Collections;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;

class CurrencyCollection
{
    private array $currencies;

    public function __construct()
    {
        $CurrencyXmlStr = Http::get('https://www.bank.lv/vk/ecb.xml')->body();
        $currencies=simplexml_load_string($CurrencyXmlStr)->Currencies->Currency;
        $currencyCollection[]=New Currency('EUR', 1);
        foreach ($currencies as $currency){
            $currencyCollection[]=New Currency($currency->ID,$currency->Rate+0);
        }
        $this->currencies=$currencyCollection;
    }

    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function currencyExchange(int $money, string $from, string $to): int
    {
        $currency=$this->getCurrency($from);
        $newCurrency=$this->getCurrency($to);
        return $currency->exchange($money, $newCurrency);
    }

    private function getCurrency(string $currencyId): Currency
    {
        foreach ($this->currencies as $currency){
            if ($currency->getId()==$currencyId){
                return $currency;
            }
        }
        abort(403);
    }
}
