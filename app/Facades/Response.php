<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class HttpResponse
 * @package App\Faceds\Response
 * @method int getCode()
 * @method \App\Utils\HttpResponse setCode()
 * @method int getStatusCode()
 * @method string getMessage()
 * @method \App\Utils\HttpResponse setMessage(string $message)
 * @method array|object getData();
 * @method \App\Utils\HttpResponse setData(array|object $data)
 * @method \App\Utils\ApiResponse setStatusCode(int $statusCode)
 * @method \Illuminate\Http\JsonResponse toJson()
 * @method static \App\Utils\HttpResponse successful(string $message = 'success')
 * @method static \App\Utils\HttpResponse failed(int $code = 10000, string $message = 'fail')
 * 
 * @see \App\Utils\HttpResponse
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'respond';
    }
}