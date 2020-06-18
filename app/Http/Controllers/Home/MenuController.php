<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Menu;
class MenuController extends Controller
{
    public function index(){
        $menu = Menu::get()->toArray();
        //处理菜单的展示效果
        $data = [];
        //循环取
        foreach($menu as $key=>$val){
            //判断顶级
            if($val["pid"]==0){
                $data[] = $val;
                //再循除顶级菜单下的分类
                foreach($menu as $k=>$v){
                    if($v["pid"]==$val["menu_id"]){
                        $data[] = $v;
                    }
                }
            }
        }
        return view("menu.index",["menu"=>$data]);
    }
    public function create(){
        if(request()->isMethod("get")){
            $menu = Menu::where("pid",0)->get();
            return view("menu.create",["menu"=>$menu]);
        }
        if(request()->isMethod("post")){
            //添加入库
            $menu = new Menu;
            $menu->menu_content = request()->content;
            $menu->menu_type = request()->menu_type;
            $menu->menu_name = request()->menu_name;
            $menu->pid = request()->pid;
            $menu->save();
            return redirect("/menu/index");
        }
    }
    public function menu(){
//        //查询顶级菜单
//        $menu = Menu::where("pid",0)->get()->toArray();
//        $data = $this->menu_list($menu);
//        //接口地址
//        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->get_access_token();
//        //需要转码以下
//        $result = json_decode($this->http_post($url,json_encode($data,JSON_UNESCAPED_UNICODE)),true);
//        if($result["errcode"]==0){
//            //成功
//            return redirect("menu/index");
//        }else{
//            exit("失败");
//        }
        //查询顶级菜单
        $menu = Menu::where("pid","0")->get()->toArray();
        //所需要的参数
        $data = $this->menu_check($menu);
//        接口地址
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->get_access_token();
        //需要转码以下
        $result = json_decode($this->http_post($url,json_encode($data,JSON_UNESCAPED_UNICODE)),true);
        if($result["errcode"]==0){
            //成功
            return redirect("menu/index");
        }else{
            exit("失败");
        }
    }
    //获取菜单
    private function menu_check($menu){
        //循环查看顶级分类下是否有子菜单
        foreach($menu as $key=>$val){
            $son_menu = Menu::where("pid",$val["menu_id"])->get()->toArray();
            if($son_menu){
                //有的话
                $arr = [
                    "name"=>$val["menu_name"],
                ];
                //循环获取子菜单内容
                foreach($son_menu as $k=>$v){
                    $sub_button = [
                        "type"=>$v["menu_type"],
                        "name"=>$v["menu_name"],
                    ];
                    //判断菜单类型
                    if($v["menu_type"]=="view"){
                        $sub_button["url"]=$v["menu_content"];
                    }
                    if($v["menu_type"]=="click"){
                        $sub_button["key"]=$v["menu_content"];
                    }
                    if($v["menu_type"]=="pic_photo_or_album"){
                        $sub_button["key"]=$v["menu_content"];
                        $sub_button["sub_button"]=[];
                    }
                    //每次循环的内容存到一个数组
                    $son_arr[] = $sub_button;
                }
                //填入数组arr
                $arr["sub_button"] = $son_arr;
            }else{
                //没有
                $arr = [
                    "name"=>$val["menu_name"],
                    "type"=>$val["menu_type"],
                ];
                //判断菜单类型
                if($val["menu_type"]=="view"){
                    $arr["url"]=$val["menu_content"];
                }
                if($val["menu_type"]=="click"){
                    $arr["key"]=$val["menu_content"];
                }
                if($val["menu_type"]=="pic_photo_or_album"){
                    $arr["key"]=$val["menu_content"];
                    $arr["sub_button"]=[];
                }
            }
            //将所有数据合并到一个数组
            $data["button"][]=$arr;
        }
        return $data;
    }
////    获取菜单
//    private function menu_list($menu){
//        //循环查看顶级菜单下是否有子菜单
//        foreach($menu as $key=>$val){
//            //查询子菜单
//            $son_menu = Menu::where("pid",$val["menu_id"])->get()->toArray();
//            //判断是否拥有子菜单
//            if($son_menu){
//                //有
//                $arr = [
//                    "name"=>$val["menu_name"],
//                ];
//                //循环获取子菜单的内容
//                foreach($son_menu as $k=>$v){
//                    $sub_button = [
//                        "type"=>$v["menu_type"],
//                        "name"=>$v["menu_name"]
//                    ];
//                    //判断此菜单的类型
//                    if($v["menu_type"]=="click"){
//                        $sub_button["key"]=$v["menu_content"];
//                    }
//                    if($v["menu_type"]=="view"){
//                        $sub_button["url"]=$v["menu_content"];
//                    }
//                    //把每次循环的数据放入一个空数组存储
//                    $son_arr[] = $sub_button;
//                }
//                //再填入数组
//                $arr["sub_button"] = $son_arr;
//            }else{
//                //没有
//                $arr = [
//                    "name"=>$val["menu_name"],
//                    "type"=>$val["menu_type"],
//                ];
//                //判断此菜单的类型
//                if($val["menu_type"]=="click"){
//                    $arr["key"]=$val["menu_content"];
//                }
//                if($val["menu_type"]=="view"){
//                    $arr["url"]=$val["menu_content"];
//                }
//            }
//            //将所有的数组合并到一个大数组
//            $data["button"][] = $arr;
//        }
//        dd($data);
//        return $data;
//    }
}
