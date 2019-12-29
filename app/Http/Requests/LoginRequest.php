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

            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages() {

        return [

            'email.required' => '信箱不能空白',
            'email.string'  => '信箱並須為字串',
            'email.email' => '信箱格式錯誤!',
            'password.required' => '密碼不能空白',
            'password.string' => '密碼必須為字串',
            'password.min:8' => '密碼長度至少8個字符串',
        ];

    }
}
