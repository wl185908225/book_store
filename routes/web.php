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
Route::get('/',  'View\MemberController@index');
Route::get('/login', 'View\MemberController@toLogin');
Route::get('/register', 'View\MemberController@toRegister')->middleware('web');
Route::get('/category', 'View\BookController@toCatetory');
Route::get('/product/category_id/{category_id}', 'View\BookController@toProduct');
Route::get('/product/{product_id}', 'View\BookController@toPdtContent');
Route::get('/cart', 'View\CartController@toCart');


Route::group(['prefix' => 'service'], function(){
    Route::get('/validate_code/create', 'Service\ValidateController@create');
    Route::post('/validate_phone/send', 'Service\ValidateController@sendSMS');
    Route::get('/validate_email', 'Service\ValidateController@validateEmail');
    Route::post('/register', 'Service\MemberController@register');
    Route::post('/login', 'Service\MemberController@login');
    Route::post('/category/parent_id/{parent_id}', 'Service\BookController@getCategoryByParent');
    Route::post('/cart/add/{product_id}', 'Service\CartController@addCart');
    Route::get('/cart/delete', 'Service\CartController@deleteCart');
    Route::post('/upload/{type}', 'Service\UploadController@uploadFile');
});


/*登录验证中间件*/
Route::group(['middleware' => ['check.login']], function(){
    Route::get('/order_commit/{product_ids}', 'View\OrderController@toOrderCommit');
    Route::get('/order_list', 'View\OrderController@toOrderList');
}); 


/*后台*/
Route::group(['prefix' => 'admin'], function(){
    Route::group(['prefix' => 'service'], function(){
        Route::post('/login', 'Admin\IndexController@login');
        Route::post('/category/add', 'Admin\CategoryController@categoryAdd');
        Route::post('/category/edit', 'Admin\CategoryController@categoryEdit');
        Route::post('/category/del', 'Admin\CategoryController@categoryDel');

        Route::post('/product/add', 'Admin\ProductController@productAdd');
        Route::post('/product/del', 'Admin\ProductController@productDel');
        Route::post('/product/edit', 'Admin\ProductController@productEdit');
    });

    Route::get('/login', 'Admin\IndexController@toLogin');
    Route::get('/index','Admin\IndexController@toIndex');
    Route::get('/category', 'Admin\CategoryController@toCategory');
    Route::get('/category_add', 'Admin\CategoryController@toCategoryAdd');
    Route::get('/category_edit', 'Admin\CategoryController@toCategoryEdit');

    Route::get('/product', 'Admin\ProductController@toProduct');
    Route::get('/product_info', 'Admin\ProductController@toProductInfo');
    Route::get('/product_add', 'Admin\ProductController@toProductAdd');
    Route::get('/product_edit', 'Admin\ProductController@toProductEdit');
}); 
