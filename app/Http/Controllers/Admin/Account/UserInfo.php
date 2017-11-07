<?php

namespace App\Http\Controllers\Admin\Account;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\Account;

class UserInfo extends Controller
{
    public function run()
    {
        $userId     = $this->_inputData['userId'];

        $logic = new Account();
        $ret   = $logic->userInfo($userId);

        return $this->renderRetData(Retcode::SUCCESS, 'success', $ret);
    }

    public static function rules()
    {
        return [
            'name'     => ['required', '用户名'],
            'password' => ['required', '密码'],
        ];
    }
}