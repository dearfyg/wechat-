@extends("layout.layout")
@section("content")
    <div class="rt_content">
        <section>
            <h2><strong style="color:grey;">课程展示列表</strong></h2>
            <div class="page_title">
                <h2 class="fl">存在的课程</h2>
                <a class="fr top_rt_btn">右侧按钮</a>
            </div>
            <table class="table">
                <tr>
                    <th>课程名称</th>
                    <th>课程介绍</th>
                    <th>打赏类型</th>
                    <th>课程链接</th>
                    <th>课程提取码</th>
                </tr>
                @foreach($courseInfo as $v)
                    <tr>
                        <td>{{$v->course_name}}</td>
                        <td>{{$v->course_desc}}</td>
                        <td>@if($v->course_pay==0) 茶叶蛋 @else 咖啡 @endif</td>
                        <td>{{$v->course_url}}</td>
                        <td>{{$v->course_code}}</td>
                    </tr>
                @endforeach
            </table>
        </section>
        <!--tabStyle-->
    </div>
@endsection
