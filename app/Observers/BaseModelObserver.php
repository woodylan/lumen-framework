<?php

namespace App\Observers;

use App\Models\BaseModel;
use App\Module\Util;

class BaseModelObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User $user
     * @return void
     */
    public function creating(BaseModel $model)
    {
        if (strlen($model->getKey()) < 1) {
            $model->setAttribute($model->getKeyName(), Util::createUuid());
        }
    }

    /**
     * 保存前修改创建时间和编辑时间
     * @param  BaseModel $model [description]
     * @return [type]           [description]
     */
    public function saving(BaseModel $model)
    {
        if ($model->meishaTimestamps) {
            if (!$model->exists) {
                $model->create_time = time();
                $model->update_time = time();
            } elseif ($model->isDirty()) {
                $model->update_time = time();
            }

        }
    }

}