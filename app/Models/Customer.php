<?php

namespace App\Models;

use App\Traits\UtilTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Customer extends Model
{
    //
    use UtilTrait;
    public $incrementing = false;
    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'address',
        'phone'
    ];

    protected $appends = ['full_name'];
    protected $with = ['transactions'];


    protected $casts = [
        'id' => 'string'
    ];

    public function transactions()
    {
        return $this->hasMany("App\Models\Transaction");
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
