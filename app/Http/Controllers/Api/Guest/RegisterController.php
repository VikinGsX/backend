<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Helper\ProxyIssueTokenTrait;


class RegisterController extends Controller
{

    use ProxyIssueTokenTrait;

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['mobile'],
            'platform' => $data['platform'],
            'station' => $data['station'],
        ]);
    }


    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\GuzzleException
     * @user object
     * @validator array
     */
    public function register(RegisterRequest $request)
    {

        $validator = $request->validated();

        if (!$validator) {
            return response()->json($validator->errors(), 422);
        }

        $user = $this->create($validator);

        if ($user) {

            $respond = $this->getAccessTokenFromRegister($validator, 'users', 'Profile');
        }

        return $respond;


    }


}
