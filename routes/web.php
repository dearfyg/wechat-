<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(["aouth"])->any('/weIndex',"Home\LoginController@weIndex");//微信首页面
Route::middleware(["aouth"])->any('/course/detail/{id}',"Home\CourseController@detail");//课程详情
Route::any("/aouth/code","Home\AouthController@code");//回调地址
Route::any('/',"Home\LoginController@login");//登录页面
Route::post('/loginDo',"Home\LoginController@loginDo");//登录方法
Route::any('/index',"Home\UserController@index");//首页
Route::any('/wechat','Home\WechatController@wechat');//发送
Route::get('/test','Home\TestController@test');//调试
Route::any('/remark',"Home\UserController@remark");//备注
Route::any('/black/{openid}',"Home\UserController@black");//拉黑
Route::any('/reblack/{openid}',"Home\UserController@reblack");//取消拉黑
Route::any('/user/tag/{openid}',"Home\UserController@userTag");//用户标签
Route::any('/tag/create',"Home\TagController@create");//标签添加
Route::any('/tag/index',"Home\TagController@index");//标签展示
Route::any('/tag/update/{id}',"Home\TagController@update");//标签展示
Route::any('/tag/delete/{id}',"Home\TagController@delete");//标签删除
Route::any('/tag/user/{id}',"Home\TagController@user");//标签用户展示
Route::any('/source/index',"Home\SourceController@index");//素材展示
Route::any('/source/create',"Home\SourceController@create");//素材添加
Route::any('/source/img',"Home\SourceController@img");//素材图片添加
Route::any('/source/voice',"Home\SourceController@voice");//素材音频添加
Route::any('/source/video',"Home\SourceController@video");//素材视频添加
Route::any('/source/news',"Home\SourceController@news");//素材图文添加
Route::any('/keyword/create',"Home\KeywordController@create");//关键字添加
Route::any('/keyword/index',"Home\KeywordController@index");//关键字展示
Route::any('/course/index',"Home\CourseController@index");//课程展示
Route::any('/course/create',"Home\CourseController@create");//课程添加

Route::any('/msg/index',"Home\MsgController@index");//群发展示
Route::any('/msg/create',"Home\MsgController@create");//群发添加
Route::any('/menu/create',"Home\MenuController@create");//菜单添加
Route::any('/menu/index',"Home\MenuController@index");//菜单列表
Route::any('/menu/menu',"Home\MenuController@menu");//生成菜单
Route::any('/qrcode',"Home\QrcodeController@index");//二维码页面
Route::any('/qrcode/qrcode',"Home\QrcodeController@qrcode");//生成二维码
Route::any('/qrcode/check',"Home\QrcodeController@check_qrcode");//检测二维码
Route::any('/qrcode/aouth_one',"Home\QrcodeController@aouth_one");//授权第一步
Route::any('/qrcode/aouth_two',"Home\QrcodeController@aouth_two");//授权第二部

Route::any('/aaa',"Controller@get_access_token");//测试



