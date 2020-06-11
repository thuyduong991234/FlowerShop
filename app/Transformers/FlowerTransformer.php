<?php

namespace App\Transformers;

use App\Models\Flower;
use Flugg\Responder\Transformers\Transformer;

class FlowerTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'catalog' => CatalogTransformer::class
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
     * @param  \App\Models\Flower $flower
     * @return
     */
    public function transform(Flower $flower)
    {
        return $flower->toArray();
    }

    public function includeCatalog(Flower $flower)
    {
        return $flower->catalog->makehidden(['created_at','updated_at','parent_id']);
    }
}
