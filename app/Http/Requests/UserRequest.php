<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('POST')){
            return [
                'name'=>['required'],
                'email'=>['required'],
                'password'=>['required'],
                'confirm_password'=>['required'],
                'image'=>['sometimes','mimes:png,jpg,jpeg,webp'],
                'role'=>['required']
            ];
        }else{
            return [
                'name'=>['required'],
                'email'=>['required'],
                'image'=>['sometimes','mimes:png,jpg,jpeg,webp']
            ];
        }
        
    }
}
