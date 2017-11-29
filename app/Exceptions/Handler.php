<?php

namespace App\Exceptions;

use App\Define\Retcode;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof EvaException) {
            $code = $e->getCode();
            if ($code >= 0) {
                $code = Retcode::ERR_PARAM;
            }
            return response(['code' => $code, 'msg' => $e->getMessage()]);
        }

        if (!env('APP_DEBUG', false)) {
            return response(['code' => Retcode::ERR_WRONG_SYSTEM_OPERATE, 'msg' => '系统异常，请稍后重试'], 500);
        }
        if (env('APP_ENV') == 'local') {
            return parent::render($request, $e);
        } else {
            return response(['code' => Retcode::ERR_WRONG_SYSTEM_OPERATE, 'msg' => '系统异常，请稍后重试'], 500);
        }
    }

    /**
     * 是否记录报告错误
     * @param Exception $e
     * @return bool
     */
    protected function shouldntReport(Exception $e)
    {
        if ($e instanceof EvaException) {
            return !$e->isReport();
        }
        return parent::shouldntReport($e);
    }
}
