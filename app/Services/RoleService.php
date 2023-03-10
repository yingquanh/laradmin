<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleService
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    protected function findBy(int $id)
    {
        return $this->role->find($id);
    }

    /**
     * 根据名称检查角色是否存在
     *
     * @param string $name
     * @param integer|null $id
     * @return bool
     */
    public function checkRoleName(string $name, int $id = null)
    {
        return $this->role
            ->where('title', $name)
            ->when(
                $id, 
                fn ($query) => $query->where('id', '<>', $id)
            )
            ->first();
    }

    /**
     * 根据列查询所有记录
     *
     * @param string ...$columns
     * @return \App\Models\Role
     */
    public function allRows(string ...$columns)
    {
        if (!count($columns)) {
            $columns = ['*'];
        }

        return $this->role->all($columns);
    }

    /**
     * 根据ID查询角色信息
     *
     * @param integer $id
     * @return \App\Models\Role
     */
    public function findRoleInfoById(int $id)
    {
        return $this->role
            ->with([
                'permissions' => function ($query) {
                    $query->select('id');
                }
            ])
            ->find($id);
    }

    /**
     * 分页查询数据
     *
     * @param Request $request
     * @return \App\Models\Role|\Throwable
     */
    public function paginate(Request $request)
    {
        return $this->role
            ->when(
                $request->input('keyword'), 
                fn ($query) => $query->where('title', 'like', '%'.trim($request->input('keyword')).'%')
            )
            ->paginate($request->input('pageSize') ?? 20);
    }

    /**
     * 存储数据
     *
     * @param Request $request
     * @return \App\Models\Role|\Throwable
     */
    public function save(Request $request)
    {
        if ($request->input('id')) {
            $this->role = $this->findBy($request->input('id'));
        }

        $this->role->title = $request->input('title');
        $this->role->description = $request->input('description') ?? '';
        $this->role->saveOrFail();

        return $this->role;
    }

    /**
     * 删除数据
     *
     * @param integer $id
     * @return \App\Models\Role|\Throwable
     */
    public function delete(int $id)
    {
        return $this->role->findOrFail($id)->delete();
    }
}