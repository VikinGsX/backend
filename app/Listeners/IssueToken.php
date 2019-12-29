<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class IssueToken
{

    public $client;

    /**
     * IssueToken constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Registered $event
     * @param $request
     * @return bool|\Illuminate\Http\JsonResponse|mixed
     * @throws \GuzzleHttp\GuzzleException
     */
    public function handle(Registered $event)
    {
        try {

            $url = env('APP_URL').'/create/v1/oauth/token';

            $params = [
                'grant_type' => env('OAUTH_GRANT_TYPE'),
                'client_id' => env('OAUTH_CLIENT_ID_PASSWORD'),
                'client_secret' => env('OAUTH_CLIENT_SECRET_PASSWORD'),
                'username' => $event->request->email,
                'password' => $event->request->password,
                'scope' => 'Profile'
            ];

            if(array_key_exists('provider', $event->request)){

                $params = array_merge($params,
                    ['provider' => $event->request->provider]);

            }elseif (blank($params['password'])){

                $params = array_merge($params, ['password'=> env('OAUTH_PASSWORD')]);
            }

            $respond = $this->client->request('POST', $url, ['form_params' => $params]);

        } catch (RequestException $exception) {

            $respond = response()->json($exception->getResponse());
        }

        if ($respond->getStatusCode() === 200) {

           return json_decode($respond->getBody()->getContents(), true);
        }

           return response()->json('falis', 401);
    }
}
