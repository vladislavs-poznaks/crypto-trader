<?php

namespace Database\Seeders;


class CandlestickMonthsSeeder extends CandlestickSeeder
{
    protected function getPeriod(): string
    {
        return '1M';
    }
}
