<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreSeo extends FormRequest
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
            'title'         => 'required|max:500',
            'keywords'      => 'required|max:255',
            'summary'       => 'required|max:500',
            'icp'           => 'max:1000',
            'copyright'     => 'required|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'SEO标题必填',
            'title.max' => 'SEO标题最长为500个字符',
            'keywords.required' => 'SEO关键词必填',
            'keywords.max' => 'SEO关键词最长为255个字符',
            'summary.required' => 'SEO描述必填',
            'summary.max' => 'SEO描述最长为1000个字符',
            'icp.max' => 'SEO-ICP最长为1000个字符',
            'copyright.required' => 'SEO版权声明必填',
            'copyright.max' => 'SEO版权声明255个字符',
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
