@extends("layout.layout")
@section("content")
    <div class="rt_content">
        <section>
            <h2><strong style="color:grey;">菜单展示列表</strong></h2>
            <div class="page_title">
                <h2 class="fl">目前菜单</h2>
                <a class="fr top_rt_btn" href="{{url("/menu/menu")}}">生成菜单</a>
            </div>
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>菜单名称</th>
                    <th>菜单类型</th>
                    <th>菜单内容</th>
                </tr>
                @foreach($menu as $v)
                    <tr>
                        <td>{{$v["menu_id"]}}</td>
                        <td>@if($v["pid"]!=0)-----@endif{{$v["menu_name"]}}</td>
                        <td>{{$v["menu_type"]}}</td>
                        <td>{{$v["menu_content"]}}</td>
                    </tr>
                @endforeach
            </table>
        </section>
        <!--tabStyle-->
    </div>
@endsection
