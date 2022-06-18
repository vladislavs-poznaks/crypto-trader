<?php

namespace Database\Factories;

use App\Constants\Code;
use App\Constants\Range;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candlestick>
 */
class CandlestickFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $code = collect(Code::cases())->random();
        $range = collect(Range::cases())->random();

        $open = $this->faker->randomFloat(8);
        $close = $this->faker->randomFloat(8);

        return [
            'code' => $code,
            'range' => $range,
            'open' => $open,
            'close' => $close,
            'close_open_difference' => $close - $open,
            'low' => $open - $open * 1.05,
            'high' => $close + $close * 1.05,
            'high_low_difference' => ($close + $close * 1.05) - ($open - $open * 1.05),
            'volume' => $this->faker->randomNumber(6),
            'open_time' => now()->subMonth(),
            'close_time' => now()->subMonths(2),
            'asset_volume' => $this->faker->randomNumber(6),
            'base_volume' => $this->faker->randomNumber(6),
            'trades' => $this->faker->randomNumber(6),
            'asset_buy_volume' => $this->faker->randomNumber(6),
            'taker_buy_volume' => $this->faker->randomNumber(6),
            'ignored' => false,
        ];
    }
}
