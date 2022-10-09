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
            ['id' => 1, 'parent_id' => 0, 'type' => 0, 'title' => '系统管理', 'node_code' => 'admin.system', 'node_route' => '', 'menu_icon' => '', 'sort' => 0],
            ['id' => 2, 'parent_id' => 1, 'type' => 0, 'title' => '角色管理', 'node_code' => 'admin.role', 'node_route' => '', 'menu_icon' => '', 'sort' => 999],
            ['id' => 3, 'parent_id' => 2, 'type' => 1, 'title' => '新增角色', 'node_code' => 'admin.role.create', 'node_route' => '', 'menu_icon' => '', 'sort' => 999],
            ['id' => 4, 'parent_id' => 2, 'type' => 1, 'title' => '编辑角色', 'node_code' => 'admin.role.edit', 'node_route' => '', 'menu_icon' => '', 'sort' => 99],
            ['id' => 5, 'parent_id' => 2, 'type' => 1, 'title' => '删除角色', 'node_code' => 'admin.role.delete', 'node_route' => '', 'menu_icon' => '', 'sort' => 9],
            ['id' => 6, 'parent_id' => 1, 'type' => 0, 'title' => '账号管理', 'node_code' => 'admin.account', 'node_route' => '', 'menu_icon' => '', 'sort' => 99],
            ['id' => 7, 'parent_id' => 6, 'type' => 1, 'title' => '新增账号', 'node_code' => 'admin.account.create', 'node_route' => '', 'menu_icon' => '', 'sort' => 999],
            ['id' => 8, 'parent_id' => 6, 'type' => 1, 'title' => '编辑账号', 'node_code' => 'admin.account.edit', 'node_route' => '', 'menu_icon' => '', 'sort' => 99],
            ['id' => 9, 'parent_id' => 6, 'type' => 1, 'title' => '删除账号', 'node_code' => 'admin.account.delete', 'node_route' => '', 'menu_icon' => '', 'sort' => 9],
        ]);
    }
}
