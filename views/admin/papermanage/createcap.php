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
echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/addKityFormulaDialog.js');   //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/defaultFilterFix.js');  //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/getKfContent.js'); //公式编辑器
?>
<!-- 弹窗 -->
<div class="contentRight">
    <div class="homeTit">试卷管理/题冒题管理/添加题冒题选项</div>
<div class="adminPop" >
    <div class="adminPopCen">
        <form action="?r=admin/papermanage/savecap" method="post" id="dialogForm" >
            <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <input type='hidden' name='_k' value='<?=$rk?>' />
            <input type='hidden' name='vP' value='<?=$rp?>' />
            <input type='hidden' name='vQId' value='<?=pub::chkData($r_data,'questionid','')?>' />
            <input type='hidden' name='vTypeId' value='<?=$t_data['typeid']?>' />
            <?if($rop=='edit'):?>
                <input type='hidden' name='vExamId' value='<?=pub::chkData($r_data,'examid','')?>' />
                <input type='hidden' name='vPId' value='<?=pub::chkData($r_data,'questionparent','')?>' />
            <?else:?>
                <input type='hidden' name='vPId' value='<?=$Q_data['questionid']?>' />
                <input type='hidden' name='vExamId' value='<?=$Q_data['examid']?>' />
            <?endif;?>
            <ul>
                <li>
                    <label>设定分值</label>
                    <div>
                        <input type="text"  class="c-set adInput" name="vQuestionScore"  data-chk='设定分值' placeholder="输入分值" value="<?=pub::chkData($r_data,'questionscore','')?>" />
                    </div>
                </li>
                <li class="ptTi">
                    <label>题干</label>
                    <div>
                     <textarea type="text" class="c-set" data-chk='题干'   name="vQuestion" id="vQuestion"   cols="" rows=""
                               style="resize:none;display: none;">
                         <?=pub::chkData($r_data,'question','')?>
                     </textarea>
                    </div>
                </li>
                <?if($t_data['type']==1 || $t_data['type']==2):?>
                <li class="ptTi">
                    <label>备选项</label>
                    <div>
                     <textarea type="text" class="c-set" data-chk='备选项'    name="vQuestionselect" id="vQuestionselect"  cols="" rows=""
                               style="resize:none;display: none;">
                         <?=pub::chkData($r_data,'questionselect','')?>
                     </textarea>
                    </div>
                </li>
                <li>
                    <label>备选数量</label>
                    <div class="adPopDiv">
                        <div class="addSele">
                            <select class="c-set" name="vNumber" data-chk='备选数量' >
                                <option value="4" <?=pub::chkData($r_data,'questionselectnumber','')=='4'?'selected="selected"':''?>>4</option>
                                <option value="1" <?=pub::chkData($r_data,'questionselectnumber','')=='1'?'selected="selected"':''?>>1</option>
                                <option value="2" <?=pub::chkData($r_data,'questionselectnumber','')=='2'?'selected="selected"':''?>>2</option>
                                <option value="3" <?=pub::chkData($r_data,'questionselectnumber','')=='3'?'selected="selected"':''?>>3</option>
                                <option value="4" <?=pub::chkData($r_data,'questionselectnumber','')=='4'?'selected="selected"':''?>>4</option>
                                <option value="5" <?=pub::chkData($r_data,'questionselectnumber','')=='5'?'selected="selected"':''?>>5</option>
                                <option value="6" <?=pub::chkData($r_data,'questionselectnumber','')=='6'?'selected="selected"':''?>>6</option>
                                <option value="7" <?=pub::chkData($r_data,'questionselectnumber','')=='7'?'selected="selected"':''?>>7</option>
                            </select>
                            <img src="assets/images/icon_downgray.png" />
                        </div>
                    </div>
                </li>
                <?endif;?>
                <?if($t_data['type']==1):?>
                <li>
                    <label>参考答案</label>
                    <div class="adPopDiv">
                        <div class="adminRadio">
                            <div  class="adminRa">
                                <img  src="<?=pub::chkData($r_data,'questionanswer','')=='A'?'assets/images/icon_Select.png':'assets/images/icon_Unselected.png'?>" />
                                <p>A</p>
                                <input type="radio"   name="vAnswer" value="A"  <?=pub::chkData($r_data,'questionanswer','')=='A'?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=pub::chkData($r_data,'questionanswer','')=='B'?'assets/images/icon_Select.png':'assets/images/icon_Unselected.png'?>" />
                                <p>B</p>
                                <input name="vAnswer" type="radio" value="B"  <?=pub::chkData($r_data,'questionanswer','')=='B'?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=pub::chkData($r_data,'questionanswer','')=='C'?'assets/images/icon_Select.png':'assets/images/icon_Unselected.png'?>" />
                                <p>C</p>
                                <input name="vAnswer" type="radio" value="C" <?=pub::chkData($r_data,'questionanswer','')=='C'?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=pub::chkData($r_data,'questionanswer','')=='D'?'assets/images/icon_Select.png':'assets/images/icon_Unselected.png'?>" />
                                <p>D</p>
                                <input name="vAnswer" type="radio" value="D" <?=pub::chkData($r_data,'questionanswer','')=='D'?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=pub::chkData($r_data,'questionanswer','')=='E'?'assets/images/icon_Select.png':'assets/images/icon_Unselected.png'?>" />
                                <p>E</p>
                                <input name="vAnswer" type="radio" value="E" <?=pub::chkData($r_data,'questionanswer','')=='E'?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=pub::chkData($r_data,'questionanswer','')=='F'?'assets/images/icon_Select.png':'assets/images/icon_Unselected.png'?>"  />
                                <p>F</p>
                                <input name="vAnswer" type="radio" value="F" <?=pub::chkData($r_data,'questionanswer','')=='F'?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=pub::chkData($r_data,'questionanswer','')=='G'?'assets/images/icon_Select.png':'assets/images/icon_Unselected.png'?>" />
                                <p>G</p>
                                <input name="vAnswer" type="radio" value="G" <?=pub::chkData($r_data,'questionanswer','')=='G'?'checked="checked"':''?> />
                            </div>
                        </div>
                    </div>
                </li>
                        <?elseif ($t_data['type']==2):?>
                <li>
                    <label>参考答案</label>
                    <div class="adPopDiv">
                        <div class="adminRadio">
                            <div class="adminRa">
                                <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'A') !== false?'assets/images/icon_fanga.png':'assets/images/icon_fang.png'?>" />
                                <p>A</p>
                                <input type="checkbox" name="vAnswer[]"  value="A" <?=strpos((pub::chkData($r_data,'questionanswer','')),'A') !== false?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'B') !== false?'assets/images/icon_fanga.png':'assets/images/icon_fang.png'?>"  />
                                <p>B</p>
                                <input type="checkbox"  name="vAnswer[]" value="B" <?=strpos((pub::chkData($r_data,'questionanswer','')),'B') !== false?'checked="checked"':''?>/>
                            </div>
                            <div class="adminRa">
                                <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'C') !== false?'assets/images/icon_fanga.png':'assets/images/icon_fang.png'?>" />
                                <p>C</p>
                                <input type="checkbox"  name="vAnswer[]" value="C" <?=strpos((pub::chkData($r_data,'questionanswer','')),'C') !== false?'checked="checked"':''?>/>
                            </div>
                            <div class="adminRa">
                                <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'D') !== false?'assets/images/icon_fanga.png':'assets/images/icon_fang.png'?>" />
                                <p>D</p>
                                <input type="checkbox"  name="vAnswer[]" value="D" <?=strpos((pub::chkData($r_data,'questionanswer','')),'D') !== false?'checked="checked"':''?>/>
                            </div>
                            <div class="adminRa">
                                <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'E') !== false?'assets/images/icon_fanga.png':'assets/images/icon_fang.png'?>" />
                                <p>E</p>
                                <input type="checkbox" name="vAnswer[]" value="E" <?=strpos((pub::chkData($r_data,'questionanswer','')),'E') !== false?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'F') !== false?'assets/images/icon_fanga.png':'assets/images/icon_fang.png'?>" />
                                <p>F</p>
                                <input type="checkbox"  name="vAnswer[]" value="F" <?=strpos((pub::chkData($r_data,'questionanswer','')),'F') !== false?'checked="checked"':''?> />
                            </div>
                            <div class="adminRa">
                                <img src="<?=strpos((pub::chkData($r_data,'questionanswer','')),'G') !== false?'assets/images/icon_fanga.png':'assets/images/icon_fang.png'?>" />
                                <p>G</p>
                                <input type="checkbox"  name="vAnswer[]" value="G" <?=strpos((pub::chkData($r_data,'questionanswer','')),'G') !== false?'checked="checked"':''?> />
                            </div>
                        </div>
                    </div>
                </li>
                        <?elseif ($t_data['type']==3 || $t_data['type']==4 ):?>
                    <li class="ptTi">
                        <label>参考答案</label>
                        <div>
                     <textarea type="text"  class="c-set" data-chk='参考答案'   name="vAnswer" id="vAnswer"  cols="" rows=""
                               style="resize:none;display: none;">
                         <?=pub::chkData($r_data,'questionanswer','')?>
                     </textarea>
                        </div>
                    </li>
                        <?endif;?>
                <li class="ptTi">
                    <label>习题解析</label>
                    <div>
                     <textarea type="text"  class="c-set" data-chk='习题解析'   name="vQuestiondescribe" id="vQuestiondescribe"  cols="" rows=""
                               style="resize:none;display: none;">
                        <?=pub::chkData($r_data,'questiondescribe','')?>
                     </textarea>
                    </div>
                </li>
                <li class="ptTi">
                    <label>讲解视频</label>
                    <div>
                        <input type="text"  class="adInput" name="vQuestionvideo"  placeholder="http://" value="<?=pub::chkData($r_data,'questionvideo','')?>" />
                    </div>
                </li>
            </ul>

            <div class="adPopBtn">
                <button type="reset" class="adRe" onclick="history.back(-1)">取消</button>
                <button type="button" onclick="artSave('dialogForm')">确定</button>
            </div>
        </form>
    </div>
