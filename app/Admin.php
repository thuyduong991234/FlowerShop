<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Admin extends Model
{
    //
    public $incrementing = false;
    protected static function boot() {
        parent::boot();
        static::creating(function ($admin) {
            $admin->{$admin->getKeyName()} = (string) Str::uuid();
        });
    }
}
