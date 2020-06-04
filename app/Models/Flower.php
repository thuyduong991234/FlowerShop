<?php

namespace App\Models;

use App\Traits\UtilTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Flower extends Model
{
    //
    use UtilTrait;
    public $incrementing = false;
    protected $fillable = [
        'catalog_id',
        'name',
        'color',
        'price',
        'discount',
        'avatar',
        'images',
        'view'
    ];
    //protected $with = ['transactions'];

    public function catalog()
    {
        return $this->belongsTo('App\Models\Catalog', 'catalog_id', 'id');
    }

    public function transactions()
    {
        return $this->belongsToMany('App\Models\Transaction', 'App\Models\TransactionFlower', 'flower_id', 'transaction_id');
    }
}
