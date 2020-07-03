<?php

namespace App\Models;

use App\Traits\UtilTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    //
    use UtilTrait;

    protected $guard = 'customer';
    public $incrementing = false;
    protected $table = 'customers';
    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'address',
        'phone'
    ];

    protected $appends = ['full_name'];
    //protected $with = ['transactionFlower'];


    protected $casts = [
        'id' => 'string'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactionFlower()
    {
        return $this->hasManyThrough(TransactionFlower::class, Transaction::class,
            'customer_id', // Foreign key on users table...
            'transaction_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
