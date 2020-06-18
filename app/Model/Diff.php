<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Diff extends Model
{
    //定义表名
    protected  $table = "diff";
    //关闭时间戳
    public $timestamps = false;
}
