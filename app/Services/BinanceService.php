<?php

namespace App\Services;

use Binance\API;

class BinanceService
{
    private API $api;

    public function __construct()
    {
        $this->api = new API(config('services.binance.key'), config('services.binance.secret'));
    }

    public function getPrice(string $symbol)
    {
        return $this->api->price($symbol);
    }

    public function getPrices()
    {
        return $this->api->prices();
    }

    public function getBalances()
    {
        return $this->api->balances($this->api->prices());
    }

    public function buyLimitOrder()
    {

    }

    public function sellLimitOrder()
    {

    }
}
