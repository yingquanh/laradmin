<?php

namespace App\Enums;

enum AccountStatus: int
{
    case Abnormal = -1;     // 异常状态
    case Normal = 0;        // 正常状态
    case Disabled = 1;      // 禁用状态
}