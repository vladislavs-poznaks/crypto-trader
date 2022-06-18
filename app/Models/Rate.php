<?php

namespace App\Models;

use App\Constants\Code;
use App\Constants\SourceSymbol;
use App\Constants\TargetSymbol;
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
        'source' => SourceSymbol::class,
        'target' => TargetSymbol::class,
    ];
}
