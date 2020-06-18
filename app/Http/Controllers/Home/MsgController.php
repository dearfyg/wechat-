<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Fans;
use App\Model\Msg;
class MsgController extends Controller
{
    //

    public function index(){
        //渲染
        $msg = Msg::get();
        return view("/msg/index",["msg"=>$msg]);
    }
    public function create(){
        if(request()->isMethod("get")){
            //查询
            $fans = Fans::get();
            //渲染页面
            return view("msg.create",["fans"=>$fans]);
        }
        if(request()->isMethod("post")){
            //接值
            $content =urlencode(request()->content);//中文编码
            $type = request()->type;
            $user = request()->people;
            //接口所需的信息
            $data = $this->checkType($type,$content,$user);
            //接口地址
            $url = "https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$this->get_access_token();
            //post发送
            $result =json_decode($this->http_post($url,urldecode(json_encode($data))),true);
            if($result["errcode"]==0){
                //添加入库
                $msg = new Msg;
                $msg->content = request()->content;
                $msg->type = $type;
                $msg->people = $user;
                $msg->save();
                return redirect("/msg/index");
            }else{
                return redirect("/msg/index");
            }
        }
    }
    private function checkType($type,$content,$user){
//        if($type=="text"){
//            $data = [
//                "touser"=> $user,
//                "text"=>[
//                    "content"=>$content,
//                ],
//                "msgtype"=>"text"
//            ];
//        }
//        if($type=="voice"){
//            $data = [
//                "touser"=> $user,
//                "voice"=>[
//                    "media_id"=>$content,
//                ],
//                "msgtype"=>"voice"
//            ];
//        }
        //判断类型是什么完后定义data
        switch ($type){
            case "text":
                $data = [
                    "touser"=> $user,
                    "text"=>[
                        "content"=>$content,
                    ],
                    "msgtype"=>"text"
                ];
                break;
            case "voice":
                 $data = [
                    "touser"=> $user,
                    "voice"=>[
                        "media_id"=>$content,
                    ],
                    "msgtype"=>"voice"
                ];
                break;
            case "image":
                 $data = [
                    "touser"=> $user,
                    "image"=>[
                        "media_id"=>$content,
                    ],
                    "msgtype"=>"image"
                ];
                break;
            case "mpvideo":
                $data = [
                    "touser"=> $user,
                    "mpvideo"=>[
                        "media_id"=>$content,
                    ],
                    "msgtype"=>"mpvideo"
                ];
                break;
        }
        return $data;
    }
}
