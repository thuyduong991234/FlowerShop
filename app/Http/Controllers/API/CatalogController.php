<?php

namespace App\Http\Controllers\API;

use App\Models\Catalog;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogRequestPost;
use App\Http\Requests\CatalogRequestPut;
use App\Transformers\CatalogTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class CatalogController extends Controller
{
    private $fractal;

    function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $listCatalogs = Catalog::when($request->name, function ($query) use ($request){
            return $query->where('name','LIKE','%'.$request->name.'%');
        })->when($request->parentID, function ($query) use ($request){
            return $query->where('parent_id','=', $request->parentID);
        })->when($request->fromDate, function ($query) use ($request){
            return $query->whereDate('created_at','>=',$request->fromDate);
        })->when($request->toDate, function ($query) use ($request){
            return $query->whereDate('created_at','<=',$request->toDate);
        })->paginate(5);
        //dd($listCatalogs);
        //return $this->fractal->createData(new Collection($listCatalogs,new CatalogTransformer()))->toArray();

        //1
        /*return responder()->success($listCatalogs->map(function ($catalog) {
            return ['id' => $catalog->id, 'name' => $catalog->name];
        })
        )->respond();*/

        //$listCatalogs = (new CatalogTransformer())->getCatalogCollection($listCatalogs);
        //return $listCatalogs;
        //2
        return responder()->success($listCatalogs, CatalogTransformer::class)->with('flowers')->respond();
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function getAll()
    {
        $list = Catalog::all();
        return response(['data' => $list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(CatalogRequestPost $request)
    {
        //
        Catalog::create($request->all());

        return responder()->success()->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return
     */
    public function show(Catalog $catalog)
    {
        //
        //return response($catalog->load('flowers:id,name'), '200');
        return responder()->success($catalog, CatalogTransformer::class)->with('flowers')->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return
     */
    public function update(CatalogRequestPut $request, Catalog $catalog)
    {
        //
        $catalog->update($request->all());
        return responder()->success()->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return
     */
    public function destroy(Catalog $catalog)
    {
        //
        $catalog->delete();
        return responder()->success()->respond();
    }
}