<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Flower extends Model
{
    //

    public $incrementing = false;
    protected static function boot() {
        parent::boot();
        static::creating(function ($flower) {
            $flower->{$flower->getKeyName()} = (string) Str::uuid();
        });
    }

    public function catalog()
    {
        return $this->belongsTo('App\Catalog', 'catalog_id', 'id');
    }

    public function transactions()
    {
        return $this->belongsToMany('App\Transaction')->using('App\Transaction_flower');
    }
}
