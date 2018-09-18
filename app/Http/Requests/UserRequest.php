<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
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
    public function rules(Request $request)
    {
        $rules = [];
        switch ($request->method) {
            case 'POST':
            case 'PUT':
                $rules = [
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore(Auth::id()),
                    ],
                    'name' => 'min:2|max:6',
                    'introduce' => 'min:6|max:200',
                ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'introduce.min' => '个人介绍 至少6个字符',
            'introduce.max' => '个人介绍 最多200个字符',
        ];
    }
}
