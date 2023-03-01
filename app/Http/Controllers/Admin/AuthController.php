<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminState;
use App\Events\AdminAuthenticated;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthPostRequest;
use App\Http\Resources\AdminPermissionResource;
use App\Services\AccountService;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $accountService;
    protected $roleService;
    protected $permissionService;

    public function __construct(
        AccountService $accountService, 
        RoleService $roleService, 
        PermissionService $permissionService)
    {
        $this->accountService = $accountService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * 登录系统
     *
     * @param AuthPostRequest $request
     * @return void
     */
    public function login(Request $request)
    {
        try {
            $admins = $this->accountService->findByAccountName($request->input('account'));

            if (is_null($admins)) {
                throw ValidationException::withMessages(['message' => '账号不存在!']);
            }

            // 缓存键名
            $cacheKey = sprintf('AdminLoginPasswdError_%d', $admins->id);

            if (Cache::has($cacheKey) && Cache::get($cacheKey) >=3) {
                throw ValidationException::withMessages(['message' => '登录密码错误次数超过限制!']);
            }

            // 解密登录密码密文
            $passwd = openssl_decrypt(
                hex2bin($request->input('password')), 
                'AES-128-CBC', 
                '3D57269CC8919245', 
                OPENSSL_RAW_DATA, 
                '349F65A7F1B85BDF'
            );
            if (!Hash::check($passwd, $admins['password'])) {
                // 登录密码不正确时，记录该行为
                // 采用 cache 进行计数, 重置或密码正确则清除 cache 值
                $number = Cache::pull($cacheKey, 0) + 1;
                // 存储用户登录密码错误次数
                Cache::add($cacheKey, $number, now()->addRealHours(3));
                // 计算剩余可登录次数
                $surplus = 3 - $number;
    
                throw ValidationException::withMessages(['message' => sprintf('密码错误,您还可以尝试[%d]次!', $surplus)]);
            }

            // 验证账号状态
            if ($admins['status'] === AdminState::Abnormal) {
                throw ValidationException::withMessages(['message' => '账号异常, 请联系管理员重置账号!']);
            } elseif ($admins['status'] === AdminState::Disabled) {
                throw ValidationException::withMessages(['message' => '账号被禁止使用, 请联系管理员解除封禁!']);
            }

            // 生成token
            $token = $admins->createToken($admins->account, ['AdminLogged'], now()->addHours(3));

            // 登录成功后事件
            event(new AdminAuthenticated($admins, $request));

            return Response::successful()->setData([
                'token' => $token->plainTextToken,
            ])->toJson();
        } catch (ValidationException $exce) {
            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10009, '登录失败')->toJson();
        }
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        // 退出登录并清除 Session 值
        Auth::guard('admin')->logout();

        // $request->session()->invalidate();

        // 重新生成CSRF令牌值
        $request->session()->regenerateToken();

        return response()->json([
            'errcode' => 0,
            'errmsg' => 'ok',
            'data' => []
        ]);
    }

    public function userinfo(Request $request)
    {
        // 管理员信息
        $admins = Auth::guard('admin')->user();

        // 动态路由
        $permissions = $this->permissionService->findByAccountIdRows($admins['id']);

        // 导航菜单
        $menus = $this->buildMenuTree(array_filter($permissions->toArray(), function ($permission) {
            return $permission['is_menu'] == 1;
        }));

        return response()->json([
            'errcode' => 0,
            'errmsg' => 'ok',
            'data' => [
                'admins' => $admins,
                'permissions' => AdminPermissionResource::collection($permissions),
                'menus' => $menus
            ]
        ]);
    }

    protected function buildMenuTree($list, int $parent_id = 0)
    {
        $menuArr = [];

        if ($list) {
            foreach ($list as $menu) {
                if ($menu['parent_id'] == $parent_id) {
                    $menu['children'] = $this->buildMenuTree($list, $menu['id']);
                    $menuArr[] = $menu;
                }
            }
        }

        return $menuArr;
    }
}
