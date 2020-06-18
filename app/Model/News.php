<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //定义表名
    protected  $table = "news";
    //定义主键
    protected $primaryKey = "news_id";
    //关闭时间戳
    public $timestamps = false;
}
