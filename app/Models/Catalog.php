<?php

namespace App\Models;

use App\Traits\UtilTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Catalog extends Model
{
    //
    use UtilTrait;
    public $incrementing = false;
    protected $table = 'catalogs';
    //protected $with = ['flowers:id,catalog_id,name'];
    protected $appends = ['sum_flower_view'];

    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function flowers()
    {
        return $this->hasMany(Flower::class);
    }

    public function getSumFlowerViewAttribute()
    {
        return $this->flowers()->sum('view');
    }
}
