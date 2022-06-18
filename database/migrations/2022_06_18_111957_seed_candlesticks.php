<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $seeders = [
        \Database\Seeders\CandlestickMonthsSeeder::class,
        \Database\Seeders\CandlestickWeeksSeeder::class,
        \Database\Seeders\CandlestickDaysSeeder::class,
        \Database\Seeders\CandlestickMinutesSeeder::class,
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->seeders as $seeder) {
//            app($seeder)->run();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        DB::table('candlesticks')->truncate();
    }
};
