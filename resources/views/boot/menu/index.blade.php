@extends('boot.layouts.base')

@section('title','菜单管理')
@section('css')

@endsection
@section('body')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-sm-4">
                <div id="nestable-menu">
                    <button type="button" data-action="expand-all" class="btn btn-white btn-sm">展开所有</button>
                    <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">收起所有</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>后台菜单</h5>
                    </div>
                    <div class="ibox-content">

                        <p class="m-b-lg">
                            后台菜单
                        </p>

                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                <li class="dd-item" data-id="1">
                                    <div class="dd-handle">
                                        <span class="label label-info"><i class="fa fa-users"></i></span> 群组
                                    </div>
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="2">
                                            <div class="dd-handle">
                                                <span class="pull-right"> 12:00 </span>
                                                <span class="label label-info"><i class="fa fa-cog"></i></span> 设置
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="3">
                                            <div class="dd-handle">
                                                <span class="pull-right"> 11:00 </span>
                                                <span class="label label-info"><i class="fa fa-bolt"></i></span> 筛选
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="4">
                                            <div class="dd-handle">
                                                <span class="pull-right"> 11:00 </span>
                                                <span class="label label-info"><i class="fa fa-laptop"></i></span> 电脑
                                            </div>
                                        </li>
                                    </ol>
                                </li>

                                <li class="dd-item" data-id="5">
                                    <div class="dd-handle">
                                        <span class="label label-warning"><i class="fa fa-users"></i></span> 用户
                                    </div>
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="6">
                                            <div class="dd-handle">
                                                <span class="pull-right"> 15:00 </span>
                                                <span class="label label-warning"><i class="fa fa-users"></i></span> 列用户表
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="7">
                                            <div class="dd-handle">
                                                <span class="pull-right"> 16:00 </span>
                                                <span class="label label-warning"><i class="fa fa-bomb"></i></span> 炸弹
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="8">
                                            <div class="dd-handle">
                                                <span class="pull-right"> 21:00 </span>
                                                <span class="label label-warning"><i class="fa fa-child"></i></span> 子元素
                                            </div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </div>
                        <div class="m-t-md">
                            <h5>数据：</h5>
                        </div>
                        <textarea id="nestable2-output" class="form-control"></textarea>


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
                    output.val(window.JSON.stringify(list.nestable("serialize")))
                } else {
                    output.val("浏览器不支持")
                }
            };

            $("#nestable2").nestable({group: 1}).on("change", updateOutput);

            updateOutput($("#nestable2").data("output", $("#nestable2-output")));
            $("#nestable-menu").on("click", function (e) {
                var target = $(e.target), action = target.data("action");
                if (action === "expand-all") {
                    $(".dd").nestable("expandAll")
                }
                if (action === "collapse-all") {
                    $(".dd").nestable("collapseAll")
                }
            })
        });
    </script>
@endsection
