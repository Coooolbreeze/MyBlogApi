<?php

namespace App\Http\Requests;

use App\Models\Image;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class StoreBlogPost extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image_id' => [
                'required',
                Rule::in(Image::pluck('id')->toArray())
            ],
            'title' => 'required|max:50',
            'outline' => 'required|max:100',
            'detail' => 'required',
            'tags' => [
                'array',
                function ($attribute, $value, $fail) {
                    $tags = Tag::pluck('id')->toArray();
                    if (array_intersect($value, $tags) != $value) {
                        return $fail($attribute . ' is invalid');
                    }
                }
            ]
        ];
    }
}
