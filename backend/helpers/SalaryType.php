<?php

namespace backend\helpers;

class SalaryType
{
    const TYPE_TIME = 1;
    const TYPE_DAY = 2;
    const TYPE_MONTH = 3;

    private static $data = [
        1 => 'เหมา',
        2 => 'รายวัน',
        3 => 'รายเดือน'

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'เหมา'],
        ['id'=>2,'name' => 'รายวัน'],
        ['id'=>3,'name' => 'รายเดือน']
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
