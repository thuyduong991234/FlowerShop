<?php

namespace App\Models;

use App\Traits\UtilTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Admin extends Model
{
    //
    use UtilTrait;
    public $incrementing = false;
    protected $table = 'admins';
    protected $fillable = [
        'last_name',
        'first_name',
        'username',
        'password'
    ];
}
