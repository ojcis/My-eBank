<?php

namespace App\Models;

class Currency
{
    private string $id;
    private float $rate;//

    public function __construct(string $id, float $rate)
    {
        $this->id = $id;
        $this->rate = $rate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function exchange(int $money, Currency $newCurrency): int
    {
        $eur=$money/$this->rate;
        return floor($eur*$newCurrency->getRate());
    }
}
