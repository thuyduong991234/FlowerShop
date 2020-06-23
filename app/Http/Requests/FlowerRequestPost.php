<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlowerRequestPost extends FormRequest
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
            'catalog_id' => 'required|exists:catalogs,id',
            'name' => 'required|max:191',
            //'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }

    public function messages()
    {
        return [
            'catalog_id.required' => "Catalog_id is required!",
            'catalog_id.exists' => "Catalog_id don't exists!",
            'name.required' => "Name of the flower is required!",
            'name.max:191' => "Max size of name is 191 characters!",
        ];
    }
}
