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
                <h5>模板列表 {{ $search  ? "/ 模板搜索" : ""}}</h5>
            </div>
            <div class="ibox-content">
                <div class="example-wrap">
                    <div class="example">
                        <form method="post" action="{{ route('template-sort') }}">
                            {{ csrf_field() }}
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="20%"><a
                                                href="{{ route('template-index', $TemplateOrm ->attributes('id',$order,$search)) }}">ID</a>
                                    </th>
                                    <th>名称</th>
                                    <th>路由</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($templates as $template)
                                        <tr>
                                            <th>{{ $template -> id }}</th>
                                            <td>{{ $template -> name }}</td>
                                            <td>{{ $template -> route }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="clearfix" style="line-height: 70px; margin-top: -20px;">
                                <div style="float: right">
                                    {{ $templates ->links() }}
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

