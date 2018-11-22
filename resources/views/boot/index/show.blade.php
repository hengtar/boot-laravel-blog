@extends('boot.layouts.base')

@section('title','中央控制台')

@section('body')
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-12">
        <blockquote class="text-warning" style="font-size:14px">您是否需要自己做一款后台、博客、商城等等的，但是又缺乏不想重复造轮子…
            <br>您是否一直在苦苦寻找一款适合自己的laravel后台内容管理系统…
            <br>您是否想做一款自己的web应用程序…
            <br>…………
            <h4 class="text-danger">那么，现在 <code>boot-laravel</code> 来了</h4>
        </blockquote>
        <hr>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>二次开发</h5>
                </div>
                <div class="ibox-content">
                    <p>我们提供基于<code>boot-laravel</code>的二次开发服务，具体费用请联系作者。</p>
                    <p>同时，我们也提供以下服务：</p>
                    <ol>
                        <li>任何类型网站建设</li>
                        <li>服务器购买及搭建</li>
                        <li>域名购买及解析</li>
                        <li>维护及二次开发服务</li>
                    </ol>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>联系信息</h5>
                </div>
                <div class="ibox-content">
                    <p><i class="fa fa-send-o"></i> 博客：<a href="http://www.boot-z.com" target="_blank">http://www.boot-z.com</a>
                    </p>
                    <p><i class="fa fa-qq"></i> QQ：<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=852952656&amp;site=qq&amp;menu=yes" target="_blank">852952656</a>
                    </p>
                    <p><i class="fa fa-weixin"></i> 微信：<a href="javascript:;">852952656</a>
                    </p>
                    <p><i class="fa fa-credit-card"></i> 支付宝：<a href="javascript:;" class="支付宝信息">852952656@qq.com</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>更新日志</h5>
                </div>
                <div class="ibox-content no-padding">
                    <div class="panel-body">
                        <div class="panel-group" id="version">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#version" href="#v41">v1.0</a><code class="pull-right">2018.11.2 13:55</code>
                                    </h5>
                                </div>
                                <div id="v41" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="alert alert-warning">boot-laravel</div>
                                        <ol>
                                            <li>系统管理模块</li>
                                            <li>权限管理模块</li>
                                            <li>会员管理模块</li>
                                            <li>菜单管理模块</li>
                                            <li>文章管理模块</li>
                                            <li>广告管理模块</li>
                                            <li>评论管理模块</li>
                                            <li>数据库管理模块</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>赞助我们</h5>
                </div>
                <div class="ibox-content">
                    <p>欢迎赞助我们</p>
                    <ol>
                        <li>赞助我们之后获取所有源码(未压缩、带注释版本)；</li>
                        <li>说明文档；</li>
                        <li>加入赞助群；</li>
                        <li>终身免费升级服务；</li>
                        <li>必要的技术支持；</li>
                        <li>付费二次开发服务；</li>
                        <li>赞助费仅需10.24元</li>
                    </ol>
                    <hr>
                    <div class="alert alert-warning">
                        赞助费仅需10.24元，赞助完成后请及时联系作者，或在赞助备注中留下邮箱或QQ，方便作者及时联系您。
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @endsection


