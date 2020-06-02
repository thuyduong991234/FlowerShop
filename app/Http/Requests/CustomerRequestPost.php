<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequestPost extends FormRequest
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
            'last_name' => 'required|max:191',
            'first_name' => 'required|max:191',
            'email' => 'required|unique:customers,email|email',
            'password' =>'required|min:1|max:8',
            'phone' => 'required|size:10',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => "Your last name is required!",
            'first_name.required' => "Your first name is required!",
            'last_name.max:191' => "Max size of last name is 191 characters!",
            'first_name.max:191' => "Max size of first name is 191 characters!",
            'email.required' => 'Your email is required!',
            'email.unique' => 'Your email had be existed!',
            'email.email' => 'Your email must be a email format!',
            'password.required'=>'Your password is required!',
            'password.min'=>'Your password must be from 1 to 8 characters!',
            'password.max'=>'Your password must be from 1 to 8 characters!',
            'phone.required' => 'Your phone is required!',
            'phone.size' => 'Your phone is not in the correct format!',
            'address.required' => 'Your address is required!',
        ];
    }
}
