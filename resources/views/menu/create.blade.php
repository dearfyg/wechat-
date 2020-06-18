@extends("layout.layout")
@section("content")
    <center><font color="red" size="2">{{session("msg")}}</font></center>
    <section>
        <h2><strong style="color:grey;">菜单添加</strong></h2>
        <form action="{{url("/menu/create")}}" method="post">
            <ul class="ulColumn2">
                <li>
                    <span class="item_name" style="width:120px;">菜单名称：</span>
                    <input type="text" name="menu_name">
                </li>
                <li>
                    <span class="item_name" style="width:120px;">菜单类型：</span>
                    <input type="radio" value="view" name="menu_type" checked>view
                    <input type="radio" value="click" name="menu_type">click
                    <input type="radio" value="pic_photo_or_album" name="menu_type">pic_photo_or_album
                </li>
                <li>
                    <span class="item_name" style="width:120px;">菜单所属分类：</span>
                    <select name="pid" id="">
                        <option value="0">一级菜单</option>
                        @foreach($menu as $v)
                            <option value="{{$v->menu_id}}">{{$v->menu_name}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <span class="item_name" style="width:120px;">菜单内容：</span>
                    <input type="text" name="content">
                    click类型需要填写字符串.view填写一个url.
                </li>
                <li>
                    <span class="item_name" style="width:120px;"></span>
                    <input type="submit" class="link_btn"/>
                </li>
            </ul>
        </form>
    </section>
@endsection
