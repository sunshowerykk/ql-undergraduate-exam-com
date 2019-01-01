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
<div class="contentRight">
    <div class="homeTit">试卷管理 / 录入题型</div>
    <div class="homeCen addCen">
        <!-- 顶部搜索 -->
        <div class="homeCenTop adminAdd">
            <form action="?r=admin/papermanage/savetype" method="post" id="dialogForm" >
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                <input type='hidden' name='_k' value='<?=$rk?>' />
                <input type='hidden' name='vP' value='<?=$rp?>' />
                <input type='hidden' name='vTypeId' value='<?=pub::chkData($r_data,'typeid','')?>' />
                <?if($rop=='edit'):?>
                    <input type='hidden' name='vExamId' value='<?=pub::chkData($r_data,'examid','')?>' />
                <?else:?>
                    <input type='hidden' name='vExamId' value='<?=$examid?>' />
                <?endif;?>
                <ul>
                    <li>
                        <label>题号</label>
                        <div class="homeSele">
                            <input type="text" class="c-set" value="<?=pub::chkData($r_data,'typenum','')?>"  name="vTypeNum" placeholder="输入题号" data-chk='题号'/>
                        </div>
                    </li>
                    <li>
                        <label>名称</label>
                        <div class="homeSele">
                            <input type="text" class="c-set" value="<?=pub::chkData($r_data,'typename','')?>"  name="vTypeName" placeholder="名称" data-chk='名称'/>
                        </div>
                    </li>
                    <li>
                        <label>题型说明</label>
                        <div class="homeSele">
                            <input type="text" class="c-set" value="<?=pub::chkData($r_data,'typeinfo','')?>"  name="vTypeInfo" placeholder="题型说明" data-chk='题型说明'/>
                        </div>
                    </li>
                    <li>
                        <label>所属类型</label>
                        <div class="homeSele">
                            <select  class="c-set" name="vType" data-chk='所属类型'>
                                <option value="">请选择</option>
                                <option value="1" <?=pub::chkData($r_data,'type','')=='1'?'selected="selected"':''?>>单选题</option>
                                <option value="2" <?=pub::chkData($r_data,'type','')=='2'?'selected="selected"':''?>>多选题</option>
                                <option value="3" <?=pub::chkData($r_data,'type','')=='3'?'selected="selected"':''?>>填空题</option>
                                <option value="4" <?=pub::chkData($r_data,'type','')=='4'?'selected="selected"':''?>>文字题</option>
                            </select>
                            <img src="assets/images/icon_downgray.png" />
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
            async: false, //同步提交，不对返回值做判断，设置true
            success: function(result){
                //返回提示信息
                if (/\[0000\]/i.test(result)){
                    showMessage('<?=langs::getTxt('saveOK')?>',2,'<??>');
                    history.back(-1);
                    //跳轉分頁
                    findtype(1);
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