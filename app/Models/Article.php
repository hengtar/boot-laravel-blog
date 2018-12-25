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


class Article extends Model
{
    use SoftDeletes;

    protected $table= 'articles';

    protected $dates= ['deleted_at'];

    protected $fillable = ['id','category_id','status','title','keywords','summary','content','tips','views','author','photo','recommend','sort'];

    //设置推荐位
    const RECOMMEND_DEFAULT = 0;
    const RECOMMEND_ONE     = 1;
    const RECOMMEND_TWO     = 2;
    const RECOMMEND_THREE   = 3;
    const RECOMMEND_FOUR    = 4;

    //设置文章状态
    const STATUS_ZERO       = 0;
    const STATUS_ONE        = 1;


    /**
     * [recommend]
     * @Notes  : [ 选择推荐位]
     * @Author : [lao.zh-ang] [852952656@qq.com]
     * @Time   : 2018\11\5 0005 -- 10:00
     * @param null $int
     * @return   array|mixed
     */
    public function recommend($int = null)
    {
        $arr = [
            self::RECOMMEND_DEFAULT => '未推荐',
            self::RECOMMEND_ONE     => '推荐一',
            self::RECOMMEND_TWO     => '推荐二',
            self::RECOMMEND_THREE   => '推荐三',
            self::RECOMMEND_FOUR    => '推荐四',
        ];

        if ($int !== null){
            return array_key_exists($int, $arr) ? $arr[$int] : $arr[self::RECOMMEND_DEFAULT];
        }

        return $arr;
    }

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
    public function attributes($recover,$type,$order,$search)
    {
        return [
            'recover'   => $recover == false ? 0 : 1,
            'type'      => $type,
            'order'     => $type  && $order == 'desc' ? 'asc' : 'desc',
            'search'    => $search
        ];
    }


    /**
     * [category]
     * @Notes  : [ 关联分类 ]
     * @Author : [lao.zh-ang] [852952656@qq.com]
     * @Time   : 2018\11\5 0005 -- 14:00
     * @return   \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id','id');
    }



}