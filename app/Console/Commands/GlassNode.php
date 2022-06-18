<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\TransferVolumeSum;
use App\Services\GlassnodeService;

class GlassNode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'glassnode:transferVolume {symbol=BTC} {range=1h} {dateFrom=1hour}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = app(GlassnodeService::class);

        $symbol = $this->argument('symbol');
        $range = $this->argument('range');
        $dateFrom = $this->argument('dateFrom');

        $result = $service->getTransferVolumeSums($symbol, $range, $dateFrom);

        foreach($result as $transferVolume) {
            var_dump($transferVolume);
            TransferVolumeSum::create([
                'code' => $symbol,
                'value' => $transferVolume->v,
                'timestamp' => Carbon::createFromTimestamp($transferVolume->t),
                'range' => $range,
            ]);
        }

        return 0;
    }
}
