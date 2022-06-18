<?php

namespace App\Models;

use App\Constants\Codes;
use App\Constants\Ranges;
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
    ];

    protected $casts = [
        'code' => Codes::class,
        'open_time' => 'datetime',
        'close_time' => 'datetime',
        'range' => Ranges::class,
        'ignored' => 'bool',
    ];
}
