<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

echo Html::cssFile('assets/css/exam/css/share.css?r='.time());
echo Html::cssFile('assets/css/exam/css/test.css?r='.time());
echo Html::jsFile('assets/js/exam/jquery-3.1.1.min.js?r='.time());
echo Html::jsFile('assets/js/exam/rem.js?r='.time());
?>
