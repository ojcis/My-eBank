<?php

namespace App\Models;

class Cryptocurrency
{
    private string $symbol;
    private string $name;
    private int $circulatingSupply;
    private float $price;
    private float $percentChange1h;
    private float $percentChange24h;
    private float $percentChange7d;
    private float $volume24h;
    private string $currency;
    private ?string $logo;


    public function __construct(
        string  $symbol,
        string  $name,
        int     $circulatingSupply,
        float   $price,
        float   $percentChange1h,
        float   $percentChange24h,
        float   $percentChange7d,
        float   $volume24h,
        string  $currency,
        ?string $logo = null

    )
    {
        $this->symbol = $symbol;
        $this->name = $name;
        $this->circulatingSupply = $circulatingSupply;
        $this->price = $price;
        $this->percentChange1h = $percentChange1h;
        $this->percentChange24h = $percentChange24h;
        $this->percentChange7d = $percentChange7d;
        $this->volume24h = $volume24h;
        $this->logo = $logo;
        $this->currency = $currency;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getVolume24h(): float
    {
        return $this->volume24h;
    }

    public function getPercentChange24h(): float
    {
        return $this->percentChange24h;
    }

    public function getPercentChange7d(): float
    {
        return $this->percentChange7d;
    }

    public function getPercentChange1h(): float
    {
        return $this->percentChange1h;
    }

    public function getCirculatingSupply(): int
    {
        return $this->circulatingSupply;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }
}
