@extends("layout.layout")
@section("content")
    <section>
        <h2><strong style="color:grey;">用户标签添加</strong></h2>
        <form action="" method="post">
            <ul class="ulColumn2">
                <li>
                    <span class="item_name" style="width:120px;">用户名称：</span>
                    <span>{{$fans_name}}</span>
                </li>
                <li>
                    <span class="item_name" style="width:120px;">标签名称：</span>
                    @foreach($tag as $v)
                    <input type="checkbox"  name="tag[]" value="{{$v->id}}" @if(in_array($v->id,$tag_id)) checked @endif />{{$v->name}}
                    @endforeach
                </li>
                <li>
                    <span class="item_name" style="width:120px;"></span>
                    <input type="submit" class="link_btn"/>
                </li>
            </ul>
        </form>
    </section>
@endsection