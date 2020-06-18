<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后台管理系统</title>
    <meta name="author" content="DeathGhost" />
    <link rel="stylesheet" type="text/css" href="/static/css/style.css" />
    <!--[if lt IE 9]>
    <script src="/static/js/html5.js"></script>
    <![endif]-->
    <script src="/static/js/jquery.js"></script>
    <script src="/static/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        (function($){
            $(window).load(function(){

                $("a[rel='load-content']").click(function(e){
                    e.preventDefault();
                    var url=$(this).attr("href");
                    $.get(url,function(data){
                        $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
                        //scroll-to appended content
                        $(".content").mCustomScrollbar("scrollTo","h2:last");
                    });
                });

                $(".content").delegate("a[href='top']","click",function(e){
                    e.preventDefault();
                    $(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
                });

            });
        })(jQuery);
    </script>
    @section("js")
    @show
</head>
<body>
<!--header-->
<header>
    <h1><img src="/static/images/admin_logo.png"/></h1>
    <ul class="rt_nav">
        <li><a href="http://www.baidu.com" target="_blank" class="website_icon">站点首页</a></li>
        <li><a href="#" class="admin_icon">DeathGhost</a></li>
        <li><a href="#" class="set_icon">账号设置</a></li>
        <li><a href="login.php" class="quit_icon">安全退出</a></li>
    </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar">
    <h2><a href="{{url("/")}}">起始页</a></h2>
    <ul>
        <li>
            <dl>
                <dt>用户信息</dt>
                <!--当前链接则添加class:active-->
                <dd><a href="{{url("/index")}}" class="active">用户列表</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>标签信息</dt>
                <dd><a href="{{url("/tag/index")}}">标签列表</a></dd>
                <dd><a href="{{url("/tag/create")}}">添加标签</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>素材管理</dt>
                <dd><a href="{{url("/source/index")}}">素材列表</a></dd>
                <dd><a href="{{url("/source/create")}}">添加素材</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>关键字的回复</dt>
                <dd><a href="{{url("/keyword/create")}}">回复添加</a></dd>
                <dd><a href="{{url("/keyword/index")}}">回复展示</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>课程管理</dt>
                <dd><a href="{{url("/course/create")}}">课程添加</a></dd>
                <dd><a href="{{url("/course/index")}}">课程展示</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>群发管理</dt>
                <dd><a href="{{url("/msg/create")}}">群发添加</a></dd>
                <dd><a href="{{url("/msg/index")}}">群发展示</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>菜单管理</dt>
                <dd><a href="{{url("/menu/create")}}">菜单添加</a></dd>
                <dd><a href="{{url("/menu/index")}}">菜单展示</a></dd>
            </dl>
        </li>
        <li>
            <p class="btm_infor">© 望唐集团 版权所有</p>
        </li>
    </ul>
</aside>

<section class="rt_wrap content mCustomScrollbar">
    @section('content')
    @show
</section>
</body>
</html>