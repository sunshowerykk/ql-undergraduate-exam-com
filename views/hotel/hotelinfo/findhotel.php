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
<table class="table table-bordered table-condensed" style="table-layout: fixed;word-break:break-all; word-wrap:break-word;" >
    <thead>
    <tr>
        <th style="width:60px">酒店Id</th>
        <th style="width:120px">酒店名称</th>
        <th style="width:80px">管理操作</th>
    </tr>
    </thead>
    <? foreach ($rData as $v) :?>
        <tr class="tr-list">
            <td><?=$v['hotelid']?></td>
            <td><?=$v['hotelname']?></td>
            <td>
                <a href="javascript:void(0)"
                   class="btn btn-info btn-xs"
                   data-hotelid="<?=pub::text2html($v['hotelid'],1,0)?>"
                   data-hotelname="<?=pub::text2html($v['hotelname'],1,0)?>"
                   onclick="<?=$rFuncName?>.clk(this);" >选择</a>
                &nbsp;&nbsp;
            </td>
        </tr>
    <?endforeach?>
</table>

