<?php

namespace App\Constants;

enum Range: string
{
    case MONTH = 'month';
    case WEEK = 'week';
    case DAY = 'day';
    case HOUR = 'hour';
    case MINUTE = 'minute';
}
