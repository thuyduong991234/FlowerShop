<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequestPost;
use App\Http\Requests\TransactionRequestPut;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $status = $request->input('status');
        $customerLastName = $request->input('lastName');
        $customerFirstName = $request->input('firstName');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $listTransactions = Transaction::where('status','LIKE','%'.$status.'%')
            ->where('customer_last_name','LIKE','%'.$customerLastName.'%')
            ->where('customer_first_name','LIKE','%'.$customerFirstName.'%')
            ->when($fromDate, function ($query, $fromDate){
                return $query->whereDate('created_at','>=',$fromDate);
            })
            ->when($toDate, function ($query, $toDate){
                return $query->whereDate('created_at','<=',$toDate);
            })
            ->paginate(5);
        return response($listTransactions, 200);
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
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
        return response($transaction, 200);
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