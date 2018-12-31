<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use app\assets\AppAsset;

//AppAsset::register($this);
?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?
//    echo Html::cssFile('assets/bootstrap/css/bootstrap.css?r='.time());
    //echo Html::cssFile('assets/css/bui-min.css');
    //echo Html::cssFile('assets/css/main.css');
    //echo Html::cssFile('assets/css/main.css');
    ?>

</head>
<body>

        <?= $content ?>


<footer class="footer">

</footer>

</body>
</html>
