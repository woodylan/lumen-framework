<?php

namespace App\Logic;


use App\Define\Common;
use App\Models\UserModel;
use App\Module\Util;
use Illuminate\Support\Facades\Redis;

class Account
{
    public function __construct($user = '')
    {
        $this->_user = $user;
    }

    public function login($name, $password)
    {
        $userModel = UserModel::where('name', $name)->first();

        if ($userModel) {
            if ($userModel->attempt($password)) {
                $auth      = Util::createUuid();
                $authArray = [
                    'userId' => $userModel['id'],
                    'role'   => 'student',
                ];
                Redis::setex('Auth:' . $auth, Common::AUTH_EXIST_TIME, json_encode($authArray));

                return [
                    'auth'   => $auth,
                    'userId' => $userModel['id'],
                ];
            }
        }

        return errorCode('account.usernameOrPasswordError');
    }
}