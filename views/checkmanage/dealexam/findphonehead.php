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
                <section class="testBtn pendBtn">
                    <ul>
                        <li><a href="?r=checkmanage/dealexam/createhead&c1=<?=$v['ehid']?>&_k=<?=$rAddK?>">批改答卷</a></li>
                    </ul>
                </section>
            </li>
        <?endforeach;?>
<!--备注 -->
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>