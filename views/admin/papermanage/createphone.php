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
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/addKityFormulaDialog.js');   //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/defaultFilterFix.js');  //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/getKfContent.js'); //公式编辑器
?>
<!-- 弹窗 -->
<section class="testTop">
    <h6><?=$t_data['typename']?></h6>
</section>

<section class="testTwoList ptList">
    <form action="?r=admin/papermanage/savequestion" method="post" id="dialogForm" >
        <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
        <input type='hidden' name='_k' value='<?=$rk?>' />
        <input type='hidden' name='vP' value='<?=$rp?>' />
        <input type='hidden' name='vQId' value='<?=pub::chkData($r_data,'questionid','')?>' />
        <input type='hidden' name='vTypeId' value='<?=$t_data['typeid']?>' />
        <input type='hidden' name='vCap' value='<?=$cap?>' />
        <?if($rop=='edit'):?>
            <input type='hidden' name='vExamId' value='<?=pub::chkData($r_data,'examid','')?>' />
        <?else:?>
            <input type='hidden' name='vExamId' value='<?=$examid?>' />
        <?endif;?>
        <!--单选题-->
        <ul>
            <?if($cap==1):?>
            <?else:?>
                <li>
                    <div class="testTwoCen">
                        <label>设定分值</label>
                        <div class="testTwoInp">
                            <input type="text"  class="c-set" name="vQuestionScore"  data-chk='设定分值' placeholder="输入分值" value="<?=pub::chkData($r_data,'questionscore','')?>" />
                        </div>
                    </div>
                </li>
            <?endif;?>
            <li>
                <div class="testTwoCen">
                    <hgroup>
                        <h6>题干</h6>
                        <div class="twoFu" style="background-color: pink;">
                                <textarea type="text" class="c-set" data-chk='题干'   name="vQuestion" id="vQuestion"   cols="" rows=""
                                          style="resize:none;display: none;">
                         <?=pub::chkData($r_data,'question','')?>
                     </textarea>
                        </div>
                    </hgroup>
                </div>
            </li>
            <?if($cap==1):?>
            <?else:?>
                <?if($t_data['type']==1 || $t_data['type']==2):?>
                    <li>
                        <div class="testTwoCen">
                            <hgroup>
                                <h6>备选项</h6>
                                <div class="twoFu" style="background-color: pink;">
                             <textarea type="text" class="c-set" data-chk='备选项'    name="vQuestionselect" id="vQuestionselect"  cols="" rows=""
                                       style="resize:none;display: none;">
                                 <?=pub::chkData($r_data,'question','')?>
                             </textarea>
                                </div>
                            </hgroup>
                        </div>
                    </li>
                    <li>
                        <div class="testTwoCen testTwoCenA">
                            <label>备选数量</label>
                            <div class="testTwoInp">
                                <select class="c-set" name="vNumber" data-chk='备选数量'>
                                    <option value="4" <?=pub::chkData($r_data,'questionselectnumber','')=='4'?'selected="selected"':''?>>4</option>
                                    <option value="1" <?=pub::chkData($r_data,'questionselectnumber','')=='1'?'selected="selected"':''?>>1</option>
                                    <option value="2" <?=pub::chkData($r_data,'questionselectnumber','')=='2'?'selected="selected"':''?>>2</option>
                                    <option value="3" <?=pub::chkData($r_data,'questionselectnumber','')=='3'?'selected="selected"':''?>>3</option>
                                    <option value="4" <?=pub::chkData($r_data,'questionselectnumber','')=='4'?'selected="selected"':''?>>4</option>
                                    <option value="5" <?=pub::chkData($r_data,'questionselectnumber','')=='5'?'selected="selected"':''?>>5</option>
                                    <option value="6" <?=pub::chkData($r_data,'questionselectnumber','')=='6'?'selected="selected"':''?>>6</option>
                                    <option value="7" <?=pub::chkData($r_data,'questionselectnumber','')=='7'?'selected="selected"':''?>>7</option>
                                </select>
                                <img src="assets/images/phone/images/icon_choose.png" class="testTwoImg" />
                            </div>
                        </div>
                    </li>
                <?endif;?>
                <?if($t_data['type']==1):?>
                    <li>
                        <div class="testTwoCen">
                            <hgroup>
                                <h6>参考答案</h6>
                                <div class="testCk testRadio">
                                    <figure>
                                        <img  src="<?=pub::chkData($r_data,'questionanswer','')=='A'?'assets/images/phone/images/icon_Selecta.png':'assets/images/phone/images/icon_Select.png'?>" />
                                        <figcaption>A</figcaption>
                                        <input type="hidden"    value="<?=pub::chkData($r_data,'questionanswer','')?>"   />
                                    </figure>
                                    <figure>
                                        <img  src="<?=pub::chkData($r_data,'questionanswer','')=='B'?'assets/images/phone/images/icon_Selecta.png':'assets/images/phone/images/icon_Select.png'?>" />
                                        <figcaption>B</figcaption>
                                        <input type="hidden"   value="<?=pub::chkData($r_data,'questionanswer','')?>"   />
                                    </figure>
                                    <figure>
                                        <img  src="<?=pub::chkData($r_data,'questionanswer','')=='C'?'assets/images/phone/images/icon_Selecta.png':'assets/images/phone/images/icon_Select.png'?>" />
                                        <figcaption>C</figcaption>
                                        <input type="hidden"    value="<?=pub::chkData($r_data,'questionanswer','')?>"   />
                                    </figure>
                                    <figure>
                                        <img  src="<?=pub::chkData($r_data,'questionanswer','')=='D'?'assets/images/phone/images/icon_Selecta.png':'assets/images/phone/images/icon_Select.png'?>" />
                                        <figcaption>D</figcaption>
                                        <input type="hidden"    value="<?=pub::chkData($r_data,'questionanswer','')?>"   />
                                    </figure>
                                    <figure>
                                        <img  src="<?=pub::chkData($r_data,'questionanswer','')=='E'?'assets/images/phone/images/icon_Selecta.png':'assets/images/phone/images/icon_Select.png'?>" />
                                        <figcaption>E</figcaption>
                                        <input type="hidden"    value="<?=pub::chkData($r_data,'questionanswer','')?>"   />
                                    </figure>
                                    <figure>
                                        <img  src="<?=pub::chkData($r_data,'questionanswer','')=='F'?'assets/images/phone/images/icon_Selecta.png':'assets/images/phone/images/icon_Select.png'?>" />
                                        <figcaption>F</figcaption>
                                        <input type="hidden"   value="<?=pub::chkData($r_data,'questionanswer','')?>"   />
                                    </figure>
                                </div>
                            </hgroup>
                        </div>
                    </li>
                <?elseif ($t_data['type']==2):?>
                    <li>
                        <div class="testTwoCen">
                            <hgroup>
                                <h6>参考答案</h6>
                                <div class="testCk testCheck">
                                    <figure>
                                        <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'A') !== false?'assets/images/phone/images/icon_fanga.png':'assets/images/phone/images/icon_fang.png'?>" />
                                        <figcaption>A</figcaption>
                                        <input type="hidden"   name="vAnswer[]" value="<?=strpos((pub::chkData($r_data,'questionanswer','')),'A') !== false?'A':''?>"   />
                                    </figure>
                                    <figure>
                                        <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'B') !== false?'assets/images/phone/images/icon_fanga.png':'assets/images/phone/images/icon_fang.png'?>" />
                                        <figcaption>B</figcaption>
                                        <input type="hidden"   name="vAnswer[]" value="<?=strpos((pub::chkData($r_data,'questionanswer','')),'B') !== false?'B':''?>"   />
                                    </figure>
                                    <figure>
                                        <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'C') !== false?'assets/images/phone/images/icon_fanga.png':'assets/images/phone/images/icon_fang.png'?>" />
                                        <figcaption>C</figcaption>
                                        <input type="hidden"   name="vAnswer[]" value="<?=strpos((pub::chkData($r_data,'questionanswer','')),'C') !== false?'C':''?>"   />
                                    </figure>
                                    <figure>
                                        <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'D') !== false?'assets/images/phone/images/icon_fanga.png':'assets/images/phone/images/icon_fang.png'?>" />
                                        <figcaption>D</figcaption>
                                        <input type="hidden"   name="vAnswer[]" value="<?=strpos((pub::chkData($r_data,'questionanswer','')),'D') !== false?'D':''?>"   />
                                    </figure>
                                    <figure>
                                        <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'E') !== false?'assets/images/phone/images/icon_fanga.png':'assets/images/phone/images/icon_fang.png'?>" />
                                        <figcaption>E</figcaption>
                                        <input type="hidden"   name="vAnswer[]" value="<?=strpos((pub::chkData($r_data,'questionanswer','')),'E') !== false?'E':''?>"   />
                                    </figure>
                                </div>
                            </hgroup>
                        </div>
                    </li>
                <?elseif ($t_data['type']==3 || $t_data['type']==4 ):?>
                    <li>
                        <div class="testTwoCen">
                            <hgroup>
                                <h6>参考答案</h6>
                                <div class="twoFu" style="background-color: pink;">
                     <textarea type="text"  class="c-set" data-chk='参考答案'   name="vAnswer" id="vAnswer"  cols="" rows=""
                               style="resize:none;display: none;">
                        <?=pub::chkData($r_data,'questionanswer','')?>
                     </textarea>
                                </div>
                            </hgroup>
                        </div>
                    </li>
                <?endif;?>
                <li>
                    <div class="testTwoCen">
                        <hgroup>
                            <h6>习题解析</h6>
                            <div class="twoFu" style="background-color: pink;">
                     <textarea type="text"  class="c-set" data-chk='习题解析'   name="vQuestiondescribe" id="vQuestiondescribe"  cols="" rows=""
                               style="resize:none;display: none;">
                        <?=pub::chkData($r_data,'questiondescribe','')?>
                     </textarea>
                            </div>
                        </hgroup>
                    </div>
                </li>
                <li>
                    <div class="testTwoCen">
                        <label>讲解视频</label>
                        <div class="testTwoInp">
                            <input type="text"  name="vQuestionvideo"  placeholder="http://" value="<?=pub::chkData($r_data,'questionvideo','')?>" />
                        </div>
                    </div>
                </li>
            <?endif;?>
            <!--<button type="submit" class="adminHeadBtn">提交</button>-->
            <button type="button" onclick="artSave('dialogForm')" class="adminHeadBtn">提交</button>
        </ul>
    </form>


