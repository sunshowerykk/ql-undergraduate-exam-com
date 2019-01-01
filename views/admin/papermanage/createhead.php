<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
/*echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::cssFile('assets/css/public.css?r='.time());*/
?>


<div class="contentRight">
    <div class="homeTit">试卷管理 / 录入新试卷</div>
    <div class="homeCen addCen">
        <!-- 顶部搜索 -->
        <div class="homeCenTop adminAdd pthomeCenTop">
            <form action="?r=admin/papermanage/savehead" method="post" id="dialogForm" >
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                <input type='hidden' name='_k' value='<?=$rk?>' />
                <input type='hidden' name='vP' value='<?=$rp?>' />
                <input type='hidden' name='vExamId' value='<?=pub::chkData($r_data,'examid','')?>' />
                <ul>
                    <li>
                        <label>试卷名称</label>
                        <div class="homeSele">
                            <input type="text" class="c-set" value="<?=pub::chkData($r_data,'examname','')?>"  name="vPaperName" placeholder="输入试卷名称" data-chk='试卷名称'/>
                        </div>
                    </li>
                    <li>
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;科目</label>
                            <div class="homeSele">
                                <input type="text" name="vSubject" value="<?=pub::chkData($r_data,'examsubname','')?>" placeholder="选择科目" data-chk='科目名称' readonly="readonly"/>
                                <input type="hidden" name="vExamsubId" value="<?=pub::chkData($r_data,'examsubid','')?>"/>
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
                            <input type="text" name="vClass" placeholder="选择课程" value="<?=pub::chkData($r_data,'examcoursename','')?>" data-chk='课程名称' readonly="readonly"/>
                            <input type="hidden" name="vExamcourseid" value="<?=pub::chkData($r_data,'examcourseid','')?>"/>
                        </div>
                    </li>
                    <li>
                        <label>节次</label>
                        <div class="homeSele">
                            <input type="text" name="vSection" placeholder="选择节次" data-chk='节次名称' value="<?=pub::chkData($r_data,'examcoursesectionname','')?>" readonly="readonly"/>
                            <input type="hidden" name="vExamsectionid" value="<?=pub::chkData($r_data,'examcoursesectionid','')?>"/>
                        </div>
                    </li>
                    <li style="margin-left: 0px;">
                        <label>试卷总分</label>
                        <div class="homeSele">
                            <input type="text" class="c-i" name="vScore" value="<?=pub::chkData($r_data,'examscore','')?>" placeholder="输入试卷总分"/>
                        </div>
                    </li>
                    <li>
                        <label>考试时长</label>
                        <div class="homeSele">
                            <input type="text" class="c-i" name="vExamTime" value="<?=pub::chkData($r_data,'examtime','')?>" placeholder="输入考试时长"/>
                        </div>
                    </li>
                </ul>
                <div class="adPopBtn">
                    <button type="reset" class="adRe" onclick="history.back(-1)">取消</button>
                    <button type="button" onclick="artSave('dialogForm')">提交</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadSection01=new LoadDialogChoose({"sectionid":"vExamsectionid","name":"vSection","subname":"vSubject","coursename":"vClass","subid":"vExamsubId","courseid":"vExamcourseid"},"loadSection01"
        ,{"url":"?r=admin/classmanage/findsection","formid":"dialogHotelForm","area":"dialogHotelList"});
    fieldsCheck=new FieldsCheck();
    fieldsCheck.setFormat('c-s-15',"\\S{0,15}");
    fieldsCheck.setFormat('c-s-20',"\\S{0,20}");
    fieldsCheck.setFormat('c-s-30',"\\S{0,30}");
    fieldsCheck.setFormat('c-s-50',"\\S{0,50}");
    fieldsCheck.setFormat('c-s-100',"\\S{0,100}");
    fieldsCheck.setFormat('c-i-30',"\\d{0,30}");
    fieldsCheck.setFormat('c-f-2',"\\d+\\.?\\d{0,3}");//0-3位小数
    fieldsCheck.keyFire();
    function artSave(formid){
        var msg=fieldsCheck.checkMsg('#'+formid);
        if(msg.length>0){      //返回的數組大於0的時候則有錯誤
            var al=msg.join('<br>');    //直接用br鏈接返回錯誤
            showalert(al,'<?=langs::getTxt('infotitle')?>');
            return false;
        }
        $("#"+formid).ajaxSubmit({
            dataType:'json',
            async: false, //同步提交，不对返回值做判断，设置true
            success: function(result){
                //返回提示信息
                if(typeof result.code!='undefined' && '[0000]'==result.code){
                    var examid=result.examid;
                    showMessage('<?=langs::getTxt('saveOK')?>',2,'<??>');
                    window.location.href ="?r=admin/papermanage/indextype&c1="+examid;
                }else{
                    showalert(result,'<?=langs::getTxt('infotitle')?>');
                }
            },
            error:function(){
                showMessage('<?=langs::getTxt('neterror')?>',2,'<?=langs::getTxt('infotitle')?>');
            }
        });
    }
</script>