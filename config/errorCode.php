<?php

// -1 ~ -1000 : 系统
// -1001 ~ -10000 : 基础逻辑
// -10000 以下 其他
return [
    'system' => [
        'invalidArgument' => ['code' => -1, 'msg' => '参数不正确'], // code, msg, data, isReport(log)
    ],

    'logic'   => [
        'notLogin'       => ['code' => -1001, 'msg' => '用户未登录'],
        'accessDenied'   => ['code' => -1002, 'msg' => '没有权限'],
        'wechatNotLogin' => ['code' => -1003, 'msg' => '微信未登录'],
        'errWechatLogin' => ['code' => -1004, 'msg' => '微信失败'],
        'errRegExist'    => ['code' => -1005, 'msg' => '帐号已存在'],
    ],

    // 10000 开始是业务错误
    'account' => [
        'usernameOrPasswordError' => ['code' => -10000, 'msg' => '用户名或密码错误'],
        'passwordError'           => ['code' => -10000, 'msg' => '密码错误'],
        'lockedOrDisabled'        => ['code' => -10000, 'msg' => '账户已被锁定或禁用'],
        'groupLockedOrDisabled'   => ['code' => -10000, 'msg' => '账户所在分组已被锁定或禁用'],
    ],

    'upload' => [
        'fileIsEmpty'        => ['code' => -10100, 'msg' => '文件不存在或为空'],
        'invalidExtension'   => ['code' => -10101, 'msg' => '只允许上传 :extensions 文件'],
        'uploadError'        => ['code' => -10102, 'msg' => '上传文件出错'],
        'fileTypeNotSupport' => ['code' => -10103, 'msg' => '不支持的文件类型'],
    ],
];