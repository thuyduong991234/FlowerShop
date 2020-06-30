<?php

namespace App\Http\Controllers\API;

use App\Imports\CustomersImport;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequestPost;
use App\Http\Requests\CustomerRequestPut;
use App\Models\TransactionFlower;
use App\Transformers\CustomerTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $listCustomers = Customer::when($request->lastName, function ($query) use ($request){
            return $query->where('last_name','LIKE','%'.$request->lastName.'%');
        })->when($request->firstName, function ($query) use ($request){
            return $query->where('first_name','LIKE','%'.$request->firstName.'%');
        })->when($request->fromDate, function ($query) use ($request){
            return $query->whereDate('created_at','>=',$request->fromDate);
        })->when($request->toDate, function ($query) use ($request){
            return $query->whereDate('created_at','<=',$request->toDate);
        })->paginate(5);

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

    public function statistic()
    {
        $customers = Customer::all();
        $customers->map(function ($customer){
            $transactions = $customer->transactions()->whereYear('created_at', '=', Carbon::now()->year)
                ->whereMonth('created_at', '=', Carbon::now()->month)
                ->get();

            $listId = $transactions->map(function ($val) {
                return $val->id;
            });

            $result = TransactionFlower::join('flowers', 'flowers.id', '=', 'transaction_flower.flower_id')
                ->select('flowers.id', 'flowers.name', DB::raw('SUM(transaction_flower.qty) as qty'))
                ->whereIn('transaction_flower.transaction_id', $listId)
                ->groupBy('flowers.id', 'flowers.name')
                ->get();
            $customer->flowers = $result;
        });

        //return response(['customer' => $customer, 'flowers' => $result]);
        return responder()->success($customers)->respond();
    }

    public function import(Request $request)
    {
        if($request->hasFile('customers'))
        {
            Excel::import(new CustomersImport(), $request->file('customers'));
            return responder()->success(['Saved successfully'])->respond();
        }
        return responder()->error(["Don't have file"])->respond();
    }

    public function export()
    {
        $fileName = 'customer'.time() . '.csv';
        return (new FastExcel(Customer::all()))->download($fileName);
    }
}