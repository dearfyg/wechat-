<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后台登录</title>
    <meta name="author" content="DeathGhost" />
    <link rel="stylesheet" type="text/css" href="/static/css/style.css" />
    <style>
        body{height:100%;background:#16a085;overflow:hidden;}
        canvas{z-index:-1;position:absolute;}
    </style>
    <script src="/static/js/jquery.js"></script>
    <script src="/static/js/verificationNumbers.js"></script>
    <script src="/static/js/Particleground.js"></script>
    <script>
        $(document).ready(function() {
            //粒子背景特效
            $('body').particleground({
                dotColor: '#5cbdaa',
                lineColor: '#5cbdaa'
            });
            //验证码
            createCode();
        });
    </script>
</head>
<body>
<dl class="admin_login">

    <dt>
        <strong>站点后台管理系统</strong>
        <em>Management System</em>
    </dt>
    <center>
        <span><u><font size="5px" color='red'>{{session('msg')}}</font></u></span>
    </center>
    <form action="{{url('/loginDo')}}" method="post">
        @csrf
    <dd class="user_icon">
        <input type="text" placeholder="账号" class="login_txtbx" name="admin_name"/>
    </dd>
    <dd class="pwd_icon">
        <input type="password" placeholder="密码" class="login_txtbx" name="admin_pwd"/>
    </dd>
    <dd class="val_icon">
        <div class="checkcode">
            <input type="text" id="J_codetext" placeholder="验证码" maxlength="4" class="login_txtbx">
            <canvas class="J_codeimg" id="myCanvas" onclick="createCode()">对不起，您的浏览器不支持canvas，请下载最新版浏览器!</canvas>
        </div>
        <input type="button" value="验证码核验" class="ver_btn" onClick="validate();">
    </dd>
     <div>
         <a href="{{url("/qrcode")}}"><img src="/static/images/wx.png" width="50"></a>
     </div>
    <dd>
        <input type="submit" value="立即登陆" class="submit_btn"/>
    </dd>
    </form>
    <dd>
        <p>© 2015-2016 DeathGhost 版权所有</p>
        <p>陕B2-20080224-1</p>
    </dd>
</dl>
</body>
</html>
