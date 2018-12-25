<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKeyword extends FormRequest
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

            'keyword' => 'required|max:500',
            'views' => 'numeric|nullable|max:9999999999',
            'sort' => 'numeric|nullable|max:100',
        ];
    }

    public function messages()
    {
        return [

            'keyword.required' => '关键词必填',
            'keyword.max' => '关键词最长为255个字符',
            'views.numeric' => '浏览量必须是数字',
            'views.max' => '浏览量最大是9999999999',
            'sort.numeric' => '排序必须是数字',
            'sort.max' => '排序最大是100',
        ];
    }


    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        exit(json_encode(array(
            'success' => false,
            'msg' => 'validator error',
            'errors' => $validator->getMessageBag()->toArray()
        )));
    }
}
