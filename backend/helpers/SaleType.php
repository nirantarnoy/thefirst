<?php

namespace backend\helpers;

class SaleType
{
    const SALE_CASH = 1;
    const SALE_LOAN = 2;

    private static $data = [
        1 => 'สด',
        2 => 'เชื่อ'
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'สด'],
        ['id'=>2,'name' => 'เชื่อ'],
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
