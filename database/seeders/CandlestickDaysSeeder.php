<?php

namespace Database\Seeders;

class CandlestickDaysSeeder extends CandlestickSeeder
{
    protected function getPeriod(): string
    {
        return '1d';
    }
}
