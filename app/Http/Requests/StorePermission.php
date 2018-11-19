<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class StorePermission extends FormRequest
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
            'name' => ['required','max:255','string',Rule::unique('permissions')->ignore($this->get('id'))],
            'chinese_name' => ['required','max:255','string',Rule::unique('permissions')->ignore($this->get('id'))],
            'guard_name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'chinese_name.required' => '权限名称必填',
            'chinese_name.unique' => '权限名称已存在',
            'chinese_name.max' => '权限名称最长为255个字符',
            'chinese_name.string' => '权限名称:请填写字符串',

            'name.required' => '权限路由别名必填',
            'name.unique' => '权限路由别名已存在',
            'name.max' => '权限路由别名最长为255个字符',
            'name.string' => '权限路由别名:请填写字符串',

            'guard_name.required' => '守护者必填',
            'guard_name.string' => '守护者:请填写字符串',
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
