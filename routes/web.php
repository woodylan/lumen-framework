<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/api/dev', ['namespace' => 'App\Http\Controllers', 'uses' => 'Dev@run']);

//免登录
$router->group(['prefix' => "/api/admin/v1/",'namespace' => 'Admin'], function () use ($router) {
    $router->group(['prefix' => "account/", 'namespace' => 'Account'], function () use ($router) {
        $router->post('/login', ['uses' => 'Login@run']);
    });
});

//web端
$router->group(['prefix' => "/api/web/v1/", 'namespace' => 'Web'], function () use ($router) {
    $router->group(['middleware' => ['adminAuth']], function () use ($router) {
        //帐号
        $router->group(['prefix' => "account/", 'namespace' => 'Account'], function () use ($router) {
            $router->post('/check-auth', ['uses' => 'CheckAuth@run']);
        });

        //用户
        $router->group(['prefix' => "user/", 'namespace' => 'User'], function () use ($router) {
            $router->post('/list', ['uses' => 'GetList@run']);
        });
    });
});

//匹配任意路由的options请求
$router->options('/api/{all:.+}', function () {
    return ['code' => 0, 'msg' => '', 'data' => new \stdClass];
});