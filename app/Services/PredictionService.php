<?php

namespace App\Services;

use App\Constants\Code;
use App\Constants\Range;
use App\Models\Candlestick;
use Carbon\Carbon;

class PredictionService implements PredictionServiceInterface
{
    private ?Candlestick $candlestick;

    public function __construct(
        private Code   $code,
        private float  $price,
        private Carbon $datetime,
    ) {
        $this->candlestick = null;
    }

    public function withCandlestick(Candlestick $candlestick): self
    {
        $this->candlestick = $candlestick;
        return $this;
    }

    public function shouldBuy(): bool
    {
        $candlestick = $this->getCandlestick();

        if (is_null($candlestick)) {
            return false;
        }

        if ($candlestick->open / $this->price < 1.05) {
            return false;
        }

        return true;
    }

    public function shouldSell(): bool
    {
        $candlestick = $this->getCandlestick();

        if (is_null($candlestick)) {
            return false;
        }

        if ($candlestick->open / $this->price > 0.95) {
            return false;
        }

        return true;
    }

    protected function getCandlestick()
    {
        if ($this->candlestick) {
            return $this->candlestick;
        }

        return Candlestick::query()
            ->where('code', $this->code)
            ->where('range', Range::MONTH)
            ->where('open_time', '<', $this->datetime->subMonth())
            ->latest('open_time')
            ->first();
    }
}
