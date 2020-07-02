<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlowerRequestPatch;
use App\Http\Requests\FlowerRequestPost;
use App\Imports\FlowersImport;
use App\Transformers\FlowerTransformer;
use Illuminate\Http\Request;
use App\Models\Flower;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class FlowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $listFlowers = Flower::when($request->name, function ($query) use ($request){
            return $query->where('name','LIKE','%'.$request->name.'%');
        })->when($request->color, function ($query) use ($request){
            return $query->where('color','LIKE','%'.$request->color.'%');
        })->when($request->fromDate, function ($query) use ($request){
            return $query->whereDate('created_at','>=',$request->fromDate);
        })->when($request->toDate, function ($query) use ($request){
            return $query->whereDate('created_at','<=',$request->toDate);
        })->paginate(5);
        //return response($listFlowers, 200);
        return responder()->success($listFlowers, FlowerTransformer::class)->with('catalog')->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(FlowerRequestPost $request)
    {
        /*
        //check file
        if($request->hasFile('avatar'))
        {
            //dd([$request->except(['avatar']), 'avatar' => "link"]);
            //Way 1: stored path of avatar
            //stored image to folder avatars
            $avatarName = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $link = $request->file('avatar')->storeAs('/avatars', $avatarName, 'public');
            $flower = new Flower();
            $flower->fill($request->except('avatar'));
            $flower->avatar = $link;
            $flower->save();

            return responder()->success(['Saved successfully'])->respond();

        }
        return responder()->error(["Don't have file"])->respond();
        */

        //Way 2
        $base64 = $request->input('avatar');
        $imgName = 'image_'.time().'.png';
        if($base64 != ""){
            Storage::disk('public')->put("avatars/$imgName", base64_decode($base64), 'public');
            $flower = new Flower();
            $flower->fill($request->except('avatar'));
            $flower->avatar = "avatars/$imgName";
            $flower->save();

            return responder()->success(['Saved successfully'])->respond();
        }

        return responder()->error(["Don't have file"])->respond();
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
     * @return
     */
    public function update(FlowerRequestPatch $request, Flower $flower)
    {
        //
        //dd($request->all());
        $base64 = $request->input('avatar');
        $imgName = 'image_'.time().'.png';
        if($base64 != ""){
            Storage::disk('public')->put("avatars/$imgName", base64_decode($base64), 'public');
            $flower->update([$request->except('avatar'),
                'avatar' => "avatars/$imgName"
            ]);
            return responder()->success(['Updated successfully'])->respond();
        }

        return responder()->error(["Failed"])->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return
     */
    public function destroy(Flower $flower)
    {
        //
        $flower->delete();
        return responder()->success(['Deleted successfully!'])->respond();
    }

    public function export()
    {
        $fileName = 'flower'.time() . '.csv';
        return (new FastExcel(Flower::all()))->download($fileName);
    }

    public function import(Request $request)
    {
        if($request->hasFile('flowers'))
        {
            Excel::import(new FlowersImport, $request->file('flowers'));
            return responder()->success(['Saved successfully'])->respond();

        }
        return responder()->error(["Don't have file"])->respond();

    }
}
