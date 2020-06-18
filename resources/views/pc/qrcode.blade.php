<html>
<head>
    <title>扫码登录</title>
    <style>
        .content{
            width: 100%;
            margin: 150px auto;
            text-align:center;
        }
        .content img{

        }
    </style>
</head>
<body>
<div class="content">
    <img src='{{url("qrcode/qrcode")}}?qrcode={{$qrcode}}' width="200px">
    <p class="tips">请扫二维码登录</p>
</div>
</body>
<html>
<script src="/static/js/jquery.js"></script>
<script>
    setInterval(function(){
        //定时发送检测
        $.ajax({
            type:"post",
            url:"{{url('qrcode/check')}}",
            data:{qrcode:"{{$qrcode}}"},
            dataType:"json",
            success:function(res){
                if(res.error==1){
                    $(".tips").text(res.msg);
                }
                if(res.error==2){
                    $(".tips").text(res.msg);
                    //跳转
                    location.href="{{url("/index")}}";
                }
            }
        })
    },2000)
</script>
