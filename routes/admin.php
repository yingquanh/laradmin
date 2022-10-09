<?php

use App\Http\Controllers\Admin\AuthController;
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

Route::group(['middleware' => ['auth:sanctum'], 'namespace' => 'Admin', 'prefix' => 'web'], function ($route) {

    // 公共路由
    /* $route->any('ueditor', [CommonController::class, 'ueditor'])
        ->withoutMiddleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class]);
    $route->post('upload', [CommonController::class, 'upload']); */

    // 登录路由
    $route->get('captcha', [AuthController::class, 'captcha'])->withoutMiddleware(['auth:sanctum']);
    $route->post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth:sanctum']);
    $route->post('logout', [AuthController::class, 'logout']);

    // 角色路由
    /* $route->get('role', [RoleController::class, 'index']);
    $route->get('role/info', [RoleController::class, 'show']);
    $route->get('role/dictionary', [RoleController::class, 'dictionary']);
    $route->get('role/permission', [RoleController::class, 'permission']);
    $route->post('role', [RoleController::class, 'store']);
    $route->put('role', [RoleController::class, 'update']);
    $route->delete('role', [RoleController::class, 'destroy']); */

    // 管理员路由
    /* $route->get('account', [AccountController::class, 'index']);
    $route->get('account/info', [AccountController::class, 'show']);
    $route->post('account', [AccountController::class, 'store']);
    $route->put('account', [AccountController::class, 'update']);
    $route->delete('account', [AccountController::class, 'destroy']); */

});