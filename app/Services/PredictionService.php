<?php

namespace App\Services;

use App\Constants\Code;
use Carbon\Carbon;

class PredictionService implements PredictionServiceInterface
{
    public function __construct(
        private Code   $code,
        private float  $price,
        private Carbon $datetime
    ) {}

    public function buy(): bool
    {
        // TODO: Implement buy() method.
        return true;
    }

    public function sell(): bool
    {
        // TODO: Implement sell() method.
        return false;
    }
}
