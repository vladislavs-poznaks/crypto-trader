<?php

namespace App\Models;

use App\Constants\Codes;
use App\Constants\OrderSide;
use App\Constants\OrderStatus;
use App\Constants\OrderType;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'order_id',
        'client_order_id',
        'type',
        'status',
        'side',
        'code',
        'price',
        'ordered_quantity',
        'executed_quantity',
        'commission',
    ];

    protected $casts = [
        'order_id' => 'int',
        'type' => OrderType::class,
        'side' => OrderSide::class,
        'status' => OrderStatus::class,
        'code' => Codes::class,
    ];
}
