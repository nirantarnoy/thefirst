<?php

namespace backend\helpers;

class MessageType
{
    const TYPE_OVER = 1;
    const TYPE_POSPONE= 2;
    const TYPE_NEAR= 3;

    private static $data = [
        1 => 'เกินกำหนดชำระ',
        2 => 'เลื่อนชำระ',
        3 => 'ใกล้กำหนดชำระ',
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'เกินกำหนดชำระ'],
        ['id'=>2,'name' => 'เลื่อนชำระ'],
        ['id'=>3,'name' => 'ใกล้กำหนดชำระ'],
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
