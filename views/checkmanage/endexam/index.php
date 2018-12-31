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
echo Html::jsFile('assets/My97DatePicker/WdatePicker.js');//时间插件
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
    <div class="homeTit">已批试卷</div>
    <div class="homeCen">
        <!-- 顶部搜索 -->
        <div class="homeCenTop teForm">
            <form class="" id="formHead">
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                <ul>
                    <?if(Yii::$app->user->identity->RoleID==1):?>
                    <li class="adFiveImg">
                        <label>阅卷人</label>
                        <div class="homeSele">
                            <select name="vTuserName">
                                <option value="0">请选择</option>
                                <?foreach ($t_data as $v):?>
                                    <option value="<?=$v['id']?>"><?=$v['UserName']?></option>
                                <?endforeach;?>
                            </select>
                            <img src="assets/images/icon_downgray.png"  />
                        </div>
                    </li>
                    <?endif;?>
                    <li>
                        <label>阅卷时间</label>
                        <div class="homeSeleSpan">
                            <div class="homeSele ">
                                <input class="Wdate fm-must" type="text" id="qDateTime1" name="qDateTime1" value=""
                                       onclick="WdatePicker({position:{left:0,top:0},dateFmt: 'yyyy-MM-dd'})" />
                                <img src="assets/images/ticon_calendar.png" />
                            </div>
                            <span>-</span>
                        </div>
                        <div class="homeSele">
                            <input class="Wdate fm-must" type="text" id="qDateTime2" name="qDateTime2" value=""
                                   onclick="WdatePicker({position:{left:0,top:0},dateFmt: 'yyyy-MM-dd'})" />
                            <img src="assets/images/ticon_calendar.png" />
                        </div>

                    </li>
                    <li>
                        <label>合计</label>
                        <div class="homeSele teHj">
                            <input type="text" id="countnum" />
                        </div>
                        <p>(份)</p>
                    </li>
                    <li>
                        <input type="button" name="" id="" onclick="findHead(1);" value="统计" />
                    </li>
                </ul>
            </form>
        </div>
        <div class="headTa" id="headTa">
            <?=Yii::$app->runAction('checkmanage/endexam/findhead')?>
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
        var url = '?r=checkmanage/endexam/findhead&p='+page;
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

    loadSection01=new LoadDialogChoose({"sectionid":"vSectionId","name":"vName","subname":"vSbuName","coursename":"VCourseName","subid":"vSubId","courseid":"vCourseId"},"loadSection01"
        ,{"url":"?r=admin/classmanage/findsection","formid":"dialogHotelForm","area":"dialogHotelList"});
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
