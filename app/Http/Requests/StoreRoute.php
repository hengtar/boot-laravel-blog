<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class StoreRoute extends FormRequest
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


       // dd($this->get('id'));
        return [
            'id' => ['required','numeric',Rule::unique('boot_menu')->ignore($this->get('id'))],
            'title' => ['required','max:255','string',Rule::unique('boot_menu')->ignore($this->get('id'))],
            'sort' => 'numeric|nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '菜单名称必填',
            'title.unique' => '菜单名称已存在',
            'title.max' => '菜单名称最长为255个字符',
            'title.string' => '菜单名称:请填写字符串',

            'id.required' => '菜单ID必填',
            'id.unique' => '菜单ID别名已存在',
            'id.numeric' => '菜单ID必须是数字(请填写分类ID)',

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
