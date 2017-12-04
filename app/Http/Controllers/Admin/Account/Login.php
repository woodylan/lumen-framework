<?php

namespace App\Http\Controllers\Admin\Account;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\Account;

/**
 * @apiDefine account 账户
 *            账户相关接口
 */
class Login extends Controller
{
    public function run()
    {
        $name     = $this->_inputData['name'];
        $password = $this->_inputData['password'];

        $logic = new Account();
        $ret   = $logic->login($name, $password);

        return $this->renderRetData(Retcode::SUCCESS, 'success', $ret);
    }

    public function rules()
    {
        return [
            'name'     => ['required', '用户名'],
            'password' => ['required', '密码'],
        ];
    }
}