<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>课程列表</title>
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
        @foreach($course as $key=>$val)
            <div class="row">
                <div class="card" style="width:100%">
                    <img src="http://www.php.cn/static/images/i12.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$val->course_name}}</h5>
                        <div class="form-group">
                            <label>下载数量</label>
                            <p class="card-text">{{$val->course_number}}次</p>
                        </div>
                        <a href="{{url('/course/detail/'.$val->course_id)}}" class="btn btn-primary">查看详情</a>
                    </div>
                </div>
            </div>
        @endforeach
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
            title: "这里是我们的php视频课程", // 分享标题
            desc: 'php优惠的最大力度', // 分享描述
            link: '{{$url}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://static.clewm.net/cli/images/cli_logo@2x.png', // 分享图标
            success: function () {
                // 设置成功
            }
        })
        //朋友圈
        wx.updateTimelineShareData({
            title: '这里是我们的php视频课程', // 分享标题
            link: '{{$url}}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://static.clewm.net/cli/images/cli_logo@2x.png', // 分享图标
            success: function () {
                // 设置成功
            }
        })
    });
</script>