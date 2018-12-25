<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 16:53
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Role extends Model
{

    protected $table= 'roles';



    protected $fillable = ['id','status','name','guard_name','chinese_name','sort'];


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


    public function getUserChineseName($id)
    {


        $userRole = \DB::table('model_has_roles')->where('model_id',$id)->first();

        return  $this->find($userRole -> role_id) -> chinese_name;

    }

}