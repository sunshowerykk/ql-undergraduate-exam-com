<?php

use yii\helpers\Html;
use app\models\pub;
use app\models\langs;
/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
?>
<div id="page">
    <?if($rPage->getTotal_pages()>1){echo $rPage->show(1);}?>
</div>
<table class="table table-bordered table-condensed ptShi"  cellpadding="0" cellspacing="0" align="center" rules="none" width="100%" >
    <thead>
    <tr class="teTableTop">
        <th style="width:60px">科目</th>
        <th style="width:120px">课程</th>
        <th style="width:80px">节次</th>
        <th style="width:80px">操作</th>
    </tr>
    </thead>
    <? foreach ($rData as $v) :?>
        <tr class="teTableTwo teVisible tr-list  ptShid">
            <td><?=$v['subname']?></td>
            <td><div class="teHide"><?=$v['coursename']?></div></td>
            <td><div class="teHide"><?=$v['name']?></div></td>
            <td>
                <a href="javascript:void(0)"
                   class="btn btn-info btn-xs ptShiC"
                   data-subname="<?=pub::text2html($v['subname'],1,0)?>"
                   data-subid="<?=pub::text2html($v['subid'],1,0)?>"
                   data-coursename="<?=pub::text2html($v['coursename'],1,0)?>"
                   data-courseid="<?=pub::text2html($v['courseid'],1,0)?>"
                   data-sectionid="<?=pub::text2html($v['sectionid'],1,0)?>"
                   data-name="<?=pub::text2html($v['name'],1,0)?>"
                   onclick="<?=$rFuncName?>.clk(this);" >选择</a>
                &nbsp;&nbsp;
            </td>
        </tr>
    <?endforeach?>
</table>

