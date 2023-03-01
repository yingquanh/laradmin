<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'tb_role';

    /**
     * 与数据表关联的主键
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 关联 Account 模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany(Account::class, 'tb_admin_role', 'role_id', 'admin_id');
    }

    /**
     * 关联 Permission 模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'tb_role_permission', 'role_id', 'permission_id');
    }
}
