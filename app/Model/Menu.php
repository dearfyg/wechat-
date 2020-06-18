<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //定义表名
    protected  $table = "menu";
    //定义主键
    protected $primaryKey = "menu_id";
    //关闭时间戳
    public $timestamps = false;
}
