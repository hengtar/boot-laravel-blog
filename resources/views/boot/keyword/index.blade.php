@extends('boot.layouts.base')

@section('title','词库列表')
@section('css')
    <style>
        .alert {
            margin-bottom: -20px;
        }

        .center {
            text-align: center;
        }
    </style>
@endsection
@section('body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <h5>词库列表 {{ $recover == false ? "" : "/ 词库回收站"}} {{ $search  ? "/ 词库搜索" : ""}}</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-2" style="width: 100px">
                            <div class="input-group">
                                <a href="{{ route('keyword-create') }}">
                                    <button class="btn btn-outline btn-danger" type="button">添加词库</button>
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
                                    <a href="{{ route('keyword-index',['recover' => true]) }}">
                                        <button class="btn  btn-default" type="button"><i class="fa fa-trash-o"></i> 回收站
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('keyword-index') }}">
                                        <button class="btn  btn-info" type="button"><i class="fa fa-list-alt"></i>
                                            &nbsp;列 表
                                        </button>
                                    </a>
                                @endif
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
                        <form method="post" action="{{ route('keyword-sort') }}">
                            {{ csrf_field() }}
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="chk_all" id="chk_all"/></th>
                                    <th width="5%" class="center"><a
                                                href="{{ route('keyword-index', $keywordOrm ->attributes($recover,'sort',$order,$search)) }}">排序</a>
                                    </th>
                                    <th width="5%"><a
                                                href="{{ route('keyword-index', $keywordOrm ->attributes($recover,'id',$order,$search)) }}">ID</a>
                                    </th>
                                    <th>关键词</th>

                                    <th width="13%"><a
                                                href="{{ route('keyword-index',$keywordOrm ->attributes($recover,'created_at',$order,$search)) }}">发布时间</a>
                                    </th>
                                    <th width="8%"><a
                                                href="{{ route('keyword-index',$keywordOrm ->attributes($recover,'views',$order,$search)) }}">点击量</a>
                                    </th>
                                    <th width="8%"><a
                                                href="{{ route('keyword-index',$keywordOrm ->attributes($recover,'status',$order,$search)) }}">状态</a>
                                    </th>

                                    <th width="8%">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($keywords as $keyword)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="chk_list" class="chk_list"
                                                       id="chk_list_{{ $keyword -> id }}" value="{{ $keyword -> id }}"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control center"
                                                       name="sort[{{ $keyword -> id }}]" value="{{ $keyword -> sort }}">
                                            </td>
                                            <th>{{ $keyword -> id }}</th>
                                            <td>{{ $keyword -> keyword }}</td>


                                            <td>{{ $keyword -> created_at }}</td>

                                            <td>{{ $keyword -> views }}</td>
                                            <th>{{ $keyword -> status($keyword -> status) }}</th>
                                            <td>
                                                @if ($recover == false)
                                                    <a class="btn btn-primary btn-outline btn-xs "
                                                       href="{{ route('keyword-edit',['id' => $keyword->id ]) }}"
                                                       title="编辑">
                                                        <i class="fa fa-paste"></i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-primary btn-outline btn-xs "
                                                       href="{{ route('keyword-restore',['id' => $keyword -> id]) }}"
                                                       onclick="return confirm('确定恢复?');" title="恢复">
                                                        <i class="fa fa-undo"></i>
                                                    </a>
                                                @endif
                                                <span>|</span>
                                                <a href="{{ $recover == false ? route('keyword-destroy',['id' => $keyword -> id]) : route('keyword-ForceDelete',['id' => $keyword -> id])}}"
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
                                <div style="float: right">
                                    {{ $keywords ->links() }}
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        //chk_all
        $("#chk_all").click(function () {
            if (this.checked) {
                $("input[name='chk_list']:checkbox").each(function () {
                    $(this).attr("checked", true);
                    $(this).prop("checked", true);
                })
            } else {
                $("input[name='chk_list']:checkbox").each(function () {
                    $(this).attr("checked", false);
                    $(this).prop("checked", false);
                })
            }
        });

        //deleteAll
        function deleteAll() {
            var deleteId = 'null,';
            $("input[name='chk_list']:checked").each(function (j) {
                if (j >= 0) {
                    deleteId += $(this).val() + ",";
                }
            });

            if (deleteId == 'null,') {
                $('.alert.alert-danger').css("display", "block");
                $('#info').html('暂未选择数据');
                return false;
            }

            if (confirm('确定批量删除?')) {
                window.location.href = "{{ route('keyword-destroy',['id' => '']) }}/" + deleteId;
            } else {
                return false;
            }
        }

        //ForceDeleteAll
        function ForceDeleteAll() {
            var deleteId = 'null,';
            $("input[name='chk_list']:checked").each(function (j) {
                if (j >= 0) {
                    deleteId += $(this).val() + ",";
                }
            });

            if (deleteId == 'null,') {
                $('.alert.alert-danger').css("display", "block");
                $('#info').html('暂未选择数据');
                return false;
            }

            if (confirm('确定批量删除?')) {
                window.location.href = "{{ route('keyword-ForceDelete',['id' => '']) }}/" + deleteId;
            } else {
                return false;
            }
        }


        function searchArticle() {
            var search = $('#search').val();
            if (search == '') {
                $('.alert.alert-danger').css("display", "block");
                $('#info').html('暂未输入数据');
                return false;
            }

            window.location.href = "{{ route('keyword-index') }}/{{ $recover == false ? 0 : 1 }}/0/0/" + search;
        }
    </script>
@endsection
