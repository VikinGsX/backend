<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Helper\ProxyIssueTokenTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{

    use ProxyIssueTokenTrait;

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\GuzzleException
     *
     * @$request = object
     * @$validator = array
     */
    public function tryToLogin(LoginRequest $request)
    {

        $validator = $request->validated();

        $result = Auth::attempt([
            'email' => $validator['email'],
            'password' => $validator['password'],
        ]);


        if (!$result) {
            return response()->json([
                'errors' => [
                    'validate' => '帳號或密碼錯誤,請重新輸入!',

                ]], 422);
        }

        //若驗證成功則頒發token

        $data = $this->getAccessTokenFromRegister($validator, 'users', 'Profile');
        if(!key_exists('access_token', $data)){
            return response('token error!');
        }
        return response()->json([
            'success' => ['登入成功 !'],
            'tokenData' => [$data],
            'userData' => [Auth::user()],
        ], 200);

    }

    public function test(Request $request)
    {
        return $request;
    }
}
