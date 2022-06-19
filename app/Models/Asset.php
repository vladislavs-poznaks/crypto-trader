<?php

namespace App\Models;

use App\Constants\Code;
use App\Constants\Symbol;
use App\Services\ExchangeServiceInterface;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'symbol',
        'quantity',
    ];

    protected $casts = [
        'symbol' => Symbol::class,
    ];

    public function marketValueIn(Symbol $symbol)
    {
        if ($this->symbol === $symbol) {
            return $this->quantity;
        }

        $exchange = app(ExchangeServiceInterface::class);

        $code = Code::from($this->symbol->value . $symbol->value);

        $price = $exchange->getPrice($code);

        return $price * $this->quantity;
    }
}
