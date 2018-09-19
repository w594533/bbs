<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('users', 'UserController', ['only' => ['index', 'show', 'edit', 'update']]);
    $router->resource('roles', 'RoleController', ['only' => ['index', 'edit', 'update', 'create']]);
    $router->resource('permissions', 'PermissionController', ['only' => ['index', 'edit', 'update', 'create']]);
    $router->resource('categories', 'CategoryController');
    $router->resource('topics', 'TopicController', ['only' => ['index', 'show', 'destroy']]);
    $router->resource('friend_links', 'FriendLinkController');

});
