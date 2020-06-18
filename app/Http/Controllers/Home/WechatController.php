<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//使用fansModel
use App\Model\Fans;
use App\Model\Keyword;
use App\Model\Course;
class WechatController extends Controller
{
    //
    public function wechat(){
        //接收随机字符串
        $echostr = request()->get('echostr','');//echostr特性只有第一次接入有值。
        //验证signature正确性 并且echostr不为空
        if($this->checkSignature()&& !empty($echostr)){
            //代表第一次接入
            echo $echostr;//返回echostr 证明接入成功
        }else{
            $obj = $this->receiveMsg();//接收消息
            //判断消息类型
            switch ($obj->MsgType){
                //事件类型
//                case "event":
//                    //订阅事件
//                    if($obj->Event=="subscribe"){
//                        //获取用户信息
//                        $openid = $obj->FromUserName;
//                        //获取access_token
//                        $access_token = $this->get_access_token();
//                        //获取用户信息接口
//                        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
//                        //调用接口
//                        $result = $this->http_get($url);
//                        //返回的是json字符串转为数组
//                        $result = json_decode($result,true);
//                        //判断是否请求成功
//                        if(empty($result["errcode"])){
//                            //为空表示成功
//                            //查询数据库中是否有此数据
//                            $check = Fans::where('openid',$openid)->first();
//                            if(!$check){
//                                //没有查询到将数据存放到数据库中
//                                Fans::create($result);
//                                //给出提示
//                                $content = "欢迎你关注我们的微信公众号";
//                            }else{
//                                //查询有此数据修改他的关注状态为1
//                                $check->status=1;
//                                $check->update($result);
//                                $content="欢迎你再次关注我们的微信公众号";
//                            }
//                        }else{
//                            //不为空表示失败
//                            $content = "关注失败";
//                        }
//                    }
//                    //取消订阅事件
//                    if($obj->Event=="unsubscribe"){
//                        //获取用户信息
//                        $openid = $obj->FromUserName;
//                        //查询是否有该openid
//                        $check = Fans::where('openid',$openid)->first();
//                        //如果有则修改状态为0
//                        if($check){
//                            $check->status = 0;
//                            $check->save();
//                            $content = "取消订阅成功";
//                        }else{
//                            $content = "取消订阅失败";
//                        }
//                    }
//                    //点击事件
//                    if($obj->Event=="CLICK"){
//                        if($obj->EventKey=="sz"){
//                            $content = "点我施恩哥哥干嘛?\n";
//                            $content .="你可以输入一些关键字例如企业啥的.\n";
//                            $content .="你也可以发语音和机器人小姐姐玩\n";
//                            $content .="就是不许点我施恩哥哥！！！";
//                        }
//                    }
//                    //发送消息
//                    $this->responseText($obj,$content);
//                    break;
                //文本类型
                //事件类型
                case "event":
                    //订阅事件
                    if($obj->Event=="subscribe"){
                        //获取用户的openid
                        $openid =$obj->FromUserName;
                        //获取用户的基本信息
                        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->get_access_token()."&openid=".$openid."&lang=zh_CN";
                        //发送请求
                        $result = json_decode($this->http_get($url),true);
                        //打印到data
                        $this->check($result);
                        if(isset($result["errcode"])){
                            //失败
                            $content = "关注失败";
                            $this->responseText($obj,$content);
                        }else{
                            //成功
                            //通过openid查询数据库中是否拥有
                            $fans = Fans::where("openid",$openid)->first();
                            if($fans){
                                //有则修改关注状态
                                $fans->status=1;
                                $fans->update($result);
                                $content ="你好".$result["nickname"]."，欢迎回来";
                                //发送消息
                                $this->responseText($obj,$content);
                            }else{
                                //没有添加入库
                                Fans::create($result);
                                $content ="你好".$result["nickname"];
                                //发送消息
                                $this->responseText($obj,$content);
                            }
                        }
                    }
                    //取消订阅事件
                    if($obj->Event=="unsubscribe"){
                        //获取用户的openid
                        $openid = $obj->FromUserName;
                        //查询数据库中是否有此数据
                        $fans = Fans::where("openid",$openid)->first();
                        $this->check($fans);
                        if($fans){
                            //有 修改状态位0
                            $fans->status= 0;
                            $fans->unsubscribe_time = time();
                            $fans->save();
                            $content = "取消订阅成功";
                            //发送消息
                            $this->responseText($obj,$content);
                        }else{
                            //没有
                            $content ="取消关注失败";
                            //发送消息
                            $this->responseText($obj,$content);
                        }
                    }

                    break;
                case "text":
                    //获取用户关键字
                    $keyword = $obj->Content;
                    //查询此关键字数据库是否存在
                    $result = Keyword::where("keyword",$keyword)->first();
                    //判断是否存在
                    if($result){
                        //存在,判断类型该发送什么消息
                        switch ($result->type){
                            case "text":
                                //调用发送文本
                                $this->responseText($obj,$result->content);
                                break;
                            case "image":
                                //调用发送图片
                                $this->responseImg($obj,$result->media);
                                break;
                            case "voice":
                                //调用发送语音
                                $this->responseVoice($obj,$result->media);
                                break;
                            case "video":
                                //调用发送视频
                                $this->responseVideo($obj,$result->media,$result->title,$result->Description);
                                break;
                            case "news":
                                //调用发送图文
                                $this->responseNews($obj,$result->ArticleCount,$result->title,$result->Description,$result->PicUrl,$result->Url);
                                break;
                        }

                    }else{
                        //不存在
                        //截取前俩位字符,看下是否位kc
                        if(substr($keyword,0,2)=="kc"){
                            //如果截取的字符是完后获取kc后面的字符
                            $name = substr($keyword,2);
                            //通过截取后的名称去模糊查询数据库中是否存在
                            $course = Course::where("course_name","like","%$name%")->get()->toArray();
                            $this->check($course);
                            //模糊查询出来为对象 转为数组
                            if($course){
                                //定义空字符串
                                $content = "";
                                //循环获取到的数据 因为并不只查到一个
                                foreach($course as $k=>$v){
                                    //链接
                                    $url = url("/course/detail/".$v["course_id"]);
                                    //回复
                                    $content.="您所查询的《".$v["course_name"]."》"."<a href='".$url."'>详细信息</a>\n";
                                }
                                $this->responseText($obj,$content);
                            }else{
                                $content = "对不起,您所查询的《".$name."》课程暂时没有收录";
                                //调用发送
                                $this->responseText($obj,$content);
                            }
                        }
                        $content = "你输入的关键词我们暂时没有收录。请你输入'企业文化','企业介绍','企业宣传','企业环境','企业'进行查看";
                        //调用发送
                        $this->responseText($obj,$content);
                    }
                    break;
                case "voice":
                    //获取用户的消息转为文本
                    $text = urlencode($obj->Recognition);//转码
                    //调用机器人的接口
                    $url = "http://openapi.tuling123.com/openapi/api/v2";
                    //请求的消息
                    $msg = [
                        "reqType"=>0,
                        "perception"=>[
                                        "inputText"=> [
                                            "text"=>$text,
                                        ]
                        ],
                        "userInfo"=>[
                            "apiKey"=>"b7da94fa32c8487a846e981f8761370c",
                            "userId"=>"1",
                        ]
                    ];
                    $msg = urldecode(json_encode($msg));//转为json格式,并且解码
                    //向接口发送请求
                    $result = $this->http_post($url,$msg);
                    //将得到的请求转为数组
                    $result = json_decode($result,true);
                    //得到机器人的回复消息
                    $content = $result["results"][0]["values"]["text"];
                    $this->responseText($obj,$content);
                    break;
            }
//            ******************************机器人和天气********************************
//            //这里证明不是第一次接入了。  处理业务逻辑  接收消息
//            $obj = $this->receiveMsg();
//            //判断接收到的类型
//            switch($obj->MsgType){
//                case "text":
//                    //城市
//                    $city = str_replace('天气：',"",$obj->Content);
//                    //key
//                    $key = "ee9206e9a2c81fd162750d3321e072ea";
//                    //接口地址  拼接接口地址
//                    $url = "http://apis.juhe.cn/simpleWeather/query?city=".$city."&key=".$key;
//                    //发送请求 默认为json格式将其转为数组类型
//                    $data = json_decode(file_get_contents($url),true);
//                    //file_put_contents('data.txt',$data);
//                    //判断是否请求成功
//                    if($data["error_code"]==0){
//                        //当前的数据
//                        $today = $data["result"]["realtime"];
//                        //未来五天的空气状况
//                        $future = $data["result"]["future"];
//                        //返回的信息
//                        $content = "您所查询的城市为:".$data["result"]["city"]."\n";
//                        $content.= "当前温度为:".$today["temperature"]."℃"."\n当前湿度为:".$today["humidity"]."%\n";
//                        $content.= "天气状况:".$today["info"]."\n"."风向:".$today["direct"]."\n"."风力:".$today["power"]."\n空气质量:".$today["aqi"]."\n";
//                        $content.= "以下是未来五天的天气情况\n";
//                        //返回未来五天的空气情况
//                        foreach($future as $k=>$v){
//                            $content.="--------------------------\n";
//                            $content.= "日期：".$v["date"]."\n";
//                            $content.="气温：".$v["temperature"]."\n";
//                            $content.="天气情况:".$v["weather"]."\n";
//                            $content.="风向:".$v["direct"]."\n";
//                        }
//                    }else{
//                        $content="您所输入的城市有误,请正确填写。格式为'天气:地区名'";
//                    }
//                    break;
//            }
//            **********************************************************************************
//            //回复消息
//            $this->responseText($obj,$content);
        }

    }
    //接收消息
    private function receiveMsg(){
        $xml = file_get_contents("php://input");//获取微信平台发来的消息
        //file_put_contents("data.txt",$xml);//讲发来的消息写入文件
        $obj = simplexml_load_string($xml,"SimpleXMLElement",LIBXML_NOCDATA);//将xml转为对象类型
        return $obj;
    }
    //自动回复文本消息
    private function responseText($obj,$content){
        //占位符的内容
        $ToUserName = $obj->FromUserName;
        $FromUserName = $obj->ToUserName;
        $time = time();
        $msgType = "text";
        $contents = $content;
        //自动回复
        $xml = "<xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[%s]]></MsgType>
                      <Content><![CDATA[%s]]></Content>
                    </xml>";
        //把占位符改为消息
        echo sprintf($xml,$ToUserName,$FromUserName,$time,$msgType,$contents);
    }
    //回复图片消息
    private function responseImg($obj,$media){
        $ToUserName = $obj->FromUserName;
        $FromUserName = $obj->ToUserName;
        $time = time();
        $msgType = "image";
        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                  <Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                  </Image>
                </xml>";
        echo sprintf($xml,$ToUserName,$FromUserName,$time,$msgType,$media);
    }
    //回复语音消息
    private function responseVoice($obj,$media){
        $ToUserName = $obj->FromUserName;
        $FromUserName = $obj->ToUserName;
        $time = time();
        $msgType = "voice";
        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                  <Voice>
                    <MediaId><![CDATA[%s]]></MediaId>
                  </Voice>
                </xml>";
        echo sprintf($xml,$ToUserName,$FromUserName,$time,$msgType,$media);
    }
    //回复视频消息
    private function responseVideo($obj,$media,$title,$content){
        $ToUserName = $obj->FromUserName;
        $FromUserName = $obj->ToUserName;
        $time = time();
        $msgType = "video";
        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                  <Video>
                    <MediaId><![CDATA[%s]]></MediaId>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                  </Video>
                </xml>";
        echo sprintf($xml,$ToUserName,$FromUserName,$time,$msgType,$media,$title,$content);
    }
    //回复图文消息
    private function responseNews($obj,$ArticleCount,$title,$content,$picurl,$url){
        $ToUserName = $obj->FromUserName;
        $FromUserName = $obj->ToUserName;
        $time = time();
        $msgType = "news";
        $xml="<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%s</CreateTime>
              <MsgType><![CDATA[%s]]></MsgType>
              <ArticleCount>%s</ArticleCount>
              <Articles>
                <item>
                  <Title><![CDATA[%s]]></Title>
                  <Description><![CDATA[%s]]></Description>
                  <PicUrl><![CDATA[%s]]></PicUrl>
                  <Url><![CDATA[%s]]></Url>
                </item>
              </Articles>
            </xml>";
        echo sprintf($xml,$ToUserName,$FromUserName,$time,$msgType,$ArticleCount,$title,$content,$picurl,$url);
    }
    //验证signature正确性
    private function checkSignature()
    {
        $signature = request()->get("signature");
        $timestamp = request()->get("timestamp");
        $nonce = request()->get("nonce");

        $token = "wechat";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    //调试方法
    private function check($data){
        //如果$data是对象或者数组类型 转换为json格式
        if(is_object($data)||is_array($data)){
            $data = json_encode($data);
        }
        return file_put_contents(date('Ymd').'.txt',$data);
    }
}
