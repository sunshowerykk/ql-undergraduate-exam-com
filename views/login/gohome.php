<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?=Html::cssFile('assets/css/login.css')?>
<div id="login">

    <h2><span class="fontawesome-lock"></span>请输入用户名和密码</h2>

</div>
<script type="text/javascript">
    top.location='index.php?r=login/index';
</script>