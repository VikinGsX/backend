<?php
namespace App;

use App\User;
use App\Social;
use Laravel\Socialite\AbstractUser as ProviderUser;

class SocialAccountService
{
    // protected $providerUser;

    // public function __construct(ProviderUser $providerUser){
    //     $this->providerUser = $providerUser;
    // }



    public function createOrGetUser(ProviderUser $providerUser)
    {

        dd($providerUser->getEmail());



        // //先在 Social model 裡找有沒有此筆user_id的資料
        // $account = Social::whereProvider('Google')
        //     ->whereProviderUserId($this->getId())
        //     ->first();
        // //如果有此筆fb_id則返回給call方法去驗證
        // if ($account) {
        //     return $account->user;

        // } else {
        //     //如果沒有此筆資料則實例化一個SocialAccount model1,並指定欄位所要的值

        //     $account = new Social([
        //         'provider_user_id' => $this->getId(),
        //         'provider' => 'google',
        //     ]);

        //     //在User Model裡查詢fb提供的E-mail是否存在
        //     $user = User::whereEmail($this->getEmail())->first();

        //     //如果找不到此e-mail 則新建一筆資料 內容為 email/users_name
        //     if (!$user) {

        //         $user = User::create([

        //             'email' => $this->getEmail(),
        //             'users_name' => $this->getName(),
        //             //  'fb_id' => $providerUser->getId(),
        //             // 'fb_nicname' => $providerUser->getNickname(),
        //             //  'fb_avatar' => $providerUser->getAvatar()

        //         ]);
        //     }

        //     $account->user()->associate($user);
        //     $account->save();

        //     //這裡返回user 是要傳遞給LoingController裡的callback方法參數,供認證專用
        //     return $user;

        // }

    }

}
