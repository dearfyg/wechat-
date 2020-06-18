@extends("layout.layout")
@section("content")
    <style>
        .card_tab li{
            display: inline-block;
            padding: 10px;
            border:1px solid #ccc;
            margin-left: 10px;
            cursor: pointer;
        }
        .cur{
            background: #ccc;
        }
        .hide{
            display:none;
        }
    </style>
    <h2><strong style="color:grey;">素材展示</strong></h2>
    <center>
        <ul class="card_tab">
            <li class="cur">图片展示</li>
            <li>音频展示</li>
            <li>视频展示</li>
            <li>图文展示</li>
        </ul>
    </center>
    <div class="content">

        <table class="table content_tab" >
            <tr>
                <th>图片名称</th>
                <th>图片介绍</th>
                <th>本地路径</th>
                <th>mediaId</th>
                <th>互联网路径</th>s
            </tr>
            @foreach($img as $k=>$v)
            <tr >
                <td style="width:265px;">{{$v->img_name}}</td>
                <td>{{$v->img_desc}}</td>
                <td>@if($v->img_url)<img src="{{$v->img_url}}" width="100">@endif</td>
                <td>{{$v->media}}</td>
                <td><img src="{{$v->url}}" width="100"></td>s
            </tr>
            @endforeach
        </table>
        <table class="table content_tab hide" >
            <tr>
                <th>音频名称</th>
                <th>音频介绍</th>
                <th>本地路径</th>
                <th>mediaId</th>
            </tr>
            @foreach($voice as $k=>$v)
            <tr >
                <td style="width:265px;"><div class="cut_title ellipsis">{{$v->voice_name}}</div></td>
                <td>{{$v->voice_desc}}</td>
                <td>
                    <audio src="{{$v->voice_url}}" controls="controls">
                        Your browser does not support the audio element.
                    </audio>
                <td>{{$v->media}}</td>
            </tr>
                @endforeach
        </table>
        <table class="table content_tab hide" >
            <tr>
                <th>视频名称</th>
                <th>视频介绍</th>
                <th>本地路径</th>
                <th>mediaId</th>
            </tr>
            @foreach($video as $k=>$v)
                <tr >
                    <td style="width:265px;"><div class="cut_title ellipsis">{{$v->video_name}}</div></td>
                    <td>{{$v->video_desc}}</td>
                    <td>
                        <video width="320" height="240" controls>
                            <source src="{{$v->video_url}}" type="video/mp4">
                            您的浏览器不支持 video 标签。
                        </video>
                    <td>{{$v->media}}</td>
                </tr>
            @endforeach
        </table>
        <table class="table content_tab hide" >
            <tr>
                <th>图文标题</th>
                <th>素材id</th>
                <th >素材url</th>
                <th>作者</th>
                <th>图文消息的摘要</th>
                <th>是否显示封面</th>
                <th>图文消息的具体内容</th>
                <th>图文消息的原文地址</th>
                <th>是否打开评论</th>
                <th>是否粉丝才可评论</th>
            </tr>
            @foreach($news as $k=>$v)
            <tr >
                <td style="width:265px;">{{$v->title}}</td>
                <td style="width:50px;">{{$v->thumb_media_id}}</td>
                <td style="width:50px;"><img src="{{$v->thumb_media_url}}" width="111"></td>
                <td>{{$v->author}}</td>
                <td>{{$v->digest}}</td>
                <td>@if($v->show_cover_pic==1) 显示 @else 不显示 @endif</td>
                <td>{{$v->content}}</td>
                <td>{{$v->content_source_url}}</td>
                <td>@if($v->need_open_comment==1) 打开 @else 不打开 @endif</td>
                <td>@if($v->only_fans_can_comment==1) 粉丝可评论 @else 所有人可评论 @endif</td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
@section("js")
    <script>
        $(function(){
            $(".card_tab li").click(function(){
                $(this).addClass("cur").siblings().removeClass("cur");
                var index=$(this).index();
                $(".content_tab").eq(index).removeClass("hide").siblings().addClass("hide");
            });
        });
    </script>
@endsection

