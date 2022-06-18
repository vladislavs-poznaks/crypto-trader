<?php

namespace App\Services;

use App\Constants\Code;
use Carbon\Carbon;

class BotService implements BotServiceInterface
{
    public function withCode(Code $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function withPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function withDatetime(Carbon $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function process(): void
    {
        $service = new PredictionService($this->code, $this->price, $this->datetime);

        // 1 Check if current position is full
        if ($this->isPositionFilled()) {
            $this->processForSell($service);
        } else {
            $this->processForBuy($service);
        }
    }

    public function isPositionFilled(): bool
    {
        // TODO Checks portfolio if position does not exceed 5% of portfolio
        return true;
    }

    public function processForBuy(PredictionService $service): void
    {
        if (!$service->buy()) {
            return;
        }

        $exchange = app(ExchangeServiceInterface::class);

        $exchange->buyLimitOrder($this->code, $this->price, 1);
    }

    public function processForSell(PredictionService $service): void
    {
        if (!$service->sell()) {
            return;
        }
        // TODO Checks portfolio if position does not exceed 5% of portfolio
    }
}
