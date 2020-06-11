<?php

namespace App\Transformers;

use App\Models\Catalog;
use Flugg\Responder\Transformers\Transformer;

class CatalogTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'flowers' => FlowerTransformer::class
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
     * @param  \App\Models\Catalog $catalog
     * @return array
     */
    public function transform(Catalog $catalog)
    {
        return $catalog->toArray();
    }

    public function includeFlowers(Catalog $catalog)
    {
        return $catalog->flowers->makehidden(['catalog_id','created_at','updated_at']);
    }

    public function getCatalogCollection($listCatalog)
    {
        return $listCatalog->map(function ($catalog){
            return [
                'id' => $catalog->id,
                'name' => $catalog->name,
                'flowers' => $catalog->flowers
            ];
        });
    }
}
