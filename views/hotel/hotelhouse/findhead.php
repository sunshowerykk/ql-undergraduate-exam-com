<?php
use yii;
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
        <th style="width:100px">房间编号</th>
        <th style="width:120px">酒店名称</th>
        <th style="width:80px">房型</th>
        <th style="width:150px">价格</th>
        <th style="width:200px;">房间图</th>
        <th style="width:150px">房间标签</th>
        <th style="width:80px">使用状态</th>
        <th style="width:160px">已预订日期</th>
        <th style="width:100px">备注</th>
        <th style="width:100px">输入日期</th>
        <?if(pub::get('frmHotelHouseEdit') || pub::get('frmHotelHouseDel') || pub::get('frmHotelHouseAdd')):?>
            <th style="width:130px">管理操作</th>
        <?endif?>
    </tr>
    </thead>
    <? foreach ($d_data as $v) :?>
        <?
            $rOpenK=pub::enFormMD5('open',$v['houseid']);
            $rEditK=Pub::enFormMD5('edit',$v['houseid']);
            $rDelK=pub::enFormMD5('del',$v['houseid']);
            $rAddK=pub::enFormMD5('add',$v['houseid']);
        ?>
        <tr class="tr-list">
            <td><?=$v['houseid']?></td>
            <td>
                <?//ID加密处理
                if (pub::get('frmHotelHouseOpen'))://显示权限判断?>
                    <a href="javascript:void(0)"
                       data-url="?r=hotel/hotelinfo/loadhead&c1=<?=$v['houseid']?>&_k=<?=Pub::enFormMD5('edit',$v['houseid'])?>"
                       data-title="【<?=$v['housenumber']?>】的房间信息"
                       data-id="artHead"
                       onclick="showWin(this);return false;"><?=$v['housenumber']?></a>
                <?endif?>
            </td>
            <td><?=$v['hotelname']?></td>
            <td><?=$v['typename']?></td>
            <td style="color: red"><?=$v['price']?></td>
            <td>
                <?if($v['FilePath']!="") :?>
                <?foreach (explode(',',$v['FilePath']) as $val) :?>
                    <img src="<?=$val?>" style="width: 40px;height: 40px">
                <?endforeach;?>
                <?endif;?>
            </td>
            <td><?=$v['titlename']?></td>
            <td><?=$v['status']==0?'空闲': '<span style="color: #ff081e;">入住中</span>' ?></td>
            <td>
                <?=pub::chkData($v,'restime',date('Y-m-d',time()),10)?>
            </td>
            <td>
                <?if (mb_strlen($v['remark'],'UTF8')>20):?>
                    <span title="<?=$v['remark']?>" style="cursor:pointer"><?=$v['remark']= mb_substr($v['remark'] , 0 , 20,'UTF8').'...'?></span>
                <?else:?>
                    <?=$v['remark']?>
                <?endif?>
            </td>
            <td><?=pub::chkData($v,'indate',date('Y-m-d',time()),10)?></td>
            <?if(pub::get('frmHotelHouseEdit') || pub::get('frmHotelHouseDel') || pub::get('frmHotelHouseAdd')):?>
                <td>
                    <?if (pub::get('frmHotelHouseEdit'))://修改权限判断?>
                        <a href="javascript:void(0)" class="btn btn-info btn-xs"
                           data-url="?r=hotel/hotelhouse/edithead&c1=<?=$v['houseid']?>&p=<?=$page->getNpage()?>&_k=<?=$rEditK?>"
                           data-title="修改【<?=$v['housenumber']?>】的房间信息"
                           data-id="artHead"
                           onclick="showWin(this);return false;" >修改</a>
                    <?endif?>
                    <?if (pub::get('frmHotelHouseDel'))://删除权限判断?>
                        <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"
                        data-url="?r=hotel/hotelhouse/delhead&c1=<?=$v['houseid']?>&_k=<?=$rDelK?>&p=<?=$page->getNpage()?>"
                        data-confirm='确认要删除【<?=$v['housenumber']?>】吗？'
                        data-id="artHead"
                        onclick="artDel(this);return false;">删除</a>
                    <?endif?>
                </td>
            <?endif?>
        </tr>
    <?endforeach?>
</table>



