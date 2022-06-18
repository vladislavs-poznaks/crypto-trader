<?php

namespace App\Services;

use App\Constants\Code;
use App\Constants\Range;
use App\Models\Candlestick;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PredictionService implements PredictionServiceInterface
{
    public function __construct(
        private Code   $code,
        private float  $price,
        private Carbon $datetime
    ) {}

    public function buy(): bool
    {
        $candlestick = $this->getCandlestick();

        return $candlestick->open / $this->price > 1.05;
    }

    public function sell(): bool
    {
        $candlestick = $this->getCandlestick();

        return $candlestick->open / $this->price < 0.90;
    }

    protected function getCandlestick(): ?Model
    {
        return Candlestick::query()
            ->where('code', $this->code)
            ->where('range', Range::MONTH)
            ->where('open_time', '<', $this->datetime->subMonth())
            ->latest('open_time')
            ->first();
    }
}
