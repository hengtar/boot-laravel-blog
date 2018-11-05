@extends('boot.layouts.base')

@section('title','添加文章')

@section('css')
    <link rel="stylesheet" href="/static/markdown/css/editormd.css">
    <link rel="stylesheet" href="/static/boot/css/app.css">
    <style>
        .container {
            margin-top: 30px;
            width: 1000px;
        }
    </style>
@endsection

@section('body')
    <div class="container">
        <div class="twelve wide column">
            <div class="ui segment">
                <div class="content extra-padding">
                    <div class="ui header text-center text gery" style="margin:10px 0 40px">
                        <i class="glyphicon glyphicon-pencil"></i> 发布文章
                    </div>
                    <form method="post" action="{{ route('article-store') }}" accept-charset="UTF-8" class="ui form" style="min-height: 50px;">
                        {{ csrf_field() }}

                        <div class="field">
                            <input class="form-control" type="text" name="title" id="title-field" placeholder="标题" required="">
                        </div>

                        <div class="field">
                            <input class="form-control" type="text" name="keywords" id="title-field" placeholder="关键词" required="">
                        </div>

                        <div class="field">
                            <input class="form-control" type="text" name="author" id="title-field" placeholder="作者" required="">
                        </div>

                        <div class="field">
                            <textarea class="form-control" type="text" name="summary" id="title-field" placeholder="描述" required=""></textarea>
                        </div>

                        <div class="field">
                            <label>文章分类</label>

                            <select class="form-control ui search multiple selection tags dropdown  category" name="c_id">
                                @foreach($category as $cate)
                                <option value="{{ $cate -> id }}">{{ $cate -> category }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="field">
                            <label>文章推荐位</label>

                            <select class="form-control ui search multiple selection tags dropdown  category" name="recommend">
                                @foreach($articles -> recommend() as $recommendKey => $recommendValue)
                                    <option value="{{ $recommendKey }}">{{ $recommendValue }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="field">
                            <div id="test-editormd">
                                <textarea id="my-editormd-markdown-doc" name="content"
                                          style="display:none;"></textarea>
                                <!-- 注意：name属性的值-->
                                <textarea id="name-code" name="content" style="display:none;"></textarea>
                            </div>
                        </div>

                        <br />

                        <div class="field">
                            <input class="form-control" type="text" name="views" id="title-field"
                                   placeholder="浏览量 (默认随机生成 100 - 500)" >
                        </div>

                        <br />

                        <div class="field">
                            <input class="form-control" type="text" name="sort" id="title-field"
                                   placeholder="排序 (数越大越靠前 1 - 100 默认：50)" >
                        </div>

                        <br />
                        <div class="ui message">
                            <button type="submit" class="ui button teal publish-btn" id="">
                                <i class="glyphicon glyphicon-pencil"></i>
                                发布文章
                            </button>

                            &nbsp;&nbsp;or&nbsp;&nbsp;
                            <button class="ui button" type="submit" name="subject" value="draft">
                                <i class="glyphicon glyphicon-file"></i> 保存草稿
                            </button>

                            <a class="pull-right" href="" target="_blank" style="color: #777;font-size: .9em;margin-top: 8px;">
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
    </script>
@endsection



