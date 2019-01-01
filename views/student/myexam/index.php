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
    <div class="homeTit">我的答卷</div>
    <div class="homeCen">
        <!-- 顶部搜索 -->
        <div class="homeCenTop">
            <form class="" id="formHead">
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                <ul>
                    <li>
                        <label>考试科目</label>
                        <div class="homeSele">
                            <input type="text" name="vSbuName" readonly="readonly"  class="ptInput" />
                            <input type="hidden" name="vSubId"/>
                        </div>
                        <a href="javascript:void(0)" title="选择科目名称" style="text-decoration:none;"
                           class="s-ib s-call ptTr"
                           data-url="?r=admin/classmanage/indexsection"
                           data-id="dialogHotel"
                           data-title="选择科目"
                           onclick="loadSection01.fire(this);" >调入
                        </a>
                        <a href="javascript:void(0)" title="清空" style="margin:0 2px;"
                           class="s-ib s-clear ptTr"
                           onclick="loadSection01.clear();">
                        </a>
                    </li>
                    <li>
                        <label>课程</label>
                        <div class="homeSele">
                            <input type="text"  class="ptInput" readonly="readonly" name="VCourseName" />
                            <input name="vCourseId" type="hidden" />
                        </div>
                    </li>
                    <li>
                        <label>节次</label>
                        <div class="homeSele">
                            <input type="text"  class="ptInput" readonly="readonly" name="vName" />
                            <input name="vSectionId" type="hidden" />
                        </div>
                    </li>
                    <li>
                        <input type="button" name="" id="" onclick="findHead(1);" value="搜索" />
                    </li>
                </ul>
            </form>
        </div>
        <div class="headTa" id="headTa">
            <?=Yii::$app->runAction('student/myexam/findhead')?>
        </div>

    </div>
</div>
<script>

    loadSection01=new LoadDialogChoose({"sectionid":"vSectionId","name":"vName","subname":"vSbuName","coursename":"VCourseName","subid":"vSubId","courseid":"vCourseId"},"loadSection01"
        ,{"url":"?r=admin/classmanage/findsection","formid":"dialogHotelForm","area":"dialogHotelList"});
    function findHead(page){
        var url = '?r=student/myexam/findhead&p='+page;
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
</script>