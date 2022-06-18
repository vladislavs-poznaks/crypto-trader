<?php

namespace App\Models;

use App\Constants\Codes;
use App\Constants\Sources;
use App\Constants\Targets;
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
        'code' => Codes::class,
        'source' => Sources::class,
        'target' => Targets::class,
    ];
}
