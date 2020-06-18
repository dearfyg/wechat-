<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Msg extends Model
{
    //定义表名
    protected  $table = "msg";
    //定义主键
    protected $primaryKey = "msg_id";
    //关闭时间戳
    public $timestamps = false;
}
