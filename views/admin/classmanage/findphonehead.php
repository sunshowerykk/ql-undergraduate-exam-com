<?php
use yii\helpers\Html;
use app\models\pub;
use app\models\langs;
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::cssFile('assets/css/public.css');
?>
        <?foreach ($data as $v):?>
            <li>
                <div class="adminTxt">
                    <h6><?=$v['subname']?></h6>
                </div>
                <div class="adminNei">
                    <hgroup>
                        <h6><?=$v['coursename']?></h6>
                        <p><?=$v['name']?></p>
                    </hgroup>
                </div>
            </li>
        <?endforeach;?>
