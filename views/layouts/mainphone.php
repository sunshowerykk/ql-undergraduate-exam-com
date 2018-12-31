<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use app\assets\AppAsset;

//AppAsset::register($this);

echo Html::cssFile('assets/css/examphone/css/share.css?r='.time());
echo Html::cssFile('assets/css/examphone/css/test.css?r='.time());
echo Html::cssFile('assets/css/examphone/css/mui.min.css?r='.time());
echo Html::cssFile('assets/css/examphone/css/common.css?r='.time());
echo Html::cssFile('assets/css/examphone/css/extra.css?r='.time());
echo Html::cssFile('assets/css/examphone/css/mui.poppicker.css?r='.time());
echo Html::jsFile('assets/js/examphone/js/jquery.js');
echo Html::jsFile('assets/js/examphone/js/mui.min.js');
echo Html::jsFile('assets/js/examphone/js/menu.js');
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


<body>
<!--主界面部分-->
<div class="headRight " >
    <!--头部-->
    <header class="mui-bar mui-bar-nav adminHead">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
        <h1 class="mui-title">考试系统</h1>
    </header>
    <article class="adminTop">
        <section class="adminTopCen">
            <div  class="menuDiv">
                <img src="assets/images/phone/images/menu.png" class="menu" />
            </div>
            <img src="assets/images/phone/images/logo_bai.png" class="logo" />
            <?if(Yii::$app->user->identity->RoleID==1):?>
            <figure class="userPop">
                <img src="assets/images/phone/images/guser.png" />
                <figcaption>管理员</figcaption>
            </figure>
            <?elseif (Yii::$app->user->identity->RoleID==3):?>
                <figure class="userPop">
                    <img src="assets/images/phone/images/guser.png" />
                    <figcaption>学员端</figcaption>
                </figure>
            <?else:?>
                <figure class="userPop">
                    <img src="assets/images/phone/images/guser.png" />
                    <figcaption>教师端</figcaption>
                </figure>
            <?endif;?>
        </section>
    </article>

    <!-- 内容区域  -->
    <article class="yeUp">

        <!----------------------------- 开始   --------------------------------------------------->
        <?=$content?>
        <!----------------------------- 结束   --------------------------------------------------->
    </article>
    <!-- 身份选择 -->
    <article class="adminUser">
        <section class="adminUserBg">
            <ul>
                <?if(Yii::$app->user->identity->RoleID==1):?>
                <li>
                    <a href="">
                        <figure>
                            <i></i>
                            <figcaption>管理员</figcaption>
                        </figure>
                    </a>
                </li>
                <?elseif (Yii::$app->user->identity->RoleID==3):?>
                <li>
                    <a href="">
                        <figure>
                            <i></i>
                            <figcaption>学员端</figcaption>
                        </figure>
                    </a>
                </li>
                <?else:?>
                <li>
                    <a href="teacher.html">
                        <figure>
                            <i></i>
                            <figcaption>教师端</figcaption>
                        </figure>
                    </a>
                </li>
                <?endif;?>
                <li>
                    <a href="?r=login/logout">
                        <figure>
                            <i></i>
                            <figcaption>退出</figcaption>
                        </figure>
                    </a>
                </li>
            </ul>
        </section>
    </article>
    <div class="heiBg"></div>
</div>

<!--侧滑菜单部分-->
<aside  class="menuBg">
    <?php
    $data=$this->params['data'];
    ?>
    <article class="menuCen" >
        <section class="menuTop">
            <img src="assets/images/phone/images/logo.png" />
        </section>
        <section class="menuUl">
            <ul>
                <?if(Yii::$app->user->identity->RoleID==1 || Yii::$app->user->identity->RoleID==2):?>
                <?if(Yii::$app->user->identity->RoleID==1):?>
                <li <?if($data==1):?>class="menuActive"<?endif;?>>
                    <a href="?r=admin/classmanage">
                        <figure>
                            <img <?if($data==1):?>src="assets/images/phone/images/gicon_a.png"<?else:?>src="assets/images/phone/images/gicon_aa.png"<?endif;?>">
                            <figcaption>类别管理</figcaption>
                        </figure>
                    </a>
                </li>
                <li <?if($data==2):?>class="menuActive"<?endif;?>>
                    <a href="?r=admin/papermanage">
                        <figure>
                            <img <?if($data==2):?>src="assets/images/phone/images/gicon_bb.png"<?else:?>src="assets/images/phone/images/gicon_b.png"<?endif;?>">
                            <figcaption>试卷管理</figcaption>
                        </figure>
                    </a>
                </li>
                <li <?if($data==3):?>class="menuActive"<?endif;?>>
                    <a href="?r=admin/teachmanage">
                        <figure>
                            <img <?if($data==3):?>src="assets/images/phone/images/gicon_cc.png"<?else:?>src="assets/images/phone/images/gicon_c.png"<?endif;?>">
                            <figcaption>阅卷人管理</figcaption>
                        </figure>
                    </a>
                </li>
                <?endif;?>
                <li <?if($data==4):?>class="menuActive"<?endif;?>>
                    <a href="?r=checkmanage/dealexam">
                        <figure>
                            <img <?if($data==4):?>src="assets/images/phone/images/gicon_dd.png"<?else:?>src="assets/images/phone/images/gicon_d.png"<?endif;?>">
                            <figcaption>待批试卷</figcaption>
                        </figure>
                    </a>
                </li>
                <li <?if($data==5):?>class="menuActive"<?endif;?>>
                    <a href="?r=checkmanage/onexam">
                        <figure>
                            <img <?if($data==5):?>src="assets/images/phone/images/gicon_ee.png"<?else:?>src="assets/images/phone/images/gicon_e.png"<?endif;?>">
                            <figcaption>批改中的试卷</figcaption>
                        </figure>
                    </a>
                </li>
                <li <?if($data==6):?>class="menuActive"<?endif;?>>
                    <a href="?r=checkmanage/endexam">
                        <figure>
                            <img <?if($data==6):?>src="assets/images/phone/images/gicon_ff.png"<?else:?>src="assets/images/phone/images/gicon_f.png"<?endif;?>">
                            <figcaption>已批试卷</figcaption>
                        </figure>
                    </a>
                </li>
                <?endif;?>
                <?if(Yii::$app->user->identity->RoleID==3):?>
                    <li <?if($data==7):?>class="menuActive"<?endif;?>>
                        <a href="?r=student/student">
                            <figure>
                                <img <?if($data==7):?>src="assets/images/icon_a.png"<?else:?>src="assets/images/icon_aa.png"<?endif;?>">
                                <figcaption>在线考试</figcaption>
                            </figure>
                        </a>
                    </li>
                    <li <?if($data==8):?>class="menuActive"<?endif;?>>
                        <a href="?r=student/myexam">
                            <figure>
                                <img <?if($data==8):?>src="assets/images/icon_bb.png"<?else:?>src="assets/images/icon_b.png"<?endif;?>">
                                <figcaption>我的答卷</figcaption>
                            </figure>
                        </a>
                    </li>
                <?endif;?>
            </ul>
        </section>
    </article>
</aside>



</body>
</html>