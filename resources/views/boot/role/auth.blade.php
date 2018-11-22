@extends('boot.layouts.base')

@section('title','权限分配')
@section('css')
    <link rel="stylesheet" href="{{ asset('/static/boot/tree/lay/css/layui.css') }}"/>
@endsection
@section('body')

    @if(Session::get('success'))
        <div class="alert alert-success " >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>成功! </strong> &nbsp;&nbsp;{{ Session::get('success') }}
        </div>
    @endif

    @if(Session::get('error'))
        <div class="alert alert-danger alert-dismissable col-sm-2" style="float: right">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>失败! </strong> &nbsp;&nbsp;{{ Session::get('error') }}
        </div>
    @endif
    <div class="wrapper wrapper-content  animated fadeInRight">

        <div class="row">
            <div class="ibox-content" >
                <form action="{{ route('role-auth-store') }}" method="post" style="margin-left: 20px">
                    <ul id="auth"></ul>
                    {{ csrf_field() }}
                    <input type="hidden" name="role_id" value="{{ $roleInfo -> id }}">
                    <button type="submit" class="btn btn-success" style="margin-top: 50px;margin-left: 50px"><i class="fa fa-lock"></i> 分配权限
                    </button>

                </form>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/static/boot/tree/layui.js') }}" charset="utf-8"></script>
    <script>
        layui.use('tree', function () {
            var tree = layui.tree({
                elem: '#auth', //指定元素，生成的树放到哪个元素上
                check: 'checkbox', //勾选风格
                skin: 'as', //设定皮肤
                drag: true,//点击每一项时是否生成提示信息
                checkboxName: 'permission[]',//复选框的name属性值
                checkboxStyle: "",//设置复选框的样式，必须为字符串，css样式怎么写就怎么写
                click: function (item) { //点击节点回调
                    console.log("item")
                },
                onchange: function () {//当当前input发生变化后所执行的回调
                    console.log(this);
                },
                nodes: [ //节点

                        @foreach($permissions as $permission)
                    {
                        name: "{{ $permission['chinese_name'] }}",
                        @foreach($rolePermissions as $role)
                                @if($role['permission_id'] == $permission['id'])
                        checked: true,
                        @endif
                                @endforeach

                        spread: true,
                        checkboxValue: "{{ $permission['id'] }}",
                        @if(!empty($permission['_child']))
                        children: [
                                @foreach($permission['_child'] as $permissionChild)
                            {
                                name: "{{ $permissionChild['chinese_name'] }}",
                                @foreach($rolePermissions as $role)
                                        @if($role['permission_id'] == $permissionChild['id'])
                                checked: true,
                                @endif
                                        @endforeach
                                checkboxValue: "{{ $permissionChild['id'] }}",
                                spread: true,
                                @if(!empty($permissionChild['_child']))
                                children: [
                                        @foreach($permissionChild['_child'] as $permissionChildSon)
                                    {
                                        name: "{{ $permissionChildSon['chinese_name'] }}",
                                        @foreach($rolePermissions as $role)
                                                @if($role['permission_id'] == $permissionChildSon['id'])
                                        checked: true,
                                        @endif
                                                @endforeach
                                        checkboxValue: "{{ $permissionChildSon['id'] }}",
                                        spread: false,
                                    },
                                    @endforeach
                                ],
                                @endif
                            },
                            @endforeach
                        ],
                        @endif

                    },
                    @endforeach

                ]
            });
        });
    </script>
@endsection
