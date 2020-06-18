<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
class AouthController extends Controller
{
    //
    public function code(){
        //获取code
        $code = request()->code;
        //判断code是否存在
        if(empty($code)){
            eixt("授权失败");
        }
        //二、通过code换取网页授权access_token
        //所需要的参数
        $appid = "wx1d72e376cd0e0cea";
        $secret = "bc0f301236d4db2b20db3dc7cea63c14";
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
        //发送请求
        $result = json_decode($this->http_get($url),true);
        //判断access_token是否获取到
        if(isset($result["errcode"])){
            //获取失败
            exit("授权失败");
        }
        //三、拉取用户信息
        //所需参数
        $access_token = $result["access_token"];
        $openid = $result["openid"];
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        //发送请求
        $result = json_decode($this->http_get($url),true);
        //判断拉取信息是否成功
        if(empty($result["errcode"])){
            //成功
            //判断数据库中是否有该数据
            $user = User::where("openid",$openid)->first();
            if($user){
                //有则不存
            }else{
                //存
                $user = new User;
                $user->openid = $result["openid"];
                $user->nickname =$result["nickname"];
                $user->sex = $result["sex"];
                $user->province = $result["province"];
                $user->city = $result["city"];
                $user->country = $result["country"];
                $user->headimgurl = $result["headimgurl"];
                $user->save();
            }
        }else{
            exit("获取信息失败");
        }
        $data = [
            "nickname"=>$result["nickname"],
            "headimgurl"=>$result["headimgurl"],
            "openid"=>$result["openid"]
        ];
        //存入session用于展示头像 和中间件的判断
        session(["user"=>$data]);
        //获取权限成功后发送模板消息
        $url ="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->get_access_token();
        $temdate = [
            "touser"=>$result["openid"],
            "template_id"=>"uKfE8McBkQRj6mRC6QATgBBZJIG_Llizst0fG5A4rSU",
            "data"=>[
                "nickname"=>[
                    "value"=>$result["nickname"],
                    "color"=>"#FF0000",
                ],
                "time"=>[
                    "value"=>date("Y年m月d日 H时i分s秒",time()),
                    "color"=>"#FF1CAE",
                ],
                "url"=>[
                    "value"=>"http://fanyinggang.zhaowei.shop/weIndex",
                    "color"=>"#FF2400"
                ]

            ]
        ];
        //发送模板消息
        $this->http_post($url,json_encode($temdate));
        //跳转首页
        return redirect("/weIndex");
    }
}
