<?php

namespace App\Services;

use App\Models\Account;

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
}