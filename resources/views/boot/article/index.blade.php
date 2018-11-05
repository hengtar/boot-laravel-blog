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
                                <a href="{{ route('article-create') }}">
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
                                    <th><input type="checkbox"></th>
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
                                @foreach($articles as $article)
                                <tr>
                                    <th><input type="checkbox" ></th>
                                    <th>{{ $article -> id }}</th>
                                    <td>{{ $article -> title }}</td>
                                    <td>{{ $article -> category -> category }}</td>
                                    <td>
                                        <img src="{{ $article -> photo }}" height="30" width="80" onError='this.src="{{ asset('/static/boot/img/no.png') }}"'>
                                    </td>
                                    <td>{{ $article -> created_at }}</td>

                                    <td>{{ $article -> views }}</td>
                                    <th>{{ $article -> status($article -> status) }}</th>
                                    <th>
                                        {{ $article ->recommend($article -> recommend) }}
                                    </th>
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
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div style="text-align: right">
                        {{ $articles ->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection


