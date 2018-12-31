<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
    <table cellpadding="0"  cellspacing="0" align="center" rules="none" width="100%" class="homeTableHead teVisible">
        <tbody>
        <tr class="homeTrHead">
            <th>题目ID</th>
            <th>题目类型</th>
            <th>题干</th>
            <th>选项</th>
            <th>选项数量</th>
            <th>答案</th>
            <th>解析</th>
            <th>分值</th>
            <th>操作</th>
        </tr>
        <?foreach ($d_data as $v):?>
            <tr class="homeTrTwo">
                <?
                $rOpenK=pub::enFormMD5('open',$v['questionid']);
                $rEditK=Pub::enFormMD5('edit',$v['questionid']);
                $rDelK=pub::enFormMD5('del',$v['questionid']);
                $rAddK=pub::enFormMD5('add',$v['questionid']);
                ?>
                <td><?=$v['questionid']?></td>
                <td><?=$v['typename']?> </td>
                <td><div class="teHide"><?= preg_replace( "/<([^p].*?)>/",'',$v['question'])?></div></td>
                <td><div class="teHide"><?= preg_replace( "/<([^p].*?)>/",'',$v['questionselect'])?></div></td>
                <td><div class="teHide"><?=$v['questionselectnumber']?></div></td>
                <td><div class="teHide"><?= preg_replace( "/<([^p].*?)>/",'',$v['questionanswer'])?></div></td>
                <td><div class="teHide"><?= preg_replace( "/<([^p].*?)>/",'',$v['questiondescribe'])?></div></td>
                <td><?=$v['questionscore']?></td>
                <td class="adminTwoDiv">
                    <?if($v['questioncap']==1):?>
                        <div class="adCaoA">
                            <a href="?r=admin/papermanage/editdetail&c1=<?=$v['questionid']?>&_k=<?=$rEditK?>&cap=1">
                                <img src="assets/images/admin_a.png" />
                                <p>编辑</p>
                            </a>
                        </div>
                        <div class="adCaoA">
                            <a href="?r=admin/papermanage/indexcap&c1=<?=$v['questionid']?>&_k=<?=$rEditK?>&cap=1">
                                <img src="assets/images/admin_a.png" />
                                <p>题冒题管理</p>
                            </a>
                        </div>
                    <?else:?>
                        <div class="adCaoA">
                            <a href="?r=admin/papermanage/editdetail&c1=<?=$v['questionid']?>&_k=<?=$rEditK?>&cap=''">
                                <img src="assets/images/admin_a.png" />
                                <p>编辑</p>
                            </a>
                        </div>
                    <?endif;?>
                    <div class="adCaoA adCaoB">
                        <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                           data-url="?r=admin/papermanage/deldetail&c1=<?=$v['questionid']?>&_k=<?=$rDelK?>&type=<?=$v['questiontype']?>"
                           data-confirm='确认要删除该题目ID为【<?=$v['questionid']?>】吗？'
                           data-id="artHead"
                           onclick="artDeldetal(this);return false;">
                            <img src="assets/images/admin_b.png" />
                            <p>删除</p>
                        </a>
                    </div>
                </td>
            </tr>
        <?endforeach;?>
        </tbody>
    </table>

<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>