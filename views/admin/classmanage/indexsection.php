<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;

?>
<div class="dialogLesson" style="width: 550px;">
    <div class="" >
        <form class="form-inline" id="dialogHotelForm">
            <input type='hidden' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <input type="hidden" name="funcName" value="<?=$rFuncName?>" />
            <input type="hidden" name="p" value="1" />
            <table width="100%" class="table-condensed">
                <tr>
                    <td style="text-align: right">
                        <button type="button" class="btn btn-info btn-sm c-fire ptShiA"
                                data-url="?r=admin/classmanage/findsection"
                                data-formid="dialogHotelForm"
                                data-area="dialogHotelList"
                                onclick="<?=$rFuncName?>.find(1);">查询</button>
                        <button type="button" class="btn btn-default btn-sm ptShib" onclick="<?=$rFuncName?>.close();">关闭</button>
                    </td>
                </tr>
            </table>

        </form>
        <div id="dialogHotelList"  class="Head">
            <?/* 不用查询明细时，可以接受模板参数进来 $detail  */?>
            <?=Yii::$app->runAction('admin/classmanage/findsection',array('qFuncName'=>$rFuncName))?>
        </div>
    </div>
    <script type="text/javascript">
        lineCH('.tr-list','#dialogHotelList');
    </script>

