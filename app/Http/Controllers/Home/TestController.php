<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    //清空每日的配额
    public function test(){
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
        //渲染页面 分配参数
        return view("test",compact("signature","noncestr","timestamp"));
    }
}
