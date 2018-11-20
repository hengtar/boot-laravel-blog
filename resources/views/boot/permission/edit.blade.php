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
                        <i class="glyphicon glyphicon-pencil"></i> 编辑权限
                    </div>
                    <form method="post" action="{{ route('permission-update') }}" accept-charset="UTF-8" class="ui form"
                          style="min-height: 50px;" id="insert">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $permission -> id }}">

                        <div class="field">
                            <input class="form-control" type="text" name="chinese_name" id="title-field" placeholder="权限名称" value="{{ $permission -> chinese_name }}">
                        </div>
                        <div class="field">
                            <input class="form-control" type="text" name="name" id="title-field" placeholder="权限路由别名" value="{{ $permission -> name }}">
                        </div>
                        <div class="field">
                            <input class="form-control" type="text" name="guard_name" id="title-field" placeholder="守护者(如没有特殊要求，请勿改动)" value="{{ $permission -> guard_name }}">
                        </div>

                        <div class="field">
                            <label>权限级别(Permission Level)</label>

                            <select class="form-control ui search multiple selection tags dropdown  category"
                                    name="p_id">
                                <option  value="0" > 默认顶级 </option>
                                @foreach($permissions as $routes)
                                    <option value="{{ $routes -> id }}" {{ $routes -> id == $permission -> p_id ? 'selected' : '' }}>{{ $routes -> lefthtml }}{{ $routes -> chinese_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <br>
                        <div class="field">
                            <input class="form-control" type="text" name="sort" id="title-field"
                                   placeholder="排序 (数越大越靠前 1 - 100 默认：50)" value="{{ $permission -> sort }}">
                        </div>
                        <br/>
                        <div class="ui segment private-checkbox">
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" class="js-switch" name="status" checked style="margin-left: -2px;"/>

                                    <label>开启权限</label>
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
                            <a href="{{ route('permission-index') }}" class="ui button"  name="subject" value="draft">
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



