<?php

namespace App\Define;

class Retcode{
    //0表示成功
    const SUCCESS   = 0;
    //-1~-9预留
    const ERR_PARAM = -1;
    //-10~-99表示系统级错误
    const ERR_WRONG_REDIS_OPERATE       = -10; //redis操作错误
    const ERR_WRONG_MYSQL_OPERATE       = -11; //mysql操作错误
    const ERR_WRONG_CACHE_OPERATE       = -12; //memcache操作错误
    const ERR_WRONG_SYSTEM_OPERATE      = -13; //系统错误
    const ERR_WRONG_FORMAT_JSON         = -14; //json格式化错误
    const ERR_WRONG_HTTP_GET_REQUEST    = -15; //http get请求错误
    const ERR_WRONG_HTTP_POST_REQUEST   = -16; //http post请求错误
    const ERR_WRONG_WECHAT_API_REQUEST  = -17; //微信请求接口错误
    const ERR_WRONG_PINGPP_API_REQUEST  = -18; //ping++支付申请失败
    //-100~-999表示业务逻辑中的错误，各个项目自定

    //-1000~……表示公共业务逻辑错误
    const ERR_NO_LOGIN      = -1001; //用户未登录
    const ERR_ACCOUNT       = -1002; //帐号或密码错误

}