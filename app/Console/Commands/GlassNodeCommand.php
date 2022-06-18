<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\TransferVolumeSum;
use App\Services\GlassnodeService;

class GlassNodeCommand extends Command
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
    protected $description = 'Fetch transfer volumes from Glassnode';
    private string $symbol;
    private string $range;
    private string $dateFrom;

    public function __construct(string $symbol = 'BTC', string $range = '1h', string $dateFrom = '1hour')
    {
        $this->symbol = $symbol;
        $this->range = $range;
        $this->dateFrom = $dateFrom;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = app(GlassnodeService::class);

        $symbol = $this->symbol;
        $range = $this->range;
        $dateFrom = $this->dateFrom;

        $result = $service->getTransferVolumeSums($symbol, $range, $dateFrom);

        foreach($result as $transferVolume) {
            TransferVolumeSum::create([
                'code' => $symbol,
                'value' => $transferVolume->v,
                'timestamp' => Carbon::createFromTimestamp($transferVolume->t),
                'range' => $range,
            ]);
        }

        return 0;
    }

    public function __invoke()
    {
        return $this->handle();
    }
}
