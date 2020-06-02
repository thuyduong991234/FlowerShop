<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Customer extends Model
{
    //
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

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
