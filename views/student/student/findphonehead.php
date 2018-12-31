<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<?foreach ($d_data as $v):?>
    <?
    $rOpenK=pub::enFormMD5('open',$v['examid']);
    $rEditK=Pub::enFormMD52('exam',$v['examid']);
    $rDelK=pub::enFormMD5('del',$v['examid']);
    $rAddK=pub::enFormMD5('add',$v['examid']);
    ?>
    <div class="conLi">
        <div class="conLi-tit">
            <ul>
                <li>
                    <p><?=$v['examid']?>&nbsp;&nbsp;<?=$v['examsubname']?></p>
                </li>
                <li>
                    <p>
                        <a href="?r=student/student/createhead&examid=<?=$v['examid']?>&_k=<?=$rEditK?>">立即答题</a>
                    </p>
                </li>
            </ul>
        </div>
        <div class="conLi-info">
            <ul>
                <li>
                    <span class="ico">●</span>
                    <p><?=$v['examcoursename']?></p>
                </li>
                <li>
                    <span class="ico">●</span>
                    <p><?=$v['examcoursesectionname']?></p>
                </li>
                <li>
                    <span class="ico">●</span>
                    <p><?=$v['examname']?></p>
                </li>
            </ul>
        </div>
    </div>
<?endforeach;?>
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>