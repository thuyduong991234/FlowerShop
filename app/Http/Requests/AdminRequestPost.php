<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequestPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'first_name' => 'required|between:2,100',
            'last_name' => 'required|between:2,100',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|string|min:1|max:8',
        ];
    }


}
