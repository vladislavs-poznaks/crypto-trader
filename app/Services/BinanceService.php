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
        // Real order goes here
    }

    public function sellLimitOrder(Codes $code, float $price, float $quantity)
    {
        // Real order goes here
    }

    public function orderStatus(Order $order)
    {
        return $this->api->orderStatus($order->code->value, $order->order_id);
    }

    public function cancelOrder(Order $order)
    {
        if ($order->status === OrderStatus::CANCELED) {
            return null;
        }

        return $this->api->cancel($order->code->value, $order->order_id);
    }
}
