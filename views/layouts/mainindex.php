<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use app\assets\AppAsset;

//AppAsset::register($this);
echo Html::cssFile('assets/css/exam/css/share.css?r='.time());
echo Html::cssFile('assets/css/exam/css/test.css?r='.time());
echo Html::jsFile('assets/js/exam/jquery-3.1.1.min.js');
echo Html::jsFile('assets/js/exam/rem.js?r='.time());
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<!--->
    <title>都想学考试系统</title>
</head>

<body>

<div class="homeHead">
    <div  class="homeHeadCon">
        <div class="Headlogo">
            <a href="/"> <img src="assets/images/logo.png" alt="logo" /></a>
        </div>
        <div class="headLogin">
            <p><?php
                date_default_timezone_set('Asia/Shanghai');
                $h=date("H");
                if($h<11) echo "早上好!";
                else if($h<13) echo "中午好！";
                else if($h<17) echo "下午好！";
                else echo "晚上好！";
                ?>
            </p>
            <h6>
                <?if(Yii::$app->user->identity->RoleID<>3):?>
                <?=Yii::$app->user->identity->UserFull?>
                <?else:?>
                <?=yii::$app->session['studentuser']['username']?>
                <?endif;?>
            </h6>
            <div class="loginImg">
                <a href="?r=login/logout" title="退出系统" class="dl-log-quit">
                <img src="assets/images/icon_exit.png" alt="退出" />
                <p>退出</p>
                </a>
            </div>
            <div class="homeHeadTog">
                <?if(Yii::$app->user->identity->RoleID==1):?>
                <div class="headSele">
                    <p>管理员端</p>
                    <img src="assets/images/icon_downwhite.png" />
                </div>
                <?elseif (Yii::$app->user->identity->RoleID==3):?>
                <div class="headSele">
                    <p>学员端</p>
                    <img src="assets/images/icon_downwhite.png" />
                </div>
                <?else:?>
                <div class="headSele">
                    <p>教师中心</p>
                    <img src="assets/images/icon_downwhite.png" />
                </div>
                <?endif;?>
                <!--显示隐藏-->
            </div>
        </div>
    </div>
</div>

<!--  内容区域 -->
<div class="content">
    <!-- 左边 -->
    <?php
    $data=$this->params['data'];
    ?>
    <?if($data<>"exam"):?>
    <div class="contentLeft">
        <ul id="contentleft">
            <?if(Yii::$app->user->identity->RoleID==1 || Yii::$app->user->identity->RoleID==2):?>
            <?if(Yii::$app->user->identity->RoleID==1):?>
            <li <?if($data==1):?>class="leftActive"<?endif;?> >
                <a href="?r=admin/classmanage">
                    <img <?if($data==1):?>src="assets/images/aicon_ff.png"<?else:?>src="assets/images/aicon_f.png"<?endif;?>">
                    <p>类别管理</p>
                </a>
            </li>
            <li <?if($data==2):?>class="leftActive"<?endif;?>>
                <a href="?r=admin/papermanage">
                    <img <?if($data==2):?>src="assets/images/aicon_gg.png"<?else:?>src="assets/images/aicon_g.png"<?endif;?>">
                    <p>试卷管理</p>
                </a>
            </li>
            <li <?if($data==3):?>class="leftActive"<?endif;?>>
                <a href="?r=admin/teachmanage">
                    <img <?if($data==3):?>src="assets/images/aicon_hh.png"<?else:?>src="assets/images/aicon_h.png"<?endif;?>">
                    <p>阅卷人管理</p>
                </a>
            </li>
            <?endif;?>
                <li <?if($data==4):?>class="leftActive"<?endif;?>>
                <a href="?r=checkmanage/dealexam">
                    <img <?if($data==4):?>src="assets/images/ticon_cc.png"<?else:?>src="assets/images/ticon_c.png"<?endif;?>">
                    <p>待批试卷</p>
                </a>
            </li>
                <li <?if($data==5):?>class="leftActive"<?endif;?>>
                <a href="?r=checkmanage/onexam">
                    <img <?if($data==5):?>src="assets/images/ticon_dd.png"<?else:?>src="assets/images/ticon_d.png"<?endif;?>">
                    <p>批改中试卷</p>
                </a>
            </li>
                <li <?if($data==6):?>class="leftActive"<?endif;?>>
                <a href="?r=checkmanage/endexam">
                    <img <?if($data==6):?>src="assets/images/ticon_ee.png"<?else:?>src="assets/images/ticon_e.png"<?endif;?>">
                    <p>已批试卷</p>
                </a>
            </li>
            <?endif;?>
            <?if(Yii::$app->user->identity->RoleID==3):?>
            <li <?if($data==7):?>class="leftActive"<?endif;?>>
                <a href="?r=student/student">
                    <img <?if($data==7):?>src="assets/images/icon_a.png"<?else:?>src="assets/images/icon_aa.png"<?endif;?>">
                    <p>在线考试</p>
                </a>
            </li>
            <li <?if($data==8):?>class="leftActive"<?endif;?>>
                <a href="?r=student/myexam">
                    <img <?if($data==8):?>src="assets/images/icon_bb.png"<?else:?>src="assets/images/icon_b.png"<?endif;?>">
                    <p>我的答卷</p>
                </a>
            </li>
            <?endif;?>
        </ul>
    </div>
    <?endif;?>
    <?=$content?>
</div>

<script type="text/javascript">
</script>

</body>
</html>
