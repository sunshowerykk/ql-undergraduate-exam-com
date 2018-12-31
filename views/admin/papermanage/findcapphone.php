<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<?foreach ($d_data as $v):?>
    <?
    $rOpenK=pub::enFormMD5('open',$v['questionid']);
    $rEditK=Pub::enFormMD5('edit',$v['questionid']);
    $rDelK=pub::enFormMD5('del',$v['questionid']);
    $rAddK=pub::enFormMD5('add',$v['questionid']);
    ?>
    <li>
        <header class="testYuHead">
            <hgroup>
                <h6><?= preg_replace( "/<([^p].*?)>/",'',$v['question'])?></h6>
                <p><?=$v['questionscore']?>分<i></i></p>
            </hgroup>
        </header>
        <article class="testYuCen">
            <dl>
                <dd>
                    <hgroup>
                        <h6>备选项：</h6>
                        <p><?= preg_replace( "/<([^p].*?)>/",'',$v['questionselect'])?></p>
                    </hgroup>
                </dd>
                <dd>
                    <hgroup>
                        <h6>备选数量：</h6>
                        <p><?=$v['questionselectnumber']?></p>
                    </hgroup>
                </dd>
                <dd>
                    <hgroup>
                        <h6>参考答案：</h6>
                        <p><?= preg_replace( "/<([^p].*?)>/",'',$v['questionanswer'])?></p>
                    </hgroup>
                </dd>
                <dd>
                    <hgroup>
                        <h6>习题讲解：</h6>
                        <p><?= preg_replace( "/<([^p].*?)>/",'',$v['questiondescribe'])?></p>
                    </hgroup>
                </dd>
                <dd>
                    <hgroup>
                        <h6>讲解视频：</h6>
                        <p><?=$v['questionvideo']?></p>
                    </hgroup>
                </dd>
            </dl>
        </article>
        <section class="testYuDel pttestYuDel">
            <a href="?r=admin/papermanage/editcap&c1=<?=$v['questionid']?>&_k=<?=$rEditK?>">编辑</a>
            <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
               data-url="?r=admin/papermanage/delcap&c1=<?=$v['questionid']?>&_k=<?=$rDelK?>"
               data-confirm='确认要删除该题目ID为【<?=$v['questionid']?>】吗？'
               data-id="artHead"
               onclick="artDelcap(this);return false;">删除
            </a>
        </section>
    </li>
<?endforeach;?>
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>