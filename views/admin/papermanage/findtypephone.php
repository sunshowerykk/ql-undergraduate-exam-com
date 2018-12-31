<?php
use app\models\langs;
use app\models\pub;
?>

<?foreach ($d_data as $v):?>
    <?
    $rOpenK=pub::enFormMD5('open',$v['typeid']);
    $rEditK=Pub::enFormMD5('edit',$v['typeid']);
    $rDelK=pub::enFormMD5('del',$v['typeid']);
    $rAddK=pub::enFormMD5('add',$v['typeid']);
    ?>
<li>
    <div class="testCenTop">
        <hgroup>
            <h6><?=$v['typeid']?></h6>
            <p><?=$v['examname']?></p>
        </hgroup>
    </div>
    <section class="testCenOne">
        <div class="testCenOneA">
            <hgroup>
                <i></i>
                <p><?=$v['typenum']?></p>
            </hgroup>
            <hgroup>
                <i></i>
                <p><?=$v['typename']?></p>
            </hgroup>
            <hgroup>
                <i></i>
                <p><?=$v['typeinfo']?></p>
            </hgroup>
            <hgroup>
                <i></i>
                <p><?if($v['type']==1){
                        echo "单选题";
                    }elseif ($v['type']==2){
                        echo "多选题";
                    }
                    elseif ($v['type']==3){
                        echo "填空题";
                    }
                    elseif ($v['type']==4){
                        echo "文字题";
                    }
                    ?></p>
            </hgroup>
        </div>
        <hgroup>
    </section>
    <section class="testBtn">
        <ul>
            <li><a href="?r=admin/papermanage/edittype&c1=<?=$v['typeid']?>&_k=<?=$rEditK?>">编辑</a></li>
            <li class="testDel">
                <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                   data-url="?r=admin/papermanage/deltype&c1=<?=$v['typeid']?>&_k=<?=$rDelK?>"
                   data-confirm='确认要删除该题型ID为【<?=$v['typeid']?>】吗？'
                   data-id="artHead"
                   onclick="artDeltype(this);return false;">删除
                </a></li>
        </ul>
    </section>
</li>
<?endforeach;?>
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>