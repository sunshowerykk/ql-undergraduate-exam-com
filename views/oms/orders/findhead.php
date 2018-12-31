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
        <th style="width: 120px;">订单编号</th>
        <th style="width:100px">酒店名称</th>
        <th style="width:100px">房间编号</th>
        <th style="width:100px">入住开始时间</th>
        <th style="width:100px">入住结束时间</th>
        <th style="width:80px">入住人数</th>
        <th style="width:220px">入住人信息</th>
        <th style="width:80px">总价</th>
        <th style="width:80px">支付</th>
        <th style="width:80px">订单状态</th>
        <?if(pub::get('frmOrdersEdit') || pub::get('frmOrdersDel') || pub::get('frmOrdersAdd')):?>
            <th style="width:130px">管理操作</th>
        <?endif?>
    </tr>
    </thead>
    <? foreach ($d_data as $v) :?>
        <?//ID MD5加密处理
            $rOpenK=pub::enFormMD5('open',$v['ordersid']);
            $rEditK=Pub::enFormMD5('edit',$v['ordersid']);
            $rDelK=pub::enFormMD5('del',$v['ordersid']);
            $rAddK=pub::enFormMD5('add',$v['ordersid']);
        ?>
        <tr class="tr-list">
            <td><?=$v['ordersid']?></td>
            <td><?=$v['hotelname']?></td>
            <td><?=$v['housenumber']?></td>
            <td><?=pub::chkData($v,'intime',date('Y-m-d',time()),10)?></td>
            <td><?=pub::chkData($v,'endtime',date('Y-m-d',time()),10)?></td>
            <td><?=$v['innumber']?></td>
            <td>姓名：<?=$v['truename']?>&nbsp;&nbsp;电话：<?=$v['phone']?></td>
            <td style="color: red"><?=$v['totalprices']?></td>
            <td><?=$v['paystatus']==1?'未支付':($v['paystatus']==2?'已支付':($v['paystatus']==3?'已完成':($v['paystatus']==4?'申请退款':"已删除"))) ?></td>
            <td><?=$v['omsstatus']==0?'已入住': ($v['omsstatus']==1?'入住中':'<span style="color: red">已退房</span>')?></td>
            <?if(pub::get('frmOrdersEdit') || pub::get('frmOrdersDel') || pub::get('frmOrdersAdd')):?>
                <td>
<!--                    --><?//if (pub::get('frmOrdersEdit'))://修改权限判断?>
<!--                        <a href="javascript:void(0)" class="btn btn-info btn-xs"-->
<!--                           data-url="?r=system/items/edithead&c1=--><?//=$v['ordersid']?><!--&p=--><?//=$page->getNpage()?><!--&_k=--><?//=$rEditK?><!--"-->
<!--                           data-title="修改【--><?//=$v['ItemsName']?><!--】的项目信息"-->
<!--                           data-id="artHead"-->
<!--                           onclick="showWin(this);return false;" >修改</a>-->
<!--                    --><?//endif?>
<!--                    --><?//if (pub::get('frmOrdersDel'))://删除权限判断?>
<!--                        <a href="javascript:void(0)" style="text-decoration:none" class="btn btn-info btn-xs"-->
<!--                        data-url="?r=system/items/delhead&c1=--><?//=$v['ordersid']?><!--&_k=--><?//=$rDelK?><!--&p=--><?//=$page->getNpage()?><!--"-->
<!--                        data-confirm='确认要删除【--><?//=$v['ItemsName']?><!--】吗？'-->
<!--                        data-id="artHead"-->
<!--                        onclick="artDel(this);return false;">删除</a>-->
<!--                    --><?//endif?>
                </td>
            <?endif?>
        </tr>
    <?endforeach?>
</table>


