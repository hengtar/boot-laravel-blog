@extends('boot.layouts.base')

@section('title','权限分配')

@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h5>分配权限</h5>
                    </div>
                    <div class="panel-body">
                        <p><strong>分配权限说明：</strong>通过拖动后台权限的菜单到角色权限中进行权限分配 </p>
                        <p><strong>注：</strong>分配权限不支持权限排序等等，仅仅支持权限分配。</p>
                    </div>
                </div>
                {{--<div id="nestable-menu">--}}
                    {{--<button type="button" data-action="expand-all" class="btn btn-white btn-sm">展开所有</button>--}}
                    {{--<button type="button" data-action="collapse-all" class="btn btn-white btn-sm">收起所有</button>--}}
                {{--</div>--}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>角色权限</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable">
                            <ol class="dd-list" >
                                <li class="dd-item" data-id="0">
                                    <div class="dd-handle">
                                        test
                                    </div>
                                </li>
                            @foreach($rolePermission as $rolePerm)
                                <li class="dd-item" data-id="{{ $rolePerm['id'] }}">
                                    <div class="dd-handle">{{ $rolePerm['chinese_name'] }}</div>
                                    @if(!empty($rolePerm['child']))
                                        <ol class="dd-list">
                                            @foreach($rolePerm['child'] as $rolePermChild)
                                                <li class="dd-item" data-id="{{ $rolePermChild['id'] }}">
                                                    <div class="dd-handle">{{ $rolePermChild['chinese_name'] }}</div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif

                                </li>
                            @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>后台权限</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                <li class="dd-item" data-id="0">
                                    <div class="dd-handle">
                                            test
                                    </div>
                                </li>
                            @foreach($permissions as $permission)
                                <li class="dd-item" data-id="{{ $permission['id'] }}">
                                    <div class="dd-handle">
                                        {{--<span class="label label-info"><i class="fa fa-cog"></i></span> --}}
                                        {{ $permission['chinese_name'] }}
                                    </div>
                                    @if(!empty($permission['child']))
                                        <ol class="dd-list">
                                            @foreach($permission['child'] as $value)
                                            <li class="dd-item" data-id=" {{ $value['id'] }}">
                                                <div class="dd-handle">
                                                    {{ $value['chinese_name'] }}
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
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
    <script src="{{ asset('/static/boot/js/content.min.js') }}"></script>
    <script src="{{ asset('/static/boot/js/plugins/nestable/jquery.nestable.js') }}"></script>
    <script>

        $(document).ready(function () {
            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target), output = list.data("output");
                if (window.JSON) {
                    var string = window.JSON.stringify(list.nestable("serialize"));
                    $.ajax({
                        url: "{{ route('role-auth-store') }}",
                        type: 'post',
                        dataType: 'json',
                        data: {string: string,_token:"{{ csrf_token() }}",role_id:"{{ $role -> id }}"},
                        success:function (res) {
                            if (res.success == true){
                                $('#nestable-output').val(res.msg);
                            } else {
                                $('#nestable-output').val(res.msg);
                            }
                        }
                    });

                } else {
                    output.val("浏览器不支持")
                }
            };

            $("#nestable").nestable({group: 1}).click("change", updateOutput);
            $("#nestable2").nestable({group: 1}).on("change");

            updateOutput($("#nestable").data("output", $("#nestable-output")));
            updateOutput2($("#nestable2").data("output", $("#nestable2-output")));


            // $("#nestable-menu").on("click", function (e) {
            //     var target = $(e.target), action = target.data("action");
            //     if (action === "expand-all") {
            //         $(".dd").nestable("expandAll")
            //     }
            //     if (action === "collapse-all") {
            //         $(".dd").nestable("collapseAll")
            //     }
            // })
        });
    </script>
@endsection
