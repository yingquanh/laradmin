<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    protected function findBy(int $id)
    {
        return $this->account->find($id);
    }

    /**
     * 根据账号名称查询
     *
     * @param string $name
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function findByAccountName(string $name)
    {
        return $this->account->where('account_name', $name)->first();
    }

    /**
     * 根据账号邮箱查询
     *
     * @param string $email
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function findByAccountEmail(string $email)
    {
        return $this->account->where('email', $email)->first();
    }

    /**
     *根据手机号码查询
     *
     * @param string $mobile
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function findByMobileNumber(string $mobile)
    {
        return $this->account->where('mobile', $mobile)->first();
    }

    /**
     * 根据名称检查账号是否存在
     *
     * @param string $name
     * @param integer|null $id
     * @return bool
     */
    public function checkAccountName(string $name, int $id = null)
    {
        $rows = $this->account
            ->where('account_name', $name)
            ->when($id, function ($query) use ($id) {
                $query->where('id', '<>', $id);
            })
            ->first();

        return !is_null($rows);
    }

    /**
     * 根据邮箱检查账号是否存在
     *
     * @param string $email
     * @param integer|null $id
     * @return bool
     */
    public function checkAccountEmail(string $email, int $id = null)
    {
        $rows = $this->account
            ->where('email', $email)
            ->when($id, function ($query) use ($id) {
                $query->where('id', '<>', $id);
            })
            ->first();

        return !is_null($rows);
    }

    /**
     * 根据手机号码检查账号是否存在
     *
     * @param string $mobile
     * @param integer|null $id
     * @return bool
     */
    public function checkMobileNumber(string $mobile, int $id = null)
    {
        $rows = $this->account
            ->where('mobile', $mobile)
            ->when($id, function ($query) use ($id) {
                $query->where('id', '<>', $id);
            })
            ->first();

        return !is_null($rows);
    }

    /**
     * 分页查询数据
     *
     * @param Request $reqeust
     * @return \App\Models\Account
     */
    public function paginate(Request $reqeust)
    {
        return $this->account
            ->with([
                'roles',
            ])
            ->paginate($reqeust->input('pageSize') ?? 20);
    }

    /**
     * 存储数据
     *
     * @param Request $reqeust
     * @return \App\Models\Account|\Throwable
     */
    public function save(Request $reqeust)
    {
        if ($reqeust->input('id')) {
            $this->account = $this->findBy($reqeust->input('id'));
        }

        // 输入密码则更新密码
        if ($reqeust->input('account_password')) {
            $this->account->account_password = Hash::make($reqeust->input('account_password'));
        }

        $this->account->account_name = $reqeust->input('account_name');
        $this->account->email = $reqeust->input('email') ?? '';
        $this->account->mobile = $reqeust->input('mobile') ?? '';
        $this->account->saveOrFail();

        return $this->account;
    }

    /**
     * 删除数据
     *
     * @param integer $account_id
     * @return \App\Models\Account|\Throwable
     */
    public function delete(int $account_id)
    {
        return $this->account->findOrFail($account_id)->delete();
    }
}