<?php

namespace App\Constants;

enum OrderStatus: string
{
    case PLACED = 'placed';
    case FILLED = 'filled';
    case CANCELED = 'canceled';
}
