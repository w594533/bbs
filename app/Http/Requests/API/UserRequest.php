<?php

namespace App\Http\Requests\API;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      $user_id  = \Auth::guard('api')->id();
        switch ($this->method()) {
          case 'POST':
              return [
                'name' => 'required|string',
                'password' => 'required|string|min:6',
                'verification_key' => 'required|string',
                'verification_code' => 'required|string',
              ];
            break;
         case 'PATCH':
            return [
              'name' => 'required|string',
              'introduce' => 'string|min:6|max:200',
              'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$user_id,
              'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user_id),
              ]
            ];

          default:
            return [];
            break;
        }

    }

    // 主要是重写这个方法。
    // protected function failedValidation(Validator $validator)
    // {
    //   if ($validator->fails()) {
    //     // throw new HttpException(500, $validator->errors());
    //      //自行封装个处理验证失败返回值 类似下面
    //      $this->respondWithValidatorError($validator->errors());
    //   }
    // }

    public function attributes()
    {
      return [
        'verification_key' => '短信验证码 key',
        'verification_code' => '短信验证码',
        'introduce' => '个人介绍'
      ];
    }

    // public function messages()
    // {
    //   return [
    //     'introduce.min' => '个人介绍 至少6个字符'
    //   ];
    // }
}
