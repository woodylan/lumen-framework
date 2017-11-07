<?php

namespace App\Http\Controllers\Admin\Order;


use App\Define\Retcode;
use App\Http\Controllers\Controller;
use App\Logic\Teacher\OrderLogic;
use Illuminate\Support\Facades\Auth;

class Delete extends Controller
{
    public function run()
    {
        $id = $this->_inputData['id'];

        $logic = new OrderLogic(Auth::user());
        $logic->delete($id);

        return $this->renderRetSimple(Retcode::SUCCESS, 'success');
    }

    public static function rules()
    {
        return [
            'id' => ['required|min:3|max:32', 'ID'],
        ];
    }
}