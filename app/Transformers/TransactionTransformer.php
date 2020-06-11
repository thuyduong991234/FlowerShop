<?php

namespace App\Transformers;

use App\Models\Transaction;
use Flugg\Responder\Transformers\Transformer;

class TransactionTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'flowers' => FlowerTransformer::class,
        'customer' => CustomerTransformer::class
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [

    ];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return $transaction->toArray();
    }

    public function includeFlowers(Transaction $transaction)
    {
        return $transaction->flowers->makehidden(['avatar','images','view','created_at','updated_at']);
    }

    public function includeCustomer(Transaction $transaction)
    {
        return $transaction->customer->makeHidden(['id','last_name','first_name','email','password','phone']);
    }
}
