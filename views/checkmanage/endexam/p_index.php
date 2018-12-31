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
echo Html::jsFile('assets/js/exam/mplugin.js');
?>
<form class="" id="formHead">
<input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
<section class="testTop ">
    <h6>已批改试卷</h6>
    <?if(Yii::$app->user->identity->RoleID==1):?>
    <section class="testHead teacThree">
        <div class="teacCen">
            <div class="inTop">
                <select name="vTuserName" onchange="findHead(1);">
                    <option value="0">选择阅卷人</option>
                    <?foreach ($t_data as $v):?>
                        <option value="<?=$v['id']?>"><?=$v['UserName']?></option>
                    <?endforeach;?>
                </select>
                <img src="assets/images/phone/images/icon_down.png" />
            </div>
            <p>合计:<span id="countnum"></span></p>
        </div>
    </section>
    <?endif;?>
</section>
</form>
<section class="testCen">
    <ul class="formData">
        <?=Yii::$app->runAction('checkmanage/endexam/findhead')?>
    </ul>
</section>
<!-- 科目弹窗 -->
<script>
    function findHead(page){
        var url = '?r=checkmanage/endexam/findhead&p='+page;
        var data = $('#formHead').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: data,
            success: function (data) {
                console.log(data);
                $('.formData').html(data);
            }
        });
    }
    function artDel(that){
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
                                    findHead(m.data('p'));
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