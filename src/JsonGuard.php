<?php

namespace Ckryo\AdminAuth;

use Ckryo\Auth\Contracts\GuardFactory;
use Ckryo\Logi\Facades\Logi;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Str;

class JsonGuard implements GuardFactory
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    protected $provider;

    protected $user;

    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;


    public function __construct(UserProvider $provider, Request $request = null)
    {
        $this->request = $request;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->request->header('api-token', '-');

        if (! empty($token)) { // 从驱动中获取 用户信息
            $user = $this->provider->retrieveByCredentials(
                ['remember_token' => $token]
            );
        }

        return $this->user = $user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }

        return null;
    }

    /**
     *
     * 登录
     *
     * @param AuthenticatableContract $user 登录用户
     * @return string 返回 token
     */
    public function login(AuthenticatableContract $user)
    {
        $time = time();
        $token = Str::random(8) . md5("admin_{$user->id}__{$time}") . Str::random(60);
        $user->setRememberToken($token);
        $this->provider->updateRememberToken($user, $token);
        Logi::login($user->id, $token);
        return $token;
    }

    /**
     * Set the current request instance.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

}
