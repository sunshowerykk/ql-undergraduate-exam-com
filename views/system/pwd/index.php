<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::cssFile('assets/css/public.css?r='.time());
echo Html::cssFile('assets/zTree/css/zTreeStyle/zTreeStyle.css?r='.time());

echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/My97DatePicker/WdatePicker.js');//时间插件
echo Html::jsFile('assets/zTree/js/jquery.ztree.core-3.5.js');     //zTree插件
echo Html::jsFile('assets/zTree/js/jquery.ztree.exedit-3.5.js');   //zTree插件
//echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
//echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
//echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
?>
<div class="findcontainer">
    <div id="Head" class="" >

    </div>
    <div id="FindHead"  class="Head">
        <?/* 不用查询明细时，可以接受模板参数进来 $detail  */?>
        <?=Yii::$app->runAction('system/pwd/edithead')?>
    </div>

</div>

<script type="text/javascript">
    <?//行移动变色?>
    lineCH('.tr-list','#FindHead');

    function findHead(page){
        var url = '?r=system/user/findhead&p='+page;
        var data = $('#formHead').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: data,
            success: function (data) {
                $('#FindHead').html(data);
            }
        });
    }

</script>