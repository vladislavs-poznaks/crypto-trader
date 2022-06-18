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

    public function __construct(Code $code, ?float $price = null, ?Carbon $datetime = null)
    {
        $this->service = app(PredictionServiceInterface::class);
        $this->exchange = app(ExchangeServiceInterface::class);

        $this->code = $code;
        $this->price = $price ?? $this->exchange->getPrice($this->code);
        $this->datetime = $datetime ?? now();
    }

    public function process(): void
    {
        $this->positionFull() ? $this->sell() : $this->buy();
    }

    protected function buy(): void
    {
        if ($this->service->shouldBuy()) {
            $this->exchange->buyLimitOrder($this->code, $this->price, $this->getOrderQuantity());
        }
    }

    protected function sell(): void
    {
        if ($this->service->shouldSell()) {
            $this->exchange->sellLimitOrder($this->code, $this->price, $this->getOrderQuantity());
        }
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
