<?php

namespace App\Repositories;

use App\Models\Cryptocurrency;

interface CryptocurrencyRepository
{
    public function getCryptocurrencies(?string $currency='EUR'): array;
    public function getCryptocurrency(string $symbol, ?string $currency='EUR'): Cryptocurrency;
}
