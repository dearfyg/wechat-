<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin;//使用admin表
use App\Model\Fans;//使用粉丝表
use App\Model\Course;
class LoginController extends Controller
{
    //登录页面
    public function login(){
        //渲染页面
        return view('login.login');
    }
    //登录成功页面
    public function loginDo(){
        //接值
        $data = request()->except("_token");
//        $pwd = encrypt($data['admin_pwd']);
//        dd($pwd);
        //判断数据库中是否有此账号
        $admin =Admin::where('admin_name',$data['admin_name'])->first();
        //如果数据库中有此账号那么则查询密码是否正确
        if($admin){
            //密码解密
//            $admin_pwd = decrypt($admin_name['admin_pwd']);
            //判断密码是否一致
            if($admin['admin_pwd']==$data['admin_pwd']){
                //一致跳转首页界面
                return redirect("/index");
            }
        }else{
            return back()->with('msg',"账号密码有误");
        }

    }
    //微信首页
    public function weIndex(){
        //获取jsapi_ticket
        $jsapi_ticket = $this->get_jsapi_ticket();
        //随机字符串
        $noncestr = $this->noncestr();
        //时间戳
        $timestamp = time();
        //当前网页的url
        $url = request()->url();
        //签名的数组
        $data = [
            "jsapi_ticket"=>$jsapi_ticket,
            "timestamp"=>$timestamp,
            "url"=>$url,
            "noncestr"=>$noncestr,
        ];
        //参数按照字段名的ASCII 码从小到大排序
        ksort($data);
        //拼接成string1 /转译以下
        $str = urldecode(http_build_query($data));
        //sha1加密
        $signature = sha1($str);
        //查询
        $course = Course::get();
        return view("weIndex",compact("course","signature","noncestr","timestamp","url"));
    }
}
