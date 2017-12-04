<?php

namespace App\Http\Controllers;

use App\Define\Retcode;
use App\Exceptions\EvaException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\FileBag;

class Controller extends BaseController
{
    const API_LOG_DIR = 'logs/api/%s.log';

    protected $_userId = null;

    protected $_data = null;
    protected $_auth = null;

    protected $_inputData = null;

    private $_input = null;
    protected $_all;

    public function __construct()
    {
        $this->_input = app()->request->all();
        $this->_getBaseParam();
        $this->_getInputData();
        $this->validator();

        $all = isset($_REQUEST['data']) ? $_REQUEST['data'] : '';
        $all = $all ? json_decode($all, true) : [];
        $files = new FileBag($_FILES);
        foreach ($files as $key => $file) {
            $all[$key] = $file;
        }
        $this->_all = $all;
    }

    private function _getBaseParam()
    {
        $this->_data = $this->_input['data'] ?? '';
    }

    private function _getInputData()
    {
        $this->_inputData = $this->_data ? json_decode($this->_data, true) : [];
    }

    public function only($keys)
    {
        return array_only($this->_all, $keys);
    }

    protected function input($key, $default = null)
    {
        return array_get($this->_inputData, $key, $default);
    }

    //参数验证
    public function validator()
    {
        //如果不存在该方法则停止
        if (!method_exists($this, 'rules')) {
            return;
        }

        $paramRules = $this->rules();

        $rule = [];
        $attributeName = [];

        //如果没有验证规则则停止
        if (empty($paramRules)) {
            return;
        }

        foreach ($paramRules as $title => $value) {
            //构建验证规则数组 别名数组
            list($rule['title'], $attributeName[$title]) = $value;
        }
        $data = empty($paramInputRules) ? $this->_inputData : $this->_input;
        $validation = app()->validator->make($data, $rule)->setAttributeNames($attributeName);
        //验证失败抛出异常
        if ($validation->fails()) {
            throw new EvaException($validation->messages()->first(), Retcode::ERR_PARAM);
        }
    }

    public function renderRetData($code, $msg, array $data)
    {
        $retData = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];

        return $retData;
    }

    public function renderRetSimple($code, $msg)
    {
        $retData = [
            'code' => $code,
            'msg'  => $msg,
            'data' => (object)[],
        ];

        return $retData;
    }

    //析构
    public function __destruct()
    {
        //打印接口请求log
        $apiLogFile = storage_path(sprintf(self::API_LOG_DIR, date('Ymd')));
        $requestApi = app()->request->getRequestUri();

        $logger = new Logger('api_log');
        $logger->pushHandler(new StreamHandler($apiLogFile, Logger::INFO));

        $inputData = json_encode($this->_input);
        $logInfo = "api: {$requestApi} with params: {$inputData}";
        $logger->addInfo($logInfo);
    }
}
