@extends('boot.layouts.base')

@section('title','文章列表')
@section('css')
    <style>
        .alert {
            margin-bottom: -20px;
        }
    </style>
@endsection
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $recover == false ? "文章列表" : "文章回收站"}}</h5>
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
                                @if ($recover == false)
                                    <a onclick="deleteAll()">
                                        <button class="btn btn-outline btn-warning" type="button">批量删除</button>
                                    </a>
                                @else
                                    <a onclick="ForceDeleteAll()">
                                        <button class="btn btn-outline btn-warning" type="button">永久删除</button>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2" style="width: 100px">
                            <div class="input-group">
                                @if ($recover == false)
                                    <a href="{{ route('article-index',['recover' => true]) }}">
                                        <button class="btn  btn-default" type="button"><i class="fa fa-trash-o" ></i> 回收站</button>
                                    </a>
                                @else
                                    <a href="{{ route('article-index') }}">
                                        <button class="btn  btn-info" type="button"><i class="fa fa-list-alt" ></i> &nbsp;列 表</button>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <form name="admin_list_sea" class="form-search col-sm-3" method="post" action="">
                            <div class="col-sm-3">
                                <div class="input-group" style="width: 270px">
                                    <input type="text" id="title" class="form-control" name="title" value="" placeholder="输入文章标题" />
                                    <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> 搜索</button>
                                </span>
                                </div>
                            </div>
                        </form>
                        @include('boot.layouts.prompt')

                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="example-wrap">
                    <div class="example">
                        <table class="table table-hover">
                            <thead>
                            <tr class="lzCenter-th">
                                <th><input type="checkbox" name="chk_all" id="chk_all" /></th>
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
                                <td>
                                    <input type="checkbox" name="chk_list" class="chk_list" id="chk_list_{{ $article -> id }}" value="{{ $article -> id }}" /></td>
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

                                    @if ($recover == false)
                                        <a class="btn btn-primary btn-outline btn-xs "
                                           href="{{ route('article-edit',['id' => $article->id ]) }}" title="修改">
                                            <i class="fa fa-paste"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-primary btn-outline btn-xs "
                                           href="{{ route('article-restore',['id' => $article -> id]) }}" onclick="return confirm('确定恢复?');"  title="恢复">
                                            <i class="fa fa-undo"></i>
                                        </a>
                                    @endif
                                    <span>|</span>
                                    <a href="{{ $recover == false ? route('article-destroy',['id' => $article -> id]) : route('article-ForceDelete',['id' => $article -> id])}}" class="btn btn-warning btn-outline btn-xs delArtciel" onclick="return confirm('确定删除?');" title="删除">
                                        <i class="fa fa-trash-o" ></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div style="text-align: right">
                        {{ $articles ->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        //chk_all
        $("#chk_all").click(function() {
            if (this.checked) {
                $("input[name='chk_list']:checkbox").each(function() {
                    $(this).attr("checked", true);
                    $(this).prop("checked",true);
                })
            } else {
                $("input[name='chk_list']:checkbox").each(function() {
                    $(this).attr("checked", false);
                    $(this).prop("checked",false);
                })
            }
        });

        //deleteAll
        function deleteAll(){
            var  deleteId = 'null,';
            $("input[name='chk_list']:checked").each(function(j) {
                if (j >= 0) {
                    deleteId += $(this).val() + ",";
                }
            });

            if (deleteId == 'null,'){
                $('.alert.alert-danger').css("display","block");
                $('#info').html('暂未选择数据');
                return false;
            }

            if (confirm('确定批量删除?')){
                window.location.href = "{{ route('article-destroy',['id' => '']) }}/" +deleteId;
            }else{
                return false;
            }
        }

        function ForceDeleteAll(){
            var  deleteId = 'null,';
            $("input[name='chk_list']:checked").each(function(j) {
                if (j >= 0) {
                    deleteId += $(this).val() + ",";
                }
            });

            if (deleteId == 'null,'){
                $('.alert.alert-danger').css("display","block");
                $('#info').html('暂未选择数据');
                return false;
            }

            if (confirm('确定批量删除?')){
                window.location.href = "{{ route('article-ForceDelete',['id' => '']) }}/" +deleteId;
            }else{
                return false;
            }
        }
    </script>
@endsection
