@extends("layout.layout")
@section("content")
    <div class="rt_content">
        <section>
            <form action="">
                内容搜索：<input type="text">
                <button>搜索</button>
            </form>
            <h2><strong style="color:grey;">群发消息展示列表</strong></h2>
            <div class="page_title">
                <h2 class="fl">存在的群发</h2>
                <a class="fr top_rt_btn">右侧按钮</a>
            </div>
            <table class="table">
                <tr>
                    <th>群发内容</th>
                    <th>群发对象</th>
                    <th>群发类型</th>
                </tr>
                @foreach($msg as $v)
                    <tr>
                        <td>{{$v->content}}</td>
                        <td>{{$v->people}}</td>
                        <td>{{$v->type}}</td>
                    </tr>
                @endforeach
            </table>
        </section>
        <!--tabStyle-->
    </div>
@endsection
