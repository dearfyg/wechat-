<?php

namespace App\Http\Middleware;

use Closure;

class Aouth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //判断是否获取到权限
        if(!session("user")){
            //所需要的参数
            //appid
            $appid = "wx1d72e376cd0e0cea";
            $redirect_uri= "http://fanyinggang.zhaowei.shop/index.php/aouth/code";//回调地址
            $scope = "snsapi_userinfo";//授权方式
            $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=STATE#wechat_redirect";
            //跳转到微信授权地址 一但授权自动跳转到回调地址
            return redirect($url);
        }else{
            //获取到了返回首页
            return $next($request);
        }

    }
}
