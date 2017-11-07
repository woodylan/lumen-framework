<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SoftDeletes;
use App\Observers\BaseModelObserver;

abstract class BaseModel extends Model
{

    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    const DELETED_AT = 'deleted_at';

    public $timestamps = false;
    public $meishaTimestamps = true;
    
    public $incrementing = false;

    protected $dates = [];
    protected $keyType = 'string';

    protected $arrayFormatter;

    protected static function boot()
    {
        parent::boot();
        static::observe(BaseModelObserver::class);
    }

    public function freshTimestamp()
    {
        // throw new \Exception('a');
        return time();
    }

    public function getDates()
    {
        return [];
    }

    public function setArrayFormat($formatter)
    {
        $args = func_get_args();
        array_shift($args);
        $this->arrayFormatter = [$formatter, $args];
        return $this;
    }

    public function toArray()
    {
        if( $this->arrayFormatter ) {
            $args = func_get_args();
            array_shift($args);
            list($formatterName, $_args) = $this->arrayFormatter;
            $args = $args ?: $_args;
            return call_user_func_array([$this, 'to' . ucfirst($formatterName) . 'Array'], $args);
        } else {
            return parent::toArray();
        }
    }

    public function getCreateTimeAttribute($value)
    {
        return $this->asDateTime($value);
    }

    public function getUpdateTimeAttribute($value)
    {
        return $this->asDateTime($value);
    }

    public function getDeletedAtAttribute($value)
    {
        return  $value === null ? null : $this->asDateTime($value);
    }
    public function setCreateTimeAttribute($value)
    {
        $this->attributes['create_time'] = $this->asDateTime($value)->timestamp;
    }

    public function setUpdateTimeAttribute($value)
    {
        $this->attributes['update_time'] = $this->asDateTime($value)->timestamp;
    }

    public function setDeletedAtAttribute($value)
    {
        $this->attributes['deleted_at'] = $value === null ? 0 : $this->asDateTime($value)->timestamp;
    }
}
