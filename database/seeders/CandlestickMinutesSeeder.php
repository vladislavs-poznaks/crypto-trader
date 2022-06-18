<?php

namespace Database\Seeders;

class CandlestickMinutesSeeder extends CandlestickSeeder
{
    protected function getPeriod(): string
    {
        return '1m';
    }
}
