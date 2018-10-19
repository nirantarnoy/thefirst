<?php

?>
<div class="row">
    <div class="col-lg-12">
        <table class="table" border="0" style="width: 100%;border-collapse: collapse;">
            <thead>
            <tr colspan="4">
                <td colspan="3" style="text-align: left;font-size: 22px;font-weight: bold;border: none;">
                    <div >
                        <?=$shop->name;?>
                    </div>

                </td>
                <td colspan="2" style="text-align: right;font-size: 14px;font-weight: bold;border: none;">
                    บิลเงินสด/ใบส่งของ
                </td>
            </tr>
            <tr colspan="4">
                <td colspan="3" style="text-align: center;font-size: 14px;font-weight: bold;border: none;">

                </td>
                <td colspan="2" style="text-align: right;font-size: 14px;font-weight: bold;border: none;">
                    เลขที่ <?=$model->sale_no?>
                </td>
            </tr><br>
            <tr colspan="4">
                <td colspan="3" style="text-align: center;font-size: 14px;font-weight: bold;border: none;">

                </td>
                <td colspan="2" style="text-align: right;font-size: 14px;font-weight: bold;border: none;">
                    วันที่ <?=$bill_date?>
                </td>
            </tr><br><br>
            <tr >
                <td colspan="2" style="border: none;font-size: 14px;font-weight: bold">โทร <?=$shop->phone?></td>

            </tr>
            <tr >
                <td colspan="1" style="border: none;font-size: 14px;font-weight: bold">ที่อยู่จัดส่ง</td>
                <td colspan="4" style="border: none;font-size: 14px;font-weight: normal">
                    <?=$modeladdress?>
                </td>
            </tr> <br> <br>
            </thead>
            <tbody style="top: 10px;">
            <tr style="background: #c3c3c3">
                <td style="padding: 10px;border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">รหัสสินค้า</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">ชื่อสินค้า</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">จำนวน</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">ราคา</td>
                <td style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;width: 15%">รวม</td>
            </tr>
            <?php $rows = 0; ?>
            <?php foreach ($modelline as $value):?>
                <?php $rows +=1; ?>
                <tr style="border: 0.5px solid black;border-bottom:none;border-collapse: collapse;">
                    <td style="padding: 5px;font-size: 14px;font-weight: normal;text-align: left;"><?=\backend\models\Product::findProductinfo($value->product_id)->product_code;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: normal;padding-left: 5px;text-align: left"><?=\backend\models\Product::findProductinfo($value->product_id)->name;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: normal;text-align: center;padding-right: 10px;"><?=number_format($value->qty,0)?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: normal;text-align: center;padding-right: 10px;"><?=number_format($value->price,0)?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: normal;text-align: right;padding-right: 10px;"><?=number_format($value->line_total,0)?></td>
                </tr>
            <?php endforeach; ?>
            <?php if($rows < 10): ?>
                <?php for($x=0;$x<=(10-$rows)-1;$x++): ?>
                            <tr style="border: 0.1px solid black;border-top: none;border-bottom:none;">
                                <td style="padding: 5px;font-size: 14px;font-weight: bold;text-align: left;"></td>
                                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left"></td>
                                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                            </tr>
                <?php endfor; ?>
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
                <td colspan="3" style="padding: 10px;font-size: 14px;font-weight: bold;text-align: right;height: 10px;">
                    ( <?=$model->sale_total_text?> )
                </td>
                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;padding-top: 10px;padding-bottom: 10px;"> รวมสุทธิ </td>
                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"><?=number_format($bill_total,0)?></td>
            </tr>

            </tbody>

        </table>

        <table style="width: 100%;border-collapse: collapse;margin-top: 5px;">
            <tr style="border: 0.5px solid black;border-collapse: collapse;">
                <td style="width: 33%;border: 0.2px solid black;padding-top: 10px;padding-left: 5px;font-size: 14px;">
                    ได้รับสินค้าไว้ถูกต้องเรียบร้อยแล้ว
                    <br /><br /><br />

                    ผู้รับ...................................
                </td>
                <td style="width: 33%;border: 0.2px solid black;padding-top: 10px;padding-left: 5px;font-size: 14px;">
                    <br /><br /><br />
                    ผู้ส่ง...................................
                </td>
                <td style="width: 33%;border: 0.2px solid black;padding-top: 10px;padding-left: 5px;font-size: 14px;">
                    <br /><br /><br />
                    ผู้รับเงิน...................................
                </td>
            </tr>
        </table>
    </div>
</div>