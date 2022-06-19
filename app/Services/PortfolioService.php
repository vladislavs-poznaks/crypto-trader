<?php

namespace App\Services;

use App\Constants\Symbol;
use App\Models\Asset;

class PortfolioService
{
    private ExchangeServiceInterface $exchange;

    public function __construct()
    {
        $this->exchange = app(ExchangeServiceInterface::class);
    }

    public function isPositionFull(Symbol $symbol): bool
    {
        $asset = Asset::query()
            ->where('symbol', $symbol)
            ->first();

        $position = $asset->marketValueIn(Symbol::BUSD) / $this->value(Symbol::BUSD);

        return $position >= 0.20;
    }

    public function value(Symbol $symbol): float
    {
        $assets = Asset::all();

        return $assets->sum->marketValueIn($symbol);
    }
}
