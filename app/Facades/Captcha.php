<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Captcha
 * @package App\Facades\Captcha
 * @method resource getContents()
 * @method \Gregwar\Captcha\CaptchaBuilder setInterpolation($interpolate = true)
 * @method string setPhrase($phrase)
 * @method \Gregwar\Captcha\CaptchaBuilder setDistortion($distortion)
 * @method \Gregwar\Captcha\CaptchaBuilder setMaxBehindLines($maxBehindLines)
 * @method \Gregwar\Captcha\CaptchaBuilder setMaxFrontLines($maxFrontLines)
 * @method \Gregwar\Captcha\CaptchaBuilder setMaxAngle($maxAngle)
 * @method \Gregwar\Captcha\CaptchaBuilder setMaxOffset($maxOffset)
 * @method string getPhrase()
 * @method bool testPhrase($phrase)
 * @method static \Gregwar\Captcha\CaptchaBuilder create($phrase = null)
 * @method \Gregwar\Captcha\CaptchaBuilder setTextColor($r, $g, $b)
 * @method \Gregwar\Captcha\CaptchaBuilder setBackgroundColor($r, $g, $b)
 * @method \Gregwar\Captcha\CaptchaBuilder setLineColor($r, $g, $b)
 * @method \Gregwar\Captcha\CaptchaBuilder setIgnoreAllEffects($ignoreAllEffects)
 * @method \Gregwar\Captcha\CaptchaBuilder setBackgroundImages(array $backgroundImages)
 * @method bool isOCRReadable()
 * @method mixed buildAgainstOCR($width = 150, $height = 40, $font = null, $fingerprint = null)
 * @method \Gregwar\Captcha\CaptchaBuilder build($width = 150, $height = 40, $font = null, $fingerprint = null)
 * @method resource distort($image, $width, $height, $bg)
 * @method mixed save($filename, $quality = 90)
 * @method resource getGd()
 * @method resource get($quality = 90)
 * @method string inline($quality = 90)
 * @method resource output($quality = 90)
 * @method array getFingerprint()
 * 
 * @see \Gregwar\Captcha\CaptchaBuilder
 */
class Captcha extends Facade
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
        return 'captcha';
    }
}