<?php

namespace App\Models;

use App\Constants\Code;
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
        'code' => Code::class,
    ];

    public function getInfoAttribute()
    {
        $side = ucfirst($this->side->value);

        return "{$side} order ({$this->code->value}) placed. | Price: {$this->price} | Quantity: {$this->ordered_quantity}";
    }
}
