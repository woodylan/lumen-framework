<?php

namespace App\Http\Controllers\Admin\Order;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\OrderLogic;
use Illuminate\Support\Facades\Auth;

class GetList extends Controller
{

    public function run()
    {
        $currentPage = $this->input('currentPage', 1);
        $perPage = $this->input('perPage', 20);

        $logic = new OrderLogic(Auth::user());
        $rows = $logic->getList($currentPage, $perPage, $this->only(['perPage', 'currentPage']));

        $rows->getCollection()->map(function ($row) {
            $row->setArrayFormat('List');
        });

        return $this->renderRetData(Retcode::SUCCESS, 'success', paginatorToArray($rows));
    }

    public function rules()
    {
        return [
            'perPage'     => ['min:1', '每页记录数'],
            'currentPage' => ['min:1', '页码'],
        ];
    }
}