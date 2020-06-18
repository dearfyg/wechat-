<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Diff;
use App\Model\User;
class QrcodeController extends Controller
{
    public function index(){
        //传一个随机数过去使每一次的二维码都不重复
        $qrcode = uniqid();
        return view("pc.qrcode",["qrcode"=>$qrcode]);
    }
    public function qrcode(){
        //设置qrcode的路径
        $qrcode_path = base_path("vendor/phpqrcode/qrlib.php");
        //引入该路径
        require_once($qrcode_path);
        //接收随机数
        $qrcode = request()->qrcode;
        //二维码内容
        $content = "http://fanyinggang.zhaowei.shop/qrcode/aouth_one?qrcode=".$qrcode;
        //把每次的不同的二维码diff和时间存入数据库
        $diff = new Diff;
        $diff->diff = $qrcode;
        $diff->diff_time = time();
        $diff->save();
        //设置qrcode图片二维码
//        \QRcode::png($content);
        //设置二维码响应为图片
        return response(\QRcode::png($content))->header("Content-Type","image/png");
    }
    //检测二维码的状态
    public function check_qrcode(){
        $qrcode = request()->qrcode;
        //数据库查询是否存在
        $diff = Diff::where("diff",$qrcode)->first();
        //判断传来的二维码时间
        if(time()-$diff->diff_time>60 ){
            return ["error"=>1,"msg"=>"二维码已失效"];
        }
        //判断状态值为1
        if($diff->status==1){
            return ["error"=>1,"msg"=>"二维码已被扫码请重新尝试"];
        }
        //判断状态值为2
        if($diff->status==2){
            //通过openid查询用户的信息存入session
            $userInfo = User::where("openid",$diff->openid)->first();
            //session的数据
            $data = [
                "id"=>$userInfo->id,
                "nickname"=>$userInfo->nickname,
                "headimgurl"=>$userInfo->headimgurl
            ];
            //存入session
            session(["user"=>$data]);
            return ["error"=>2,"msg"=>"登录成功"];
        }
    }
    //授权第一步
    public function aouth_one(){
        //过来接qrcode值
        $qrcode = request()->qrcode;
        //存入session用于第二步的修改状态
        session(["qrcode"=>$qrcode]);
        //查询是否有该条数据
        $diff = Diff::where("diff",$qrcode)->first();
        //修改状态为1
        $diff->status=1;
        //保存
        $diff->save();
        //获取授权所需要的参数
        $appid = "wx1d72e376cd0e0cea";
        //回调地址
        $redirect_url ="http://fanyinggang.zhaowei.shop/qrcode/aouth_two";
        //授权方式
        $scope = "snsapi_userinfo";
        //获取授权的地址
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_url."&response_type=code&scope=".$scope."&state=STATE#wechat_redirect";
        //跳转到回调地址
        return redirect($url);
    }
    //授权第二部
    public function aouth_two(){
        //接code
        $code = request()->code;
        //access_token所需参数
        $appid="wx1d72e376cd0e0cea";
        $secret = "bc0f301236d4db2b20db3dc7cea63c14";
        //通过code换access_token
        $url  ="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
        //发送请求
        $result = json_decode($this->http_get($url),true);
        //获取用户的openid值
        $openid = $result["openid"];
        //拉取用户信息
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$result["access_token"]."&openid=".$openid."&lang=zh_CN";
        //发送请求
        $result = json_decode($this->http_get($url),true);
        //查询用户表中是否拥有
        $userInfo = User::where("openid",$openid)->first();
        //判断是否拥有
        if(!$userInfo){
            //没有添加入库
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
        //修改状态值为2 登录成功
        $qrcode = session("qrcode");
        //查询该条记录修改状态值
        $diff = Diff::where("diff",$qrcode)->first();
        $diff->openid = $openid;
        $diff->status=2;
        $diff->save();
    }
}
