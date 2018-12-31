<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<!-- 表格 -->
<div class="homeTable teVisible">
    <table cellpadding="0"  cellspacing="0" align="center" rules="none" width="100%" class="homeTableHead teVisible">
        <tbody>
        <tr class="teTableTop">
            <th>考生姓名</th>
            <th>科目</th>
            <th>课程</th>
            <th>节次</th>
            <th>试卷名称</th>
            <th>交卷时间</th>
            <th>操作</th>
            <th>批改用时</th>
            <th>批改提交时间</th>
        </tr>
        <?foreach ($d_data as $v):?>

            <?
            $rOpenK=pub::enFormMD5('open',$v['ehid']);
            $rEditK=Pub::enFormMD5('edit',$v['ehid']);
            $rDelK=pub::enFormMD5('del',$v['ehid']);
            $rAddK=pub::enFormMD5('add',$v['ehid']);
            ?>
        <tr class="teTableTwo teVisible">
            <td><?=$v['username']?></td>
            <td><?=$v['examsubname']?></td>
            <td><div class="teHide"><?=$v['examcoursename']?></div></td>
            <td><div class="teHide"><?=$v['examcoursesectionname']?></div></td>
            <td><div class="teHide"><?=$v['examname']?></div></td>
            <td><?=date('Y-m-d H:i:s',$v['ehendtime'])?></td>
            <td class="homeTrOper">操作<i></i>
                <div class="teCaozuo">
                    <p   class="teActive"><a href="?r=checkmanage/dealexam/createhead&c1=<?=$v['ehid']?>&_k=<?=$rAddK?>">批改答卷</a></p>
                    <p   class="adFoDe"><a>查看批改</a></p>
                    <p   class="adFoDe"><a>放弃批改</a></p>
                </div>
            </td>
            <td></td>
            <td></td>
        </tr>
        <?endforeach;?>
        </tbody>
    </table>
</div>
<!--备注 -->
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>