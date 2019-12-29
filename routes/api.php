<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */



Route::group(['middleware' => 'SwitchGuardValidate'], function (){

    Route::post('/user/profile', 'Api\Members\HandleMembersToken@profile')->middleware('scope:Profile');

    Route::post('/user/email', function (Request $request) {
        return $request->user()->email;
    })->middleware('scope:Email');

//    Route::post('/product/name', 'Api\Members\HandleMembersToken@test')
//        ->middleware('scope:Product');
});







//使用者email註冊,若註冊成功發放token
Route::middleware('dev')->post('/register', 'Api\Guest\RegisterController@register');

//使用官網帳密登入
Route::middleware('login')->post('/login', 'Api\Guest\LoginController@tryToLogin');

Route::middleware('dev')->post('/test', 'Api\Guest\RegisterController@test');

//將用戶重新導向至OAuth提供程序
Route::get('/login/{provider}', 'Api\Guest\SocialController@redirectToProvider');

//在身份驗證之後接收來自提供程序的回調。
Route::get('/login/{provider}/callback', 'Api\Guest\SocialController@handleProviderCallback');



//使用refresh_token 換取新的access_token social
Route::post('/change/new/token', 'Api\Members\HandleMembersToken@HandleNewToken');







//======================================================================================
/**
 * Backend admin table
 */
//Route::group(['middleware' => 'use_admin_validator']);







//======================================================================================
//test
Route::post('/test', 'Api\Guest\SocialController@test');
//Route::get('/test2', function(){
//    $user = \App\Social::find(1);
//    event(new \App\Events\ProviderSignup($user));
//});