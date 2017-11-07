<?php
/**
 * Created by PhpStorm.
 * User: Dylan
 * Date: 2017/9/19
 * Time: 下午2:04
 */

namespace App\Http\Controllers\Teacher\Order;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\Teacher\OrderLogic;
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