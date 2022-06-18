<?php

namespace App\Constants;

enum Code: string
{
    case BTC_BUSD = 'BTCBUSD';
    case ETH_BUSD = 'ETHBUSD';

    public function source(): string
    {
        return 'BUSD';
    }

    public function target(): string
    {
        return match ($this) {
            Code::BTC_BUSD => 'BTC',
            Code::ETH_BUSD => 'ETH',
        };
    }
}