</section>
<script type="text/javascript">
    <?if($t_data['type']==1):?>
    $('.testRadio figure').click(function(){
        var answer=$.trim($(this).text());
        $(this).find('img').attr('src','assets/images/phone/images/icon_Selecta.png');
        $(this).find('input').val(answer);
        $(this).find('input').attr("name","vAnswer");

        $(this).siblings().find('img').attr('src','assets/images/phone/images/icon_Select.png');
        $(this).siblings().find('input').val("");
        $(this).siblings().find('input').attr("name","");
    })
    <?elseif ($t_data['type']==2):?>
    // $('.testCheck figure').click(function(){
    //     var answer=$.trim($(this).text());
    //     $(this).find('img').attr('src','assets/images/phone/images/icon_Selecta.png');
    //     $(this).siblings().find('img').attr('src','assets/images/phone/images/icon_Select.png');
    // })
    $('.testCheck figure').click(function(){
        if($(this).find('img').attr('src') == 'assets/images/phone/images/icon_fang.png'){
            $(this).find('img').attr('src','assets/images/phone/images/icon_fanga.png');
            var answer=$.trim($(this).text());
            $(this).find('input').val(answer);
        }else{
            $(this).find('img').attr('src','assets/images/phone/images/icon_fang.png');
            $(this).find('input').val("");
        }
    })
    <?elseif ($t_data['type']==3 || $t_data['type']==4):?>
    var ueE;
    $(document).ready(function () {
        //渲染編輯器的DOM到ueA
        if (ueE) {
            ueE.destroy();
        }
        ueE = new UE.ui.Editor({
            initialFrameWidth: '100%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueE.render('vAnswer');
        // ueA.render('ueRemarks2');
        ueE.addListener("ready", function () {
            $('#vAnswer').show();
        });
    });

    <?endif;?>
    fieldsCheck=new FieldsCheck();
    fieldsCheck.setFormat('c-s-15',"\\S{0,15}");
    fieldsCheck.setFormat('c-s-20',"\\S{0,20}");
    fieldsCheck.setFormat('c-s-30',"\\S{0,30}");
    fieldsCheck.setFormat('c-s-50',"\\S{0,50}");
    fieldsCheck.setFormat('c-s-100',"\\S{0,100}");
    fieldsCheck.setFormat('c-i-30',"\\d{0,30}");
    fieldsCheck.setFormat('c-f-2',"\\d+\\.?\\d{0,3}");//0-3位小数
    fieldsCheck.keyFire();
    <?if($cap==1):?>
    $(document).ready(function () {
        var ueA;
        //渲染編輯器的DOM到ueA
        if (ueA) {
            ueA.destroy();
        }
        ueA = new UE.ui.Editor({
            initialFrameWidth: '100%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueA.render('vQuestion');
        // ueA.render('ueRemarks2');
        ueA.addListener("ready", function () {
            $('#vQuestion').show();
        });
    });
    <?else:?>
    var ueA;
    var ueB;
    var ueC;
    var ueD;
    $(document).ready(function () {
        //渲染編輯器的DOM到ueA
        if (ueA) {
            ueA.destroy();
        }
        if (ueB) {
            ueB.destroy();
        }
        if (ueC) {
            ueB.destroy();
        }
        if (ueD) {
            ueB.destroy();
        }
        ueA = new UE.ui.Editor({
            initialFrameWidth: '100%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueB= new UE.ui.Editor({
            initialFrameWidth: '100%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueC= new UE.ui.Editor({
            initialFrameWidth: '100%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueD= new UE.ui.Editor({
            initialFrameWidth: '100%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueA.render('vQuestion');
        // ueA.render('ueRemarks2');
        ueA.addListener("ready", function () {
            $('#vQuestion').show();
        });
        ueB.render('vQuestionselect');
        // ueA.render('ueRemarks2');
        ueB.addListener("ready", function () {
            $('#vQuestionselect').show();
        });
        ueC.render('vQuestiondescribe');
        // ueA.render('ueRemarks2');
        ueC.addListener("ready", function () {
            $('#vQuestiondescribe').show();
        });
    });
    <?endif;?>
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
                    setTimeout(history.back(-1), 2000 )
                    //跳轉分頁
                    // findHead(1);
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