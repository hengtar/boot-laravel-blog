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
                        <i class="glyphicon glyphicon-pencil"></i> 发布词库
                    </div>
                    <form method="post" action="{{ route('keyword-store') }}" accept-charset="UTF-8" class="ui form"
                          style="min-height: 50px;" id="insert">
                        {{ csrf_field() }}

                        <div class="field">
                            <input class="form-control" type="text" name="keyword" id="title-field" placeholder="关键词">
                        </div>

                        <div class="field">
                            <input class="form-control" type="text" name="views" id="title-field"
                                   placeholder="点击量 (默认随机生成 100 - 500)">
                        </div>

                        <br/>

                        <div class="field">
                            <input class="form-control" type="text" name="sort" id="title-field"
                                   placeholder="排序 (数越大越靠前 1 - 100 默认：50)">
                        </div>

                        <br/>

                        <div class="ui segment private-checkbox">
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" class="js-switch" name="status" checked style="margin-left: -2px;"/>

                                    <label>是否显示给用户</label>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="ui message">
                            <button type="submit" class="ui button teal publish-btn" id="">
                                <i class="glyphicon glyphicon-pencil"></i>
                                发布词库
                            </button>
                            &nbsp;&nbsp;or&nbsp;&nbsp;
                            <a href="{{ route('keyword-index') }}" class="ui button"  name="subject" value="draft">
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



