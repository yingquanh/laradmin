<?php

namespace App\Utils;

use Illuminate\Support\Facades\Response;

class HttpResponse
{
    protected $code = 0;
    protected $message;
    protected $data = [];
    protected $statusCode = 200;

    /**
     * 公共错误消息
     */
    const COMMON_ERROR_MESSAGE = [
        10001 => '保存失败',
        10002 => '更新失败',
        10003 => '删除失败',
    ];

    public function __construct(int $code = 0, string $message = 'success', array|object $data = [], int $statusCode = 200)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode(int $code)
    {
        $this->code = $code;
        
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(array|object $data)
    {
        $this->data = $data;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    protected function toArray()
    {
        if (array_key_exists($this->code, self::COMMON_ERROR_MESSAGE)) {
            $this->setMessage(self::COMMON_ERROR_MESSAGE[$this->code]);
        }

        $data = [
            'errcode' => $this->code,
            'errmsg' => $this->message,
            'data' => $this->data
        ];

        return $data;
    }

    public function toJson()
    {
        return Response::json($this->toArray(), $this->getStatusCode());
    }

    public static function successful(string $message = 'success')
    {
        return new static(0, $message, [], 200);
    }

    public static function failed(int $code = 10000, string $message = 'fail')
    {
        return new static($code, $message, [], 200);
    }

    
}