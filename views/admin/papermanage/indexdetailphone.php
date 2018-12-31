<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;

echo Html::cssFile('assets/css/public.css?r='.time());
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::cssFile('assets/css/examphone/css/swiper.min.css');
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/js/examphone/js/swiper.min.js'); //编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/addKityFormulaDialog.js');   //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/defaultFilterFix.js');  //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/getKfContent.js'); //公式编辑器

?>

<style >
    .testTwoHead > ul{
        overflow: visible;
        width: 90%;
    }
    .testTwoHead ul li{
        width: 120px !important;
    }
</style>

<section class="testTwoHead">
    <ul class="swiper-wrapper">
        <?foreach ($t_data as $key=>$val):?>
            <?if($key==0):?>
                <li class="swiper-slide testTwoActive"><?=$val['typenum']?>、<?=$val['typename']?></li>
            <?else:?>
                <li class="swiper-slide"><?=$val['typenum']?>、<?=$val['typename']?></li>
            <?endif;?>
        <?endforeach;?>
    </ul>
</section>


<section class="testYu">
    <!--单选题-->
    <?foreach ($t_data as $v):?>
    <form action="">
        <ul class="question<?=$v['typeid']?>">
            <?=Yii::$app->runAction('admin/papermanage/finddetail',array('examid'=>$v['examid'],'typeid'=>$v['typeid']))?>
            <!--<button type="submit" class="adminHeadBtn">提交</button>-->
        </ul>
        <div class="ptFormAdd">
            <button type="button" class="adminHeadBtn"><a href="?r=admin/papermanage/createquestion&examid=<?=$v['examid']?>&typeid=<?=$v['typeid']?>">添加</a></button>
            <button type="button" class="adminHeadBtn"><a href="?r=admin/papermanage/createquestion&examid=<?=$v['examid']?>&typeid=<?=$v['typeid']?>&cap=1">添加题冒题</a></button>
        </div>
    </form>
    <?endforeach;?>
</section>
<script>
    $(function(){

        var swiper = new Swiper('.testTwoHead');

        //tab
        $('.testTwoHead ul li').click(function(){
            $(this).addClass('testTwoActive').siblings().removeClass('testTwoActive');
            var my = $(this).index();
            $('.testYu form').eq(my).show().siblings().hide();
        })

    })
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