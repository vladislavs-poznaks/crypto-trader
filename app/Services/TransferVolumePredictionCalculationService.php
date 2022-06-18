<?php

namespace App\Services;

use App\Models\Candlestick;
use App\Models\TransferVolumeSum;

class TransferVolumePredictionCalculationService
{
    private array $rangeSizes = [
        'month' => 12, // 1 year
        'week' => 49, // 1 year
        'day' => 90, // 3 x 3men
        'hour' => 168, // 24 x 7 d
        'minute' => 300 // 60 * 5 h
    ];

    public function process()
    {
        $chunks = TransferVolumeSum::query()
            ->whereNULL('calculation_index')
            ->cursor()
            ->chunk(100);

        foreach($chunks as $rows) {
            foreach($rows as $row) {
                $this->calculate($row);
            }
        }
    }

    protected function calculate(TransferVolumeSum $row)
    {
        $value = $this->calculateRSI($row);

        $row->calculation_index = $value;
        $row->save();
    }

    protected function calculateRSI(TransferVolumeSum $row): ?float
    {
        $limit = $this->getSize($row->range);

        $pastRows = TransferVolumeSum::query()
            ->where('code', $row->code)
            ->where('range', $row->range)
            ->where('timestamp', '<=',$row->timestamp)
            ->orderBy('timestmap','desc')
            ->limit($limit)
            ->get();

        if (count($pastRows) < $limit) {
            return null;
        }

        /** @var Candlestick $previousRow */
        $previousRow = $pastRows->shift();


        $index = 0;
        foreach($pastRows as $pastRow) {
            if ($row->value > $pastRow->value) {
                $index++;
            }
        }

        return $index/$limit;
    }

    protected function getSize(string $range): int {
        return $this->rangeSizes[$range]+1;
    }
}
