<?php

namespace Database\Seeders;

class CandlestickHoursSeeder extends CandlestickSeeder
{
    protected function getPeriod(): string
    {
        return '1h';
    }
}
