<?php

namespace App\Logic;

use App\Define\Retcode;
use App\Exceptions\EvaException;
use App\Module\Util;

abstract class CRUD
{
    protected $adminUser;


    protected $modelName;
    protected $listColumns = ['*'];

    public function __construct($user = null)
    {
        $this->user = $user;
    }


    protected function getOneFilter($row, $condition)
    {
    }

    protected function getListFilter($rows, $condition)
    {
    }

    protected function customFill($rows, $inputData)
    {
    }

    protected function customVerify($row, $inputData)
    {
    }

    protected function getFillable($row)
    {
        return [];
    }

    protected function afterSave($row, $inputData)
    {
    }

    protected function getDeleteFilter($row)
    {
    }


    public function getList($currentPage = 1, $perPage = 10, $condition = array())
    {
        $rows = call_user_func_array([$this->modelName, 'select'], []);
        $this->getListFilter($rows, $condition);
        return $rows->paginate($perPage, $this->listColumns, 'page', $currentPage);
    }

    public function getOne($id, $condition = array())
    {
        $row = call_user_func_array([$this->modelName, 'select'], []);
        $row = $row->find($id);
        $this->getOneFilter($row, $condition);
        if (!$row) {
            throw new EvaException('数据不存在或已经被删除', Retcode::ERR_PARAM);
        }

        return $row;
    }


    public function delete($ids)
    {
        $ids = is_array($ids) ? $ids : ($ids ? explode('|', $ids) : []);
        if (!$ids) {
            throw new EvaException('ID不存在', Retcode::ERR_PARAM);
        }
        $rows = call_user_func_array([$this->modelName, 'select'], []);
        $rows = $rows->whereIn('id', $ids)->get();
        if (count($rows) < 1) {
            throw new EvaException('数据不存在或已经被删除', Retcode::ERR_PARAM);
        }
        foreach ($rows as $row) {
            $this->getDeleteFilter($row);
            $row->delete();
        }
        return $rows;
    }


    public function save($inputData)
    {
        $row = new $this->modelName;
        if (isset($inputData['id']) && !empty($inputData['id'])) {
            $row = call_user_func_array([$this->modelName, 'find'], [$inputData['id']]);
            if (!$row) {
                throw new EvaException('数据不存在或已经被删除', Retcode::ERR_PARAM);
            }
        }
        $this->customVerify($row, $inputData);
        $fillable = $this->getFillable($row);
        if ($fillable) {
            $row->fillable($fillable);
        }
        $row->fill(Util::snakeCaseArray($inputData, false));
        $this->fillOperationUser($row);

        $this->customFill($row, $inputData);
        $row->save();
        $this->afterSave($row, $inputData);
        return $row;
    }

    protected function fillOperationUser($row)
    {
        if (!empty($this->user->id)) {
            $userId = $this->user->id;
        } else {
            $userId = $this->user['userId'];
        }
        $row->update_user_id = $userId;
        if (!$row->exists) {
            $row->create_user_id = $userId;
        }
    }

}