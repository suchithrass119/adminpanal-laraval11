<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PublicSecurity;
use App\Http\Middleware\AdminSecurity;


Route::get('/', function () {
    return view('indexpage');
});
Route::get('get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'flat') {
    return $captcha->src($config);
});
Route::get('/admin/adminerror', function () {
    return view('admin.pages.privilage');
});


Route::group(['prefix' => 'admin'], function () {


    /******************************* ADMIN Public Security middlewarew START **************************************/
    Route::middleware([PublicSecurity::class])->group(function () {
        Route::post('/getLogin', [App\Http\Controllers\Admin\SecurityController::class, 'getLogin']);
        Route::get('/logout',  [App\Http\Controllers\Admin\SecurityController::class, 'logout']);
    });

    Route::middleware([AdminSecurity::class])->group(function () {
        Route::get('/adminhome',  [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        Route::resource('/user', App\Http\Controllers\Admin\UserController::class);
        Route::resource('/add_controllers', App\Http\Controllers\Admin\ControllersController::class);
        Route::resource('/add_menu', App\Http\Controllers\Admin\MenuController::class);
        Route::get('/get_available_menus/{module_id?}',  [App\Http\Controllers\Admin\SecurityController::class, 'get_available_menus']);
        Route::resource('/add_module', App\Http\Controllers\Admin\ModuleController::class);
        Route::resource('/create_role', App\Http\Controllers\Admin\RoleController::class);
        Route::resource('/add_roleright', App\Http\Controllers\Admin\RolerightController::class);
        Route::resource('/add_userroles', App\Http\Controllers\Admin\UserroleController::class);
        Route::get('/viewprofile/{id}',  [App\Http\Controllers\Admin\SecurityController::class, 'view_profile']);
        Route::post('/editprofile',  [App\Http\Controllers\Admin\SecurityController::class, 'edit_profile']);
        Route::post('/change_password',  [App\Http\Controllers\Admin\SecurityController::class, 'change_password']);



    });

        




});