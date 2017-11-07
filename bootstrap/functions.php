<?php

function envConfig($name)
{
    app()->configure(sprintf("%s/%s", app()->environment(), current(explode('.', $name))));
    return config(sprintf("%s/%s", app()->environment(), $name));

}

function errorCode($errorCodeKey)
{
    $replaces = [];
    if (is_array($errorCodeKey)) {
        if (count($errorCodeKey) === 2) {
            list($errorCodeKey, $replaces) = $errorCodeKey;
        } else {
            throw new \Exception('ErrorCode invalid: ' . var_export($errorCodeKey, true));
        }
    }
    app()->configure('errorCode');
    $error = config("errorCode.{$errorCodeKey}");
    if (!$error) {
        throw new \Exception('ErrorCode not found: ' . $errorCodeKey);
    }
    $error = array_merge(['code' => -1, 'msg' => '系统异常'], $error);
    $msg   = $error['msg'];
    foreach ($replaces as $key => $value) {
        $msg = str_replace(
            [':' . $key, ':' . strtoupper($key), ':' . ucfirst($key)],
            [$value, strtoupper($value), ucfirst($value)],
            $msg
        );
    }

    throw new \App\Exceptions\EvaException($msg, $error['code']);
}

function paginatorToArray($paginator, $formatter = null)
{
    if ($formatter) {
        $formatter = is_array($formatter) ? $formatter : [$formatter];
        $paginator->getCollection()->map(function ($row) use ($formatter) {
            call_user_func_array([$row, 'setArrayFormat'], $formatter);
        });
    }
    return [
        'count'       => $paginator->total(),
        'perPage'     => $paginator->perPage(),
        'currentPage' => $paginator->currentPage(),
        'lastPage'    => $paginator->lastPage(),
        // 'next_page_url' => $paginator->nextPageUrl(),
        // 'prev_page_url' => $paginator->previousPageUrl(),
        // 'from' => $paginator->firstItem(),
        // 'to' => $paginator->lastItem(),
        'list'        => $paginator->getCollection()->toArray(),
    ];
}