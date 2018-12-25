@extends('boot.layouts.base')

@section('title','添加词库')

@section('css')
    <link rel="stylesheet" href="/static/boot/css/app.css">
    <style>
        .container {
            margin-top: 30px;
            margin-bottom: 30px;
            width: 1000px;
        }

        #error {
            position: fixed;
            top: 40px;
            right: 90px;
            height: 598px;
            width: 200px;
            z-index: 1040;
        }
    </style>
@endsection

@section('body')
    <div id="error">

    </div>
    <div class="container">
        <div class="twelve wide column">
            <div class="ui segment">
                <div class="content extra-padding">
                    <div class="ui header text-center text gery" style="margin:10px 0 40px">
                        <i class="glyphicon glyphicon-pencil"></i> 编辑菜单
                    </div>
                    <form method="post" action="{{ route('menu-update') }}" accept-charset="UTF-8" class="ui form"
                          style="min-height: 50px;" id="insert">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $BootMenu -> id }}">

                        <div class="field">
                            <input class="form-control" type="text" name="title" id="title-field" placeholder="菜单名称" value="{{ $BootMenu -> title }}">
                        </div>
                        <div class="field">
                            <input class="form-control" type="text" name="route" id="title-field" placeholder="菜单路由别名" value="{{ $BootMenu -> route }}">
                        </div>
                        <div class="field">
                            <label>图标(Icon eg：fa-book)</label>
                            <input class="form-control" type="text" name="icon"  placeholder="Icon" value="{{ $BootMenu -> icon }}">
                        </div>
                        <div class="field">
                            <label>菜单级别(Permission Level)</label>

                            <select class="form-control ui search multiple selection tags dropdown  category"
                                    name="p_id">
                                <option  value="0" > 默认顶级 </option>
                                @foreach($menus as $routes)
                                    <option value="{{ $routes -> id }}" {{ $routes -> id == $BootMenu -> p_id ? 'selected' : '' }}>{{ $routes -> lefthtml }}{{ $routes -> chinese_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <br>
                        <div class="field">
                            <input class="form-control" type="text" name="sort" id="title-field"
                                   placeholder="排序 (数越大越靠前 1 - 100 默认：50)" value="{{ $BootMenu -> sort }}">
                        </div>
                        <br/>
                        <div class="ui segment private-checkbox">
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" class="js-switch" name="status" {{ $BootMenu -> status ? "checked" :'' }}  style="margin-left: -2px;"/>

                                    <label>开启菜单</label>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="ui message">
                            <button type="submit" class="ui button teal publish-btn" id="">
                                <i class="glyphicon glyphicon-pencil"></i>
                                确认
                            </button>
                            &nbsp;&nbsp;or&nbsp;&nbsp;
                            <a href="{{ route('menu-index') }}" class="ui button"  name="subject" value="draft">
                                <i class="glyphicon glyphicon-repeat"></i> 返回列表
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="/static/boot/js/jquery.form.js"></script>
    <script type="text/javascript">

        function objToArray(array) {
            var arr = [];
            for (var i in array) {
                arr.push(array[i]);
            }
            console.log(arr);
            return arr;
        }
        var opt = {
            success: insertOk,
            dataType: 'json',
            timeout: 5000
        };
        $('#insert').ajaxForm(opt);

        function insertOk(res) {
            if (res.success === false) {
                var items = objToArray(res.errors);
                $("#error").empty();

                if (!res.errors) {
                    $('#error').append(
                        "<div style='opacity:1;' class='alert alert-danger'><ul><li>" + res.msg + "</li></ul> </div>"

                    );
                }
                items.map(function (value) {
                    $('#error').append(
                        "<div style='opacity:1;' class='alert alert-danger'><ul><li>" + value[0] + "</li></ul> </div>"

                    );
                })
            } else {
                window.location.href = res.url;
            }
        }

    </script>


@endsection



