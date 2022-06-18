<?php

namespace App\Services;

use App\Constants\Code;
use Carbon\Carbon;

class BotService implements BotServiceInterface
{
    private PredictionServiceInterface $service;
    private ExchangeServiceInterface $exchange;

    private Code $code;
    private ?float $price;
    private ?Carbon $datetime;

    public function __construct(Code $code, ?float $price = null, ?Carbon $datetime = null, ?PredictionService $service = null)
    {
        $this->exchange = app(ExchangeServiceInterface::class);

        $this->code = $code;
        $this->price = $price ?? $this->exchange->getPrice($this->code);
        $this->datetime = $datetime ?? now();

        $this->service = $service ?? app(PredictionServiceInterface::class, [
            'code' => $this->code,
            'price' => $this->price,
            'datetime' => $this->datetime
        ]);
    }

    public function process(): string
    {
        return $this->positionFull() ? $this->sell() : $this->buy();
    }

    protected function buy(): string
    {
        if ($this->service->shouldBuy()) {
            return $this->exchange->buyLimitOrder($this->code, $this->price, $this->getOrderQuantity());
        }

        return 'No buy order';
    }

    protected function sell(): string
    {
        if ($this->service->shouldSell()) {
            return $this->exchange->sellLimitOrder($this->code, $this->price, $this->getOrderQuantity());
        }

        return 'No sell order';
    }

    protected function positionFull(): bool
    {
        // TODO Checks portfolio if position does not exceed 5% of portfolio
        return false;
    }

    protected function getOrderQuantity(): float
    {
        // TODO Checks portfolio how much for current price we can buy to not exceed 5%
        return 1.0;
    }
}
