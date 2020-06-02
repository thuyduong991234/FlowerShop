<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Catalog extends Model
{
    //
    public $incrementing = false;
    protected $fillable = [
        'name',
        'parent_id'
    ];
    protected static function boot() {
        parent::boot();
        static::creating(function ($flowerCatalog) {
            $flowerCatalog->{$flowerCatalog->getKeyName()} = (string) Str::uuid();
        });
    }

    public function flower()
    {
        return $this->hasMany("App\Flower");
    }
}
