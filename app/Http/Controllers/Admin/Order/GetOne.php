<?php

namespace App\Http\Controllers\Teacher\Order;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\OrderLogic;
use Illuminate\Support\Facades\Auth;

class GetOne extends Controller
{
    public function run()
    {
        $id = $this->_inputData['id'];

        $logic = new OrderLogic(Auth::user());
        $row   = $logic->getOne($id);
        $row->setArrayFormat('Detail');

        return $this->renderRetData(Retcode::SUCCESS, 'success', $row->toArray());
    }

    public static function rules()
    {
        return [
            'id' => ['required|min:3|max:32', 'ID'],
        ];
    }
}