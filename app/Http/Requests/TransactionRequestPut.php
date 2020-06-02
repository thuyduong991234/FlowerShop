<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequestPut extends FormRequest
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
            'status' => 'sometimes|required|boolean',
            'customer_id' => 'nullable|exists:customers,id',
            'customer_last_name' => 'sometimes|required|max:191',
            'customer_first_name' => 'sometimes|required|max:191',
            'customer_email' => 'sometimes|required|email',
            'customer_phone' => 'sometimes|required|size:10',
            'amount' => 'sometimes|required|numeric',
            'payment_method' => 'sometimes|required',
            'payment_info' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status is required',
            'status.boolean' => 'Status must be 0 or 1',
            'customer_id.exists' => "CustomerID doesn't exist!",
            'customer_last_name.required' => 'Your last name is required!',
            'customer_first_name.required' => 'Your first name is required!',
            'customer_last_name.max:191' => 'Max size of last name is 191 characters!',
            'customer_first_name.max:191' => 'Max size of first name is 191 characters!',
            'customer_email.required' => 'Your email is required!',
            'customer_email.email' => 'Your email must be a email format!',
            'amount.required'=>'Amount field is required!',
            'amount.numeric'=>'Amount must be a numeric!',
            'customer_phone.required' => 'Your phone is required!',
            'customer_phone.size' => 'Your phone is not in the correct format!',
            'payment_method.required' => 'Payment method is required!',
            'payment_info.required' => 'Payment info is required!'
        ];
    }
}
