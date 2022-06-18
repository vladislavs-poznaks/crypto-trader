<?php

namespace App\Models;

use App\Constants\Code;
use App\Constants\Range;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candlestick extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'code',
        'range',
        'open',
        'close',
        'close_open_difference',
        'low',
        'high',
        'high_low_difference',
        'volume',
        'open_time',
        'close_time',
        'asset_volume',
        'base_volume',
        'trades',
        'asset_buy_volume',
        'taker_buy_volume',
        'ignored',
        'calculation_RSI',
    ];

    protected $casts = [
        'code' => Code::class,
        'open_time' => 'datetime',
        'close_time' => 'datetime',
        'range' => Range::class,
        'ignored' => 'bool',
    ];
}
