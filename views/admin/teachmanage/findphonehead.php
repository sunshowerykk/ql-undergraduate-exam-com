<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
        <?foreach ($d_data as $v):?>
            <?
            $rOpenK=pub::enFormMD5('open',$v['id']);
            $rEditK=Pub::enFormMD5('edit',$v['id']);
            $rDelK=pub::enFormMD5('del',$v['id']);
            $rAddK=pub::enFormMD5('add',$v['id']);
            ?>
            <li>
                <div class="testCenTop">
                    <hgroup>
                        <h6><?=$v['UserName']?> <?=$v['Phone']?></h6>
                        <p><?=$v['InTime']?></p>
                    </hgroup>
                </div>
                <section class="testCenOne">
                    <div class="testCenOneA">
                        <hgroup>
                            <p><?=$v['SubName']?></p>
                        </hgroup>
                        <hgroup>
                            <p><?=$v['CourseName']?></p>
                        </hgroup>
                        <hgroup>
                            <p><?=$v['SectionName']?></p>
                        </hgroup>
                    </div>
                    <hgroup>
                </section>
                <section class="testBtn">
                    <ul>
                        <li><a href="?r=admin/teachmanage/edithead&c1=<?=$v['id']?>&_k=<?=$rEditK?>">编辑</a></li>
                        <li class="testDel">
                            <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                               data-url="?r=admin/teachmanage/delhead&c1=<?=$v['id']?>&_k=<?=$rDelK?>&p=<?=$page->getNpage()?>"
                               data-confirm='确认要删除【<?=$v['UserName']?>】吗？'
                               data-id="artHead"
                               onclick="artDel(this);return false;">删除
                            </a>
                        </li>
                    </ul>
                </section>
            </li>
        <?endforeach;?>
<!--备注 -->
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>
