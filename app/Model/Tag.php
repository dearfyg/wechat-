<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //定义表名
    protected  $table = "tag";
    //定义主键
    protected $primaryKey = "tag_id";
    //关闭时间戳
    public $timestamps = false;
    //设置白名单
    protected $fillable = ["name",'id'];
    //关联模板
    public function userfans(){
        return $this->belongsToMany("App\Model\Fans","user_tag","tag_id","user_id");
    }
}
