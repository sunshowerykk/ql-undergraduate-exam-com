<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
?>
<table cellpadding="0"  cellspacing="0" align="center" rules="none" width="100%" class="homeTableHead teVisible">
    <tbody>
    <tr class="homeTrHead">
        <th>题型ID</th>
        <th>试卷名称</th>
        <th>题号</th>
        <th>名称</th>
        <th>题型说明</th>
        <th>所属类型</th>
        <th>操作</th>
    </tr>
    <?foreach ($d_data as $v):?>
        <tr class="homeTrTwo">
            <?
            $rOpenK=pub::enFormMD5('open',$v['typeid']);
            $rEditK=Pub::enFormMD5('edit',$v['typeid']);
            $rDelK=pub::enFormMD5('del',$v['typeid']);
            $rAddK=pub::enFormMD5('add',$v['typeid']);
            ?>
            <td><?=$v['typeid']?></td>

            <td><?=$v['examname']?></div></td>
            <td><?=$v['typenum']?></div></td>
            <td><?=$v['typename']?></div></td>
            <td><div class="teHide"><?=$v['typeinfo']?></div></td>
            <td><?if($v['type']==1){
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
                ?>
            </td>
            <td class="adminTwoDiv">
                <div class="adCaoA">
                    <a href="?r=admin/papermanage/edittype&c1=<?=$v['typeid']?>&_k=<?=$rEditK?>">
                        <img src="assets/images/admin_a.png" />
                        <p>编辑</p>
                    </a>
                </div>
                <div class="adCaoA adCaoB">
                    <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                       data-url="?r=admin/papermanage/deltype&c1=<?=$v['typeid']?>&_k=<?=$rDelK?>"
                       data-confirm='确认要删除该题型ID为【<?=$v['typeid']?>】吗？'
                       data-id="artHead"
                       onclick="artDeltype(this);return false;">
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