<?php

namespace App\Models;

use App\Traits\UtilTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class TransactionFlower extends Pivot
{
    //
    protected $table = 'transaction_flower';
    protected $fillable = [
        'transaction_id',
        'flower_id',
        'qty',
        'amount',
        'data',
        'status'
    ];
}
