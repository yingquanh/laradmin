<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Captcha;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CommonController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * 验证码
     *
     * @return void
     */
    public function captcha()
    {
        try {
            $builder = Captcha::create(4)
                ->setBackgroundColor(255, 255, 255)     // 设置校验码图片背景颜色
                ->setLineColor(0, 0, 0)
                ->setInterpolation(false)
                ->setIgnoreAllEffects(true)             // 禁用校验码效果
                ->build(125, 60);

            // 存储校验码
            $captchaKey = md5(sprintf('check_code_%s_%d_b6c5ee9fe10bfd00a9', config('app.key'), microtime(true)));
            Cache::put($captchaKey, strtolower($builder->getPhrase()), 300);

            return Response::successful()->setData([
                'base64url' => $builder->inline(),
                'phrase' => $builder->getPhrase(),
            ])->setHeaders([
                'Captchakey' => $captchaKey,
            ])->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed()->toJson();
        }
    }
}