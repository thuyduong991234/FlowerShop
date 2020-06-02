<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequestPost;
use App\Http\Requests\CustomerRequestPut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $lastName = $request->input('lastName');
        $firstName = $request->input('firstName');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $listCustomers = Customer::where('last_name','LIKE','%'.$lastName.'%')
            ->where('first_name','LIKE','%'.$firstName.'%')
            ->when($fromDate, function ($query, $fromDate){
                return $query->whereDate('created_at','>=',$fromDate);
            })
            ->when($toDate, function ($query, $toDate){
                return $query->whereDate('created_at','<=',$toDate);
            })
            ->paginate(5);
        return response($listCustomers, 200);
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
        $customer = new Customer;
        $customer->fill($request->except('password'));
        $customer->password = Hash::make($request->input('password'));
        $customer->save();

        return response('Saved successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
        return response($customer, 200);
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

        $customer->update([
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'email'=> $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address')
        ]);


        return response('Updated successfully', 200);
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
