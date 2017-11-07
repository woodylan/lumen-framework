<?php

namespace App\Models;


class UserModel extends BaseModel
{
    use SoftDeletes;

    const STATUS_INIT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;
    const STATUS_DISABLED = 3;

    const ROLE_DEV = 1;
    const ROLE_TEST = 2;

    static $STATUS_NAMES = array(
        self::STATUS_INIT     => '初始化',
        self::STATUS_ACTIVE   => '正常',
        self::STATUS_LOCKED   => '锁定',
        self::STATUS_DISABLED => '禁用',
    );

    protected $table = 'interactive_user.tb_teacher';
    protected $fillable = [
    ];

    protected $hidden = [
        'password',
        'password_salt',
    ];

    protected $casts = [
        'sex'    => 'integer',
        'status' => 'integer',
    ];

    public function getStatusName()
    {
        return isset(self::$STATUS_NAMES[$this->status]) ? self::$STATUS_NAMES[$this->status] : '未知';
    }

    public function attempt($password)
    {
        return strtoupper($this->password) == strtoupper(md5($password . $this->salt));
    }


    public function toDetailArray()
    {
        return [
            'userId'   => $this->id,
        ];
    }

    public function toAdminListArray()
    {
        return [
            'userId'      => $this->id,
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