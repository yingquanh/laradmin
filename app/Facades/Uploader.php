<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class UploadFile
 * @package App\Facades
 * @method static string image()
 * @method static string audio()
 * @method static string video()
 * @method static string upload()
 * 
 * @see \App\Utils\Uploader
 */
class Uploader extends Facade
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
        return 'uploader';
    }
}