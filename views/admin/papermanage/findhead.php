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
            <th>试卷编号</th>
            <th>科目</th>
            <th>课程</th>
            <th>节次</th>
            <th>试卷名称</th>
            <th>总分</th>
            <th>题量</th>
            <th>答题时间</th>
            <th>操作</th>
        </tr>
        <?foreach ($d_data as $v):?>
        <tr class="teTableTwo teVisible">
            <?
            $rOpenK=pub::enFormMD5('open',$v['examid']);
            $rEditK=Pub::enFormMD5('edit',$v['examid']);
            $rExam=Pub::enFormMD52('exam',$v['examid']);
            $rDelK=pub::enFormMD5('del',$v['examid']);
            $rAddK=pub::enFormMD5('add',$v['examid']);
            ?>
            <td><?=$v['examid']?></td>
            <td><?=$v['examsubname']?></td>
            <td><div class="teHide"><?=$v['examcoursename']?></div></td>
            <td><div class="teHide"><?=$v['examcoursesectionname']?></div></td>
            <td><div class="teHide"><?=$v['examname']?></div></td>
            <td><?=$v['examscore']?></td>
            <td><?=$v['questioncount']?></td>
            <td><?=$v['examtime']?></td>
            <td class="homeTrOper">操作
                <div class="teCaozuo" >
                    <p class="teActive"><a href="?r=admin/papermanage/loadhead&c1=<?=$v['examid']?>&_k=<?=$rOpenK?>">预览</a></p>
                    <p><a href="?r=admin/papermanage/edithead&c1=<?=$v['examid']?>&p=<?=$page->getNpage()?>&_k=<?=$rEditK?>">编辑</a></p>
                    <p><a href="?r=admin/papermanage/indextype&c1=<?=$v['examid']?>&_k=<?=$rEditK?>">题型管理</a></p>
                    <p><a href="?r=admin/papermanage/indexdetail&c1=<?=$v['examid']?>&p=<?=$page->getNpage()?>&_k=<?=$rEditK?>">试题管理</a></p>
                    <p><a href="?r=admin/papermanage/copyhead&c1=<?=$v['examid']?>&_k=<?=$rExam?>" >复制连接</a>
                    </p>
                    <p>
                        <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                           data-url="?r=admin/papermanage/delhead&c1=<?=$v['examid']?>&_k=<?=$rDelK?>&p=<?=$page->getNpage()?>"
                           data-confirm='确认要删除试卷名称【<?=$v['examname']?>】吗？删除后，试卷下的试题但不会删除！'
                           data-id="artHead"
                           onclick="artDel(this);return false;">删除 </a>
                    </p>
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
<script>
    $(function(){
        $('.homeTrOper').hover(function(){
            $(this).find(".teCaozuo").fadeToggle();
        })
        $('.teCaozuo p').hover(function(){
            $(this).addClass('teActive').siblings().removeClass('teActive');
        })
    })
</script>