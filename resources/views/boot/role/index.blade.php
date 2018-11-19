@extends('boot.layouts.base')

@section('title','用户列表')
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

                <h5>角色列表 {{ $search  ? "/ 角色搜索" : ""}}</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-2" style="width: 100px">
                            <div class="input-group">
                                <a href="{{ route('role-create') }}">
                                    <button class="btn btn-outline btn-danger" type="button">添加角色</button>
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
                        <form method="post" action="{{ route('role-sort') }}">
                            {{ csrf_field() }}
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="3%"><input type="checkbox" name="chk_all" id="chk_all"/></th>
                                    <th width="5%" class="center"><a
                                                href="{{ route('role-index', $RoleOrm ->attributes('sort',$order,$search)) }}">排序</a>
                                    </th>
                                    <th width="5%"><a
                                                href="{{ route('role-index', $RoleOrm ->attributes('id',$order,$search)) }}">ID</a>
                                    </th>
                                    <th>角色名称</th>
                                    <th>角色英文名称</th>
                                    <th>守护者</th>


                                    <th width="13%"><a
                                                href="{{ route('role-index',$RoleOrm ->attributes('created_at',$order,$search)) }}">创建时间</a>
                                    </th>
                                    <th width="8%"><a
                                                href="{{ route('role-index',$RoleOrm ->attributes('status',$order,$search)) }}">状态</a>
                                    </th>

                                    <th width="8%">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($Roles as $Role)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="chk_list" class="chk_list"
                                                       id="chk_list_{{ $Role -> id }}" value="{{ $Role -> id }}"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control center"
                                                       name="sort[{{ $Role -> id }}]" value="{{ $Role -> sort }}">
                                            </td>
                                            <th>{{ $Role -> id }}</th>
                                            <td>{{ $Role -> chinese_name }}</td>
                                            <td>{{ $Role -> name }}</td>
                                            <td>{{ $Role -> guard_name }}</td>


                                            <td>{{ $Role -> created_at }}</td>

                                            <th>{{ $Role -> status($Role -> status) }}</th>
                                            <td>
                                                <a class="btn btn-primary btn-outline btn-xs "
                                                   href="{{ route('role-edit',['id' => $Role->id ]) }}"
                                                   title="分配权限">
                                                    <i class="fa fa-lock"></i>
                                                </a>
                                                <span>|</span>
                                                    <a class="btn btn-primary btn-outline btn-xs "
                                                       href="{{ route('role-edit',['id' => $Role->id ]) }}"
                                                       title="编辑">
                                                        <i class="fa fa-paste"></i>
                                                    </a>
                                                <span>|</span>
                                                <a href="{{ route('role-destroy',['id' => $Role -> id]) }}"
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
                                    {{ $Roles ->links() }}
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
                window.location.href = "{{ route('role-destroy',['id' => '']) }}/" + deleteId;
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

            window.location.href = "{{ route('role-index') }}/0/0/" + search;
        }
    </script>
@endsection
