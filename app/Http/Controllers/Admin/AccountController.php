<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use Illuminate\Http\Request;
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
                'data' => $list
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

    public function show(Request $request)
    {

    }

    public function store()
    {

    }

    public function update()
    {
        // 修改密码后退出其他设备的session
    }

    public function destroy(Request $request)
    {
        if (!$request->filled('id')) {
            throw ValidationException::withMessages(['message' => '未知错误, 系统参数[id]缺失']);
        }

        try {


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
