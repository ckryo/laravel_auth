<?php
namespace Ckryo\AdminAuth\Contracts;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

interface GuardFactory {
    /**
     * 验证当前用户是否已登录
     *
     * @return bool
     */
    public function check();

    /**
     * 获取当前用户信息
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user();

    /**
     * 获取用户id
     *
     * @return int|null
     */
    public function id();

    /**
     *
     * 登录
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user 登录用户
     * @return string 返回 token
     */
    public function login(AuthenticatableContract $user);

}