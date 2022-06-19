<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Constants\Range;
use App\Constants\Symbol;
use App\Models\TransferVolumeSum;
use App\Services\GlassnodeService;
use Illuminate\Database\Seeder;

class TransferVolumeSumSeeder extends Seeder
{
    private array $ranges = [
        '1month' => Range::MONTH,
        '1w' => Range::WEEK,
        '24h' => Range::DAY,
    ];

    private array $targets = [
        'BTC' => Symbol::BTC,
        'ETH' => Symbol::ETH,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = app(GlassnodeService::class);

        foreach ($this->targets as $symbol => $target) {
            foreach($this->ranges as $rangeString => $range) {
                $result = $service->getTransferVolumeSums(
                    $symbol,
                    $rangeString,
                    '10years'
                );

                if ($result === null) {
                    continue;
                }

                $this->persist($result, $symbol, $rangeString);
            }
        }
    }

    protected function persist(array $result, string $symbol, string $range): void
    {
        foreach($result as $transferVolume) {
            TransferVolumeSum::create([
                'code' => $symbol,
                'value' => $transferVolume->v,
                'timestamp' => Carbon::createFromTimestamp($transferVolume->t),
                'range' => $this->ranges[$range],
            ]);
        }
    }
}
