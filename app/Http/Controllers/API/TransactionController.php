<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequestPost;
use App\Http\Requests\TransactionRequestPut;
use App\Models\Transaction;
use App\Transformers\TransactionTransformer;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $listTransactions = Transaction::when($request->status, function ($query) use ($request){
            return $query->where('status','=',$request->status);
        })->when($request->lastName, function ($query) use ($request){
            return $query->where('customer_last_name','LIKE','%'.$request->lastName.'%');
        })->when($request->firstName, function ($query) use ($request){
            return $query->where('customer_first_name','LIKE','%'.$request->firstName.'%');
        })->when($request->fromDate, function ($query) use ($request){
            return $query->whereDate('created_at','>=',$request->fromDate);
        })->when($request->toDate, function ($query) use ($request){
            return $query->whereDate('created_at','<=',$request->toDate);
        })->paginate(5);

        return responder()->success($listTransactions, TransactionTransformer::class)->with(['flowers','customer'])->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequestPost $request)
    {
        //
        Transaction::create($request->all());
        return response('Saved successfully!', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return
     */
    public function show(Transaction $transaction)
    {
        //return $transaction->flowers;
        return responder()->success($transaction, TransactionTransformer::class)->with(['flowers','customer'])->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequestPut $request, Transaction $transaction)
    {
        //
        $transaction->update($request->all());
        return response('Updated successfully!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
        $transaction->delete();
        return response('Deleted successfully!',204);
    }
}