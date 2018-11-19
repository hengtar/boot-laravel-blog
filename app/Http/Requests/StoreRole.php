<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class StoreRole extends FormRequest
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
            'name' => ['required','max:255','string',Rule::unique('roles')->ignore($this->get('id'))],
            'chinese_name' => ['required','max:255','string',Rule::unique('roles')->ignore($this->get('id'))],
            'guard_name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '角色英文名称必填',
            'name.unique' => '角色英文名称已存在',
            'name.max' => '角色英文名称最长为255个字符',
            'name.string' => '角色英文名称:请填写字符串',

            'chinese_name.required' => '角色名称必填',
            'chinese_name.unique' => '角色名称已存在',
            'chinese_name.max' => '角色名称最长为255个字符',
            'chinese_name.string' => '角色名称:请填写字符串',

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
