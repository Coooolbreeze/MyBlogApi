<?php

namespace App\Http\Requests;

use App\Models\Image;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class UpdateBlogPost extends Request
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
                Rule::in(Image::pluck('id')->toArray())
            ],
            'title' => 'max:50',
            'outline' => 'max:100',
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
