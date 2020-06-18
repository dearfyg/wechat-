<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redis;
//使用AccessToken模型
use App\Model\AccessToken;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //get请求
    public function http_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//向那个url地址上面发送
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//设置发送http请求时需不需要证书
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置发送成功后要不要输出1 不输出，0输出
        $output = curl_exec($ch);//执行
        curl_close($ch);    //关闭
        return $output;
    }

    //post请求
    public function http_post($url, $data)
    {
        $curl = curl_init(); //初始化
        curl_setopt($curl, CURLOPT_URL, $url);//向那个url地址上面发送
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);//需不需要带证书
        curl_setopt($curl, CURLOPT_POST, 1); //是否是post方式 1是，0不是
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//需不需要输出
        $output = curl_exec($curl);//执行
        curl_close($curl); //关闭
        return $output;
    }

    //获取access_token
    public function get_access_token()
    {
        //看redis中是否拥有此值
        $access_token = Redis::get("access_token");
        //判断是否拥有
        if(!$access_token){
            ////没有
            //所需参数
            $appid = "wx1d72e376cd0e0cea";
            $secret = "bc0f301236d4db2b20db3dc7cea63c14";
            //发送请求的接口
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
            //发送get请求 并转为数组用于处理
            $result = json_decode($this->http_get($url),true);
            //存储在redis
            $access_token = Redis::setex("access_token",3600,$result["access_token"]);
        }
        return $access_token;

//        //刚进来先判断数据库中是否有access
//        $access = AccessToken::orderBy("id", "desc")->first();
//        //数据库中没有或者时间超过了7000s 则重新获取access
//        if (!$access || time() - $access->access_token_time > 7000) {
//            //获取appid
//            $appid = "wx1d72e376cd0e0cea";
//            //获取secret
//            $secret = "bc0f301236d4db2b20db3dc7cea63c14";
//            //调用access_token接口
//            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
//            //get请求接口
//            $result = $this->http_get($url);
//            //得到的json字符串转为数组形式
//            $result = json_decode($result, true);
//            //判断是否请求成功
//            if (isset($result["access_token"])) {
//                //表示请求成功  存入数据库
//                $access_token = new AccessToken();
//                //token值
//                $access_token->access_token = $result["access_token"];
//                //获取到的时间
//                $access_token->access_token_time = time();
//                //存入数据库
//                $access_token->save();
//                //返回数据
//                return $result["access_token"];
//            } else {
//                //表示失败，返回false
//                return false;
//            }
//        } else {
//            //直接数据库中获取
//            return $access->access_token;
//        }
    }
    //本地上传
    public function uploads($img, $pathname)
    {
        //本地图片上传
        //判断是否有文件上传 并且上传没有出错
        if (request()->hasFile("$img") && request()->file("$img")->isValid()) {
            $img = request()->file("$img");//获取图片数据
            $extension = $img->getClientOriginalExtension();
            $fileName = uniqid() . "." . $extension;
            $path = $img->storeAs("$pathname", $fileName);//上传到img
            return $path;
        }
    }
    //服务器上传
    public function wechatUploads($img, $pathname,$name,$title="",$content=""){
        $path = $this->uploads($img,$pathname);
        $absolute = public_path("uploads/" . $path);//绝对路径
        //本地上传成功后 服务器上传
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=" . $this->get_access_token() . "&type=" . $name;
        //请求所需信息
        if($name=="video"){
            $data = [
                "media" => new \CURLFile($absolute), //因为是curl上传所以要调用php自带函数CURLFile 并且要绝对路径
                "description"=>json_encode([
                    "title"=>$title,
                    "introduction"=>$content
                ])
            ];
        }else{
            $data = [
                "media" => new \CURLFile($absolute), //因为是curl上传所以要调用php自带函数CURLFile 并且要绝对路径
            ];
        }
        //发送请求
        $result = json_decode($this->http_post($url, $data), true);//因为没有说要json格式所以不用转换，但因为下面要用。返回的是json格式我们要转为数组格式
        return $result;
    }
    //获取jsapi_ticket
    public function get_jsapi_ticket(){
        //因为每日获取有限所以要存入文件缓存
        //查询文件缓存是否存在
        $jsapi_ticket = cache("jsapi_ticket");
        if($jsapi_ticket){
            //存在直接返回
            return $jsapi_ticket;
        }else{
            //不存在调用接口并且存入文件缓存
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$this->get_access_token()."&type=jsapi";
            //发送请求
            $result = json_decode($this->http_get($url),true);
            $jsapi_ticket = cache(["jsapi_ticket"=>$result["ticket"]],118);
            //返回数据
            return $result["ticket"];
        }
    }
    //生成noncestr字符串
    public function noncestr(){
        //定义一个字符串
        $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        //定义一个空字符串
        $noncestr = "";
        //循环取16此
        for($i=1;$i<=16;$i++){
            //定义一个随机数
            $key = rand(0,61);
            //用$key指向字符串的值每次获取其中一个
            $noncestr.=$str[$key];
        }
        //返回
        return $noncestr;
    }
}