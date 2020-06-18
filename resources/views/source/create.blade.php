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
    <h2><strong style="color:grey;">素材添加</strong></h2>
    <center>
        <ul class="card_tab">
            <li class="cur">图片</li>
            <li>音频</li>
            <li>视频</li>
            <li>图文</li>
        </ul>
    </center>
    <div class="content">
        <form action="{{url("/source/img")}}" method="post" class="content_tab" enctype="multipart/form-data">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">图片名称：</span>
                        <input type="text" class="textbox textbox_295" name="img_name" placeholder="图片名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图片介绍：</span>
                        <textarea name="img_desc" class="textbox textbox_295" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图片上传：</span>
                        <input type="file" class="textbox textbox_295" name="img_url" />
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
        <form action="{{url("/source/voice")}}" method="post" class="content_tab hide" enctype="multipart/form-data">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">音频名称：</span>
                        <input type="text" class="textbox textbox_295" name="voice_name" placeholder="音频名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">音频介绍：</span>
                        <textarea name="voice_desc" class="textbox textbox_295" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">音频上传：</span>
                        <input type="file" class="textbox textbox_295" name="voice_url" />
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
        <form action="{{url("/source/video")}}" method="post" class="content_tab hide" enctype="multipart/form-data">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">视频名称：</span>
                        <input type="text" class="textbox textbox_295" name="video_name" placeholder="视频名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">视频介绍：</span>
                        <textarea name="video_desc" class="textbox textbox_295" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">视频上传：</span>
                        <input type="file" class="textbox textbox_295" name="video_url" />
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
        <form action="{{url("/source/news")}}" method="post" class="content_tab hide" enctype="multipart/form-data">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">图文标题：</span>
                        <input type="text" class="textbox textbox_295" name="title" placeholder="图文标题..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">缩略图：</span>
                        <input type="file" class="textbox textbox_295" name="thumb_media_id" />
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图文作者：</span>
                        <input type="text" class="textbox textbox_295" name="author" placeholder="图文作者..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图文摘要：</span>
                        <textarea name="digest" class="textbox textbox_295" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">是否显示封面：</span>
                        <input type="radio"  name="show_cover_pic" value="1" checked/>是
                        <input type="radio"  name="show_cover_pic" value="0"/>否
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图文内容：</span>
                        <textarea name="content" class="textbox textbox_295" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">原文地址：</span>
                        <input type="text" class="textbox textbox_295" name="content_source_url" placeholder="原文地址..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;"> 是否打开评论：</span>
                        <input type="radio"  name="need_open_comment" value="1" checked/>是
                        <input type="radio"  name="need_open_comment" value="0"/>否
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">是否粉丝才可评论：</span>
                        <input type="radio"  name="only_fans_can_comment" value="1"/>仅粉丝
                        <input type="radio"  name="only_fans_can_comment" value="0" checked/>所有人
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
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