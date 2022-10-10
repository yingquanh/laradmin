<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class AuthPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account' => 'bail|required',
            'password' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) {
                    // 解密登录密码密文
                    $passwd = openssl_decrypt(hex2bin($value), 'AES-128-CBC', '3D57269CC8919245', OPENSSL_RAW_DATA, '349F65A7F1B85BDF');
                    if (strlen($passwd) < 6 || strlen($passwd) > 24) {
                        $fail('登录密码长度为6~24个字符');
                    }
                },
            ],
            'captcha' => [
                'bail',
                'required',
                'size:4',
                function ($attribute, $value, $fail) {
                    info($attribute);
                    if (!Cache::has($this->header('captcha_key'))) {
                        $fail('校验码已过期');
                    } elseif (strtolower($value) !== Cache::pull($this->header('captcha_key'))) {
                        $fail('校验码不正确');
                    }
                },
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'account.required' => '登录账号为必填项',
            'password.required' => '登录密码为必填项',
            'captcha.required' => '校验码为必填项',
            'captcha.size' => '校验码长度为4个字符'
        ];
    }
}
