<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;

echo Html::cssFile('assets/css/public.css?r='.time());
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/addKityFormulaDialog.js');   //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/defaultFilterFix.js');  //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/getKfContent.js'); //公式编辑器


?>
<style>
    .ptInput{
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        background-color: transparent;
        border: none;
        font-size: 0.116666666667rem;
        text-indent: 1em;
        color: #999999;
    }

</style>

<div class="contentRight">
    <div class="homeTit">试卷管理/录入试题
        <div class="ptDiv">
            <a href="?r=admin/papermanage"><p>试卷管理</p></a>
            <a href="?r=admin/papermanage/indextype&c1=<?=$examid?>&_k=<?=Pub::enFormMD5('edit',$examid)?>"> <p>题型管理</p></a>
        </div>
    </div>
    <div class="homeCen">
        <!-- 顶部搜索 -->
        <div class="contentTwo adminXia">

            <!-- 选项卡开始 -->
            <div class="anTab">
                <div class="anTabHead">
                    <h6>题型</h6>
                    <ul>
                        <?foreach ($t_data as $key=>$val):?>
                            <?if($key==0):?>
                                 <li class="anActive"><?=$val['typenum']?>、<?=$val['typename']?></li>
                            <?else:?>
                                <li ><?=$val['typenum']?>、<?=$val['typename']?></li>
                             <?endif;?>
                        <?endforeach;?>
                    </ul>
                </div>
                <div class="anNum">
                    <!--选项卡-->
                    <dl>
                        <?foreach ($t_data as $v):?>
                        <dd class="anNumA">
                            <a href="?r=admin/papermanage/createquestion&examid=<?=$v['examid']?>&typeid=<?=$v['typeid']?>">
                            <div class="adAddBtn adA">
                                    <img src="assets/images/add.png" /><p>添加</p>
                                </div>
                            </a>
                            <a href="?r=admin/papermanage/createquestion&examid=<?=$v['examid']?>&typeid=<?=$v['typeid']?>&cap=1">
                                <div class="adAddBtn adA">
                                    <img src="assets/images/add.png" /><p>添加题冒题</p>
                                </div>
                            </a>
                            <div class="question<?=$v['typeid']?> homeTable teVisible">
                                <?=Yii::$app->runAction('admin/papermanage/finddetail',array('examid'=>$v['examid'],'typeid'=>$v['typeid']))?>
                            </div>
                        </dd>
                        <?endforeach;?>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        //选项卡
        $('.anTabHead ul li').click(function () {
            $(this).addClass('anActive').siblings().removeClass('anActive');
            var my = $(this).index();
            $('.anNum dl dd').eq(my).show().siblings().hide();
        })
    });
    <?foreach ($t_data as $v):?>
    function finddetail<?=$v['typeid']?>(page){
        var url = '?r=admin/papermanage/finddetail&p='+page+'&typeid=<?=$v['typeid']?>'+'&examid=<?=$examid?>';
        $.ajax({
            url:url,
            type: 'post',
            data: '',
            success: function (data) {
                $('.question<?=$v['typeid']?>').html(data);
            }
        });
    }
    <?endforeach;?>
    function artDeldetal(that){
        var m = $(that);
        var d = dialog({
            title:'确认提示',
            content: m.data('confirm'),
            button: [
                {
                    value: '取消',
                    callback: function () {},
                    autofocus: true
                },
                {
                    value: '确认',
                    callback: function () {
                        var url = m.data('url');
                        $.ajax({
                            dataType:'json',
                            url:url,
                            type: 'post',
                            data: {"_csrf":'<?= Yii::$app->request->csrfToken ?>'},
                            success: function (data) {
                                if(typeof data.code!='undefined' && '[0000]'==data.code){
                                    var type=data.type;
                                    <?foreach ($t_data as $v):?>
                                    if(type==<?=$v['typeid']?>){
                                        finddetail<?=$v['typeid']?>(1);
                                    }
                                    <?endforeach;?>
                                    // if(type==1){
                                    //     finddetail1(1);
                                    // }else if(type==2){
                                    //     finddetail2(1);
                                    // }else if(type==3){
                                    //     finddetail3(1);
                                    // }else{
                                    //     finddetail4(1);
                                    // }

                                }else{
                                    showMessage(data,3,'<?=langs::getTxt('infotitle')?>');
                                }
                            }
                        });
                    }
                }
            ]
        });
        d.showModal();
    }

</script>