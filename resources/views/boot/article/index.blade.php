@extends('boot.layouts.base')

@section('title','文章列表')

@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>文章列表</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-2" style="width: 100px">
                            <div class="input-group">
                                <a href="">
                                    <button class="btn btn-outline btn-danger" type="button">添加文章</button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-2" style="width: 100px">
                            <div class="input-group">
                                <a href="">
                                    <button class="btn btn-outline btn-warning" type="button">批量删除</button>
                                </a>
                            </div>
                        </div>

                        <form name="admin_list_sea" class="form-search" method="post" action="">
                            <div class="col-sm-3">
                                <div class="input-group" style="width: 270px">
                                    <input type="text" id="title" class="form-control" name="title" value="" placeholder="输入文章标题" />
                                    <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> 搜索</button>
                                </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="example-wrap">
                    <div class="example">
                        <form action="/admin/article/sort.html" method="post" id="up_sort">
                            <table class="table table-hover">
                                <thead>
                                <tr class="lzCenter-th">
                                    <th>选择</th>
                                    <th width="5%">排序</th>
                                    <th>ID</th>
                                    <th width="20%">标题</th>
                                    <th>所属分类</th>
                                    <th>文章封面</th>
                                    <th width="10%">发布时间</th>

                                    <th>浏览量</th>
                                    <th>状态</th>
                                    <th>推荐位置</th>
                                    <th>操作</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <td ><input type="text" value="0" name="sort-9404" class="form-control" id="sort_id" param="9404"></td>
                                    <th>9404</th>
                                    <td>充值协议</td>
                                    <td>世界看点</td>
                                    <td>
                                        <img src="http://bvrcn.oss-cn-beijing.aliyuncs.com/8272c00ed2d54a208fffdc6f35dd98cfed9569bc.jpeg" height="30" width="80">
                                    </td>
                                    <td>2018-11-02 10:19:35</td>

                                    <td>531</td>
                                    <td>
                                        <a class="btn btn-danger btn-outline btn-xs statusArtciel" id="status-9404">
                                            <i class="fa fa-hand-o-down"></i> 已关闭
                                        </a>

                                    </td>
                                    <td>
                                       热点活动
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-outline btn-xs "
                                           href="" title="修改">
                                            <i class="fa fa-paste"></i>
                                        </a>
                                        |
                                        <a class="btn btn-warning btn-outline btn-xs delArtciel" title="删除">
                                            <i class="fa fa-trash-o" ></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div style="text-align: left">
                                <td colspan="7">
                                    <button type="submit" class="btn btn-outline btn-success" >排序</button>
                                </td>
                            </div>
                        </form>

                    </div>

                    <div style="text-align: right">
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection


