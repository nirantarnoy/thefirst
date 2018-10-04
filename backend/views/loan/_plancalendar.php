<?php
use \yii2fullcalendar\yii2fullcalendar;
use yii\helpers\Url;
use yii\web\JsExpression;

$events = array();
//Testing
$Event = new \yii2fullcalendar\models\Event();
$Event->id = 1;
$Event->title = 'ปฏิทิน';
$Event->start = date('Y-m-d\TH:i:s\Z');
//$event->nonstandard = [
//    'field1' => 'Something I want to be included in object #1',
//    'field2' => 'Something I want to be included in object #2',
//];
$events[] = $Event;
$url_to_find_event = Url::to(['loan/findevent'],true);

$jsEvent = <<<JS
 function (event,jsEvent,ui,view) {
  // alert(event.title);
  //alert(ui.name);
 }
JS;
$js = <<< JS
  $(function() {
     $(document).on('click','td.fc-day,.fc-day-top',function() {
         var date = $(this).attr("data-date");
         var xhtml = '';
         var xhtml2 = '';
         if(date != null){
             $.ajax({
                dataType: 'json',
                type: 'post',
                url: '$url_to_find_event',
                async: false,
                data: {'datefind': date},
                success: function(data) {
                   // alert(data[1].length);
                    //return;
                    //alert(data[0]['product']);
                  if(data[0].length == 0 && data[1].length == 0){
                        $("#errorModal").modal("show").find('.error-text').html('ไม่พบรายการบันทึกประจำวัน');
                        return;
                  }
                  if(data[0].length >0){
                        for(var i = 0;i<=data[0].length-1;i++){
                            xhtml = xhtml+"<tr><td>"+data[0][i]['no']+"</td><td>"+data[0][i]['product']+"</td><td>"+data[0][i]['qty']+"</td></tr>";
                         }
                      
                  }
                  if(data[1].length >0){
                        for(var i = 0;i<=data[1].length-1;i++){
                            xhtml2 = xhtml2+"<tr><td>"+data[1][i]['no']+"</td><td>"+data[1][i]['orchard']+"</td><td>"+data[1][i]['team_cut']+"</td><td>"+data[1][i]['team_pick']+"</td></tr>";
                         }
                      
                  }
                 $("#bankModal").modal("show")
                 $("#bankModal").find('.table-event').html(xhtml);
                 $("#bankModal").find('.tbody').html(xhtml2);
                }
             });
         }
         
         //$(".plan_date").val(date);
        // $("#bankModal").modal("show").find('#items').text(new Date(date).toLocaleDateString());
        
        
     })
  })
JS;

$this->registerJs($js,static::POS_END);


?>
<div class="panel panel-headlin">
    <div class="panel-heading">
        <h3><i class="fa fa-calendar"></i> ปฏิทินแจ้งเตือนชำระเงิน<small></small></h3>

        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <?= \yii2fullcalendar\yii2fullcalendar::widget([
                        'options' => [
                            'lang' => 'th',
                        ],
                        'clientOptions' => [
                            'selectable' => true,
                            'selectHelper' => true,
                            'editable' => true,
            //
                        ],
                'eventClick'=> new \yii\web\JsExpression($jsEvent),
                'events' => Url::to(['loan/calendaritem']),
            //    'select' => new \yii\web\JsExpression($jsEvent)
                        //'events' => $events
                    ]);
                    ?>
                </div>
            </div>
    </div>
    <div id="bankModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-calendar-check-o"></i> แผนสั่งซื้อประจำวันที่  <span id="items" style="font-size: 24px;font-weight: bold;"> </span></h4>
                </div>
                <div class="modal-body">

                     <?php //$form = \yii\widgets\ActiveForm::begin(['action' => Url::to(['purchplan/createtitle'],true)])?>
<!--                    <input type="hidden" class="plan_date" name="plan_date">-->
                       <?php //echo $form->field($modelevent,'title')->textInput()?>
<!--                    <input type="submit" value="OK">-->
                     <?php //\yii\widgets\ActiveForm::end();?>

                    <div class="xx">
                       <h3>ยอดรวมแผนสั่งซื้อ</h3>
                       <table class="table table-striped">
                            <thead style="background-color: #00b488;color: #fff;">
                            <th>#</th>
                            <th>ประเภท</th>
                            <th>จำนวนรวม</th>
                            </thead>
                           <tbody class="table-event">
                               <tr>
                                   <td>1</td>
                                   <td>ควั่น</td>
                                   <td>2,500</td>
                               </tr>
                               <tr>
                                   <td>2</td>
                                   <td>หัวโต</td>
                                   <td>4,700</td>
                               </tr>
                               <tr>
                                   <td></td>
                                   <td style="text-align: right;font-weight: bold;">รวมทั้งหมด</td>
                                   <td style="font-weight: bold;">7,200</td>
                               </tr>
                           </tbody>
                       </table>
                        <h3>รายชื่อสวนที่ต้องตัดมะพร้าว</h3>
                        <table class="table table-striped table-work">
                            <thead style="background-color: #00b488;color: #fff;">
                            <th>#</th>
                            <th>ชื่อเสวน</th>
                            <th>ทีมตัด</th>
                            <th>ทีมขน</th>
                            </thead>
                            <tbody class="tbody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
                </div>
            </div>

        </div>
    </div>
    <div id="errorModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-calendar-check-o"></i> แจ้งสถานะ</h4>
                </div>
                <div class="modal-body">
                    <i class="fa fa-warning text-danger"></i> <span class="error-text"></span>
                </div>
            </div>
        </div>
    </div>

</div>

