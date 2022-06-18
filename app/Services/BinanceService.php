<?php

namespace App\Services;

use App\Constants\Codes;
use App\Constants\OrderSide;
use App\Constants\OrderStatus;
use App\Constants\OrderType;
use App\Models\Order;
use Binance\API;
use Illuminate\Support\Str;

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

    public function candlesticks(Codes $code, string $period)
    {
        return $this->api->candlesticks($code->value, $period);
    }

    public function buyLimitOrder(Codes $code, float $price, float $quantity)
    {
        // Fakes limit order placement
        Order::create([
            'order_id' => random_int(100000, 999999),
            'client_order_id' => Str::random(10),
            'side' => OrderSide::BUY,
            'type' => OrderType::LIMIT,
//            'status' => OrderStatus::PLACED,
            'code' => $code,
            'price' => $price,
            'ordered_quantity' => $quantity,
//            'executed_quantity' => 0,
        ]);
    }

    public function sellLimitOrder(Codes $code, float $price, float $quantity)
    {
        // Fakes limit order placement
        Order::create([
            'order_id' => random_int(100000, 999999),
            'client_order_id' => Str::random(10),
            'side' => OrderSide::SELL,
            'type' => OrderType::LIMIT,
//            'status' => OrderStatus::PLACED,
            'code' => $code,
            'price' => $price,
            'ordered_quantity' => $quantity,
//            'executed_quantity' => 0,
        ]);
    }
}
