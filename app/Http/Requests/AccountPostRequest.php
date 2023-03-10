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
            'account' => 'bail|required',
            'password' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) {
                    // 解密登录密码密文
                    // $passwd = openssl_decrypt(hex2bin($value), 'AES-128-CBC', '3D57269CC8919245', OPENSSL_RAW_DATA, '349F65A7F1B85BDF');
                    $passwd = $value;
                    if (strlen($passwd) < 8 || strlen($passwd) > 26) {
                        $fail('登录密码长度为8~26个字符');
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
        ];
    }
}
