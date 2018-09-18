<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\API\VerificationCodeRequest;
use App\Http\Controllers\API\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, User $user)
    {
      $code = str_pad(str_random(1, 9999), 4, 0, STR_PAD_LEFT);

      $key = 'verifyCode_'.str_random(10);

      $expiredAt = now()->addMinutes(10);//10分钟过期
      Cache::put($key, ['phone' => $request->phone, 'code' => $code], $expiredAt);

      return $this->response->array([
        'key' => $key,
        'code' => $code
      ])->setStatusCode(201);
    }
}
