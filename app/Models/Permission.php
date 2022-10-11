<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 't_permission';

    /**
     * 与数据表关联的主键
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 关联 Role 模型
     *
     * @return void
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 't_role_permission', 'permission_id', 'role_id');
    }
}
