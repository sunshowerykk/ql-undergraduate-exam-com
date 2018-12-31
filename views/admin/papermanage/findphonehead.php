<?php
use app\models\langs;
use app\models\pub;
?>

<?foreach ($d_data as $v):?>
    <?
    $rOpenK=pub::enFormMD5('open',$v['examid']);
    $rEditK=Pub::enFormMD5('edit',$v['examid']);
    $rDelK=pub::enFormMD5('del',$v['examid']);
    $rAddK=pub::enFormMD5('add',$v['examid']);
    ?>
<li>
    <div class="testCenTop">
        <hgroup>
            <h6><?=$v['examid']?></h6>
            <p><?=$v['examscore']?>分  |  <?=$v['questioncount']?>题  |  <?=$v['examtime']?>分钟</p>
        </hgroup>
    </div>
    <section class="testCenOne">
        <div class="testCenOneA">
            <hgroup>
                <i></i>
                <p><?=$v['examsubname']?></p>
            </hgroup>
            <hgroup>
                <i></i>
                <p><?=$v['examcoursename']?></p>
            </hgroup>
            <hgroup>
                <i></i>
                <p><?=$v['examcoursesectionname']?></p>
            </hgroup>
            <hgroup>
                <i></i>
                <p><?=$v['examname']?></p>
            </hgroup>
        </div>
        <hgroup>
    </section>
    <section class="testBtn">
        <ul>
            <li><a href="?r=admin/papermanage/loadhead&c1=<?=$v['examid']?>&_k=<?=$rOpenK?>">预览</a></li>
            <li><a href="?r=admin/papermanage/edithead&c1=<?=$v['examid']?>&p=<?=$page->getNpage()?>&_k=<?=$rEditK?>">编辑</a></li>
            <li><a href="?r=admin/papermanage/indextype&c1=<?=$v['examid']?>&_k=<?=$rEditK?>">题型管理</a></li>
            <li><a href="?r=admin/papermanage/indexdetail&c1=<?=$v['examid']?>&p=<?=$page->getNpage()?>&_k=<?=$rEditK?>">试题管理</a></li>
            <li class="testDel">删除</li>
        </ul>
    </section>
</li>

<?endforeach;?>
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>