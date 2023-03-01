<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLogged extends Model
{
    use HasFactory;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'tb_admin_logged';

    /**
     * 与数据表关联的主键
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ipv4',
        'address',
        'platform',
    ];

    /**
     * IPv4 属性修改器
     *
     * @return Attribute
     */
    protected function ipv4(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => long2ip($value),
            set: fn ($value) => ip2long($value),
        );
    }
}
