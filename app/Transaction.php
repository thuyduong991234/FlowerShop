<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    //
    public $incrementing = false;
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
    protected static function boot() {
        parent::boot();
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    public function customer() {
        return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function flowers()
    {
        return $this->belongsToMany('App\Flower')->using('App\Transaction_flower');
    }
}
