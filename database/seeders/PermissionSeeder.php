<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_permission')->insert([
            ['id' => 1, 'parent_id' => 0, 'title' => '系统管理', 'node' => 'admin.system', 'route' => '', 'component' => '', 'icon' => 'SolutionOutlined', 'is_menu' => 1, 'sort' => 0],
            ['id' => 2, 'parent_id' => 1, 'title' => '角色管理', 'node' => 'admin.role', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 1, 'sort' => 999],
            ['id' => 3, 'parent_id' => 2, 'title' => '新增角色', 'node' => 'admin.role.create', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 0, 'sort' => 999],
            ['id' => 4, 'parent_id' => 2, 'title' => '编辑角色', 'node' => 'admin.role.edit', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 0, 'sort' => 99],
            ['id' => 5, 'parent_id' => 2, 'title' => '删除角色', 'node' => 'admin.role.delete', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 0, 'sort' => 9],
            ['id' => 6, 'parent_id' => 1, 'title' => '账号管理', 'node' => 'admin.account', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 1, 'sort' => 99],
            ['id' => 7, 'parent_id' => 6, 'title' => '新增账号', 'node' => 'admin.account.create', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 0, 'sort' => 999],
            ['id' => 8, 'parent_id' => 6, 'title' => '编辑账号', 'node' => 'admin.account.edit', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 0, 'sort' => 99],
            ['id' => 9, 'parent_id' => 6, 'title' => '删除账号', 'node' => 'admin.account.delete', 'route' => '', 'component' => '', 'icon' => '', 'is_menu' => 0, 'sort' => 9],
        ]);
    }
}
