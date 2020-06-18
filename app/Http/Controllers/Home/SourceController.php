<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Img;
use App\Model\Voice;
use App\Model\Video;
use App\Model\News;
class SourceController extends Controller
{
    //展示
    public function index()
    {
        //图片展示
        $img = Img::get();
        //音频展示
        $voice = Voice::get();
        //视频展示
        $video = Video::get();
        //图文展示
        $news = News::get();
        return view("source.index",["img"=>$img,"voice"=>$voice,"video"=>$video,"news"=>$news]);
    }

    //添加
    public function create()
    {
        return view("source.create");
    }

    //添加图片
    public function img()
    {
        if (request()->isMethod("post")) {
         $path = $this->uploads("img_url","img");
         $result = $this->wechatUploads("img_url","img","image");
                //判断是否上传成功
                if(empty($result["errcode"])){
                    //成功 添加入库
                    $imgsource = new Img;
                    $imgsource->img_name = request()->img_name;
                    $imgsource->img_desc = request()->img_desc;
                    $imgsource->img_url = asset("uploads/".$path);
                    $imgsource->media = $result["media_id"];
                    $imgsource->url = $result["url"];
                    $imgsource->save();
                    return redirect("/source/index");
                }else{
                    //失败
                    return redirect("/source/index");
                }
        }
    }
    //添加音频
    public function voice(){
        if(request()->isMethod("post")){
            $path = $this->uploads("voice_url","voice");
            $result = $this->wechatUploads("voice_url","voice","voice");
            //判断是否上传成功
            if(empty($result["errcode"])){
                //成功 添加入库
                $voice = new Voice;
                $voice->voice_name = request()->voice_name;
                $voice->voice_desc = request()->voice_desc;
                $voice->voice_url = asset("uploads/".$path);
                $voice->media = $result["media_id"];
                $voice->save();
                return redirect("/source/index");
            }else{
                //失败
                return redirect("/source/index");
            }
        }
    }
    //添加视频
    public function video(){
        //视频名称
        $name = request()->video_name;
        //视频内容
        $desc = request()->video_desc;
        //本地上传
        $path = $this->uploads("video_url","video");
        //服务器上传
        $result = $this->wechatUploads("video_url","video","video",$name,$desc);
        //判断是否上传成功
        if(empty($result["errcode"])){
            //成功 添加入库
            $video = new Video;
            $video->video_name = $name;
            $video->video_desc = $desc;
            $video->video_url = asset("uploads/".$path);
            $video->media = $result["media_id"];
            $video->save();
            return redirect("/source/index");
        }else{
            //失败
            return redirect("/source/index");
        }
    }
    //添加图文
    public function news(){
        $path = $this->uploads("thumb_media_id","thumb");
        $result = $this->wechatUploads("thumb_media_id","thumb","thumb");
        $thumb_media_id = isset($result["media_id"])?$result["media_id"]:"";
        $thumb_media_url = isset($result["url"])?$result["url"]:"";
        if(empty($result["errcode"])){
            //成功 添加入库
            $news = new News;
            $news->title = request()->title;
            $news->thumb_media_id = $thumb_media_id;
            $news->author = request()->author;
            $news->digest = request()->digest;
            $news->show_cover_pic = request()->show_cover_pic;
            $news->content = request()->content;
            $news->content_source_url = request()->content_source_url;
            $news->need_open_comment = request()->need_open_comment;
            $news->only_fans_can_comment = request()->only_fans_can_comment;
            $news->thumb_media_url = $thumb_media_url;
            $news->save();
            return redirect("/source/index");
        }else{
            //失败
            return redirect("/source/index");
        }
    }
}
