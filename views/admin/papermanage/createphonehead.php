<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::cssFile('assets/css/public.css?r='.time());
?>
<section class="testTop ">
    <h6>录入新试卷</h6>
</section>
<section class="testAdd">
    <form action="?r=admin/papermanage/savehead" method="post" id="dialogForm" >
        <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
        <input type='hidden' name='_k' value='<?=$rk?>' />
        <input type='hidden' name='vP' value='<?=$rp?>' />
        <input type='hidden' name='vExamId' value='<?=pub::chkData($r_data,'examid','')?>' />
        <ul>
            <li>
                <div class="testAddCen">
                    <label>试卷名称</label>
                    <div class="testInput">
                        <input type="text" class="c-set" value="<?=pub::chkData($r_data,'examname','')?>"  name="vPaperName" placeholder="输入试卷名称" data-chk='试卷名称'/>
                    </div>
                </div>
            </li>
            <li>
                <div class="testAddCen">
                    <label>科目</label>
                    <div class="testInput">
                        <select class="first-div" name="vExamsubId" id="vExamsubId">
                            <option value="">请选择</option>
                            <?foreach ($data  as  $v):?>
                                <option value="<?=$v['id']?>"><?=$v['name']?></option>
                            <?endforeach;?>
                        </select>
                        <input type="hidden" id="vSubject" name="vSubject">
                        <img src="assets/images/phone/images/icon_choose.png" />
                    </div>
                </div>
            </li>
            <li>
                <div class="testAddCen">
                    <label>课程</label>
                    <div class="testInput">
                        <select class="second-div" name="vExamcourseid" id="vExamcourseid">
                            <option value="">请选择</option>
                        </select>
                        <input type="hidden" id="vClass" name="vClass">
                        <img src="assets/images/phone/images/icon_choose.png" />
                    </div>
                </div>
            </li>
            <li>
                <div class="testAddCen">
                    <label>节次</label>
                    <div class="testInput">
                        <select class="last-div" name="vExamsectionid" id="vExamsectionid">
                            <option value="">请选择</option>
                        </select>
                        <input type="hidden" id="vSection" name="vSection">
                        <img src="assets/images/phone/images/icon_choose.png" />
                    </div>
                </div>
            </li>
            <li>
                <div class="testAddCen">
                    <label>试卷总分</label>
                    <div class="testInput">
                        <input type="text" class="c-i" name="vScore" value="<?=pub::chkData($r_data,'examscore','')?>" placeholder="输入试卷总分"/>
                    </div>
                </div>
            </li>
            <li>
                <div class="testAddCen">
                    <label>试卷时长</label>
                    <div class="testInput">
                        <input type="text" class="c-i" name="vExamTime" value="<?=pub::chkData($r_data,'examtime','')?>" placeholder="输入考试时长"/>
                    </div>
                </div>
            </li>
<!--            <li>-->
<!--                <div class="testAddCen">-->
<!--                    <label>题型选择</label>-->
<!--                    <div class="testInput">-->
<!--                        <select>-->
<!--                            <option value="0">请选择</option>-->
<!--                            <option value="1">请选择</option>-->
<!--                            <option value="2">请选择</option>-->
<!--                        </select>-->
<!--                        <img src="images/icon_choose.png" />-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </li>-->
        </ul>
        <a onclick="artSave('dialogForm')" class="testAddBtn">添加</a>
    </form>
</section>
<script type="text/javascript">
    fieldsCheck=new FieldsCheck();
    fieldsCheck.setFormat('c-s-15',"\\S{0,15}");
    fieldsCheck.setFormat('c-s-20',"\\S{0,20}");
    fieldsCheck.setFormat('c-s-30',"\\S{0,30}");
    fieldsCheck.setFormat('c-s-50',"\\S{0,50}");
    fieldsCheck.setFormat('c-s-100',"\\S{0,100}");
    fieldsCheck.setFormat('c-i-30',"\\d{0,30}");
    fieldsCheck.setFormat('c-f-2',"\\d+\\.?\\d{0,3}");//0-3位小数
    fieldsCheck.keyFire();
    loadSection01=new LoadDialogChoose({"sectionid":"vExamsectionid","name":"vSection","subname":"vSubject","coursename":"vClass","subid":"vExamsubId","courseid":"vExamcourseid"},"loadSection01"
        ,{"url":"?r=admin/classmanage/findsection","formid":"dialogHotelForm","area":"dialogHotelList"});
    function artSave(formid){
        var msg=fieldsCheck.checkMsg('#'+formid);
        if(msg.length>0){      //返回的數組大於0的時候則有錯誤
            var al=msg.join('<br>');    //直接用br鏈接返回錯誤
            showalert(al,'<?=langs::getTxt('infotitle')?>');
            return false;
        }
        $("#"+formid).ajaxSubmit({
            async: false, //同步提交，不对返回值做判断，设置true
            success: function(result){
                //返回提示信息
                if (/\[0000\]/i.test(result)){
                    showMessage('<?=langs::getTxt('saveOK')?>',2,'<??>');
                    history.back(-1);
                    //跳轉分頁
                }else{
                    showalert(result,'<?=langs::getTxt('infotitle')?>');
                }
            },
            error:function(){
                showMessage('<?=langs::getTxt('neterror')?>',2,'<?=langs::getTxt('infotitle')?>');
            }
        });
    }

    var arr = [];
    <?php
    $index=0;
    foreach($data as $v1){
        echo "arr[$index]={'index':1,'id':".$v1['id'].",'pid':0,'name':'".$v1['name']."'};";
        $index++;
        foreach($v1['courses'] as $v2){
            echo "arr[$index]={'index':2,'id':".$v2['id'].",'pid':".$v2['category_name'].",'name':'".$v2['course_name']."'};";
            $index++;
            foreach($v2['courseSections'] as $v3){
                echo "arr[$index]={'index':3,'id':".$v3['id'].",'pid':".$v3['course_id'].",'name':'".$v3['name']."'};";
                $index++;
            }
        }
    }
    ?>
    $(document).on('change','#vExamsubId',function(){
        var id=$(this).val();
        var text=$(this).find("option:selected").text();
        $("#vSubject").val(text)
        $('.second-div').empty();
        // alert(arr.length);
        for(var i=0;i<arr.length;i++){
            // console.log(arr[i]['index']+'--'+arr[i]['pid']);
            if (arr[i]['index'] == 2 && arr[i]['pid']==id){
                $("#vClass").val(arr[0]['name'])
                $('.second-div').append("<option value= \""+arr[i]['id']+"\">"+arr[i]['name']+"</option>");
            }
        }
    })
    $(document).on('change','#vExamcourseid',function(){
        var id=$(this).val();
        for(var i=0;i<arr.length;i++){
            // console.log(arr[i]['index']+'--'+arr[i]['pid']);
            if (arr[i]['index'] == 3 && arr[i]['pid']==id){
                $('.last-div').append("<option value= \""+arr[i]['id']+"\">"+arr[i]['name']+"</option>");
            }
        }
    })
</script>