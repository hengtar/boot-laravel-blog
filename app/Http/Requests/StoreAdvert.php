<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvert extends FormRequest
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
            'title' => 'required|max:500',
            'keywords' => 'required|max:500',
            'summary' => 'required|max:1000',
            'views' => 'numeric|nullable',
            'sort' => 'numeric|nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '广告标题必填',
            'title.max' => '广告标题最长为500个字符',
            'keywords.required' => '广告关键词必填',
            'keywords.max' => '广告关键词最长为255个字符',
            'summary.required' => '广告描述必填',
            'summary.max' => '广告描述最长为1000个字符',
            'views.numeric' => '浏览量必须是数字',
            'sort.numeric' => '排序必须是数字',
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
