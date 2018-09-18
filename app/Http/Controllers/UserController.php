<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Image;
use App\Handlers\ImageUploadHandler;
use App\Rules\Oldpassword;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = Auth::user();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.index', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user = Auth::user();
        $user->fill($request->all());
        $user->introduce = $request->introduce;
        $user->save();
        return redirect()->route('users.edit', ['user' => Auth::id()])->with('success', '资料修改成功');
    }

    /**
     * 修改头像
     */
    public function edit_avatar()
    {
        $user = Auth::user();
        return view('users.edit_avatar', compact('user'));
    }

    /**
     * 保存修改的头像
     */
    public function update_avatar(Request $request, ImageUploadHandler $uploader)
    {
        $request->validate([
          'avatar' => 'required|file|mimes:jpeg,jpg,png|dimensions:min_width=300,min_height=300'
        ], [
          'avatar.mimes' => '文件类型不正确，仅支持png,jpg格式'
        ]);

        if ($request->avatar) {
          $result = $uploader->save($request->avatar,"users","user",300);
          if ($result) {
            $user = Auth::user();
            $user->avatar = $result;
            $user->save();
          }
        }

        return redirect()->route('users.edit_avatar')->with('success', '头像上传成功');
    }

    public function edit_password()
    {
      $user = Auth::user();
      return view('users.edit_password', compact('user'));
    }

    public function update_password(Request $request)
    {
      $request->validate([
        'old_password' => ['required', new Oldpassword],
        'password' => [
          'required',
          'min:6',
          'max:20',
          // 'regex:/^[A-Za-z_]{6,20}$/'
        ]
      ], [
        'password.regex' => '密码格式错误，必须以英文字母或者下划线开头'
      ]);
      $user = Auth::user();
      $user->password = Hash::make($request->password);
      $user->save();
      return redirect()->route('users.edit_password')->with('success', '密码修改成功');
    }
}
