<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //定义表名
    protected  $table = "video";
    //定义主键
    protected $primaryKey = "video_id";
    //关闭时间戳
    public $timestamps = false;
}
