<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\Http\Requests\API\UserRequest;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\TransFormers\UserTransFormer;
use Auth;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $cache = Cache::get($request->verification_key);

        if (!$cache) {
            //判断key 与缓存中是否一致
            $this->response->error('验证码失效', 422);
        }

        if (!hash_equals($request->verification_code, $cache['code'])) {
            $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
        'name' => $request->name,
        'phone' => $cache['phone'],
        'password' => Hash::make($request->password)
      ]);

        //清除缓存
        Cache::forget($request->verification_key);

        $this->response->created();
    }

    public function me()
    {
        $meta = [];
        return $this->response->item($this->user(), new UserTransFormer);
    }

    public function update(UserRequest $request)
    {
        $user = $this->user();
        $attributes = $request->all();
        if ($request->avatar_image_id && $request->avatar_image_id != $user->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);
            $attributes['avatar'] = $image->path;
        }
        $user->update($attributes);
        return $this->response->item($user, new UserTransFormer);
    }

    public function activedUsers(User $user)
    {
        $users = $user->activedUsers();
        return $this->response->collection($users, new UserTransFormer);
    }
}
