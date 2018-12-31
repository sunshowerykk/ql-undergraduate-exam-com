<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
//echo Html::cssFile('assets/css/public.css?r='.time());
//echo Html::cssFile('assets/zTree/css/zTreeStyle/zTreeStyle.css?r='.time());
?>
<div class="dialogLesson" style="width: 550px;">
    <div class="" >
        <form class="form-inline" id="dialogHotelForm">
            <input type='hidden' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <input type="hidden" name="funcName" value="<?=$rFuncName?>" />
            <input type="hidden" name="p" value="1" />
            <table width="100%" class="table-condensed">
                <tr>
                    <th style="width: 130px;">酒店名称/ID：</th>
                    <td style="width: 150px;">
                        <input type="text" class="c-tab c-st-30 c-end" id="qHotelName" name="qHotelName" placeholder="酒店名称/ID" />
                    </td>
                    <td style="text-align: right">
                        <button type="button" class="btn btn-info btn-sm c-fire"
                                data-url="?r=hotel/hotelinfo/findhotel"
                                data-formid="dialogHotelForm"
                                data-area="dialogHotelList"
                                onclick="<?=$rFuncName?>.find(1);">查询</button>
                        <button type="button" class="btn btn-default btn-sm" onclick="<?=$rFuncName?>.close();">关闭</button>
                    </td>
                </tr>
            </table>

        </form>
        <div id="dialogHotelList"  class="Head">
            <?/* 不用查询明细时，可以接受模板参数进来 $detail  */?>
            <?=Yii::$app->runAction('hotel/hotelinfo/findhotel',array('qFuncName'=>$rFuncName))?>
        </div>
    </div>
    <script type="text/javascript">
        lineCH('.tr-list','#dialogHotelList');
    </script>

