<?php

namespace App\Services;

use App\Constants\Code;
use App\Models\Candlestick;
use Carbon\Carbon;

interface PredictionServiceInterface
{
    public function __construct(Code $code, float $price, Carbon $datetime, ?Candlestick $candlestick);

    public function shouldBuy(): bool;
    public function shouldSell(): bool;
}
