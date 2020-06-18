<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //定义表名
    protected  $table = "course";
    //定义主键
    protected $primaryKey = "course_id";
    //关闭时间戳
    public $timestamps = false;
    protected $fillable = ['course_name',"course_url","course_desc","course_code","course_pay"];
}
