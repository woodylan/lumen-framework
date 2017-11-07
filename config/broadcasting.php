<?php
/**
 * Created by PhpStorm.
 * User: Dylan
 * Date: 2017/7/9
 * Time: 下午6:25
 */

return [
    'default' => env('BROADCAST_DRIVER', 'redis'),


    'connections' => [

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],
    ],

];