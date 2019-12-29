<?php

namespace App\Http\Controllers\Api\Guest;


use App\Http\Controllers\Controller;
use App\User;
use App\Social;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use App\Helper\ProxyIssueTokenTrait;
use Illuminate\Support\Facades\Hash;

/**
 * Class SocialController
 * @package App\Http\Controllers\Api\Guest
 */
class SocialController extends Controller
{

    use ProxyIssueTokenTrait;

    /**
     * @param Request $request
     * @param $provider
     * @return mixed
     *
     * 跳轉到google使用者登入驗證
     */
    public function redirectToProvider(Request $request, $provider)
    {
        //return Socialite::with($provider)->stateless()->redirect();

        $data = Socialite::with($provider)->stateless()->redirect();
        $redirect = collect($data)->get("\x00*\x00targetUrl");
        return $redirect;


    }


    /**
     * @param Request $request
     * @param $provider
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\GuzzleException
     *
     * 驗證成功後會跳轉到 login/callback
     * 取得到provider資料後,判斷email是否已經註冊本站會員
     * 如果已經註冊則返回user,如果沒有,則先create new member再返回user data
     *
     *
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        $providerUser = Socialite::driver($provider)->stateless()->user();

        $user = $this->createOrGetUser($providerUser, $provider);

        // 1.當拿到createOrGetUser 回傳值進行返回到前端處理
        // 2.要觸發發放由passport發放的access_token監聽
        return response()->json(['user_data' => $user], 200);
    }

    /**
     * @param $providerUser
     * @param $provider
     * @return bool|mixed
     * @throws \GuzzleHttp\GuzzleException
     */
    public function createOrGetUser($providerUser, $provider)
    {
        $account = Social::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())->first();

        if ($account) {

            // return $providerUser;
            $exitsUser = [
                'email' => $providerUser->getEmail(),
                'password' => env('OAUTH_PASSWORD'),
            ];
            $scopes = 'Profile';
            $respond = $this->getAccessToken($exitsUser, 'socials', $scopes);

            return $respond;


        } else {

            $createNewUser = Social::create([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider,
                'email' => $providerUser->getEmail(),
                'password' => Hash::make(env('OAUTH_PASSWORD')),
                'name' => $providerUser->getName(),
                'nick_name' => $providerUser->getNickname(),
                'avatar' => $providerUser->getAvatar(),
            ]);

            if ($createNewUser) {

                $scopes = 'Profile';
                $respond = $this->getAccessToken($createNewUser, 'socials', $scopes);

            }

            return $respond;
        }

    }


    public function test(Request $request)
    {

        return response('OMG!!');
    }

}
