<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequestPost;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function register(CustomerRequestPost $request)
    {
        $customer = Customer::create($request->all());

        return response()->json([
            'message' => 'Successfully registered',
            'admin' => $customer
        ], 201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:customers',
            'password' => 'required|string|min:1|max:8'
        ]);

        if($validator->fails())
        {
            return response($validator->errors(),422);
        }

        if($token = auth('customer')->attempt($validator->validated()))
        {
            return response($token, 200);
        }
        return response(['error' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        auth()->logout();
        return response("Logout successfully!",200);
    }
}
