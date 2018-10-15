<?php

?>
<div class="row">
    <div class="col-lg-12">
        <table class="table" border="0" style="width: 100%;border-collapse: collapse;">
            <thead>
            <tr colspan="4">
                <td colspan="4" style="text-align: center;font-size: 22px;font-weight: bold;border: none;">
                    <div >
                        <?=$shop->name;?>
                    </div>
                    <div style="text-align: center;font-size: 16px;">
                        <?=$modeladdress->address." ต."
                        .$shop::findDistrictname($modeladdress->district_id)
                        ." อ.".$shop::findCityname($modeladdress->city_id)." จ."
                        .$shop::findProvincename($modeladdress->province_id)." "
                        .$modeladdress->zipcode;?>
                    </div>
                    <div style="text-align: center;font-size: 18px;">
                        <?= 'โทร.'.$shop->phone;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= 'Email::'.$shop->email;?></span>
                    </div>
                </td>
            </tr><br>
            <tr colspan="4">
                <td colspan="4" style="text-align: center;font-size: 28px;font-weight: bold;border: none;">
                    ใบเสร็จรับเงิน
                </td>
            </tr><br>
            <tr >
                <td colspan="2" style="border: none;font-size: 18px;font-weight: bold">ลูกค้า <?=$custname?></td>
                <td style="border: none;font-size: 18px;font-weight: bold"></td>
                <td style="border: none;font-size: 18px;font-weight: bold">วันที่  <?=$bill_date?></td>
            </tr>
            </thead>
            <tbody style="top: 10px;">
            <tr style="background: #c3c3c3">
                <td style="padding: 10px;border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">รหัสสินค้า</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">ชื่อสินค้า</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right">จำนวน</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right">ราคา</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;width: 15%">รวม</td>
            </tr>
            <?php $rows = 0; ?>
            <?php foreach ($modelline as $value):?>
                <?php $rows +=1; ?>
                <tr style="border: 1px solid black;border-collapse: collapse;">
                    <td style="padding: 5px;font-size: 14px;font-weight: bold;text-align: left;"><?=\backend\models\Product::findProductinfo($value->product_id)->product_code;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left"><?=\backend\models\Product::findProductinfo($value->product_id)->name;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"><?=number_format($value->qty,0)?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"><?=number_format($value->price,0)?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"><?=number_format($value->line_total,0)?></td>
                </tr>
            <?php endforeach; ?>
            <?php if($rows < 10): ?>
                <?php //for($x=0;$x<=(20-$rows)-1;$x++): ?>
                <!--            <tr style="border: 0.1px solid black;">-->
                <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left;height: 10px;"></td>-->
                <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left"></td>-->
                <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right"></td>-->
                <!--                <td style="border-left: 0.2px solid grey;border-right: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right"></td>-->
                <!--            </tr>-->
                <?php //endfor; ?>
            <?php endif; ?>

            <?php //for($x=0;$x<=(20-$rows)-1;$x++): ?>
            <!--            <tr style="border: 1px solid black;">-->
            <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left;height: 10px;"></td>-->
            <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left"></td>-->
            <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right"></td>-->
            <!--                <td style="border-left: 0.2px solid grey;border-right: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right"></td>-->
            <!--            </tr>-->
            <?php //endfor; ?>
            <tr style="border: 1px solid black;">
                <td colspan="2" style="padding: 10px;font-size: 14px;font-weight: bold;text-align: right;height: 10px;">จำนวนรวม</td>
                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"><?=number_format($bill_total,0)?></td>
            </tr>

            </tbody>
            <tfoot>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;font-size: 16px;font-weight: bold;text-align: center"></td>
                <td colspan="2" style="border: none;font-size: 16px;font-weight: bold;text-align: center"></td>
            </tr><br><br><br>
            <tr>
                <td colspan="2" style="border: none;font-size: 16px;font-weight: normal;text-align: center">ชื่อ.........................................ผู้ขาย</td>
                <td colspan="2" style="border: none;font-size: 16px;font-weight: normal;text-align: center">ชื่อ.........................................ผู้ซื้อ</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>