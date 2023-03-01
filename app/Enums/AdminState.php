<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * 管理员账号状态枚举
 * @method static static Abnormal()
 * @method static static Normal()
 * @method static static Disabled()
 */
final class AdminState extends Enum
{
    /**
     * 异常状态
     */
    const Abnormal = -1;

    /**
     * 正常状态
     */
    const Normal = 0;

    /**
     * 禁用状态
     */
    const Disabled = 1;
}
