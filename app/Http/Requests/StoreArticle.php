<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticle extends FormRequest
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
            'author' => 'required|max:255',
            'keywords' => 'required|max:500',
            'summary' => 'required|max:1000',
            'content' => 'required',
            'views' => 'numeric|nullable',
            'sort' => 'numeric|nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '文章标题必填',
            'title.max' => '文章标题最长为500个字符',
            'author.required' => '文章作者必填',
            'author.max' => '文章作者最长为255个字符',
            'keywords.required' => '文章关键词必填',
            'keywords.max' => '文章关键词最长为255个字符',
            'summary.required' => '文章描述必填',
            'summary.max' => '文章描述最长为1000个字符',
            'content.required' => '文章内容必填',
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
