<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountPostRequest;
use App\Http\Resources\AccountInfoResource;
use App\Http\Resources\AccountPaginateCollection;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
        try {
            $list = $this->accountService->paginate($request);

            return response()->json([
                'errcode' => 0,
                'errmsg' => 'ok',
                'data' => new AccountPaginateCollection($list)
            ]);
        } catch (\Exception $exce) {
            Log::error($exce->getMessage().':'.$exce->getLine());

            return response()->json([
                'errcode' => 10001,
                'errmsg' => 'fail',
                'data' => []
            ]);
        }
    }

    /**
     * 获取账号信息
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request)
    {
        if (!$request->filled('id')) {
            throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失!']);
        }

        try {
            $info = $this->accountService->findAccountInfoById($request->input('id'));

            return response()->json([
                'errcode' => 0,
                'errcode' => 'ok',
                'data' => new AccountInfoResource($info)
            ]);
        } catch (\Exception $exce) {
            Log::error($exce->getMessage().':'.$exce->getLine());

            return response()->json([
                'errcode' => 10001,
                'errmsg' => 'fail',
                'data' => []
            ]);
        }
    }

    /**
     * 新增账号信息
     *
     * @param AccountPostRequest $request
     * @return void
     */
    public function store(AccountPostRequest $request)
    {
        if ($this->accountService->checkAccountName($request->input('account_name'))) {
            throw ValidationException::withMessages(['message' => '账号已存在!']);
        }

        if ($this->accountService->checkAccountEmail($request->input('email'))) {
            throw ValidationException::withMessages(['message' => '邮箱已存在!']);
        }

        if ($this->accountService->checkMobileNumber($request->input('mobile'))) {
            throw ValidationException::withMessages(['message' => '手机号码已存在!']);
        }

        DB::beginTransaction();
        try {
            // 存储账号信息
            $account = $this->accountService->save($request);

            // 附加用户组
            $account->roles()->attach($request->input('role_id'));

            DB::commit();

            return response()->json([
                'errcode' => 0,
                'errmsg' => '保存成功',
                'data' => []
            ]);
        } catch (\Exception $exce) {
            DB::rollBack();
            Log::error($exce->getMessage().':'.$exce->getLine());

            return response()->json([
                'errcode' => 10003,
                'errmsg' => '保存失败',
                'data' => []
            ]);
        }
    }

    /**
     * 更新账号信息
     *
     * @param AccountPostRequest $request
     * @return void
     */
    public function update(AccountPostRequest $request)
    {
        if (!$request->filled('id')) {
            throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失!']);
        }

        if ($this->accountService->checkAccountName($request->input('account_name'), $request->input('id'))) {
            throw ValidationException::withMessages(['message' => '账号已存在!']);
        }

        if ($this->accountService->checkAccountEmail($request->input('email'), $request->input('id'))) {
            throw ValidationException::withMessages(['message' => '邮箱已存在!']);
        }

        if ($this->accountService->checkMobileNumber($request->input('mobile'), $request->input('id'))) {
            throw ValidationException::withMessages(['message' => '手机号码已存在!']);
        }
        
        DB::beginTransaction();
        try {
            // 更新账号信息
            $account = $this->accountService->save($request);

            // 同步用户组
            $account->roles()->sync($request->input('role_id'));

            DB::commit();

            // 修改密码后退出其他设备的session

            return response()->json([
                'errcode' => 0,
                'errmsg' => '更新成功',
                'data' => []
            ]);
        } catch (\Exception $exce) {
            DB::rollBack();
            Log::error($exce->getMessage().':'.$exce->getLine());

            return response()->json([
                'errcode' => 10003,
                'errmsg' => '更新失败',
                'data' => []
            ]);
        }
    }

    /**
     * 删除账号信息
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        if (!$request->filled('id')) {
            throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失!']);
        }

        try {
            $this->accountService->delete($request->input('id'));

            return response()->json([
                'errcode' => 0,
                'errmsg' => '删除成功',
                'data' => []
            ]);
        } catch (\Exception $exce) {
            Log::error($exce->getMessage().':'.$exce->getLine());

            return response()->json([
                'errcode' => 10003,
                'errmsg' => '删除失败',
                'data' => []
            ]);
        }
    }
}
