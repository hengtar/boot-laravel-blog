<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 16:53
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class User extends Model
{

    protected $table= 'users';



    protected $fillable = ['id','status','name','email','password','remember_token','sort','true_name','role_id','photo'];


    //设置关键词状态
    const STATUS_ZERO       = 0;
    const STATUS_ONE        = 1;


    public function status($int = null)
    {
        $arr = [
            self::STATUS_ZERO      => "关闭",
            self::STATUS_ONE       => "开启",
        ];

        if ($int !== null){
            return array_key_exists($int, $arr) ? $arr[$int] : $arr[self::RECOMMEND_DEFAULT];
        }

        return $arr;
    }

    //route
    public function attributes($type,$order,$search)
    {
        return [
            'type'      => $type,
            'order'     => $type  && $order == 'desc' ? 'asc' : 'desc',
            'search'    => $search
        ];
    }

}