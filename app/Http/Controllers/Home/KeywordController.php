<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keyword;
use Lcobucci\JWT\Signer\Key;

class KeywordController extends Controller
{
    //展示
    public function index(){
        $keywordInfo = Keyword::get();
        return view("/keyword/index",["keyInfo"=>$keywordInfo]);
    }
    //添加
    public function create(){
        if(request()->isMethod("get")){
            //渲染页面
            return view("/keyword/create");
        }
        if(request()->isMethod(("post"))){
            $keyword = new Keyword;
            $keyword->keyword = request()->keyword;
            $keyword->type = $type = request()->type;
            switch ($type){
                case "text":
                    $keyword->content = request()->content;
                    break;
                case "image":
                    $keyword->media = request()->media;
                    break;
                case "voice":
                    $keyword->media = request()->media;
                    break;
                case "video":
                    $keyword->media = request()->media;
                    $keyword->title = request()->title;
                    $keyword->Description = request()->Description;
                    break;
                case "news":
                    $keyword->ArticleCount = request()->ArticleCount;
                    $keyword->Articles = request()->Articles;
                    $keyword->title = request()->title;
                    $keyword->Description = request()->Description;
                    $keyword->PicUrl = request()->PicUrl;
                    $keyword->Url = request()->Url;
            }
            $keyword->save();
            return redirect("/keyword/index");

        }
    }
}
