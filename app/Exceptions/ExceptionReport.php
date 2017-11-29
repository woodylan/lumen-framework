<?php

namespace App\Exceptions;

use Exception;

class ExceptionReport extends Exception
{
    protected $isReport = true;

    public function isReport()
    {
        return $this->isReport;
    }
}
