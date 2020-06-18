<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>课程详情</title>
</head>
<body>
<div class="row">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img width="30px" style="border-radius: 50%" src="{{session("user.headimgurl")}}" alt="..."><span class="caret"></span>
            <button>
                <button type="button" class="btn btn-primary">{{session("user.nickname")}}<button>
    </div>
</div>
<div class="container">
    <div class="container">
        <div class="row">
            <div class="card" style="width:100%">
                <img src="http://www.php.cn/static/images/i12.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$course->course_name}}</h5>
                    <p class="card-text">{{$course->course_desc}}</p>
                    <div class="form-group">
                        <label>下载数量</label>
                        <p class="card-text">{{$course->course_number}}次</p>
                    </div>
                    <div class="form-group">
                        <label>百度网盘地址</label>
                        <p class="card-text">{{$course->course_url}}</p>
                    </div>
                    <div class="form-group">
                        <label>邮箱地址</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="用来接收提取码的邮箱">
                    </div>
                    @if($course->course_pay==0)
                        <a href="javascript:void(0)" class="btn btn-primary">打赏个茶叶蛋(￥1.5)</a>
                    @else($course->course_pay==1)
                        <a href="javascript:void(0)" class="btn btn-primary">打赏一杯咖啡(￥2.5)</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
{{--//第一步先引入--}}
<script src="http://res2.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
<script>
    //配置
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: 'wx1d72e376cd0e0cea', // 必填，公众号的唯一标识
        timestamp:"{{$timestamp}}", // 必填，生成签名的时间戳
        nonceStr:"{{$noncestr}}", // 必填，生成签名的随机串
        signature:"{{$signature}}",// 必填，签名
        jsApiList: ["updateAppMessageShareData","updateTimelineShareData"] // 必填，需要使用的JS接口列表
    });
    //成功
    wx.ready(function (){
        //朋友
        wx.updateAppMessageShareData({
            title: "{{$course->course_name}}", // 分享标题
            desc: '{{$course->desc}}', // 分享描述
            link: '{{$url}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://static.clewm.net/cli/images/cli_logo@2x.png', // 分享图标
            success: function () {
                // 设置成功
            }
        })
        //朋友圈
        wx.updateTimelineShareData({
            title: '{{$course->course_name}}', // 分享标题
            link: '{{$url}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://static.clewm.net/cli/images/cli_logo@2x.png', // 分享图标
            success: function () {
                // 设置成功
            }
        })
    });
</script>