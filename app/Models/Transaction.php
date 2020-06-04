<?php

namespace App\Models;

use App\Traits\UtilTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    //
    use UtilTrait;
    public $incrementing = false;
    protected $table = 'transactions';
    protected $fillable = [
        'status',
        'customer_id',
        'customer_last_name',
        'customer_first_name',
        'customer_email',
        'customer_phone',
        'amount',
        'payment_method',
        'payment_info',
        'message',
        'security',
    ];
    //protected $with = ['flowers'];


    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function flowers()
    {
        return $this->belongsToMany(Flower::class,'transaction_flower', 'transaction_id', 'flower_id');
    }
}

