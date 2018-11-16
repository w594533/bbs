<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
  'namespace' => 'App\Http\Controllers\API',
  'middleware' => ['serializer:array', 'bindings', 'throttle:60,1']
], function ($api) {
    //获取验证码
    $api->post('verify_code', 'VerificationCodesController@store')->name('api.verify_code.store');

    //用户注册，通过手机号，验证码
    $api->post('users', 'UsersController@store')->name('api.users.store');

    //第三方登录
    $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialsStore')->name('api.authorizes.socialsStore');

    //话题列表
    $api->get('topics', 'TopicsController@index')->name('api.topics.index');
    //某个用户话题列表
    $api->get('user/{user}/topics', 'TopicsController@userIndex')->name('api.user.topics.index');
    //详情
    $api->get('topics/{topic}', 'TopicsController@show')->name('api.topics.show');

    $api->get('categories', 'CategoriesController@index')->name('api.categories.index');

    //回复列表
    $api->get('replies', 'RepliesController@index')->name('api.replies.index');
    //某个有用户的回复列表
    $api->get('user/{user}/replies', 'RepliesController@userIndex')->name('api.user.replies.index');

    //边栏活跃用户
    $api->get('actived_users', 'UsersController@activedUsers')->name('api.user.actived_users');

    //友情链接
    $api->get('friend_links', 'FriendLinksController@index')->name('api.friend_links.index');

    //api上传文件测试
    $api->post('/upload', 'ImagesController@upload')->name('api.images.upload');

    $api->group(['middleware' => 'auth:api'], function ($api) {
        // 当前登录用户信息
        $api->get('/users', 'UsersController@me')->name('api.users.show');

        //图片资源
        $api->post('/images', 'ImagesController@store')->name('api.images.store');

        //修改用户信息
        $api->patch('/users', 'UsersController@update')->name('api.users.update');

        //话题相关
        $api->resource('topics', 'TopicsController', ['only' => ['store', 'update', 'destroy']]);

        //回复
        $api->post('topics/{topic}/replies', 'RepliesController@store')->name('api.replies.store');
        $api->delete('replies/{reply}', 'RepliesController@destroy')->name('api.replies.destroy');

        //消息通知列表
        $api->get('user/notifications', 'NotificationsController@userIndex')->name('api.user.notifications.index');
        //标记消息已读
        $api->patch('user/read/notifications', 'NotificationsController@read')->name('api.user.notifications.read');
    });
});
