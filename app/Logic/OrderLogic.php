<?php

namespace App\Logic\Teacher;


use App\Logic\CRUD;
use App\Models\Assignment\AssignmentAnswerModel;
use App\Models\Assignment\AssignmentModel;
use App\Models\OrderModel;
use App\Module\Upload;

class OrderLogic extends CRUD
{
    protected $modelName = OrderModel::class;

    protected function getFillable($row)
    {
        return [
            'order_id',
        ];
    }

    protected function customFill($rows, $inputData)
    {

    }

    protected function getListFilter($rows, $condition)
    {
        $rows->with('answerList', 'studentList');

        $rows->where('order_id', $condition['orderId']);

        $rows->orderBy('create_time', 'desc');
    }

    protected function getOneFilter($row, $condition)
    {
        $row->with('answerList', 'studentList');
    }

    protected function getDeleteFilter($row)
    {
        //todo 判断是否可以删除
    }

}