<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CandlestickMonthsSeeder::class);
        $this->call(CandlestickWeeksSeeder::class);
        $this->call(CandlestickDaysSeeder::class);
        $this->call(CandlestickHoursSeeder::class);
        $this->call(CandlestickMinutesSeeder::class);
    }
}
