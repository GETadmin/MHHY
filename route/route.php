<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::rule('/','index');
Route::rule('/admin', 'admin/Login/index');
Route::group('/admins',function (){

        Route::rule('login/:name', 'admin/Login/:name');
        Route::rule('index/:name', 'admin/Index/:name');
})->middleware(app\http\middleware\Check::class);
Route::group('auth',function (){
    Route::group('auth',function (){
        Route::rule(':name','admin/Auth/:name');
    });

})->middleware(app\http\middleware\Check::class);

return [];
