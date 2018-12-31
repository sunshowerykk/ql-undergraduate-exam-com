<?php
use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::cssFile('assets/css/public.css');
?>
<section class="testTop">
    <h6>全部类别</h6>
</section>

<section class="adminContent">
    <ul>
        <?=Yii::$app->runAction('admin/classmanage/findphonehead')?>
    </ul>
</section>