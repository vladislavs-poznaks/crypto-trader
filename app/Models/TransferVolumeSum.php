<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferVolumeSum extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'code',
        'value',
        'timestamp',
        'range',
    ];
}

