<?php

namespace App\Http\Controllers\API;

use App\Catalog;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogRequestPost;
use App\Http\Requests\CatalogRequestPut;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parentID= $request->input('parentID');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $listCatalogs = Catalog::where('name','LIKE','%'.$request->input('name').'%')
            ->when($parentID, function ($query, $parentID){
                return $query->where('parent_id','LIKE','%'.$parentID.'%');
            })
            ->when($fromDate, function ($query, $fromDate){
                return $query->whereDate('created_at','>=',$fromDate);
            })
            ->when($toDate, function ($query, $toDate){
                return $query->whereDate('created_at','<=',$toDate);
            })
            ->paginate(5);
        return response($listCatalogs, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogRequestPost $request)
    {
        //
        Catalog::create($request->all());

        return response('Saved successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        //
        return response($catalog, '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogRequestPut $request, Catalog $catalog)
    {
        //
        $catalog->update($request->all());
        return response('Updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {
        //
        $catalog->delete();
        return response('Deleted successfully', 204);
    }
}