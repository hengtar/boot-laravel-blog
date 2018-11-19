<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class StoreUser extends FormRequest
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
            'name' => ['required','max:255','string','alpha_num',Rule::unique('users')->ignore($this->get('id'))],
            'email' => ['required','max:255','string','email',Rule::unique('users')->ignore($this->get('id'))],
            'password' => 'required|string|min:6',
            'true_name' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名必填',
            'name.unique' => '用户名已存在',
            'name.max' => '用户名最长为255个字符',
            'name.string' => '请填写字符串',
            'email.required' => '邮箱必填',
            'email.string' => '请填写字符串',
            'email.email' => '请填写正确的邮箱',
            'email.unique' => '邮箱已存在',
            'password.required' => '用户密码必填',
            'password.string' => '请填写字符串',
            'password.min' => '密码最少6个字符',
            'true_name.required' => '真实姓名必填',
            'true_name.max' => '真实姓名最长为255个字符',
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
