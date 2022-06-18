<?php

namespace App\Services;

use App\Constants\Code;
use Carbon\Carbon;

interface PredictionServiceInterface
{
    public function __construct(Code $code, float $price, Carbon $datetime);

    public function buy(): bool;
    public function sell(): bool;
}
