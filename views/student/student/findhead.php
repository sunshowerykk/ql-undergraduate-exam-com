<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<!-- 表格 -->
<div class="homeTable">
    <table cellpadding="0"  cellspacing="0" align="center" rules="none" width="100%" class="homeTableHead">
        <tbody>
        <tr class="homeTrHead">
            <th>考试编号</th>
            <th>科目</th>
            <th>课程</th>
            <th>节次</th>
            <th>试卷名称</th>
            <th>操作</th>
        </tr>
        <?foreach ($d_data as $v):?>
        <tr class="homeTrTwo">
            <?
            $rOpenK=pub::enFormMD5('open',$v['examid']);
            $rEditK=Pub::enFormMD52('exam',$v['examid']);
            $rDelK=pub::enFormMD5('del',$v['examid']);
            $rAddK=pub::enFormMD5('add',$v['examid']);
            ?>
            <td><?=$v['examid']?></td>
            <td><?=$v['examsubname']?></td>
            <td><div class="teHide"><?=$v['examcoursename']?></div></td>
            <td><div class="teHide"><?=$v['examcoursesectionname']?></div></td>
            <td><div class="teHide"><?=$v['examname']?></div></td>
            <td class="homeTrOper"><a href="?r=student/student/createhead&examid=<?=$v['examid']?>&_k=<?=$rEditK?>">立即答题</a></td>
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