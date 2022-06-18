<?php

namespace App\Constants;

enum Ranges: string
{
    case MONTH = 'month';
    case WEEK = 'week';
    case DAY = 'day';
    case HOUR = 'hour';
    case MINUTE = 'minute';
}
