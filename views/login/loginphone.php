<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
echo Html::cssFile('assets/css/examphone/css/share.css?r='.time());
echo Html::cssFile('assets/css/examphone/css/test.css?r='.time());
echo Html::cssFile('assets/css/examphone/css/mui.min.css?r='.time());


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>考试系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>考试系统</title>
</head>

<body class="f5">
<article class="sign">
    <h6>登录</h6>
    <form id="login-form"  method="post" action="?r=login">
        <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
        <ul>
            <li>
                <label>用户名</label>
                <div class="signDiv">
                    <td><input type="text" id="UserName" name="LoginForm[UserName]" placeholder="请输入用户名" ></td>
                </div>
            </li>
            <li>
                <label>密码</label>
                <div class="signDiv">
                    <td><input type="password" id="password"  name="LoginForm[UserPwd]" placeholder="请输入密码"></td>
                </div>
            </li>
            <span id="rinfo" class="swinfo"></span>
            <button type="submit" onclick="login();return false" >登录</button>
        </ul>
    </form>
</article>


</body>
</html>

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
