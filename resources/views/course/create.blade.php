@extends("layout.layout")
@section("content")
    <center><font color="red" size="2">{{session("msg")}}</font></center>
    <section>
        <h2><strong style="color:grey;">课程添加</strong></h2>
        <form action="{{url("/course/create")}}" method="post">
            <ul class="ulColumn2">
                <li>
                    <span class="item_name" style="width:120px;">课程名称：</span>
                    <input type="text" class="textbox textbox_295" name="course_name" placeholder="课程名称..."/>
                </li>
                <li>
                    <span class="item_name" style="width:120px;">课程介绍：</span>
                    <textarea name="course_desc"  cols="30" rows="10"></textarea>
                </li>
                <li>
                    <span class="item_name" style="width:120px;">打赏：</span>
                    <input type="radio" name="course_pay" value="0" checked>茶叶蛋
                    <input type="radio" name="course_pay" value="1">咖啡
                </li>
                <li>
                    <span class="item_name" style="width:120px;">课程链接：</span>
                    <input type="text" class="textbox textbox_295" name="course_url" placeholder="课程链接..."/>
                </li>
                <li>
                    <span class="item_name" style="width:120px;">课程提取码：</span>
                    <input type="text" class="textbox textbox_295" name="course_code" placeholder="课程提取码..."/>
                </li>
                <li>
                    <span class="item_name" style="width:120px;"></span>
                    <input type="submit" class="link_btn"/>
                </li>
            </ul>
        </form>
    </section>
@endsection
