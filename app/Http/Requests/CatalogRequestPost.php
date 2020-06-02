<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogRequestPost extends FormRequest
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
            'name' => 'required|max:191',
            'parent_id' => 'exists:catalogs,id',
        ];
    }

    public function messages()
    {
        return [
            'parent_id.exists' => "ParentID doesn't exist in Catalog table!",
            'name.required' => "Name of the catalog is required!",
            'name.max:191' => "Max size of name is 191 characters!"
        ];
    }
}
