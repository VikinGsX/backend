<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class  RegisterRequest extends FormRequest
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


    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'mobile' => 'string|unique:users',
            'platform' => 'required',
            'station' => 'required',
        ];
    }


    public function messages() {

    return [
        'name.required' => '姓名不能空白',
        'name.string'  => '姓名並須為字串',
        'name.max:255' => '姓名過長',
        'email.required' => '信箱不能空白',
        'email.string'  => '信箱並須為字串',
        'email.email' => '信箱格式錯誤!',
        'email.max:50' => '信箱名稱過長',
        'email.unique:users' => '此信箱已經註冊過了',
        'password.required' => '密碼不能空白',
        'password.string' => '密碼必須為字串',
        'password.min:8' => '密碼長度至少8個字符串',
        'password.confirmed' => '確認密碼有誤',
        'mobile.string' => '手機號碼須為字串',
        'mobile.unique' => '手機已經註冊過了!',
        'platform.required' => '平台來源不能空白',
        'station.required' => '站點來源不能為空',
        ];

    }



    // public function attributes()
    //     {
    //       return [
    //         'name' => '姓名1',
    //         'email' => '信箱1',
    //         'password' => '密碼1',
    //         'mobile' => '手機1',
    //       ];
    //     }


 
    
}
