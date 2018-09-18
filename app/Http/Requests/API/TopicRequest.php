<?php

namespace App\Http\Requests\API;

use Dingo\Api\Http\FormRequest;

class TopicRequest extends FormRequest
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
        return [
            'title' => 'required|min:2|max:20',
            'body' => 'required|min:6',
            'category_id' => 'exists:categories,id'
        ];
    }

    public function attributes()
    {
      return [
        'category_id' => '分类'
      ];
    }
}
