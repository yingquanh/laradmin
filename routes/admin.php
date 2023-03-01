<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CommonController;
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

Route::group(['middleware' => ['auth:sanctum', 'sanctum:admin'], 'namespace' => 'Admin', 'prefix' => 'web'], function ($router) {

    // 公共路由
    $router->prefix('common')->group(function ($router) {
        $router->get('captcha', [CommonController::class, 'captcha'])->withoutMiddleware(['auth:sanctum', 'sanctum:admin']);

    });


    /* $router->any('ueditor', [CommonController::class, 'ueditor'])
        ->withoutMiddleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class]);
    $router->post('upload', [CommonController::class, 'upload']); */

    // 认证路由
    // $router->get('captcha', [AuthController::class, 'captcha'])->withoutMiddleware(['auth:sanctum']);
    // $router->get('userinfo', [AuthController::class, 'userinfo']);
    // $router->post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth:sanctum']);
    // $router->post('logout', [AuthController::class, 'logout']);
    $router->prefix('auth')->group(function ($router) {
        $router->post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth:sanctum', 'sanctum:admin']);
        $router->post('logout', [AuthController::class, 'logout']);
        $router->get('logged_info', [AuthController::class, 'userinfo']);
    });

    // 角色路由
    $router->prefix('role')->group(function ($router) {
        $router->get('list', [RoleController::class, 'index']);
        $router->get('info', [RoleController::class, 'show']);
        $router->post('create', [RoleController::class, 'store']);
        $router->put('update', [RoleController::class, 'update']);
        $router->delete('delete', [RoleController::class, 'destroy']);
    });

    // $router->get('role', [RoleController::class, 'index'])->name('admin.role');
    // $router->get('get_role_info', [RoleController::class, 'show']);
    // $router->get('get_role_dictionary', [RoleController::class, 'dictionary']);
    // $router->get('get_permission_dictionanry', [RoleController::class, 'permission']);
    // $router->post('create_role_info', [RoleController::class, 'store'])->name('admin.role.create');
    // $router->put('update_role_info', [RoleController::class, 'update'])->name('admin.role.edit');
    // $router->delete('delete_role_info', [RoleController::class, 'destroy'])->name('admin.role.del');

    // 账号路由
    $router->prefix('account')->group(function ($router) {
        $router->get('list', [AccountController::class, 'index']);
        $router->get('info', [AccountController::class, 'show']);
        $router->post('create', [AccountController::class, 'store']);
        $router->put('update', [AccountController::class, 'update']);
        $router->delete('delete', [AccountController::class, 'destroy']);
    });

    // $router->get('account', [AccountController::class, 'index'])->name('admin.account');
    // $router->get('get_account_info', [AccountController::class, 'show']);
    // $router->post('create_account_info', [AccountController::class, 'store'])->name('admin.account.create');
    // $router->put('update_account_info', [AccountController::class, 'update'])->name('admin.account.edit');
    // $router->delete('delete_account_info', [AccountController::class, 'destroy'])->name('admin.account.del');

});