<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    protected function findBy(int $id)
    {
        return $this->permission->find($id);
    }

    /**
     * 根据账号ID查询管理员权限数据
     *
     * @param integer $account_id
     * @return object
     */
    public function findByAccountIdRows(int $account_id)
    {
        return $this->permission
            ->whereHas('roles', function ($query) use ($account_id) {
                $query->whereHas('admins', function ($query) use ($account_id) {
                    $query->where('id', $account_id);
                });
            })
            ->orderByDesc('sort')
            ->get();
    }

    /**
     * 根据字段查询所有权限数据
     *
     * @param string ...$columns
     * @return \App\Models\Permission
     */
    public function allRows(string ...$columns)
    {
        if (!count($columns)) {
            $columns = ['*'];
        }
        
        return $this->permission->all($columns);
    }
}