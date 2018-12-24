@extends('boot.layouts.base')

@section('title','更改广告')

@section('css')
    <link rel="stylesheet" href="/static/markdown/css/editormd.css">
    <link rel="stylesheet" href="/static/boot/css/app.css">
    <link rel="stylesheet" type="text/css" href="/static/webupload/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/static/webupload/style.css">
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
                        <i class="glyphicon glyphicon-pencil"></i> 编辑广告
                    </div>
                    <form method="post" action="{{ route('advert-update') }}" accept-charset="UTF-8" class="ui form"
                          style="min-height: 50px;" id="insert">
                        {{ csrf_field() }}

                        <input type="hidden" name="id" value="{{ $adverts -> id }}">

                        <div class="field">
                            <input class="form-control" type="text" name="title" id="title-field" placeholder="标题" value="{{ $adverts -> title }}">
                        </div>

                        <div class="field">
                            <input class="form-control" type="text" name="keywords" id="title-field" placeholder="关键词" value="{{ $adverts -> keywords }}">
                        </div>

                        <div class="field">
                            <textarea class="form-control" type="text" name="summary" id="title-field" placeholder="描述"
                            >{{ $adverts -> summary }}</textarea>
                        </div>

                        <div class="field">
                            <label>广告分类</label>
                            <select class="form-control ui search multiple selection tags dropdown  category"
                                    name="category_id">
                                @foreach($category as $cate)
                                    <option value="{{ $cate -> id }}"  {{ $cate -> id == $adverts -> category_id ? 'selected' :''  }}>{{ $cate -> lefthtml }}{{ $cate -> category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>广告推荐位</label>
                            <select class="form-control ui search multiple selection tags dropdown  category"
                                    name="recommend">
                                @foreach($adverts -> recommend() as $recommendKey => $recommendValue)
                                    <option {{ $recommendKey == $adverts -> recommend ? 'selected' : '' }} value="{{ $recommendKey }}">{{ $recommendValue }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <div class="input-group col-sm-12">
                                <input type="hidden" id="data_photo" name="photo" value="{{ $adverts -> photo }}">


                                <div id="imgPicker" class="col-sm-2" >选择图片</div>
                                <img id="img_data" class="col-sm-2" style="margin-top: -5px;" src="{{ $adverts -> photo }}"/>
                                <div id="fileList" class="col-sm-8 uploader-list alert alert-info" style="height:69px;">上传状态<p>图片上传建议大小： 1500px  * 1200px</p></div>
                            </div>

                        </div>
                        <br/>
                        <div class="field">
                            <input class="form-control" type="text" name="views" id="title-field"
                                   placeholder="浏览量 (默认随机生成 100 - 500)" value="{{ $adverts -> views }}">
                        </div>

                        <br/>

                        <div class="field">
                            <input class="form-control" type="text" name="sort" id="title-field"
                                   placeholder="排序 (数越大越靠前 1 - 100 默认：50)" value="{{ $adverts -> sort }}">
                        </div>

                        <br/>

                        <div class="ui segment private-checkbox">
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" class="js-switch" name="status" {{ $adverts -> status? "checked" :'' }} style="margin-left: -2px;"/>

                                    <label>是否显示给用户</label>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="ui message">
                            <button type="submit" class="ui button teal publish-btn" id="">
                                <i class="glyphicon glyphicon-pencil"></i>
                                发布广告
                            </button>
                            &nbsp;&nbsp;or&nbsp;&nbsp;
                            <a href="{{ route('advert-index') }}" class="ui button"  name="subject" value="draft">
                                <i class="glyphicon glyphicon-repeat"></i> 返回列表
                            </a>

                            <a class="pull-right" href="" target="_blank"
                               style="color: #777;font-size: .9em;margin-top: 8px;">
                                编辑器使用指南
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="/static/markdown/examples/js/jquery.min.js"></script>
    <script src="/static/markdown/editormd.min.js"></script>
    <script src="/static/boot/js/jquery.form.js"></script>
    <script type="text/javascript" src="/static/webupload/webuploader.min.js"></script>

    <script type="text/javascript">
        var $list = $('#fileList');
        //上传图片,初始化WebUploader
        var uploader = WebUploader.create({
            auto: true,
            formData: {
                _token:'{{ csrf_token() }}'
            },
            swf: "{{ asset('/static/webupload/Uploader.swf') }}",
            server: "{{ route('upload-localhost') }}",
            duplicate :true,
            pick: '#imgPicker',
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/jpg,image/jpeg,image/png'
            },
            'onUploadSuccess': function(file, data) {
                $("#data_photo").val(data._raw);
                $("#img_data").attr('src', data._raw).show();
            }
        });

        uploader.on( 'fileQueued', function( file ) {
            $list.html( '<div id="' + file.id + '" class="item">' +
                '<h4 class="info">' + file.name + '</h4>' +
                '<p class="state" style="margin-top: -10px;">正在上传...</p>' +
                '</div>' );
        });

        // 文件上传成功
        uploader.on( 'uploadSuccess', function( file ) {
            $( '#'+file.id ).find('p.state').text('上传成功！');
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            $( '#'+file.id ).find('p.state').text('上传出错!');
        });


    </script>
    <script type="text/javascript">
        $(function () {
            testEditor = editormd("test-editormd", {
                width: "100%",
                height: 600,
                watch: false,
                placeholder: "请注意单词拼写，以及中英文排版，支持Markdown格式，`单行代码` ... 更多请见下方，点击眼睛预览全文",
                syncScrolling: "single",
                path: "/static/markdown/lib/",
                toolbarIcons: function () {
                    return ["undo", "redo", "|", "bold", "hr", "|", "image", "code", "preformatted-text", "quote", "list-ul", "|", "lowercase", "||", "search", "watch", "fullscreen"]
                },

                saveHTMLToTextarea: true,
                /**上传图片相关配置如下*/
                imageUpload: true,
                imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL: "{:url('bbs/upload/uploadFile')}",//注意你后端的上传图片服务地址
            });
            testEditor.setEditorTheme('neo');
        });

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



