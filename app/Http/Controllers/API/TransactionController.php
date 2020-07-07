<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequestPost;
use App\Http\Requests\TransactionRequestPut;
use App\Mail\TransactionMail;
use App\Models\Transaction;
use App\Models\TransactionFlower;
use App\Transformers\TransactionTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        return responder()->success($listTransactions, TransactionTransformer::class)->with(['flowers', 'customer'])->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(TransactionRequestPost $request)
    {
        //
        $transaction = Transaction::create($request->except('flowers'));
        foreach ($request->input('flowers') as $flower)
        {
            $new = new TransactionFlower();
            $new->fill($flower);
            $new->transaction_id = $transaction->id;
            $new->save();
        }
        Mail::to($request->input('customer_email'))->send(new TransactionMail($transaction));
        return responder()->success(['Saved successfully!'])->respond();
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
     * @return
     */
    public function update(TransactionRequestPut $request, Transaction $transaction)
    {
        //
        $transaction->update($request->all());
        return responder()->success(['Updated successfully!'])->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return
     */
    public function destroy(Transaction $transaction)
    {
        //
        $transaction->delete();
        return responder()->success(['Deleted successfully!'])->respond();
    }
}