</div>
</div>

<script type="text/javascript">
    <?if($t_data['type']==1):?>
        $('.adminRa').find('img').click(function(){
            if($(this).attr('src') == 'assets/images/icon_Unselected.png'){
                $(this).attr('src','assets/images/icon_Select.png');
                $(this).next().next().attr("checked","checked");
                $('.adminRa').find('img').not(this).attr('src','assets/images/icon_Unselected.png');
                $('.adminRa').find('img').not(this).next().next().attr("checked",false);
            }else{
                $(this).attr('src','assets/images/icon_Unselected.png');
              //  $(this).next().next().attr("checked","checked");
            }
        })
    <?elseif ($t_data['type']==2):?>
    $('.adminRa').find('img').click(function(){
        if($(this).attr('src') == 'assets/images/icon_fang.png'){
            $(this).attr('src','assets/images/icon_fanga.png');
            $(this).next().next().attr("checked","checked");
        }else{
            $(this).attr('src','assets/images/icon_fang.png');
            $(this).next().next().attr("checked",false);
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
            initialFrameWidth: '85%',
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
    //啟動文本框
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
            initialFrameWidth: '85%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueB= new UE.ui.Editor({
            initialFrameWidth: '85%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueC= new UE.ui.Editor({
            initialFrameWidth: '85%',
            initialFrameHeight: '200',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            //toolbars:[],
            initialStyle: 'p{font-size:13px}'
        });
        ueD= new UE.ui.Editor({
            initialFrameWidth: '85%',
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