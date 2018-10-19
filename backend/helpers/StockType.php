<?php

namespace backend\helpers;

class StockType
{
    const TYPE_IN = 1;
    const TYPE_OUT = 2;

    private static $data = [
        1 => 'In',
        2 => 'Out',

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'In'],
        ['id'=>2,'name' => 'Out'],

    ];
    public static function asArray()
    {
        return self::$data;
    }
    public static function asArrayObject()
    {
        return self::$dataobj;
    }
    public static function getTypeById($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
    public static function getTypeByName($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
}
