<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>@yield('title')</title>
    <link href="{{ asset('/static/boot/css/bootstrap.min14ed.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/boot/css/font-awesome.min93e3.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/boot/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/boot/css/style.min862f.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/static/photo/dist/zoomify.min.css') }}">
    @section('css')

    @show
</head>
<body class="gray-bg">

@section('body')

    @show
<script src="{{ asset('/static/boot/js/jquery.min.js') }}"></script>
<script src="{{ asset('/static/boot/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/static/boot/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('/static/boot/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('/static/boot/js/plugins/layer/layer.min.js') }}"></script>
<script src="{{ asset('/static/boot/js/hplus.min.js') }}"></script>
<script src="{{ asset('/static/boot/js/contabs.min.js') }}"></script>
<script src="{{ asset('/static/boot/js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('/static/photo/dist/zoomify.min.js') }}"></script>
<script type="text/javascript">
    $('.example img').zoomify();
</script>

@section('js')

@show
</body>
</html>
