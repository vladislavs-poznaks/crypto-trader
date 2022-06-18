<?php

namespace App\Services;

use App\Models\Candlestick;

class RSICalculationService
{
    private array $rangeSizes = [
        'month' => 24,
        'week' => 89,
        'day' => 110,
        'hour' => 72,
        'minute' => 60
    ];

    public function process()
    {
        $candleStickChuns = Candlestick::query()
            ->whereNULL('calculation_RSI')
            ->cursor()
            ->chunk(100);

        foreach ($candleStickChuns as $candlesSticks) {
            foreach ($candlesSticks as $candlesStick) {
                $this->calculate($candlesStick);
            }
        }
    }

    protected function calculate(Candlestick $candlestick)
    {
        $value = $this->calculateRSI($candlestick);

        $candlestick->calculation_RSI = $value;
        $candlestick->save();
    }

    protected function calculateRSI(Candlestick $candlestick): float
    {

        $pastCandlesticks = Candlestick::query()
            ->where('code', $candlestick->code)
            ->where('range', $candlestick->range)
            ->where('close_time', '<', $candlestick->close_time)
            ->orderBy('close_time', 'desc')
            ->limit($this->getSize($candlestick->range->value))
            ->get();

        $upSimpleAverage = 0;
        $downSimpleAverage = 0;

        /** @var Candlestick $previousCandlestick */
        $previousCandlestick = $pastCandlesticks->shift();

        foreach ($pastCandlesticks as $candleStick) {
            $closeDiff = abs($candleStick->close - $previousCandlestick->close);

            if ($candleStick->close > $previousCandlestick->close) {
                $upSimpleAverage += $closeDiff;
            } else {
                $downSimpleAverage += $closeDiff;
            }

            $previousCandlestick = $candleStick;
        }

        $relativeStrength = $upSimpleAverage / ($downSimpleAverage === 0 ? 1 : $downSimpleAverage);

        return (100 - 100 / (1 + $relativeStrength));
    }

    protected function getSize(string $range): int
    {
        return $this->rangeSizes[$range] + 1;
    }
}
