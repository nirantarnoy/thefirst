<?php

namespace backend\helpers;

class RunnoTitle
{
    const RUNNO_PR = 1;
    const RUNNO_PO = 2;
    const RUNNO_QT = 3;
    const RUNNO_SO = 4;
    const RUNNO_TRANSFER = 5;
    const RUNNO_ISSUE = 6;
    const RUNNO_ISSUE_RETURN = 7;
    const RUNNO_SO_RETURN = 8;
    const RUNNO_PO_RETURN = 9;
    const RUNNO_COUNT = 10;
    const RUNNO_ADJUST = 11;
    const RUNNO_WORKREQ = 12;
    const RUNNO_WORKORDER = 13;
    const RUNNO_PRODREC = 14;
    const RUNN0_PDR = 15;
    const RUNNO_INV = 16;

    private static $data = [
        1 => 'ขอซื้อ',
        2 => 'สั่งซ์้อ',
        3 => 'เสนอราคา',
        4 => 'ขาย',
        5 => 'ย้าย',
        6 => 'เบิก',
        7 => 'คืนเบิก',
        8 => 'คืนขาย',
        9 => 'คืนซ์้อ',
        10 => 'นับสต๊อก',
        11 => 'ปรับสต๊อก',
        12 => 'ใบคำร้อง',
        13 => 'ใบสั่งงาน',
        14 => 'ใบรับวัตถุดิบ',
        15 => 'รับเข้าผลิค',
        16 => 'ใบจ่ายเงิน',
        17 => 'ตรวจสอบคุณภาพ',
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'ขอซื้อ','prefix'=>'PR'],
        ['id'=>2,'name' => 'สั่งซ์้อ','prefix'=>'PO'],
        ['id'=>3,'name' => 'เสนอราคา','prefix'=>'QUO'],
        ['id'=>4,'name' => 'ขาย','prefix'=>'SO'],
        ['id'=>5,'name' => 'ย้าย','prefix'=>'TF'],
        ['id'=>6,'name' => 'เบิก','prefix'=>'IS'],
        ['id'=>7,'name' => 'คืนเบิก','prefix'=>'RT'],
        ['id'=>8,'name' => 'คืนขาย','prefix'=>'SRT'],
        ['id'=>9,'name' => 'คืนซ์้อ','prefix'=>'PRT'],
        ['id'=>10,'name' => 'นับสต๊อก','prefix'=>'CT'],
        ['id'=>11,'name' => 'ปรับสต๊อก','prefix'=>'AD'],
        ['id'=>12,'name' => 'ใบคำร้อง','prefix'=>'WR'],
        ['id'=>13,'name' => 'ใบสั่งงาน','prefix'=>'WO'],
        ['id'=>14,'name' => 'ใบรับวัตถุดิบ','prefix'=>'PDR'],
        ['id'=>15,'name' => 'รับเข้าผลิต','prefix'=>'REP'],
        ['id'=>16,'name' => 'ใบจ่ายเงิน','prefix'=>'INV'],
        ['id'=>17,'name' => 'ตรวจสอบคุณภาพ','prefix'=>'QC']
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
