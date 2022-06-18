<?php

namespace App\Services;

use App\Constants\Codes;
use App\Constants\OrderSide;
use App\Constants\OrderStatus;
use App\Constants\OrderType;
use App\Models\Order;
use Illuminate\Support\Str;

class FakeBinanceService extends BinanceService
{
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

    public function orderStatus(Order $order)
    {
        // Fakes placed order execution
        $order->update([
            'status' => OrderStatus::FILLED,
            'executed_quantity' => $order->ordered_quantity,

        ]);
    }

    public function cancelOrder(Order $order)
    {
        // Fakes placed order execution
        $order->update([
            'status' => OrderStatus::CANCELED,
        ]);
    }
}
