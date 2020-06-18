@extends("layout.layout")
@section("content")
    <center><font color="red" size="2">{{session("msg")}}</font></center>
    <div class="rt_content">
        <!--开始：以下内容则可删除，仅为素材引用参考-->
        <!--点击加载-->
        <script>
            $(document).ready(function(){
                $("#loading").click(function(){
                    $(".loading_area").fadeIn();
                    $(".loading_area").fadeOut(1500);
                });
            });
        </script>
        <section class="loading_area">
            <div class="loading_cont">
                <div class="loading_icon"><i></i><i></i><i></i><i></i><i></i></div>
                <div class="loading_txt"><mark>数据正在加载，请稍后！</mark></div>
            </div>
        </section>
        <!--结束加载-->
        <!--弹出框效果-->
        <script>
            $(document).ready(function(){
                //弹出文本性提示框
                $("#showPopTxt").click(function(){
                    $(".pop_bg").fadeIn();
                });
                //弹出：确认按钮
                $(".trueBtn").click(function(){
                    alert("你点击了确认！");//测试
                    $(".pop_bg").fadeOut();
                });
                //弹出：取消或关闭按钮
                $(".falseBtn").click(function(){
                    alert("你点击了取消/关闭！");//测试
                    $(".pop_bg").fadeOut();
                });
            });
        </script>
        <section class="pop_bg">
            <div class="pop_cont">
                <!--title-->
                <h3>弹出提示标题</h3>
                <!--content-->
                <div class="pop_cont_input">
                    <ul>
                        <li>
                            <span>标题</span>
                            <input type="text" placeholder="定义提示语..." class="textbox"/>
                        </li>
                        <li>
                            <span class="ttl">城市</span>
                            <select class="select">
                                <option>选择省份</option>
                            </select>
                            <select class="select">
                                <option>选择城市</option>
                            </select>
                            <select class="select">
                                <option>选择区/县</option>
                            </select>
                        </li>
                        <li>
                            <span class="ttl">地址</span>
                            <input type="text" placeholder="定义提示语..." class="textbox"/>
                        </li>
                        <li>
                            <span class="ttl">地址</span>
                            <textarea class="textarea" style="height:50px;width:80%;"></textarea>
                        </li>
                    </ul>
                </div>
                <!--以pop_cont_text分界-->
                <div class="pop_cont_text">
                    这里是文字性提示信息！
                </div>
                <!--bottom:operate->button-->
                <div class="btm_btn">
                    <input type="button" value="确认" class="input_btn trueBtn"/>
                    <input type="button" value="关闭" class="input_btn falseBtn"/>
                </div>
            </div>
        </section>
        <section>
            <h2><strong style="color:grey;">用户的标签列表</strong></h2>
            <div class="page_title">
                <h2 class="fl">标签</h2>
                <a class="fr top_rt_btn">右侧按钮</a>
            </div>
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>标签名称</th>
                    <th>标签id</th>
                    <th>操作</th>
                </tr>
                @foreach($tagInfo as $v)
                    <tr >
                        <td>{{$v->tag_id}}</td>
                        <td>{{$v->name}}</td>
                        <td>{{$v->id}}</td>
                        <td align="center">
                            <a href="{{url("/tag/delete/".$v->id)}}">删除</a>
                            <a href="{{url("/tag/update/".$v->id)}}">修改</a>
                            <a href="{{url("/tag/user/".$v->id)}}">展示用户</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <aside class="paging">
            </aside>
        </section>
        <!--tabStyle-->
        <script>
            $(document).ready(function(){
                //tab
                $(".admin_tab li a").click(function(){
                    var liindex = $(".admin_tab li a").index(this);
                    $(this).addClass("active").parent().siblings().find("a").removeClass("active");
                    $(".admin_tab_cont").eq(liindex).fadeIn(150).siblings(".admin_tab_cont").hide();
                });
            });
        </script>
    </div>
@endsection