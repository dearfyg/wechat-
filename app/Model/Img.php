<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    //定义表名
    protected  $table = "img";
    //定义主键
    protected $primaryKey = "img_id";
    //关闭时间戳
    public $timestamps = false;
}
