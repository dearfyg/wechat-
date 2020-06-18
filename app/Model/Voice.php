<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Voice extends Model
{
    //定义表名
    protected  $table = "voice";
    //定义主键
    protected $primaryKey = "voice_id";
    //关闭时间戳
    public $timestamps = false;
}
