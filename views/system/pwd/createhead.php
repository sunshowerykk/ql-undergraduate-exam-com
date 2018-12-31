<?php

use yii\helpers\Html;
use app\models\pub;
use app\models\langs;

/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
//echo Html::cssFile('assets/css/public.css');

?>
<div class="" style="width: 300px;">
    <div style="overflow-y:auto; padding:2px;">
        <div id="FindHead" class="" >
            <?//begin增加修改字段排版位置?>
            <form action="?r=system/pwd/savehead" method="post" id="frmSave" name="frmSave" class="">
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                <table class="table table-bordered table-condensed table-hover">
                    <tr>
                        <th>原始密码</th>
                        <td>
                            <input type="password" onkeyup="keydown(event,1)"
                                   class="fm-must" data-chk='原始密码' autofocus
                                   name="UserPwd" id="UserPwd" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <th>新&nbsp;密&nbsp;码</th>
                        <td>
                            <input type="password" onkeyup="keydown(event,2)"
                                   class="fm-must" data-chk='新密码'
                                   name="UserPwd1" id="UserPwd1"  value=""/>
                        </td>
                    </tr>
                    <tr>
                        <th>确认密码</th>
                        <td>
                            <input type="password" onkeyup="keydown(event,3)"
                                   class="fm-must" data-chk='确认密码'
                                   name="UserPwd2" id="UserPwd2"  value=""/>
                        </td>
                    </tr>

                </table>
            </form>
            <?//end增加修改字段排版位置?>
        </div>
        <?//子表明细字段排版位置?>
        <div id="addDetail"  class="Detail">

        </div>
    </div>
    <div class="" style="text-align: right;padding: 2px;border-top: 2px solid #e5e5e5;" >
        <button type="button" class="btn btn-primary btn-sm" onclick="artSave('frmSave')">保存</button>
    </div>
</div>

<script type="text/javascript">
    //回車
    function keydown(e,i){
        //alert(e.keyCode);
        if (e.keyCode==13){  //回車鍵的鍵值為13
            if (i==1) {
                $('#UserPwd1').focus();
            }else if (i==2){
                $('#UserPwd2').focus();
            }else if (i==3){
                artSave('frmSave')
            }
        }
        return false;
    }
    function artSave(formid){
        var msg = checkWithClass('frmSave');
        if (msg!=''){
            showalert(msg,'<?=langs::getTxt('infotitle')?>');
            return false;
        }
        $("#"+formid).ajaxSubmit({
            async: false, //同步提交，不对返回值做判断，设置true
            success: function(result){
                //返回提示信息
                if (/\[0000\]/i.test(result)){
                    showMessage('密码修改成功，跳转中...',2,'<??>');
                    top.location='?r=login/logout';
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