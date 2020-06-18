<?php

namespace App\Http\Controllers\Home;

use App\Model\UserTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Tag;//使用标签表
class TagController extends Controller
{
    //展示
    public function index(){
//        //
//        $url=" https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->get_access_token();
//        //
//        $result = json_decode($this->http_get($url),true);
//        dd($result);
        //查询
        $tagInfo = Tag::get();
        //渲染页面
        return view("tag.index",["tagInfo"=>$tagInfo]);
    }
    //添加
    public function create(){
        //判断是get请求就是展示添加页面
        if(request()->isMethod("get")){
            //渲染页面
            return view("tag.create");
        }
        //判断是post请求就是添加方法
        if(request()->isMethod("post")){
            //接值
            $name = request()->post("name");
            //先给公众号上添加标签
            //access
            $access = $this->get_access_token();
            //接口地址
            $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$access;
            //接口所需信息
            $data = [
                "tag"=>[
                    "name"=>$name,
                ]
            ];
            //post传输 处理为数组
            $result = json_decode($this->http_post($url,json_encode($data)),true);
            //判断公众号是否添加标签成功
            if(isset($result["tag"])){
                //给数据库中添加
                Tag::create($result["tag"]);
                return redirect("/tag/index");
            }else{
                //添加标签失败了
                return redirect("/tag/create")->with("msg","添加失败或已有此标签");
            }
        }
    }
    //修改
    public function update($id){
        //判断是否get请求
        if(request()->isMethod("get")){
            //查询数据
            $tag = Tag::where("id",$id)->first();
            //渲染页面
            return view('tag.update',["tag"=>$tag]);
        }
        //post请求为修改
        if(request()->isMethod("post")){
            //首先接值
            $name = request()->name;
            //access
            $access = $this->get_access_token();
            //接口网址
            $url = " https://api.weixin.qq.com/cgi-bin/tags/update?access_token=".$access;
            //接口所需信息
            $data = [
                "tag"=>[
                    "id"=>$id,
                    "name"=>$name
                ]
            ];
            //发送请求
            $result = json_decode($this->http_post($url,json_encode($data)),true);
            //判断公众平台是否修改成功
            if($result["errcode"]==0){
                //修改数据库
                $tag = Tag::where("id",$id)->first();
                $tag->name=$name;
                $tag->save();
                return redirect("/tag/index");
            }else{
                return redirect("/tag/index")->with("msg","修改失败");
            }
        }
    }
    //删除
    public function delete($id){
        //获取用户的openid
        $openid = UserTag::where("id",$id)->pluck("openid")->toArray();
        //删除服务器上用户标签
        //批量删除用户标签的接口
        $url = " https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=".$this->get_access_token();
        //接口所需要的数据
        $data = [
            "openid_list"=>[$openid],
            "tagid"=>"$id"
        ];
        //发送接口
        $result = json_decode($this->http_post($url,json_encode($data)),true);
        //判断是否成功
        if($result["errcode"]==0){
            //删除本地用户标签
            UserTag::where("id",$id)->delete();
        }
        //删除服务器上标签
        $url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=".$this->get_access_token();
        //接口所需数据
        $data = [
            "tag"=>["id"=>$id],
        ];
        //发送接口请求
        $result = json_decode($this->http_post($url,json_encode($data)),true);
        //判断是否成功
        if($result["errcode"]==0){
            //删除本地标签
            Tag::where("id",$id)->delete();
        }
        return redirect("/tag/index");

    }
    //展示用户
    public function user($id){
       //通过id查询用户
        $user = Tag::where("id",$id)->first();
        //渲染页面
        return view("tag.user",["user"=>$user]);
    }
}
