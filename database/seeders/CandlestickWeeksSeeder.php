<?php

namespace Database\Seeders;

class CandlestickWeeksSeeder extends CandlestickSeeder
{
    protected function getPeriod(): string
    {
        return '1w';
    }
}
