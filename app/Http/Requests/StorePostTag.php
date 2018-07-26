<?php

namespace App\Http\Requests;

class StorePostTag extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:tags|max:12'
        ];
    }
}
