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
    <h2><strong style="color:grey;">关键字添加</strong></h2>
    <center>
        <ul class="card_tab">
            <li class="cur">文本</li>
            <li>图片</li>
            <li>音频</li>
            <li>视频</li>
            <li>图文</li>
        </ul>
    </center>
    <div class="content">
        <form action="{{url("/keyword/create")}}" method="post" class="content_tab" >
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">关键字：</span>
                        <input type="text" class="textbox textbox_295" name="keyword" placeholder="关键字名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">回复内容：</span>
                        <textarea name="content" id="" cols="30" rows="10"></textarea>
                    </li>
                    <input type="hidden" name="type" value="text">
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
        <form action="{{url("/keyword/create")}}" method="post" class="content_tab hide" >
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">关键字：</span>
                        <input type="text" class="textbox textbox_295" name="keyword" placeholder="关键字名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">回复MediaId：</span>
                        <input type="text" name="media" class="textbox textbox_295">
                    </li>
                    <input type="hidden" name="type" value="image">
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
        <form action="{{url("/keyword/create")}}" method="post" class="content_tab hide" >
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">关键字：</span>
                        <input type="text" class="textbox textbox_295" name="keyword" placeholder="关键字名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">回复MediaId：</span>
                        <input type="text" name="media" class="textbox textbox_295">
                    </li>
                    <input type="hidden" name="type" value="voice">
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
        <form action="{{url("/keyword/create")}}" method="post" class="content_tab hide" >
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">关键字：</span>
                        <input type="text" class="textbox textbox_295" name="keyword" placeholder="关键字名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">回复MediaId：</span>
                        <input type="text" name="media" class="textbox textbox_295">
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">标题：</span>
                        <input type="text" class="textbox textbox_295" name="title" placeholder="标题..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">描述：</span>
                        <textarea name="Description" id="" cols="30" rows="10"></textarea>
                    </li>
                    <input type="hidden" name="type" value="video">
                    <li>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn"/>
                    </li>
                </ul>
            </table>
        </form>
        <form action="{{url("/keyword/create")}}" method="post" class="content_tab hide" >
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableBasic">
                <ul class="ulColumn2">
                    <li>
                        <span class="item_name" style="width:120px;">关键字：</span>
                        <input type="text" class="textbox textbox_295" name="keyword" placeholder="关键字名称..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图文消息个数：</span>
                        <input type="text" class="textbox textbox_295" name="ArticleCount" placeholder="图文消息个数..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图文消息信息：</span>
                        <input type="text" name="Articles" class="textbox textbox_295">
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图文消息标题：</span>
                        <input type="text" class="textbox textbox_295" name="title" placeholder="标题..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图文消息描述：</span>
                        <textarea name="Description" id="" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">图片链接：</span>
                        <input type="text" class="textbox textbox_295" name="PicUrl" placeholder="标题..."/>
                    </li>
                    <li>
                        <span class="item_name" style="width:120px;">点击图文消息跳转链接：</span>
                        <input type="text" class="textbox textbox_295" name="Url" placeholder="标题..."/>
                    </li>
                    <input type="hidden" name="type" value="news">
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