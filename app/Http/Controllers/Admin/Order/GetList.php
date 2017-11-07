<?php

namespace App\Http\Controllers\Teacher\Order;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\Teacher\OrderLogic;
use Illuminate\Support\Facades\Auth;

class GetList extends Controller
{

    public function run()
    {
        $currentPage = $this->_inputData['currentPage'] ?? 1;
        $perPage = $this->_inputData['perPage'] ?? 50;

        $logic = new OrderLogic(Auth::user());
        $rows = $logic->getList($currentPage, $perPage, $this->only(['orderId', 'perPage', 'currentPage']));

        $rows->getCollection()->map(function ($row) {
            $row->setArrayFormat('List');
        });

        return $this->renderRetData(Retcode::SUCCESS, 'success', paginatorToArray($rows));
    }

    public static function rules()
    {
        return [
            'orderId'     => ['required|min:3|max:32', '订单ID'],
            'perPage'     => ['min:1', '每页记录数'],
            'currentPage' => ['min:1', '页码'],
        ];
    }
}