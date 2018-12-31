<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<!-- 表格 -->
<div class="homeTable">
    <table cellpadding="0"  cellspacing="0" align="center" rules="none" width="100%" class="homeTableHead">
        <tbody>
        <tr class="homeSheete">
            <th>试卷编号</th>
            <th>科目</th>
            <th>课程</th>
            <th>节次</th>
            <th>试卷名称</th>
            <th>得分</th>
            <th>交卷时间</th>
            <th>考试用时</th>
            <th>操作</th>
            <th>阅卷人</th>
        </tr>
        <?foreach ($d_data as $v):?>
            <?
            $rOpenK=pub::enFormMD52('open',$v['ehid']);
            $rEditK=Pub::enFormMD5('edit',$v['ehid']);
            $rDelK=pub::enFormMD5('del',$v['ehid']);
            $rAddK=pub::enFormMD5('add',$v['ehid']);
            ?>
        <tr class="homeSheeteA">
            <td><?=$v['ehid']?></td>
            <td><?=$v['examsubname']?></td>
            <td><?=$v['examcoursename']?></td>
            <td><?=$v['examcoursesectionname']?></td>
            <td><?=$v['examname']?></td>
            <td><?=$v['ehgardestatus']==1?'阅卷中': $v['ehscore'] ?></td>
            <td><?=date('Y-m-d H:i:s',$v['ehendtime'])?></td>
            <td>
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
            </td>
            <td class="homeSdJ">
                <?if($v['ehstatus']==1):?>
                <?if($v['ehgardestatus']==2):?>
                <a href="?r=student/myexam/loadhead&c1=<?=$v['ehid']?>&_k=<?=$rOpenK?>">查看答卷</a><span>|</span><a href="?r=student/myexam/errorhead&c1=<?=$v['ehid']?>&_k=<?=$rOpenK?>">错题本</a>
                    <?else:?>
                    阅卷中
                <?endif;?>
                <?else:?>
                <a href="?r=student/student/edithead&c1=<?=$v['ehid']?>&_k=<?=$rEditK?>">继续答题</a>
                <?endif;?>
            </td>
            <td>
                <?if($v['ehstatus']==1):?>
                <?=$v['ehgrade']==1?'自评分': $v['chcheckusername'] ?>
                <?else:?>
                /
                <?endif;?>
            </td>
        </tr>
        <?endforeach;?>
        </tbody>
    </table>
</div>
<!--备注 -->
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>
<script>
</script>