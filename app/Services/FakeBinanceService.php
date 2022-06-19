<?php

namespace App\Services;

use App\Constants\Code;
use App\Constants\OrderSide;
use App\Constants\OrderStatus;
use App\Constants\OrderType;
use App\Models\Order;
use Illuminate\Support\Str;

class FakeBinanceService extends BinanceService implements ExchangeServiceInterface
{
    public function buyLimitOrder(Code $code, float $price, float $quantity)
    {
        // Fakes limit order placement
        $order = Order::create([
            'order_id' => random_int(100000, 999999),
            'client_order_id' => Str::random(10),
            'side' => OrderSide::BUY,
            'type' => OrderType::LIMIT,
//            'status' => OrderStatus::PLACED,
            'code' => $code,
            'price' => $price,
            'loss_limit_price' => $price * 0.93,
            'profit_limit_price' => $price * 1.05,
            'ordered_quantity' => $quantity,
//            'executed_quantity' => 0,
        ]);

        return $order->info;
    }

    public function sellLimitOrder(Code $code, float $price, float $quantity)
    {
        // Fakes limit order placement
        $order = Order::create([
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

        return $order->info;
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
