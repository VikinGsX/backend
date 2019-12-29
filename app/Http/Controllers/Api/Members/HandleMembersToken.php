<?php

namespace App\Http\Controllers\Api\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ProxyIssueTokenTrait;

class HandleMembersToken extends Controller
{
    use ProxyIssueTokenTrait;

    /**
     * @param Request $request
     * @return bool|mixed
     * @throws \GuzzleHttp\GuzzleException
     */
    public function HandleNewToken(Request $request)
    {
        return $this->useRefreshTokenMakeNewAccessToken($request->refresh_token);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function profile(Request $request)
    {
        return $request->user()->toArray();
    }
}
