<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountPostRequest extends FormRequest
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
            'account_name' => 'bail|required',
            'account_password' => [
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
            'account_name.required' => '登录账号为必填项',
            'account_password.required' => '登录密码为必填项',
        ];
    }
}
