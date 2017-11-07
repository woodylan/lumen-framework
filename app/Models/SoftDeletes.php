<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes as BaseSoftDeletes;

trait SoftDeletes
{
    use BaseSoftDeletes;
    /**
     * [runSoftDelete description]
     *  覆盖上级方法 使用时间戳
     * @return [type] [description]
     */
    protected function runSoftDelete()
    {
        $query = $this->newQueryWithoutScopes()->where($this->getKeyName(), $this->getKey());

        $this->{$this->getDeletedAtColumn()} = $time = $this->freshTimestamp();

        $query->update([$this->getDeletedAtColumn() => $time]);
    }


}