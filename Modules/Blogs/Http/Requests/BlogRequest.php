<?php

namespace Modules\Blogs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $imageRules = ['mimes:jpeg,png,jpg,gif,webp', 'max:2048'];

        if ($this->isMethod('post')) {
            $imageRules = array_merge(['required', 'image'], $imageRules);
        } else if ($this->isMethod('put')) {
            $imageRules = array_merge(['nullable', 'sometimes'], $imageRules);
        }
        return [
            'title' => ['required', Rule::unique('blogs', 'title')->ignore($this->blog)],
            'slug' => [
                'required',
                Rule::unique('blogs','slug')->ignore($this->blog),
            ],
            'image' => $imageRules,
            'description'=>['required'],
            'is_published'=>['required'],
        ];

    }

    public function messages()
    {
        return [
            'is_published.required' => 'The status field is required.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
