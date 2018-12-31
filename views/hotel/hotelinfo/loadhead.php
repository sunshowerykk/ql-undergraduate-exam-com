<?php

use yii\helpers\Html;
use app\models\pub;
use app\models\langs;
/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
//echo Html::cssFile('assets/css/public.css');
?>
<div style="width: 800px;">
    <div style="overflow-y:auto; padding:2px;margin-bottom: 5px">
        <div id="FindHead" style="width: 650px;">
            <?//begin增加修改字段排版位置?>
                <table class="table table-bordered table-condensed" style="table-layout: fixed;word-break:break-all; word-wrap:break-word;">
                    <tr class="tr-list">
                        <th style="width:80px;text-align:right;">编号:</th>
                        <td style="width:160px;text-align:left;">
                            <span><?=pub::chkData($r_data,'AdfansId')?></span>
                        </td>
                        <th style="width:80px;text-align:right;">微信号:</th>
                        <td style="width:160px;text-align:left;">
                            <span><?=pub::chkData($r_data,'WechatName')?></span>
                        </td>
                        <th style="width:80px;text-align:right;">项目名称:</th>
                        <td style="width:160px;text-align:left;">
                            <span><?=pub::chkData($r_data,'ItemsName')?></span>
                        </td>
                    </tr>
                    <tr class="tr-list">
                        <th style="width:80px;text-align:right;">增粉人数:</th>
                        <td style="width:160px;text-align:left;">
                            <span><?=pub::chkData($r_data,'Fans')?></span>
                        </td>
                        <th style="width:80px;text-align:right;">部门:</th>
                        <td style="width:160px;text-align:left;">
                            <span><?=pub::chkData($r_data,'DeptName')?></span>
                        </td>
                        <th style="text-align:right;">输入日期:</th>
                        <td style="text-align:left;">
                            <span><?=pub::chkData($r_data,'DateTime',date('Y-m-d',time()),10)?></span>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">备注信息:</th>
                        <td style="text-align:left;" colspan="3">
                            <span><?=pub::chkData($r_data,'Remark')?></span>
                        </td>
                        <th style="text-align:right;">输入人员:</th>
                        <td style="text-align:left;">
                            <span><?=pub::chkData($r_data,'InUser',Yii::$app->user->identity->UserName)?></span>
                        </td>
                    </tr>
                </table>
            <?//end增加修改字段排版位置?>
        </div>
        <?//子表明细字段排版位置?>
    </div>
    <div class="" style="text-align: right;padding: 2px;border-top: 2px solid #e5e5e5;" >
        <button type="button" class="btn btn-default btn-sm" onclick="artClose('artHead');">关闭</button>
    </div>
</div>