<?php

namespace backend\helpers;

class JournalType
{
    const TYPE_PO = 1;
    const TYPE_SO = 2;
    const TYPE_IMPORT = 3;
    const TYPE_ADJUST = 4;
    const TYPE_CLAIM = 5;

    private static $data = [
        1 => 'Purchase',
        2 => 'Sale',
        3 => 'Import',
        4 => 'Adjust',
        5 => 'Claim',

    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'Purchase'],
        ['id'=>2,'name' => 'Sale'],
        ['id'=>3,'name' => 'Import'],
        ['id'=>4,'name' => 'Adjust'],
        ['id'=>5,'name' => 'Claim'],

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
