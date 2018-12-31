<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = '資訊管理系統';
echo Html::cssFile('assets/artDialog/ui-dialog.css');

echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //彈出框
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定義
echo Html::jsFile('assets/js/bui.js');
echo Html::jsFile('assets/js/config.js');
?>
<style>
    .btn-sm,
    .btn-group-sm > .btn {
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
        border: 1px;
    }
    .btn-success {
        color: #fff;
        background-color: #5cb85c;
        border-color: #4cae4c;
    }
    .btn-success:hover {
        color: #fff;
        background-color: #449d44;
        border-color: #398439;
    }
    .btn-success:active,
    .btn-success.active,
    .open > .dropdown-toggle.btn-success {
        color: #fff;
        background-color: #449d44;
        border-color: #398439;
    }

</style>

<div class="header">
    <div class="dl-title"><span class="">大統營科技惠州有限公司</span></div>
    <div class="dl-log">欢迎您，<span class="dl-log-user"><?=Yii::$app->user->identity->UserFull?></span>
        <a href="#" class="dl-log-quit"
                data-url="?r=system/pwd/edithead"
                data-title="修改密碼"
                data-id="artHead"
                onclick="showWin(this);" >[修改密碼]</a>
        <a href="#" title="退出系统" class="dl-log-quit" onclick="reloadpage();">[退出]</a>
    </div>
</div>
<div class="content">
    <ul class="dl-tab-conten" id="J_NavContent">
        <li class="dl-tab-item">
            <div class="dl-second-nav">
                <div id="J_webTree" class="dl-second-tree">
                </div>
            </div>
            <div id="J_webTab" class="dl-inner-tab">

            </div>
        </li>
    </ul>
</div>


<script type="text/javascript">

    BUI.use('common/main',function(){
        var confNewMenu = <?=$confNewMenu?>;

        var Menu = BUI.Menu;
        var sideMenu = new Menu.SideMenu({
            render:'#J_webTree',

            items :confNewMenu
        });
        sideMenu.render();
        sideMenu.on('menuclick', function(e){

            var config = {
                title : e.item.get('text'),
                reload : true,
                id :e.item.get('id'),
                href : e.item.get('href')
            };
            tab.addTab(config);
        });
        var Tab = BUI.Tab
        var tab = new Tab.NavTab({
            render:'#J_webTab',

        });
        tab.render();
    });

</script>