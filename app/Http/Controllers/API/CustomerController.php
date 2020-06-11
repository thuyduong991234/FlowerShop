<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequestPost;
use App\Http\Requests\CustomerRequestPut;
use App\Transformers\CustomerTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
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
        $listCustomers = Customer::where('last_name','LIKE','%'.$request->input('lastName').'%')
            ->where('first_name','LIKE','%'.$request->input('firstName').'%')
            ->when($fromDate, function ($query, $fromDate){
                return $query->whereDate('created_at','>=',$fromDate);
            })
            ->when($toDate, function ($query, $toDate){
                return $query->whereDate('created_at','<=',$toDate);
            })
            ->paginate(5);
        //return response($listCustomers, 200);
        return responder()->success($listCustomers, CustomerTransformer::class)->with('transactions')->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequestPost $request)
    {
        //
        //$customer = new Customer;
        //$customer->fill($request->except('password'));
        //$customer->password = Hash::make($request->input('password'));
        //$customer->save();
        Customer::create($request->all());

        return response('Saved successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return
     */
    public function show(Customer $customer)
    {
        //
        //dd($customer);
        return responder()->success($customer, CustomerTransformer::class)->with('transactions')->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequestPut $request
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequestPut $request, Customer $customer)
    {
        //dd($customer);
        if(Hash::check($request->input('oldPassword'), $customer->password) ) {
            $customer->update($request->all());
            return response('Updated successfully', 200);
        }
        else{
            return response("Current password isn't right!", 422);
        }
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
        $customer->delete();
        return response('Deleted successfully!',204);
    }
}