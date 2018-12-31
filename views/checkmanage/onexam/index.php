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
    <div class="homeTit">批改中试卷</div>
    <div class="homeCen">
        <!-- 顶部搜索 -->
        <div class="homeCenTop adminFour">
            <div class="teTwo">
                <img src="assets/images/ticon.png" />
                <h6>请抓紧时间批阅</h6>
            </div>
            <form class="" id="formHead">
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <?if(Yii::$app->user->identity->RoleID==1):?>

                <ul>
                    <li>
                        <label>阅卷人</label>
                        <div class="homeSele">
                            <select name="vTuserName">
                                <option value="0">请选择</option>
                                <?foreach ($t_data as $v):?>
                                    <option value="<?=$v['id']?>"><?=$v['UserName']?></option>
                                <?endforeach;?>
                            </select>
                            <img src="assets/images/icon_downgray.png" />
                        </div>
                    </li>
                    <li>
                        <input type="button" name="" id="" onclick="findHead(1);" value="搜索" />
                    </li>
                </ul>
            <?endif;?>
            </form>
        </div>
        <div class="headTa" id="headTa">
            <?=Yii::$app->runAction('checkmanage/onexam/findhead')?>
        </div>

    </div>
</div>
<script>
    $(function(){
        $(document).on('hover','.homeTrOper',function(){
            //  $('.homeTrOper').hover(function(){
            $(this).find(".teCaozuo").fadeToggle();
        })
        $(document).on('hover','.teCaozuo p',function(){
            // $('.teCaozuo p').hover(function(){
            $(this).addClass('teActive').siblings().removeClass('teActive');
        })
    })
    function findHead(page){
        var url = '?r=checkmanage/onexam/findhead&p='+page;
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
    function artWaive(that){
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
                                    findHead(1);
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