<?php

namespace App\Repositories;

use App\Models\Cryptocurrency;
use Illuminate\Support\Facades\Http;

class CoinMarketCapApiCryptocurrenciesRepository implements CryptocurrencyRepository
{
    public function getCryptocurrencies(?string $currency='EUR'): array
    {
        $request = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('COINMARKETCAP_API_KEY'),
        ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'start' => '1',
            'limit' => 100,
            'convert' => $currency,
        ]);
        $cryptocurrencies = [];
        foreach ($request->object()->data as $cryptocurrency) {
            $cryptocurrencies[] = $this->createCryptocurrency($cryptocurrency);
        }
        return $cryptocurrencies;
    }

    public function getCryptocurrency(string $symbol, ?string $currency='EUR'): Cryptocurrency
    {
        $request = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('COINMARKETCAP_API_KEY'),
        ])->get('https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest', [
            'symbol' => $symbol,
            'convert' => $currency,
        ]);
        $logo=$this->getLogo($symbol);
        $cryptocurrency=$this->createCryptocurrency($request->object()->data->$symbol[0], $logo, $currency);
        return $cryptocurrency;
    }

    private function getLogo(string $symbol): string
    {
        $request = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('COINMARKETCAP_API_KEY'),
        ])->get("https://pro-api.coinmarketcap.com/v2/cryptocurrency/info", [
            'symbol' => $symbol
        ]);
        return $request->object()->data->$symbol[0]->logo;
    }

    private function createCryptocurrency($cryptocurrency, ?string $logo='null', ?string $currency='EUR'): Cryptocurrency
    {
        return new Cryptocurrency(
            $cryptocurrency->symbol,
            $cryptocurrency->name,
            $cryptocurrency->circulating_supply,
            $cryptocurrency->quote->$currency->price,
            $cryptocurrency->quote->$currency->percent_change_1h,
            $cryptocurrency->quote->$currency->percent_change_24h,
            $cryptocurrency->quote->$currency->percent_change_7d,
            $cryptocurrency->quote->$currency->volume_24h,
            $currency,
            $logo
        );
    }
}
