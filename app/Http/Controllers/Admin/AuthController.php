<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Captcha;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function __construct()
    {
        
    }

    public function captcha()
    {
        $builder = Captcha::create(4)
            ->setBackgroundColor(249, 249, 249)     // 设置校验码图片背景颜色
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

    public function login()
    {

    }

    public function logout()
    {

    }
}
