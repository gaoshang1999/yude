<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication routes...
$app->get('auth/login', ['as'=>'userlogin', 'uses'=>'Auth\AuthController@getLogin']);
$app->post('auth/login', 'Auth\AuthController@postLogin');
$app->get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
$app->post('auth/sendverifycode', 'Auth\AuthController@sendCode');
$app->get('auth/register', 'Auth\AuthController@getRegister');
$app->post('auth/register', 'Auth\AuthController@postRegister');

// // Password reset link request routes...
// $app->get('password/email', 'Auth\PasswordController@getEmail');
// $app->post('password/email', 'Auth\PasswordController@postEmail');

// // Password reset routes...
// $app->get('password/reset/{token}', 'Auth\PasswordController@getReset');
// $app->post('password/reset', 'Auth\PasswordController@postReset');

$app->get('/', function() use ($app) {
    return view('welcome');
});

// 管理员后台
$app->group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => ['auth.login', 'auth.admin']], function($app){
    $app->get('/', 'UserController@userlist');
    $app->get('/user', 'UserController@userlist');
    $app->get('/user/add', 'UserController@useradd');
    $app->post('/user/add', 'UserController@useradd');
    $app->get('/user/edit/{id}', 'UserController@useredit');
    $app->post('/user/edit/{id}', 'UserController@useredit');
});

// 用户后台
$app->group(['namespace' => 'App\Http\Controllers\My', 'prefix' => 'my', 'middleware' => 'auth.login'], function($app){
    $app->get('/', 'MyController@dashboard');
    $app->get('/profile', 'MyController@dashboard');
});