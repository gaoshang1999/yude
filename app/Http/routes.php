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
$app->post('auth/phonecheck/{phone}', 'Auth\AuthController@phoneCheck');

// Registration routes...
$app->post('auth/sendverifycode', 'Auth\AuthController@sendCode');
$app->get('auth/register', 'Auth\AuthController@getRegister');
$app->post('auth/register', 'Auth\AuthController@postRegister');
$app->post('auth/ajax_register', 'Auth\AuthController@ajaxPostRegister');
$app->post('auth/reset', 'Auth\AuthController@resetPassword');

// // Password reset link request routes...
// $app->get('password/email', 'Auth\PasswordController@getEmail');
// $app->post('password/email', 'Auth\PasswordController@postEmail');

// // Password reset routes...
// $app->get('password/reset/{token}', 'Auth\PasswordController@getReset');
// $app->post('password/reset', 'Auth\PasswordController@postReset');

$app->get('/', 'Front\HomeController@home');
$app->get('/books/lists', 'Admin\BooksController@lists');
$app->get('/books/{id}', 'Admin\BooksController@detail');
$app->get('/courses/lists', 'Admin\CoursesController@lists');
$app->get('/courses/{id}', 'Admin\CoursesController@detail');
$app->get('/cart/courses/add/{id}', 'My\MyController@courses_add');
$app->post('/cart/courses/add/{id}', 'My\MyController@courses_add');
$app->get('/cart/books/add/{id}', 'My\MyController@books_add');
$app->post('/cart/books/add/{id}', 'My\MyController@books_add');
$app->get('/cart/courses/remove/{id}', 'My\MyController@courses_remove');
$app->get('/cart/books/remove/{id}', 'My\MyController@books_remove');
$app->post('/ablesky/usercheck/{username}', 'Ablesky\AbleskyController@checkIfUserNameDuplicated');
$app->post('/ablesky/emailcheck/{email}', 'Ablesky\AbleskyController@checkIfEmailDuplicated');
// $app->get('/', function() use ($app) {
//     return view('front.wxjz');
// });


// 管理员后台
$app->group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => ['auth.login', 'auth.admin']], function($app){
    $app->get('/', 'UserController@userlist');

    // 用户管理
    $app->get('/user', 'UserController@userlist');
    $app->get('/user/add', 'UserController@useradd');
    $app->post('/user/add', 'UserController@useradd');
    $app->get('/user/edit/{id}', 'UserController@useredit');
    $app->post('/user/edit/{id}', 'UserController@useredit');
    $app->post('/user/delete/{id}', 'UserController@delete');
    $app->get('/user/reset/{id}', 'UserController@reset');
    $app->post('/user/reset/{id}', 'UserController@reset');
    $app->get('/user/search', 'UserController@search');
    
    
    // 课程管理
    $app->get('/courses', 'CoursesController@courses');
    $app->get('/courses/add', 'CoursesController@coursesadd');
    $app->post('/courses/add', 'CoursesController@coursesadd');
    $app->get('/courses/edit/{id}', 'CoursesController@coursesedit');
    $app->post('/courses/edit/{id}', 'CoursesController@coursesedit');
    $app->post('/courses/delete/{id}', 'CoursesController@delete');
    $app->get('/courses/search', 'CoursesController@search');
    
    // 课程组管理
    $app->get('/groups', 'GroupsController@groups');
    $app->get('/groups/add', 'GroupsController@groupsadd');
    $app->post('/groups/add', 'GroupsController@groupsadd');
    $app->get('/groups/edit/{id}', 'GroupsController@groupsedit');
    $app->post('/groups/edit/{id}', 'GroupsController@groupsedit');
    $app->post('/groups/delete/{id}', 'GroupsController@delete');
    $app->get('/groups/search', 'GroupsController@search');
    
    // 教材管理
    $app->get('/books', 'BooksController@books');
    $app->get('/books/add', 'BooksController@booksadd');
    $app->post('/books/add', 'BooksController@booksadd');
    $app->get('/books/edit/{id}', 'BooksController@booksedit');
    $app->post('/books/edit/{id}', 'BooksController@booksedit');
    $app->post('/books/delete/{id}', 'BooksController@delete');
    $app->get('/books/search', 'BooksController@search');


    // 订单管理
    $app->get('/orders', 'OrdersController@orders');
    $app->post('/orders/new', 'OrdersController@neworder');
    $app->get('/orders/{id}', 'OrdersController@detail');
    $app->post('/orders/open/{id}', 'OrdersController@open');
});

//能力天空接口-课程目录树
$app->group(['namespace' => 'App\Http\Controllers\Ablesky', 'prefix' => 'ablesky', 'middleware' => ['auth.login', 'auth.admin']], function($app){
    $app->post('/category/update', 'AbleskyController@update_ablesky_category');
    $app->get('/category/tree', 'AbleskyController@list_ablesky_category');
});

//能力天空接口-跳转
$app->group(['namespace' => 'App\Http\Controllers\Ablesky', 'prefix' => 'ablesky', 'middleware' => ['auth.login']], function($app){    
   $app->get('/redirect', 'AbleskyController@oneStopRedirect');
});

// 用户后台
$app->group(['namespace' => 'App\Http\Controllers\My', 'prefix' => 'my', 'middleware' => 'auth.login'], function($app){
    $app->get('/', 'MyController@order');
    $app->get('/profile', 'MyController@personal');
});

// 订单
$app->group(['namespace' => 'App\Http\Controllers', 'prefix' => 'order', 'middleware' => 'auth.login'], function($app){
    $app->get('/', 'OrderController@step1');
    $app->get('/step1', 'OrderController@step1');
    $app->get('/step2', 'OrderController@step2');
    $app->post('/step3', 'OrderController@step3');
    $app->get('/payonline/{orderno}', 'OrderController@payonline');
    $app->get('/topay/{orderno}', 'OrderController@topay');
    $app->get('/step4', 'OrderController@step4');
});

// 支付宝
$app->group(['namespace' => 'App\Http\Controllers\Pay', 'prefix' => 'alipay'], function($app){
    $app->get('/test', 'AlipayController@ali_test');
    $app->get('/return', 'AlipayController@ali_return');
    $app->post('/notify', 'AlipayController@ali_notify');
});

// 微信支付
$app->group(['namespace' => 'App\Http\Controllers\Pay', 'prefix' => 'wxpay'], function($app){
    $app->get('/qrcode/{orderno}/{totalprice}', 'WxPayController@payqrcode');
    $app->get('/pay/{orderno}', 'WxPayController@pay');
    $app->get('/checkorder/{orderno}', 'WxPayController@checkorder');
    $app->post('/notify', 'WxPayController@wx_notify');
});

// 易支付
$app->group(['namespace' => 'App\Http\Controllers\Pay', 'prefix' => 'yizhifu'], function($app){
    $app->post('/notify', 'YizhifuController@yzf_notify');
    $app->get('/return', 'YizhifuController@yzf_return');
});


