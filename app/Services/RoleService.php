<?php

namespace App\Services;

use App\Models\Role;

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

    
}