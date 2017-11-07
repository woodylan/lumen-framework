<?php

namespace App\Models;


class OrderModel extends BaseModel
{
    use SoftDeletes;

    protected $table = 'interactive_user.tb_teacher';
    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function toDetailArray()
    {
        return [
            'userId' => $this->id,
        ];
    }

    public function toAdminListArray()
    {
        return [
            'userId' => $this->id,
        ];
    }

    public function toMiniArray()
    {
        return [
            'userId' => $this->id,
            'name'   => $this->nick_name,
            'avatar' => $this->avatar,
        ];
    }
}