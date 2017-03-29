<?php

namespace Ckryo\AdminAuth\Controllers;

use App\Http\Controllers\Controller;
use Ckryo\AdminAuth\Auth;
use Ckryo\AdminAuth\Models\User;
use Ckryo\Response\ErrorCodeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    function store(Request $request, Auth $auth) {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required'
        ], [
            'name.required' => '账号不能为空',
            'password.required' => '密码不能为空',
        ]);
        $name = $request->name;
        if ($user = User::where('name', $name)->first()) {
            if (!Hash::check($request->password, $user->password)) {
                throw new ErrorCodeException(211);
            }
            $token = $auth->login($user);
            return response()->ok('登录成功', [
                'user_info' => [],
                'org_info' => [],
                'menu_info' => [],
                'api_token' => $token
            ]);
        }
        throw new ErrorCodeException(210);
    }

}