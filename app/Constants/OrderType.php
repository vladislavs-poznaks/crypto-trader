<?php

namespace App\Constants;

enum OrderType: string
{
    case LIMIT = 'limit';
    case MARKET = 'market';
}
