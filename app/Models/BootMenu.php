<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 16:53
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BootMenu extends Model
{

    protected $table= 'boot_menu';

//    use SoftDeletes;
//    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
//
//    protected $dates= ['deleted_at'];
//
//    protected $fillable = ['id','p_id','status','keywords','summary','photo','category','sort'];
//
//    protected $softCascade = ['article'];
//
//
//
//    //设置分类状态
//    const STATUS_ZERO       = 0;
//    const STATUS_ONE        = 1;
//
//
//    public function status($int = null)
//    {
//        $arr = [
//            self::STATUS_ZERO      => "关闭",
//            self::STATUS_ONE       => "开启",
//        ];
//
//        if ($int !== null){
//            return array_key_exists($int, $arr) ? $arr[$int] : $arr[self::RECOMMEND_DEFAULT];
//        }
//
//        return $arr;
//    }
//
//    //route
//    public function attributes($recover,$type,$order,$search)
//    {
//        return [
//            'recover'   => $recover == false ? 0 : 1,
//            'type'      => $type,
//            'order'     => $type  && $order == 'desc' ? 'asc' : 'desc',
//            'search'    => $search
//        ];
//    }
//
//    //use \Askedio\SoftCascade\Traits\SoftCascadeTrait;    使用  protected $softCascade = ['article'];
//    public function article()
//    {
//        return $this->hasOne('App\Models\Article','category_id','id');
//
//    }



}