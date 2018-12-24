<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class StoreMenu extends FormRequest
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
            'title' => ['required','max:255','string',Rule::unique('boot_menu')->ignore($this->get('id'))],
            'route' => ['required','max:255','string',Rule::unique('boot_menu')->ignore($this->get('id'))],
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

            'route.required' => '菜单路由别名必填',
            'route.unique' => '菜单路由别名已存在',
            'route.max' => '菜单路由别名最长为255个字符',
            'route.string' => '菜单路由别名:请填写字符串',

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
