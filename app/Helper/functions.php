<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\9 0009
 * Time: 14:07
 */


/**
 * [FormatDelete]
 * @Notes  : [ FormatDelete to Controller@destroy,@deleteForce ]
 * @Author : [lao.zh-ang] [852952656@qq.com]
 * @Time   : 2018\11\9 0009 -- 14:21
 * @param $id
 * @return   array|mixed|string
 */
function FormatDelete($id){

    if (substr($id, 0, 5) === "null,") {
        $id = str_replace("null,", "", $id);
        $id = rtrim($id, ',');
    }

    $id = is_array($id) ? $id : (is_string($id) ? explode(',', $id) : func_get_args());

    return $id;
}