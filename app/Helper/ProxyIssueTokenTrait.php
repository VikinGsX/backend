<?php
/**
 * Created by PhpStorm.
 * User: Soros
 * Date: 2019/12/14
 * Time: 上午 12:27
 */

namespace App\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;


trait ProxyIssueTokenTrait
{
    /**
     * @var Client
     */
    public $client;

    /**
     * ProxyIssueTokenTrait constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     * issue token api url
     */
    protected function issueUrl()
    {

        return env('APP_URL') . env('OAUTH_ISSUE_TOKEN_URL');

    }


    /**
     * @param $guard_table
     * @param $scopes
     * @return array
     */
    protected function params($guard_table, $scopes)
    {

        return [
            'grant_type' => env('OAUTH_GRANT_TYPE'),
            'client_id' => env('OAUTH_CLIENT_ID_PASSWORD'),
            'client_secret' => env('OAUTH_CLIENT_SECRET_PASSWORD'),
            'provider' => $guard_table,
            'scope' => $scopes
        ];
    }


    /**
     * @param $request
     * @param $guard_table
     * @param $scopes
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \GuzzleHttp\GuzzleException
     *
     */
    public function getAccessTokenFromRegister($request, $guard_table, $scopes)
    {
        try {
            $params = array_merge($this->params($guard_table, $scopes), [

                'username' => $request['email'],
                'password' => $request['password']

            ]);

            $respond = $this->client->request('POST', $this->issueUrl(), ['form_params' => $params]);

        } catch (RequestException $exception) {

          //  return response()->json($exception->getResponse());
            $respondd = $this->client->request('POST', $this->issueUrl(), ['form_params' => $params]);
            //return response()->json(['token_error' => $exception]);

            return $respondd;

        }

        if ($respond->getStatusCode() === 200) {

            $token = json_decode($respond->getBody()->getContents(), true);

            if(key_exists('access_token', $token)){
                return $token;
            }

            return response('請求成功但沒有產生token!!');

        }

        return response()->json(['errors' => ['status_code' => 'token請求失敗 !']], 500);
    }


    /**
     * @param string $guard
     * @return bool|mixed
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAccessToken($request, $guard_table, $scopes)
    {

        try {


            $type = gettype($request);


            if ($type === 'array') {

                $params = array_merge($this->params($guard_table, $scopes), [
                    'username' => $request['email'],
                    'password' => $request['password']
                ]);

            } elseif ($type === 'object') {
                $params = array_merge($this->params($guard_table, $scopes), [
                    'username' => $request->email,
                    'password' => env('OAUTH_PASSWORD')
                ]);

            }

            $respond = $this->client->request('POST', $this->issueUrl(), ['form_params' => $params]);

        } catch (RequestException $exception) {

            $respond = response()->json($exception->getResponse());


        }

        if ($respond->getStatusCode() === 200) {

            return json_decode($respond->getBody()->getContents(), true);
        }

        return response()->json('falis', 401);
    }


    /**
     * @return bool|mixed
     * @throws \GuzzleHttp\GuzzleException
     */
    public function useRefreshTokenMakeNewAccessToken($refreshToken)
    {
        try {

            $url = env('APP_URL') . env('OAUTH_ISSUE_TOKEN_URL');
            $params = [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'client_id' => env('OAUTH_CLIENT_ID_PASSWORD'),
                'client_secret' => env('OAUTH_CLIENT_SECRET_PASSWORD'),
                'scope' => 'Profile'
            ];

            $respond = $this->client->request('POST', $url, ['form_params' => $params]);

        } catch (RequestException $exception) {
            return $exception->getResponse();
        }

        if ($respond->getStatusCode() === 200) {
            return json_decode($respond->getBody(), true);
        }
        return response()->json([
            ['errors' => 'refresh_token expired!']],422);

    }


    /**
     * @return bool|mixed
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getRefreshtoken()
    {

        try {
            $url = env('APP_URL') . env('OAUTH_ISSUE_TOKEN_URL');

            $params = array_merge(config('passport.refresh_token'), [
                'refresh_token' => request('refresh_token'),
            ]);

            $respond = $this->client->request('POST', $url, ['form_params' => $params]);
        } catch (RequestException $exception) {
            return false;
        }

        if ($respond->getStatusCode() === 200) {
            return json_decode($respond->getBody(), true);
        }
        return false;
    }


    /**
     * @param $arrayData
     * @return mixed
     */
    public function objectToArray($arrayData)
    {
        return json_decode(json_encode($arrayData), true);

    }
}