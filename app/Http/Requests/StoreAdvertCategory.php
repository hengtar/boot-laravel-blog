<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertCategory extends FormRequest
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
            'category' => 'required|max:500',
            'keywords' => 'max:500',
            'summary' => 'max:1000',
            'sort' => 'numeric|nullable',
        ];
    }

    public function messages()
    {
        return [
            'category.required' => '分类标题必填',
            'category.max' => '分类标题最长为500个字符',
            'keywords.max' => '分类关键词最长为255个字符',
            'summary.max' => '分类描述最长为1000个字符',
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
