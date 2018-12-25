<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 16:53
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Category extends Model
{
    protected $table= 'category';

    protected $dates= ['deleted_at'];

    protected $fillable = ['id','p_id','status','keywords','summary','photo','category','sort'];

    protected $softCascade = ['article'];



    //设置分类状态
    const STATUS_ZERO       = 0;
    const STATUS_ONE        = 1;


    public function status($int = null)
    {
        $arr = [
            self::STATUS_ZERO      => "关闭",
            self::STATUS_ONE       => "开启",
        ];

        if ($int !== null){
            return array_key_exists($int, $arr) ? $arr[$int] : $arr[self::STATUS_ONE];
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