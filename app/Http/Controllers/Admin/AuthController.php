<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Captcha;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthPostRequest;
use App\Services\AccountService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $accountService;
    protected $roleService;

    public function __construct(
        AccountService $accountService, 
        RoleService $roleService)
    {
        $this->accountService = $accountService;
        $this->roleService = $roleService;
    }

    /**
     * 验证码
     *
     * @return void
     */
    public function captcha()
    {
        $builder = Captcha::create(4)
            ->setBackgroundColor(255, 255, 255)     // 设置校验码图片背景颜色
            ->setLineColor(0, 0, 0)
            ->setInterpolation(false)
            ->setIgnoreAllEffects(true)             // 禁用校验码效果
            ->build(125, 60);

        // 存储校验码
        $captchaKey = md5(sprintf('%s+%s+%s', config('app.key'), microtime(true), 'b6c5ee9fe10bfd00a9'));
        Cache::put($captchaKey, strtolower($builder->getPhrase()), 300);

        return response()->json([
            'errcode' => 0,
            'errmsg' => 'ok',
            'data' => $builder->inline()
        ])->withHeaders([
            'Captcha-Key' => $captchaKey
        ]);
    }

    /**
     * 登录系统
     *
     * @param AuthPostRequest $request
     * @return void
     */
    public function login(AuthPostRequest $request)
    {
        $credentials = [
            'account_name' => $request->input('account'),
            
        ];

        $admins = $this->accountService->findByAccountName($request->input('account'));
        if (is_null($admins)) {
            throw ValidationException::withMessages(['message' => '账号不存在!']);
        } elseif ($admins['status'] < 0) {
            throw ValidationException::withMessages(['message' => '账号异常, 请联系管理员重置账号!']);
        } elseif ($admins['status'] > 0) {
            throw ValidationException::withMessages(['message' => '账号被禁止使用, 请联系管理员解除封禁!']);
        }

        // 解密登录密码密文
        $passwd = openssl_decrypt(
            hex2bin($request->input('password')), 
            'AES-128-CBC', 
            '3D57269CC8919245', 
            OPENSSL_RAW_DATA, 
            '349F65A7F1B85BDF'
        );
        if (!Hash::check($passwd, $admins['account_password'])) {
            // 登录密码不正确时，记录该行为
            // 采用 cache 进行计数, 重置或密码正确则清除 cache 值
            $login_passwd_error_number = 1;

            throw ValidationException::withMessages(['message' => sprintf('密码错误,您还可以尝试[%d]次!', $login_passwd_error_number)]);
        }

        // 登录行为记录

        // 账号密码登录
        Auth::guard('admin')->login($admins, $request->input('remember'));

        return response()->json([
            'errcode' => 0,
            'errmsg' => 'ok',
            'data' => [
                // 'admins' => $admins,
                // 'permissions' => $permissions
            ]
        ]);
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
}
