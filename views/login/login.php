<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;

echo Html::cssFile('assets/css/login.css?a='.time());


?>
<div id="login">
    <h2><span class="fontawesome-lock">请输入用户名和密码</span></h2>
    <form id="login-form"  method="post" action="?r=login">
        <fieldset>
            <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <table width="350px">
                <tr>
                    <td width="60px"><label for="UserName">用户名:</label></td>
                    <td><input type="UserName" id="UserName" name="LoginForm[UserName]" placeholder="请输入用户名" style="width: 200px" autofocus></td>
                </tr>
                <tr>
                    <td><label for="password">密&nbsp;&nbsp;&nbsp;&nbsp;码:</label></td>
                    <td><input type="password" id="password"  name="LoginForm[UserPwd]" placeholder="请输入密码" style="width: 200px"></td>
                </tr>
                <?if ($sms!='nosm'):?>
                <tr>
                    <td><label for="chkCode"><?=$status?>验证码:</label></td>
                    <td >
                        <input type="text" id="chkCode" style="width: 140px"  name="LoginForm[chkCode]" placeholder="验证码">
                    <input type="button" value="获取" onclick="sendSMS()">
                    </td>
                </tr>
                <?endif?>
                <tr>
                    <td colspan="2">
                        <table width="99%">
                            <tr>
                                <td align="left"><span id="rinfo" class="swinfo"></span> </td>
                                <td width="50px"><input type="submit" class="btn btn-inverse" onclick="login();return false" value="登录" /></td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>
        </fieldset>
    </form>
</div>
<?=Html::jsFile('assets/js/jquery-1.8.1.min.js')?>
<?=Html::jsFile('assets/js/pub.js')?>
<script type="text/javascript">
    function sendSMS(){
        var url = '?r=login/ajaxsendsms';
        var data=$('#login-form').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: data,
            success: function (data) {
                if (data=='0'){
                    $('#rinfo').html('验证码已经发送...');
                }else{
                    $('#rinfo').html(data);
                    flash('#rinfo',8,6,100);
                }
            }
        });
    }
    function login(){
        var url = '?r=login/ajaxlogin';
        var data=$('#login-form').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: data,
            success: function (data) {
                if (data=='1'){
                    $('#rinfo').html('验证正确，跳转中...');
                    top.location='/';
                }else{
                    $('#rinfo').html(data);
                    flash('#rinfo',8,6,100);
                }
            }
        });
    }

</script>
