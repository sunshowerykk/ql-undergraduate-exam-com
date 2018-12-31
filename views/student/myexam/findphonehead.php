<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<?foreach ($d_data as $v):?>
<?
$rOpenK=pub::enFormMD52('open',$v['ehid']);
$rEditK=Pub::enFormMD5('edit',$v['ehid']);
$rDelK=pub::enFormMD5('del',$v['ehid']);
$rAddK=pub::enFormMD5('add',$v['ehid']);
?>
    <div class="conLi">
        <div class="conLi-tit my_answer">
            <ul>
                <li>
                    <p><?=$v['ehid']?>&nbsp;&nbsp;<?=$v['examsubname']?></p>
                </li>
                <li>
                    <p><?=$v['ehgardestatus']==1?'阅卷中': $v['ehscore'] ?></p>
                </li>
            </ul>
        </div>
        <div class="conLi-info">
            <ul>
                <li>
                    <p><?=$v['examcoursename']?></p>
                </li>
                <li>
                    <p><?=$v['examcoursesectionname']?></p>
                </li>
                <li>
                    <p><?=$v['examname']?></p>
                </li>
            </ul>
            <ul>
                <li>
                    <img src="assets/images/phone/images/ximg_a.png" >
                    <span>
                    <?if($v['ehstatus']==1):?>
                        <?=$v['ehgrade']==1?'自评分': $v['chcheckusername'] ?>
                    <?else:?>
                        /
                    <?endif;?>
                    </span>
                </li>
                <li>
                    <img src="assets/images/phone/images/ximg_b.png" >
                    <span>考试用时
                        <?
                        $remain = $v['ehtime']%86400;
                        $hours = intval($remain/3600);

                        // 分
                        $remain = $v['ehtime']%3600;
                        $mins = intval($remain/60);
                        // 秒
                        $secs = $remain%60;
                        if($hours!=0){
                            echo ($hours."小时".$mins."分".$secs."秒");
                        }else{
                            echo ($mins."分".$secs."秒");
                        }
                        ?>
                    </span>
                </li>
            </ul>
                <?if($v['ehstatus']==1):?>
                    <?if($v['ehgardestatus']==2):?>
                    <div class="info-bottom">
                                <ul>
                                    <li>交卷时间</li>
                                    <li><?=date('Y-m-d H:i:s',$v['ehendtime'])?></li>
                                </ul>
                                <ul>
                                    <li> <a href="?r=student/myexam/loadhead&c1=<?=$v['ehid']?>&_k=<?=$rOpenK?>">查看答卷</a></li>
                                    <li><a href="?r=student/myexam/errorhead&c1=<?=$v['ehid']?>&_k=<?=$rOpenK?>">错题本</a></li>
                                </ul>
                    </div>
                    <?else:?>
                            <div class="info-bottom">
                                <ul>
                                    <li>交卷时间</li>
                                    <li><?=date('Y-m-d H:i:s',$v['ehendtime'])?></li>
                                </ul>
                                <ul>
                                    <li>阅卷中</li>
                                </ul>
                            </div>
                    <?endif;?>
                <?else:?>
                    <div class="info-bottom goon">
                        <ul>
                            <li>交卷时间</li>
                            <li>\</li>
                        </ul>
                        <ul>
                            <li> <a href="?r=student/student/edithead&c1=<?=$v['ehid']?>&_k=<?=$rEditK?>">继续答题</a></li>
                        </ul>
                    </div>
                <?endif;?>
        </div>
    </div>
<?endforeach;?>