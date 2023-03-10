<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleInfoResource;
use App\Http\Resources\RolePaginateCollection;
use App\Http\Resources\RolePermissionResource;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    protected $roleService;
    protected $permissionService;

    public function __construct(
        RoleService $roleService, 
        PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * 获取角色列表数据
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        try {
            $list = $this->roleService->paginate($request);

            return Response::successful()->setData(new RolePaginateCollection($list))->toJson();
        } catch (\Exception $exce) {
            Log::error($exce->getMessage().':'.$exce->getLine());

            return Response::failed()->toJson();
        }
    }

    public function show(Request $request)
    {
        try {
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失']);
            }

            $info = $this->roleService->findRoleInfoById($request->input('id'));

            return Response::successful()->setData(new RoleInfoResource($info))->toJson();
        } catch (ValidationException $exce) {
            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10009, '未查询到记录')->toJson();
        }
    }

    /**
     * 角色数据字典
     *
     * @param Request $request
     * @return void
     */
    public function dictionary(Request $request)
    {
        try {
            $list = $this->roleService->allRows('id', 'role_name');

            return Response::successful()->setData($list)->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed()->toJson();
        }
    }

    /**
     * 获取权限数据
     *
     * @param Request $request
     * @return void
     */
    public function permission(Request $request)
    {
        try {
            $list = $this->permissionService->allRows();

            return Response::successful()->setData(RolePermissionResource::collection($list))->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed()->toJson();
        }
    }

    /**
     * 新建角色信息
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // 验证角色名称
            if ($this->roleService->checkRoleName($request->input('title'))) {
                throw ValidationException::withMessages(['message' => '角色名称已存在']);
            }

            // 存储数据
            $role = $this->roleService->save($request);

            // 绑定权限
            // $role->permissions()->attach($request->input('permissions'));

            DB::commit();

            return Response::successful('保存成功')->toJson();
        } catch (ValidationException $exce) {
            DB::rollBack();

            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            DB::rollBack();
            Log::error($exce);

            return Response::failed(10001)->toJson();
        }
    }

    /**
     * 更新角色信息
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失']);
            }
    
            if ($this->roleService->checkRoleName($request->input('title'), $request->input('id'))) {
                throw ValidationException::withMessages(['message' => '角色名称已存在']);
            }

            // 存储数据
            $role = $this->roleService->save($request);

            // 绑定权限
            // $role->permissions()->sync($request->input('permissions'));

            DB::commit();

            return Response::successful('提交成功')->toJson();
        } catch (ValidationException $exce) {
            DB::rollBack();

            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            DB::rollBack();
            Log::error($exce);

            return Response::failed(10003, '操作失败')->toJson();
        }
    }

    /**
     * 删除角色信息
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        try {
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失']);
            }

            $this->roleService->delete($request->input('id'));

            return Response::successful('删除成功')->toJson();
        } catch (ValidationException $exce) {
            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10003, '操作失败')->toJson();
        }
    }
}
