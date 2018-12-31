<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<!-- 表格 -->
<div class="homeTable">
    <table cellpadding="0"  cellspacing="0" align="center" rules="none" width="100%" class="homeTableHead teVisible">
        <tbody>
        <tr class="homeTrHead">
            <th>阅卷人姓名</th>
            <th>科目</th>
            <th>课程</th>
            <th>节次</th>
            <th>手机号</th>
            <th>日期</th>
            <th>操作</th>
        </tr>

        <?foreach ($d_data as $v):?>
            <?
            $rOpenK=pub::enFormMD5('open',$v['id']);
            $rEditK=Pub::enFormMD5('edit',$v['id']);
            $rDelK=pub::enFormMD5('del',$v['id']);
            $rAddK=pub::enFormMD5('add',$v['id']);
            ?>
        <tr class="homeTrTwo">
            <td><?=$v['UserName']?></td>
            <td><?=$v['SubName']?></td>
            <td><?=$v['CourseName']?></td>
            <td><?=$v['SectionName']?></td>
            <td><?=$v['Phone']?></td>
            <td><?=$v['InTime']?></td>
            <td class="adminTwoDiv">
                <div class="adCaoA">
                    <a href="?r=admin/teachmanage/edithead&c1=<?=$v['id']?>&_k=<?=$rEditK?>">
                        <img src="assets/images/admin_a.png" />
                        <p>编辑</p>
                    </a>
                </div>
                <div class="adCaoA adCaoB">
                    <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                       data-url="?r=admin/teachmanage/delhead&c1=<?=$v['id']?>&_k=<?=$rDelK?>&p=<?=$page->getNpage()?>"
                       data-confirm='确认要删除【<?=$v['UserName']?>】吗？'
                       data-id="artHead"
                       onclick="artDel(this);return false;">
                        <img src="assets/images/admin_b.png" />
                        <p>删除</p>
                    </a>
                </div>
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
