<?php

namespace App\Models;

use App\Constants\Code;
use App\Constants\Symbol;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'code',
        'source',
        'target',
        'rate',
    ];

    protected $casts = [
        'code' => Code::class,
        'source' => Symbol::class,
        'target' => Symbol::class,
    ];
}
