<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?=Html::cssFile('assets/css/login.css?r='.time())?>
<div id="login">

    <h2><span class="fontawesome-lock"></span>请输入用户名和密码</h2>

    <form id="login-form"  method="post" action="?r=index/login">
        <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
        <fieldset>
            <table>
                <tr >
                    <td ><label for="UserName">用户名</label><</td>
                    <td><input type="UserName" id="UserName" name="LoginForm[UserName]" placeholder="请输入用户名" style="width: 250px"></td>

                </tr>
                <tr>
                    <td><label for="password">密码</label></td>
                    <td><input type="password" id="password"  name="LoginForm[UserPwd]" placeholder="请输入密码" style="width: 250px"></td>
                </tr>

            </table>


            <table width="100%">
                <tr>
                    <td><?=$status?></td>
                    <td width="50px"><input type="submit" class="btn btn-inverse" value="登录" /></td>
                </tr>
            </table>


        </fieldset>

    </form>

</div>