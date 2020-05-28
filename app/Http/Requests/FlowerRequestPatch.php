<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlowerRequestPatch extends FormRequest
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
            'catalog_id' => 'exists:catalogs,id',
            'name' => 'sometimes|required|max:191',
            'avatar' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'catalog_id.exists' => "Catalog_id don't exists!",
            'name.required' => "Name of the flower is required!",
            'name.max:191' => "Max size of name is 191 characters!",
            'avatar.url' => "Avatar must be a URL format!"
        ];
    }
}
