<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlowerRequestPatch;
use App\Http\Requests\FlowerRequestPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Flower;

class FlowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $listFlowers = Flower::all();
        return response($listFlowers, 200);
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $flower = Flower::where('id', '=', $id)->get();
        return response($flower, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FlowerRequestPatch $request, $id)
    {
        //
        //$request->validated();

        Flower::where('id', $id)->update($request->all());
        return response('Updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Flower::where('id',$id)->delete();
        return response('Deleted successfully', 200);
    }
}
