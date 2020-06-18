<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
class CourseController extends Controller
{
    //
    public function index(){
        $courseInfo = Course::get();
        //渲染
        return view("course.index",["courseInfo"=>$courseInfo]);
    }
    public function create(){
        if(request()->isMethod("get")){
            //渲染
            return view("course.create");
        }
       if(request()->isMethod("post")){
            //接值
           $data = request()->post();
           //存入数据库
           $course = Course::create($data);
           if($course){
               return redirect("course/index");
           }
       }
    }
    public function detail($id){
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
        $course = Course::find($id);
        return view("course.detail",compact("course","signature","noncestr","timestamp","url"));
    }
}
