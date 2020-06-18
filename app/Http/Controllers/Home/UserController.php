<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Fans;//粉丝表
use App\Model\Tag;//标签表
use App\Model\UserTag;//用户标签
class UserController extends Controller
{
    //
    //展示页面
    public function index(){
        //查询表中所有数据
        $fansInfo = Fans::paginate(3);
        return view("user.index",["fansInfo"=>$fansInfo]);
    }
    //修改备注
    public function remark(){
        //判断是否为ajax
        if(request()->ajax()){
            //接值
            $remark = request()->remark;
            $openid = request()->openid;
            //修改微信公众平台的备注
            //获取access
            $access = $this->get_access_token();
            //获取接口地址
            $url = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=".$access;
            //接口需要的信息
            $data = [
                "openid"=>$openid,
	            "remark"=>$remark
            ];
            //使用post方式传输
            $result = $this->http_post($url,json_encode($data));
            //转为数组
            $result = json_decode($result,true);
            //如果没有错误则证明成功否则失败
            if($result["errcode"]==0){
                //成功修改本地数据库
                $fans  = Fans::where("openid",$openid)->first();//查询出这条数据
                $fans->remark = $remark;//修改备注
                $fans->save();//保存
                return ["error_num"=>0,"msg"=>"修改备注成功"];//返回信息
            }else{
                return ["error_num"=>1,"msg"=>"平台修改失败"];
            }
        }else{
            return ["error_num"=>1,"msg"=>"不是ajax请求"];
        }
    }
    //拉黑
    public function black($openid){
       //先拉黑公众号
        //获取access
        $access = $this->get_access_token();
        //获取接口地址
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=".$access;
        //接口所需信息
        $data = [
            "openid_list"=>[$openid],
        ];
        //发送post并转为数组
        $result = json_decode($this->http_post($url,json_encode($data)),true);
        //判断是否拉黑成功
        if($result["errcode"]==0){
            //服务器成功后本地修改
            $fans = Fans::where("openid",$openid)->first();//查询
            $fans->is_black=1;//修改拉黑状态
            $fans->save();//保存
            return redirect("/index")->with("msg","拉黑成功");
        }else{
            return redirect("/index")->with("msg","拉黑失败");
        }
    }
    //取消拉黑
    public function reblack($openid){
        //先取消拉黑公众号
        //获取access
        $access = $this->get_access_token();
        //获取接口地址
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=".$access;
        //接口所需信息
        $data = [
            "openid_list"=>[$openid],
        ];
        //发送post并转为数组
        $result = json_decode($this->http_post($url,json_encode($data)),true);
        //判断是否取消拉黑成功
        if($result["errcode"]==0){
            //服务器成功后本地修改
            $fans = Fans::where("openid",$openid)->first();//查询
            $fans->is_black=0;//修改拉黑状态
            $fans->save();//保存
            return redirect("/index")->with("msg","取消拉黑成功");
        }else{
            return redirect("/index")->with("msg","取消拉黑失败");
        }
    }
    //用户设置标签
    public function userTag($openid){
        if(request()->isMethod("get")){
            //获取用户名称
            $fans_name = Fans::where("openid",$openid)->value("nickname");
            //获取所有标签
            $tag = Tag::get();
            //获取所有标签id
            $tag_id = UserTag::where("openid",$openid)->pluck("id")->toArray();
            return view("user.userTag",["fans_name"=>$fans_name,"tag"=>$tag,"tag_id"=>$tag_id]);
        }
        if(request()->isMethod("post")){
            //获取该用户所有的标签id
            $tag = UserTag::where('openid',$openid)->pluck("id")->toArray();
            //先删除平台上面的
            $url = " https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=".$this->get_access_token();
            //循环
            foreach($tag as $k=>$v){
                //请求的数据
                $data = [
                    "openid_list"=>["$openid"],
                    "tagid" =>$v
                ];
                //发送请求
                $this->http_post($url,json_encode($data));
            }
            //删除本地
            UserTag::where("openid",$openid)->delete();
            //接标签的id
            $id = request()->tag;
            //公众平台给用户设置标签的接口网址
            $url = " https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".$this->get_access_token();
            //循环打标签
            foreach($id as $k=>$v){
                //用户的id
                $user_id = Fans::where("openid",$openid)->value("user_id");
                //标签的id
                $tagid = Tag::where("id",$v)->value("tag_id");
                //接口所需的信息
                $data = [
                    "openid_list"=>["$openid"],
                    "tagid"=>$v
                ];
                //发送请求
              $this->http_post($url,json_encode($data));
               //添加入库
               UserTag::create(["user_id"=>$user_id,"tag_id"=>$tagid,"openid"=>$openid,"id"=>$v]);
            }
            return redirect("/index");
        }
    }
}
