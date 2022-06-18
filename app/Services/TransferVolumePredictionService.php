<?php

namespace App\Services;

use App\Models\TransferVolumeSum;
use App\Models\TransferVolumePrediction;

class TransferVolumePredictionService
{
    public function getCurrentCombinedTransferVolumeIndexDay(
        string $symbol,
        int $days,
        string $baseDate = null
    ): float {
        if ($baseDate === null) {
            $baseDate = date('Y-m-d');
        }
        $range = '24h';

        $transferVolumeSums = TransferVolumeSum::query()
            ->orderBy('timestamp', 'desc')
            ->where([
                'code' => $symbol,
                'range' => $range,
                ['timestamp', '<=', $baseDate]
            ])
            ->take($days + 1)
            ->get();

        $index = 0;
        $baseDay = $transferVolumeSums[0];


        for ($i = 1; $i <= $days; $i++) {
            if ($baseDay->value > $transferVolumeSums[$i]->value) {
                $index++;
            }
        }

        $coefficient = $index/$days;

        TransferVolumePrediction::create([
            'symbol' => $symbol,
            'range' => $range,
            'date' => $baseDate,
            'value' => $coefficient,
            'size' => $days,
        ]);

        return $coefficient;
    }

    public function getCurrentCombinedTransferVolumeIndexWeek(
        string $symbol,
        int $weeks,
        string $baseDate = null
    ): float {
        if ($baseDate === null) {
            $baseDate = date('Y-m-d');
        }
        $range = '1w';

        $transferVolumeSums = TransferVolumeSum::query()
            ->orderBy('timestamp', 'desc')
            ->where([
                'code' => $symbol,
                'range' => $range,
                ['timestamp', '<=', $baseDate]
            ])
            ->take($weeks + 1)
            ->get();

        $index = 0;
        $baseWeek = $transferVolumeSums[0];


        for ($i = 1; $i <= $weeks; $i++) {
            if ($baseWeek->value > $transferVolumeSums[$i]->value) {
                $index++;
            }
        }

        $coefficient = $index/$weeks;

        TransferVolumePrediction::create([
            'symbol' => $symbol,
            'range' => $range,
            'date' => $baseDate,
            'value' => $coefficient,
            'size' => $weeks,
        ]);

        return $coefficient;
    }

    public function getCurrentCombinedTransferVolumeIndexMonth(
        string $symbol,
        int $months,
        string $baseDate = null
    ): float {
        if ($baseDate === null) {
            $baseDate = date('Y-m-d');
        }
        $range = '1month';

        $transferVolumeSums = TransferVolumeSum::query()
            ->orderBy('timestamp', 'desc')
            ->where([
                'code' => $symbol,
                'range' => $range,
                ['timestamp', '<=', $baseDate]
            ])
            ->take($months + 1)
            ->get();

        $index = 0;
        $baseMonth = $transferVolumeSums[0];


        for ($i = 1; $i <= $months; $i++) {
            if ($baseMonth->value > $transferVolumeSums[$i]->value) {
                $index++;
            }
        }

        $coefficient = $index/$months;

        TransferVolumePrediction::create([
            'symbol' => $symbol,
            'range' => $range,
            'date' => $baseDate,
            'value' => $coefficient,
            'size' => $months,
        ]);

        return $coefficient;
    }
}
