<?php

namespace App\Services;

use App\Constants\Code;

interface ExchangeServiceInterface
{
    public function getPrice(Code $code);
}
