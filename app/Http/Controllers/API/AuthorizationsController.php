<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\SocialAuthorizationRequest;
use App\Models\User;
use App\Traits\PassportToken;
use Auth;

class AuthorizationsController extends Controller
{
    use PassportToken;
    //登录,测试微信登录，可以使用code 或者 access_token + openid的方式
    public function socialsStore($type, SocialAuthorizationRequest $request)
    {
      if (!in_array($type, ['weixin'])) {
        return $this->response->errorBadRequest();
      }

      $driver = \Socialite::driver($type);

      try{
        if($code = $request->code) {
          $response = $driver->getAccessTokenResponse($code);
          $token = array_get($response, 'access_token');
        } else {
          $token = $request->access_token;

          if ($type == 'weixin') {
            $driver->setOpenId($request->openid);
          }
        }

        $oauthUser = $driver->userFromToken($token);

      } catch (\Exception $e) {
        return $this->response->errorUnauthorized('参数错误，未获取用户信息');
      }

      switch ($type) {
        case 'weixin':
          $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;
          if ($unionid) {
            $user = User::where('weixin_unionid', $unionid)->first();
          }  else {
            $user = User::where('weixin_openid', $oauthUser->getId())->first();
          }

          if (!$user) {
            $user = User::create([
              'name' => $oauthUser->getNickname(),
              'avatar' => $oauthUser->getAvatar(),
              'weixin_openid' => $oauthUser->getId(),
              'weixin_unionid' => $unionid
            ]);
          }
          break;
      }
      $result = $this->getBearerTokenByUser($user, '1', false);
      return $this->response->array($result)->setStatusCode(201);
    }
}
