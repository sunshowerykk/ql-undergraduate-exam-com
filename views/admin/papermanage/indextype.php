<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;

echo Html::cssFile('assets/css/public.css?r='.time());
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框s
echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/addKityFormulaDialog.js');   //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/defaultFilterFix.js');  //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/getKfContent.js'); //公式编辑器

?>
<style>
    .ptInput{
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        background-color: transparent;
        border: none;
        font-size: 0.116666666667rem;
        text-indent: 1em;
        color: #999999;
    }

</style>

<div class="contentRight">
    <div class="homeTit">试卷管理/题型管理</div>
    <div class="ptDiv">
        <a href="?r=admin/papermanage"><p>试卷管理</p></a>
        <a href="?r=admin/papermanage/indexdetail&c1=<?=$examid?>&_k=<?=Pub::enFormMD5('edit',$examid)?>"> <p>试题管理</p></a>
    </div>
    <div class="homeCen">
        <!-- 顶部搜索 -->
        <div class="homeCenTop">
            <form class="" id="formHead">
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            </form>
        </div>
        <a href="?r=admin/papermanage/createtype&examid=<?=$examid?>">
            <div class="adAddBtn adA">
                <img src="assets/images/add.png" /><p>添加题型</p>
            </div>
        </a>
        <div class="headTa" id="headTa">
            <?=Yii::$app->runAction('admin/papermanage/findtype',array('examid'=>$examid))?>
        </div>

    </div>
</div>
<script>
    function findtype(page){
        var url = '?r=admin/papermanage/findtype&p='+page+'&examid=<?=$examid?>';
         var data = $('#formHead').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: data,
            success: function (data) {
                $('.headTa').html(data);
            }
        });
    }
    function artDeltype(that){
        var m = $(that);
        var d = dialog({
            title:'确认提示',
            content: m.data('confirm'),
            button: [
                {
                    value: '取消',
                    callback: function () {},
                    autofocus: true
                },
                {
                    value: '确认',
                    callback: function () {
                        var url = m.data('url');
                        $.ajax({
                            url:url,
                            type: 'post',
                            data: {"_csrf":'<?= Yii::$app->request->csrfToken ?>'},
                            success: function (data) {
                                if (/\[0000\]/i.test(data)) {
                                    findtype(m.data('p'));
                                }else{
                                    showMessage(data,3,'<?=langs::getTxt('infotitle')?>');
                                }
                            }
                        });
                    }
                }
            ]
        });
        d.showModal();
    }
</script>