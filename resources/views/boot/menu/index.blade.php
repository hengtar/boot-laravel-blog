@extends('boot.layouts.base')

@section('title','菜单管理')
@section('css')

@endsection
@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="ibox float-e-margins col-sm-10">
            <div class="ibox-title">

                <h5>后端菜单 {{ $search  ? "/ 菜单搜索" : ""}}</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-2" style="width: 100px">
                            <div class="input-group">
                                <a href="{{ route('menu-create') }}">
                                    <button class="btn btn-outline btn-danger" type="button">添加菜单</button>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-2" style="width: 100px">
                            <div class="input-group">
                                <a onclick="deleteAll()">
                                    <button class="btn btn-outline btn-warning" type="button">批量删除</button>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="input-group" style="width: 270px">
                                <input type="text" class="form-control" id="search" name="title" value="{{ $search }}"
                                       placeholder="Search"/>
                                <span class="input-group-btn">
                                    <a onclick="searchArticle()">
                                          <button class="btn  btn-info" type="button"><i class="fa fa-search"></i> Search</button>
                                    </a>
                                </span>
                            </div>
                        </div>

                        @include('boot.layouts.prompt')
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="example-wrap">
                    <div class="example">
                        <form method="post" action="{{ route('menu-sort') }}">
                            {{ csrf_field() }}
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="chk_all" id="chk_all"/></th>
                                    <th width="5%" class="center"><a
                                                href="{{ route('menu-index', $menuOrm ->attributes('sort',$order,$search)) }}">排序</a>
                                    </th>
                                    <th width="5%"><a
                                                href="{{ route('menu-index', $menuOrm ->attributes('id',$order,$search)) }}">ID</a>
                                    </th>
                                    <th>菜单名称</th>
                                    <th>菜单路由</th>


                                    <th width="13%"><a
                                                href="{{ route('menu-index',$menuOrm ->attributes('created_at',$order,$search)) }}">创建时间</a>
                                    </th>
                                    <th width="8%"><a
                                                href="{{ route('menu-index',$menuOrm ->attributes('status',$order,$search)) }}">状态</a>
                                    </th>

                                    <th width="8%">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($menusTree as $menuTree)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="chk_list" class="chk_list"
                                                   id="chk_list_{{ $menuTree['id'] }}" value="{{ $menuTree['id'] }}"/>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control center"
                                                   name="sort[{{ $menuTree['id'] }}]" value="{{ $menuTree['sort'] }}">
                                        </td>
                                        <th>{{ $menuTree['id'] }}</th>
                                        <td>{{ $menuTree['lefthtml'] }}{{ $menuTree['title'] }}</td>
                                        <td>{{ $menuTree['lefthtml'] }}{{ $menuTree['route'] }}</td>

                                        <td>{{ $menuTree['created_at'] }}</td>
                                        <th>{{ $menuOrm -> status($menuTree['created_at']) }}</th>
                                        <td>
                                            <a class="btn btn-primary btn-outline btn-xs "
                                               href="{{ route('menu-edit',['id' => $menuTree['id'] ]) }}"
                                               title="编辑">
                                                <i class="fa fa-paste"></i>
                                            </a>
                                            <span>|</span>
                                            <a href="{{ route('menu-destroy',['id' => $menuTree['id']]) }}"
                                               class="btn btn-warning btn-outline btn-xs delArtciel"
                                               onclick="return confirm('确定删除?');" title="删除">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                            <hr>
                            <div class="clearfix" style="line-height: 70px; margin-top: -20px;">
                                <div style="float: left">
                                    <button class="btn btn-outline btn-success" type="submit">排序</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>后台菜单</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                @foreach($menus as $menu)
                                    <li class="dd-item" data-id="1">
                                        <div class="dd-handle">
                                            <span class="label label-info"><i class="fa {{ $menu['icon'] }}"></i></span> {{ $menu['title'] }}
                                        </div>
                                        @if(!empty($menu['_child']))
                                            @foreach($menu['_child'] as $child)
                                        <ol class="dd-list">
                                            <li class="dd-item" data-id="2">
                                                <div class="dd-handle">
                                                    <span class="label label-info"></span> {{ $child['title'] }}
                                                </div>
                                            </li>
                                        </ol>
                                            @endforeach
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')


@endsection
