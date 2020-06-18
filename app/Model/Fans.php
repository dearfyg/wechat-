<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fans extends Model
{
    //定义表名
    protected  $table = "fans";
    //定义主键
    protected $primaryKey = "user_id";
    //关闭时间戳
    public $timestamps = false;
    //设置白名单
    protected $fillable = ['openid',"nickname","sex","city","province","country","headimgurl","subscribe_time"];
    //时间
    protected $dates = ['subscribe_time'];
    //关联
    public function tags(){
        return $this->belongsToMany("App\Model\Tag","user_tag","user_id","tag_id");
    }
}
