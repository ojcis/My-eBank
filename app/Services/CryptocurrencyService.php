<?php

namespace App\Services;

use App\Models\Cryptocurrency;
use App\Repositories\CoinMarketCapApiCryptocurrenciesRepository;
use App\Repositories\CryptocurrencyRepository;

class CryptocurrencyService
{
    private CoinMarketCapApiCryptocurrenciesRepository $cryptocurrencyRepository;

    public function __construct(CoinMarketCapApiCryptocurrenciesRepository $cryptocurrencyRepository)
    {
        $this->cryptocurrencyRepository = $cryptocurrencyRepository;
    }

    public function all(?string $currency='EUR'): array
    {
        return $this->cryptocurrencyRepository->getCryptocurrencies($currency);
    }

    public function single(string $symbol, ?string $currency='EUR'): Cryptocurrency
    {
        return $this->cryptocurrencyRepository->getCryptocurrency($symbol, $currency);
    }
}
