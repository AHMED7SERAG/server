<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "password" => "required",
            "email" => "required|exists:admins,email",
            'admin' =>'mimes:png,jpg,jpeg' 

        ];
    }
    public function messages()
    {
        return [
            "password.required" =>"كلمة المرور مطلوبة"
        ];
    }
}
