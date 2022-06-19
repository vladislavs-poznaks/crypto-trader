<?php

namespace App\Services;

use App\Constants\Code;
use App\Constants\Range;
use App\Models\Candlestick;
use App\Models\TransferVolumeSum;
use Carbon\Carbon;

class PredictionService implements PredictionServiceInterface
{
    public function __construct(
        private Code $code,
        private float $price,
        private Carbon $datetime,
    )
    {
    }

    public function withCandlestick(Candlestick $candlestick): self
    {
        return $this;
    }

    public function shouldBuy(): bool
    {
        dump('TVP',$this->getTVP());
        dump('RSI',$this->getRSI());
        return $this->getRSIISLow() && $this->getTVPIsLow();
    }

    public function shouldSell(): bool
    {
        return $this->getRSIIsHigh() && $this->getTVPIsLow();
    }

    // Check if asset is overbought
    protected function getRSIIsHigh(): bool
    {
        return $this->getRSI() > 75.0;
    }

    // Check if  asset is oversold.
    protected function getRSIIsLow(): bool
    {
        return $this->getRSI() < 25.0;
    }

    // RSI is from 0 to 100
    protected function getRSI(): float
    {
        $monthlyCandle = Candlestick::query()
            ->where('close_time', '<=', $this->datetime)
            ->where('code', $this->code)
            ->where('range', Range::MONTH)
            ->latest('close_time')
            ->first();

        $weeklyCandle = Candlestick::query()
            ->where('close_time', '<=', $this->datetime)
            ->where('code', $this->code)
            ->where('range', Range::WEEK)
            ->latest('close_time')
            ->first();

        $dailyCandle = Candlestick::query()
            ->where('close_time', '<=', $this->datetime)
            ->where('code', $this->code)
            ->where('range', Range::DAY)
            ->latest('close_time')
            ->first();

        $hourlyCandle = Candlestick::query()
            ->where('close_time', '<=', $this->datetime)
            ->where('code', $this->code)
            ->where('range', Range::HOUR)
            ->latest('close_time')
            ->first();

        $minuteCandle = Candlestick::query()
            ->where('close_time', '<=', $this->datetime)
            ->where('code', $this->code)
            ->where('range', Range::MINUTE)
            ->latest('close_time')
            ->first();

        // FAILSAFE
        if (empty($monthlyCandle) || empty($weeklyCandle) || empty($dailyCandle) || empty($hourlyCandle) || empty($minuteCandle)) {
            return 200.0;
        }

        // Calculate RSI based on coeficient from multiple RSI
        $monthlyCandleRSI = 0.25 * $monthlyCandle->calculation_RSI;
        $weeklyCandleRSI = 0.25 * $weeklyCandle->calculation_RSI;
        $dailyCandleRSI = 0.3 * $dailyCandle->calculation_RSI;
        $hourlyCandleRSI = 0.1 * $hourlyCandle->calculation_RSI;
        $minuteCandleRSI = 0.1 * $minuteCandle->calculation_RSI;

        // Overall RSI
        return $monthlyCandleRSI + $weeklyCandleRSI + $dailyCandleRSI + $hourlyCandleRSI + $minuteCandleRSI;
    }

    // IF TVP is low, then there might be changes following soon
    protected function getTVPIsLow(): bool
    {
        return $this->getTVP() < 0.25;
    }

    protected function getTVP(): float
    {
        $target = $this->code->source();

        $monthlyCandle = TransferVolumeSum::query()
            ->where('code', $target)
            ->where('range', Range::MONTH)
            ->where('timestamp','<=',$this->datetime)
            ->latest('timestamp')
            ->first();

        $weeklyCandle = TransferVolumeSum::query()
            ->where('code', $target)
            ->where('range', Range::WEEK)
            ->where('timestamp','<=',$this->datetime)
            ->latest('timestamp')
            ->first();

        $dailyCandle = TransferVolumeSum::query()
            ->where('code', $target)
            ->where('range', Range::DAY)
            ->where('timestamp','<=',$this->datetime)
            ->latest('timestamp')
            ->first();

        // FAILSAFE
        if (empty($monthlyCandle) || empty($weeklyCandle) || empty($dailyCandle)) {
            return 2.0;
        }

        // Calculate TVP based on coeficient from multiple TVP
        $monthlyCandleTVP = 0.3 * $monthlyCandle->calculation_index;
        $weeklyCandleTVP = 0.3 * $weeklyCandle->calculation_index;
        $dailyCandleTVP = 0.4 * $dailyCandle->calculation_index;

        // Overall Value
        return $monthlyCandleTVP + $weeklyCandleTVP + $dailyCandleTVP;
    }
}
