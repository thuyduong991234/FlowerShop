<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlowerRequestPatch;
use App\Http\Requests\FlowerRequestPost;
use App\Transformers\FlowerTransformer;
use Flugg\Responder\TransformBuilder;
use Illuminate\Http\Request;
use App\Models\Flower;
use Illuminate\Support\Collection;

class FlowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $listFlowers = Flower::where('name','LIKE','%'.$request->input('name').'%')
            ->where('color','LIKE','%'.$request->input('color').'%')
            ->when($fromDate, function ($query, $fromDate){
                return $query->whereDate('created_at','>=',$fromDate);
            })
            ->when($toDate, function ($query, $toDate){
                return $query->whereDate('created_at','<=',$toDate);
            })
            ->paginate(5);
        //return response($listFlowers, 200);
        return responder()->success($listFlowers, FlowerTransformer::class)->with('catalog')->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlowerRequestPost $request)
    {
        //
        //$request->validated();

        Flower::create($request->all());

        return response('Saved successfully', 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return
     */
    public function show(Flower $flower)
    {
        //
        return responder()->success($flower, FlowerTransformer::class)->with('catalog')->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FlowerRequestPatch $request, Flower $flower)
    {
        //
        $flower->update($request->all());
        return response('Updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flower $flower)
    {
        //
        $flower->delete();
        return response('Deleted successfully', 204);
    }
}
