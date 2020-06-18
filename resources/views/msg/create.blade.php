@extends("layout.layout")
@section("content")
    <center><font color="red" size="2">{{session("msg")}}</font></center>
    <section>
        <h2><strong style="color:grey;">群发消息添加</strong></h2>
        <form action="{{url("/msg/create")}}" method="post">
            <ul class="ulColumn2">
                <li>
                    <span class="item_name" style="width:120px;">群发对象：</span>
                    <select name="people" >
                        @foreach($fans as $v)
                            <option value="{{$v->openid}}">{{$v->nickname}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <span class="item_name" style="width:120px;">群发内容：</span>
                    <textarea name="content"  cols="30" rows="10"></textarea>
                    如果是图片、语音、视频请输入media_id.
                </li>
                <li>
                    <span class="item_name" style="width:120px;">群发类型：</span>
                    <select name="type" id="">
                        <option value="text">文本</option>
                        <option value="image">图片</option>
                        <option value="voice">语音</option>
                        <option value="mpvideo">视频</option>
                    </select>
                </li>
                <li>
                    <span class="item_name" style="width:120px;"></span>
                    <input type="submit" class="link_btn"/>
                </li>
            </ul>
        </form>
    </section>
@endsection
