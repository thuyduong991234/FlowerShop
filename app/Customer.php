<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    //
    public $incrementing = false;
    protected static function boot() {
        parent::boot();
        static::creating(function ($customer) {
            $customer->{$customer->getKeyName()} = (string) Str::uuid();
        });
    }

    protected $casts = [
        'id' => 'string'
    ];

    public function transactions()
    {
        return $this->hasMany("App\Transaction");
    }
}
