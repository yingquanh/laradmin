<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 't_role';

    /**
     * 与数据表关联的主键
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
