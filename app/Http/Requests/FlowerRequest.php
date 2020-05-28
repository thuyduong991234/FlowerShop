<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlowerRequest extends FormRequest
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
            'catalog_id' => 'required',
            'name' => 'required|max:191',
        ];
    }

    public function messages()
    {
        return [
            'catalog_id.required' => "Catalog_id is required!",
            'name.required' => "Name of the flower is required!",
            'name.max:191' => "Max size of name is 191 characters!"
        ];
    }
}
