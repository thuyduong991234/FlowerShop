<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class Transaction_flower extends Pivot
{
    //
    public $incrementing = false;
    protected static function boot() {
        parent::boot();
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }
}
