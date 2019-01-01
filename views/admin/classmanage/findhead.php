<?php
use yii\helpers\Html;
use app\models\pub;
use app\models\langs;
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::cssFile('assets/css/public.css');
?>
<!--备注 -->

<!-- 表格 -->
<div class="homeTable teVisible" id="teVisible">
    <table cellpadding="0"  cellspacing="0" align="center" rules="none" width="100%" class="homeTableHead teVisible">
        <tbody>
        <tr class="teTableTop">
            <th>科目</th>
            <th>课程</th>
            <th>节次</th>
        </tr>
        <?foreach ($data as $v):?>
            <tr class="teTableTwo teVisible">
                <td><div class="teHide"><?=$v['subname']?></div></td>
                <td><div class="teHide"><?=$v['coursename']?></div></td>
                <td><div class="teHide"><?=$v['name']?></div></td>
            </tr>
        <?endforeach;?>
        </tbody>
    </table>
</div>
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>
