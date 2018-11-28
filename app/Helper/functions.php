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


/**
 * [tree]
 * @Notes  : [ 无限极分类函数 ]
 * @Author : [lao.zh-ang] [852952656@qq.com]
 * @Time   : 2018\11\13 0013 -- 12:51
 * @param $cate
 * @param string $lefthtml
 * @param int $pid
 * @param int $lvl
 * @param int $leftpin
 * @return   array
 */
function tree($cate , $lefthtml = ' — — ' , $pid=0 , $lvl=0, $leftpin=0 ){

    $arr=array();
    foreach ($cate as $v){


        if($v['p_id'] == $pid){
            $v['lvl']=$lvl + 1;
            $v['leftpin']=$leftpin + 0;
            $v['lefthtml']=str_repeat($lefthtml,$lvl);
            $arr[]=$v;
            $arr= array_merge($arr,tree($cate,$lefthtml,$v['id'],$lvl+1 , $leftpin+20));
        }
    }

    return $arr;
}


/**
 * [tree]
 * @Notes  : [ 无限极分类函数 ]
 * @Author : [lao.zh-ang] [852952656@qq.com]
 * @Time   : 2018\11\13 0013 -- 12:51
 * @param $cate
 * @param string $lefthtml
 * @param int $pid
 * @param int $lvl
 * @param int $leftpin
 * @return   array
 */
function treeParent($cate , $lefthtml = ' — — ' , $pid=0 , $lvl=0, $leftpin=0 ){

    $arr=array();
    foreach ($cate as $v){


        if($v['parent_id'] == $pid){
            $v['lvl']=$lvl + 1;
            $v['leftpin']=$leftpin + 0;
            $v['lefthtml']=str_repeat($lefthtml,$lvl);
            $arr[]=$v;
            $arr= array_merge($arr,treeParent($cate,$lefthtml,$v['id'],$lvl+1 , $leftpin+20));
        }
    }

    return $arr;
}




function prepareMenu($param)
{
    $parent = []; //父类
    $child = [];  //子类

    foreach($param as $key=>$vo){

        if($vo['parent_id'] == 0){
            $vo['route'] = '#';
            $parent[] = $vo;
        }else{
            $child[] = $vo;
        }
    }

    foreach($parent as $key=>$vo){
        foreach($child as $k=>$v){

            if($v['parent_id'] == $vo['id']){
                $parent[$key]['child'][] = $v;
            }
        }
    }
    unset($child);
    return $parent;
}



function authMenu($param)
{
    $parent = []; //父类
    $child = [];  //子类

    foreach($param as $key=>$vo){

        if($vo['p_id'] == 0){
            $parent[] = $vo;
        }else{
            $child[] = $vo;
        }
    }

    foreach($parent as $key=>$vo){
        foreach($child as $k=>$v){
            if($v['p_id'] == $vo['id']){
                $parent[$key]['child'][] = $v;
            }
        }
    }

    return $parent;
}


/**
 * 将返回的数据集转换成树
 * @param  array   $list  数据集
 * @param  string  $pk    主键
 * @param  string  $pid   父节点名称
 * @param  string  $child 子节点名称
 * @param  integer $root  根节点ID
 * @return array          转换后的树
 */
function list_to_tree($list, $pk = 'id', $pid = 'p_id', $child = '_child', $root=0) {
    $tree = array();// 创建Tree
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[$data[$pk]] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}


/**
 * 将返回的数据集转换成树
 * @param  array   $list  数据集
 * @param  string  $pk    主键
 * @param  string  $pid   父节点名称
 * @param  string  $child 子节点名称
 * @param  integer $root  根节点ID
 * @return array          转换后的树
 */
function list_to_tree_parent($list, $pk = 'id', $pid = 'parent_id', $child = '_child', $root=0) {
    $tree = array();// 创建Tree
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[$data[$pk]] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}




function giveArray($array){
    $return=[];
    array_walk_recursive($array,function($value,$key)use(&$return){
        if($key=='id')
            $return[]=$value;
    });

    return $return;
}