<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //定义表名
    protected  $table = "user";
    //定义主键
    protected $primaryKey = "id";
    //关闭时间戳
    public $timestamps = false;
}
