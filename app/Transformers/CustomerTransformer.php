<?php

namespace App\Transformers;

use App\Models\Customer;
use App\Models\Transaction;
use Flugg\Responder\Transformers\Transformer;

class CustomerTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'transactions' => TransactionTransformer::class
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Customer $customer
     * @return array
     */
    public function transform(Customer $customer)
    {
        return $customer->toArray();
    }

    public function includeTransactions(Customer $customer)
    {
        return $customer->transactions->makehidden(['customer_id','customer_last_name','customer_first_name','customer_email','customer_phone']);
    }
}
