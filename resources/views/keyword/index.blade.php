@extends("layout.layout")
@section("content")
    <div class="rt_content">
        <section>
            <h2><strong style="color:grey;">关键字回复展示列表</strong></h2>
            <div class="page_title">
                <h2 class="fl">已有关键词</h2>
                <a class="fr top_rt_btn">右侧按钮</a>
            </div>
            <table class="table">
                <tr>
                    <th>关键词</th>
                    <th>回复内容</th>
                    <th>类型</th>
                </tr>
                @foreach($keyInfo as $v)
                    <tr  openid="{{$v->openid}}">
                        <td style="width:265px;"><div class="cut_title ellipsis">{{$v->keyword}}</div></td>
                        <td>@if($v->type=="text") {{$v->content}} @elseif($v->type=="image"||$v->type=="voice"||$v->type=="video") {{$v->media}} @else {{$v->title}} @endif</td>
                        <td>{{$v->type}}</td>
                    </tr>
                @endforeach
            </table>
        </section>
        <!--tabStyle-->
    </div>
@endsection
