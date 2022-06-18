<?php

namespace Tests\Unit;

use App\Constants\Code;
use App\Models\Candlestick;
use App\Services\PredictionService;
use PHPUnit\Framework\TestCase;

class PredictionServiceTest extends TestCase
{
    /** @test */
    public function it_suggests_to_buy_if_returned_candlestick_if_current_price_is_smaller()
    {
        $code = Code::BTC_BUSD;
        $price = 17.000;
        $datetime = now();

        $candlestick = new Candlestick([
            'code' => $code,
            'open' => 18.000
        ]);

        // PREVIOUS PRICE / CURRENT PRICE = 18.000 / 17.000 = 1.058

        $service = new PredictionService($code, $price, $datetime, $candlestick);

        $this->assertTrue($service->shouldBuy());
        $this->assertFalse($service->shouldSell());
    }

    /** @test */
    public function it_does_not_suggest_to_buy_if_returned_candlestick_if_current_price_is_larger()
    {
        $code = Code::BTC_BUSD;
        $price = 19.000;
        $datetime = now();

        $candlestick = new Candlestick([
            'code' => $code,
            'open' => 18.000
        ]);

        // PREVIOUS PRICE / CURRENT PRICE = 18.000 / 19.000 = 0.947

        $service = new PredictionService($code, $price, $datetime, $candlestick);

        $this->assertFalse($service->shouldBuy());
        $this->assertTrue($service->shouldSell());
    }

    /** @test */
    public function it_does_not_suggest_to_buy_or_sell_if_prices_are_similar()
    {
        $code = Code::BTC_BUSD;
        $price = 18.000;
        $datetime = now();

        $candlestick = new Candlestick([
            'code' => $code,
            'open' => 18.000
        ]);

        // PREVIOUS PRICE / CURRENT PRICE = 18.000 / 18.000 = 1.000

        $service = new PredictionService($code, $price, $datetime, $candlestick);

        $this->assertFalse($service->shouldBuy());
        $this->assertFalse($service->shouldSell());
    }
}
