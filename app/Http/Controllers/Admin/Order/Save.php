<?php

namespace App\Http\Controllers\Teacher\Order;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\OrderLogic;
use Illuminate\Support\Facades\Auth;

class Save extends Controller
{
    public function run()
    {
        $logic = new OrderLogic(Auth::user());
        $logic->save($this->_inputData);

        return $this->renderRetSimple(Retcode::SUCCESS, 'success');
    }

    public static function rules()
    {
        return [
            'id' => ['min:3|max:32', 'id'],
        ];
    }
}