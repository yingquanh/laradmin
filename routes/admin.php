<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum'], 'namespace' => 'Admin', 'prefix' => 'web'], function ($router) {

    // 公共路由
    /* $router->any('ueditor', [CommonController::class, 'ueditor'])
        ->withoutMiddleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class]);
    $router->post('upload', [CommonController::class, 'upload']); */

    // 登录路由
    $router->get('captcha', [AuthController::class, 'captcha'])->withoutMiddleware(['auth:sanctum']);
    $router->get('userinfo', [AuthController::class, 'userinfo']);
    $router->post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth:sanctum']);
    $router->post('logout', [AuthController::class, 'logout']);

    // 管理员路由
    $router->get('account', [AccountController::class, 'index'])->name('admin.account');
    $router->get('get_account_info', [AccountController::class, 'show']);
    $router->post('create_account_info', [AccountController::class, 'store'])->name('admin.account.create');
    $router->put('update_account_info', [AccountController::class, 'update'])->name('admin.account.edit');
    $router->delete('delete_account_info', [AccountController::class, 'destroy'])->name('admin.account.del');

    // 角色路由
    $router->get('role', [RoleController::class, 'index'])->name('admin.role');
    $router->get('get_role_info', [RoleController::class, 'show']);
    $router->get('get_role_dictionary', [RoleController::class, 'dictionary']);
    $router->get('get_permission_dictionanry', [RoleController::class, 'permission']);
    $router->post('create_role_info', [RoleController::class, 'store'])->name('admin.role.create');
    $router->put('update_role_info', [RoleController::class, 'update'])->name('admin.role.edit');
    $router->delete('delete_role_info', [RoleController::class, 'destroy'])->name('admin.role.del');

});