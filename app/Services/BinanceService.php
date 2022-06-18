<?php

namespace App\Services;

use App\Constants\Code;
use App\Constants\OrderStatus;
use App\Models\Order;
use App\Models\Rate;
use Binance\API;

class BinanceService implements ExchangeServiceInterface
{
    private API $api;

    public function __construct()
    {
        $this->api = new API(config('services.binance.key'), config('services.binance.secret'));
    }

    public function getPrice(string $symbol)
    {
        $price = $this->api->price($symbol);

        Rate::create([
            'code' => $symbol,
            'rate' => $price,
        ]);

        return $price;
    }

    public function getPrices()
    {
        return $this->api->prices();
    }

    public function getBalances()
    {
        return $this->api->balances($this->api->prices());
    }

    public function candlesticks(Code $code, string $period)
    {
        return $this->api->candlesticks($code->value, $period);
    }

    public function buyLimitOrder(Code $code, float $price, float $quantity)
    {
        // Real order goes here
    }

    public function sellLimitOrder(Code $code, float $price, float $quantity)
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
