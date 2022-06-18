<?php

namespace App\Console\Commands;

use App\Constants\Code;
use App\Services\BotServiceInterface;
use Illuminate\Console\Command;

class BotTradeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vev:trade {code=BTCBUSD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start trading';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $code = Code::from($this->argument('code'));
        $bot = app(BotServiceInterface::class, [
            'code' => $code
        ]);

        echo $bot->process() . PHP_EOL;

        return 0;
    }
}
