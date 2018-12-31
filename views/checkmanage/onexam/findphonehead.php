<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
        <?foreach ($d_data as $v):?>

            <?
            $rOpenK=pub::enFormMD5('open',$v['ehid']);
            $rEditK=Pub::enFormMD5('edit',$v['ehid']);
            $rDelK=pub::enFormMD5('del',$v['ehid']);
            $rAddK=pub::enFormMD5('add',$v['ehid']);
            ?>
            <li>
                <div class="testCenTop">
                    <hgroup>
                        <h6><?=$v['username']?><span><?=$v['examsubname']?></span></h6>
                        <p><?=date('Y-m-d H:i:s',$v['ehendtime'])?></p>
                    </hgroup>
                </div>
                <section class="testCenOne">
                    <div class="testCenOneA pending">
                        <hgroup>
                            <p><?=$v['examcoursename']?></p>
                            <p><?=$v['examcoursesectionname']?></p>
                            <p><?=$v['examname']?></p>
                        </hgroup>
                    </div>
                </section>
                <section class="testBtn endHg">
                    <figure>
                        <img src="assets/images/phone/images/ximg_b.png" />
                        <figcaption>用时<?
                            $remain = $v['ehgardetime']%86400;
                            $hours = intval($remain/3600);

                            // 分
                            $remain = $v['ehgardetime']%3600;
                            $mins = intval($remain/60);
                            // 秒
                            $secs = $remain%60;
                            if($hours!=0){
                                echo ($hours."小时".$mins."分".$secs."秒");
                            }else{
                                echo ($mins."分".$secs."秒");
                            }
                            ?></figcaption>
                    </figure>
                    <ul>
                        <li><a href="?r=checkmanage/onexam/createhead&c1=<?=$v['ehid']?>&_k=<?=$rAddK?>">批改答卷</a></li>
                        <li><a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                               data-url="?r=checkmanage/onexam/waivehead&c1=<?=$v['ehid']?>&_k=<?=$rEditK?>&p=<?=$page->getNpage()?>"
                               data-confirm='确认要放弃考生【<?=$v['username']?>】这张试卷吗？'
                               data-id="artHead"
                               onclick="artWaive(this);return false;">放弃阅卷
                            </a></li>
                    </ul>
                </section>
            </li>
        <?endforeach;?>
<!--备注 -->
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>