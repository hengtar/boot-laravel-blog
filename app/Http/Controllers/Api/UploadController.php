<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\6 0006
 * Time: 13:35
 */

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class UploadController
{

    public function localhost(Request $request)
    {
        $path = $request->file('file')->store('/public/'.date('Ymd',time()));


        return '/'.str_replace('public','storage',$path);
    }
}