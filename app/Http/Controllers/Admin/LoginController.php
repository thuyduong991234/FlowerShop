<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestPost;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends Controller
{
    //
    public function register(AdminRequestPost $request)
    {
        $admin = Admin::create($request->all());

        return response()->json([
            'message' => 'Successfully registered',
            'admin' => $admin
        ], 201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:1|max:8'
        ]);

        if($validator->fails())
        {
            return response($validator->errors(),422);
        }

        if($token = auth('api')->attempt($request->all()))
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
