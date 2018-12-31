<?php

use yii\helpers\Html;
use app\models\pub;
use app\models\langs;
/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
?>
<div id="page">
    <?if($page->getTotal_pages()>1){echo $page->show(1);}?>
</div>
<table class="table table-bordered table-condensed" style="table-layout: fixed;word-break:break-all; word-wrap:break-word;">
    <thead>
    <tr style="border:1px solid #DDDDDD;">
        <th style="width: 40px;">#</th>
        <th style="width:150px">酒店名称</th>
        <th style="width:150px">酒店简介</th>
        <th style="width:150px">预订须知</th>
        <th style="width:150px">地址</th>
        <th style="width:160px;">经纬度</th>
        <th style="width:80px">显示排序</th>
        <th style="width:80px">默认推荐</th>
        <th style="width:80px">输入人员</th>
        <?if(pub::get('frmHotelInfoEdit') || pub::get('frmHotelInfoDel') || pub::get('frmHotelInfoAdd')):?>
            <th style="width:130px">管理操作</th>
        <?endif?>
    </tr>
    </thead>
    <? foreach ($d_data as $v) :?>
        <?
            $rOpenK=pub::enFormMD5('open',$v['hotelid']);
            $rEditK=Pub::enFormMD5('edit',$v['hotelid']);
            $rDelK=pub::enFormMD5('del',$v['hotelid']);
            $rAddK=pub::enFormMD5('add',$v['hotelid']);
        ?>
        <tr class="tr-list">
            <td><?=$v['hotelid']?></td>
            <td>
                <?//ID加密处理
                if (pub::get('frmHotelInfoOpen'))://显示权限判断?>
                    <a href="javascript:void(0)"
                       data-url="?r=hotel/hotelinfo/loadhead&c1=<?=$v['hotelid']?>&_k=<?=Pub::enFormMD5('edit',$v['hotelid'])?>"
                       data-title="【<?=$v['hotelname']?>】的信息"
                       data-id="artHead"
                       onclick="showWin(this);return false;"><?=$v['hotelname']?></a>
                <?endif?>
            </td>
            <td><?=$v['intro']?></td>
            <td><?=$v['notice']?></td>
            <td><?=$v['hoteladdress']?></td>
            <td><?=$v['lng']?>,<?=$v['lat']?></td>
            <td><?=$v['rank']?></td>
            <td>
                <?=$v['recommend']==1?'默认推荐': '<span style="color: #ff081e;">不推荐</span>' ?>
            </td>
            <td><?=$v['Inuser']?></td>
            <?if(pub::get('frmHotelInfoEdit') || pub::get('frmHotelInfoDel') || pub::get('frmHotelInfoAdd')):?>
                <td>
                    <?if (pub::get('frmHotelInfoEdit'))://修改权限判断?>
                        <a href="javascript:void(0)" class="btn btn-info btn-xs"
                           data-url="?r=hotel/hotelinfo/edithead&c1=<?=$v['hotelid']?>&p=<?=$page->getNpage()?>&_k=<?=$rEditK?>"
                           data-title="修改【<?=$v['hotelname']?>】的酒店信息"
                           data-id="artHead"
                           onclick="showWin(this);return false;" >修改</a>
                    <?endif?>
                    <?if (pub::get('frmHotelInfoDel'))://删除权限判断?>
                        <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                        data-url="?r=hotel/hotelinfo/delhead&c1=<?=$v['hotelid']?>&_k=<?=$rDelK?>&p=<?=$page->getNpage()?>"
                        data-confirm='确认要删除【<?=$v['hotelid']?>】吗？'
                        data-id="artHead"
                        onclick="artDel(this);return false;">删除</a>
                    <?endif?>
                </td>
            <?endif?>
        </tr>
    <?endforeach?>
</table>



