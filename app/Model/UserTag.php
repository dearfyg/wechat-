<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserTag extends Model
{
    //定义表名
    protected $table = "user_tag";
    //关闭时间戳
    public $timestamps = false;
    //设置白名单
    protected $fillable = ["user_id", 'id',"openid","tag_id"];
}
