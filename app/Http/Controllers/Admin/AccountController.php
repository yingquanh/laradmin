<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminState;
use App\Facades\Response;
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

            return Response::successful()->setData(new AccountPaginateCollection($list))->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10009)->toJson();
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
        try {
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失!']);
            }

            $info = $this->accountService->findAccountInfoById($request->input('id'));

            return Response::successful()->setData(new AccountInfoResource($info))->toJson();
        } catch (ValidationException $exce) {
            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10009, '未查询到记录')->toJson();
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
        DB::beginTransaction();
        try {
            // 验证管理员账号
            if ($this->accountService->checkAccountName($request->input('account'))) {
                throw ValidationException::withMessages(['message' => '账号已存在!']);
            }

            // 验证管理员邮箱
            if ($request->input('email') && $this->accountService->checkAccountEmail($request->input('email'))) {
                throw ValidationException::withMessages(['message' => '邮箱已存在!']);
            }

            // 验证管理员手机号
            if ($request->input('mobile') && $this->accountService->checkMobileNumber($request->input('mobile'))) {
                throw ValidationException::withMessages(['message' => '手机号码已存在!']);
            }


            // 存储账号信息
            $account = $this->accountService->save($request);

            // 附加用户组
            $account->roles()->attach($request->input('roleid'));

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
     * 更新账号信息
     *
     * @param AccountPostRequest $request
     * @return void
     */
    public function update(AccountPostRequest $request)
    {        
        DB::beginTransaction();
        try {
            // 验证数据
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失!']);
            }

            // 验证管理员账号
            if ($this->accountService->checkAccountName($request->input('account'), $request->input('id'))) {
                throw ValidationException::withMessages(['message' => '账号已存在!']);
            }

            // 验证管理员邮箱
            if ($request->input('email') && $this->accountService->checkAccountEmail($request->input('email'), $request->input('id'))) {
                throw ValidationException::withMessages(['message' => '邮箱已存在!']);
            }
    
            // 验证管理员手机号
            if ($request->input('mobile') && $this->accountService->checkMobileNumber($request->input('mobile'), $request->input('id'))) {
                throw ValidationException::withMessages(['message' => '手机号码已存在!']);
            }


            // 更新账号信息
            $account = $this->accountService->save($request);

            // 同步用户组
            $account->roles()->sync($request->input('roleid'));

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
     * 删除账号信息
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        try {
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失!']);
            }

            $this->accountService->delete($request->input('id'));

            return Response::successful('删除成功')->toJson();
        } catch (ValidationException $exce) {
            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10003, '操作失败')->toJson();
        }
    }

    /**
     * 恢复账号
     *
     * @param Request $request
     * @return void
     */
    public function recover(Request $request)
    {
        try {
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失']);
            }

            $this->accountService->update(
                $request->input('id'),
                [
                    'status' => AdminState::Normal,
                ]
            );

            return Response::successful('操作成功')->toJson();
        } catch (ValidationException $exce) {
            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10004, '操作失败')->toJson();
        }
    }

    /**
     * 禁用账号
     *
     * @param Request $request
     * @return void
     */
    public function forbidden(Request $request)
    {
        try {
            if (!$request->filled('id')) {
                throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失']);
            }

            $this->accountService->update(
                $request->input('id'),
                [
                    'status' => AdminState::Disabled,
                ]
            );

            return Response::successful('操作成功')->toJson();
        } catch (ValidationException $exce) {
            return Response::failed(10009, $exce->getMessage())->toJson();
        } catch (\Exception $exce) {
            Log::error($exce);

            return Response::failed(10004, '操作失败')->toJson();
        }
    }
}
