<?php
use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::cssFile('assets/css/public.css');
?>
<div class="contentRight">
    <div class="homeTit">类别管理</div>
    <div class="homeCen">

        <div class="headTa">
            <?=Yii::$app->runAction('admin/classmanage/findhead')?>
        </div>

    </div>
</div>
<script>
    function findhead(page){
        var url = '?r=admin/classmanage/findhead&p='+page;
       // var data = $('#formHead').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: '',
            success: function (data) {
                $('.headTa').html(data);
            }
        });
    }
</script>