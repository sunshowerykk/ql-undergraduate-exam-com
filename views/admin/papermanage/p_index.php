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
//echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
//echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
//echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器

?>
<section class="testTop ">
    <h6>试卷管理</h6>
    <section class="testHead">
        <figure>
            <figcaption class="testHa">科目</figcaption>
            <img src="assets/images/phone/images/icon_down.png" />
        </figure>
        <figure>
            <figcaption class="testHb">课程</figcaption>
            <img src="assets/images/phone/images/icon_down.png" />
        </figure>
    </section>
</section>
    <section class="testCen">
        <ul id="findhead">
            <?=Yii::$app->runAction('admin/papermanage/findhead')?>
        </ul>
    </section>
<section class="testBottom"><a href="?r=admin/papermanage/createhead">录入新试卷</a></section>
<!-- 科目弹窗-->
<form class="" id="formHead">
    <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
<section class="testPop">
    <ul>
        <li class="testPopa">
            <section class="testDiv first-div">
                <?php
                foreach($data as $v1){
                    echo '<p data-id="'.$v1['id'].'">'.$v1['name'].'</p>';
                }
                ?>
            </section>
            <input type="hidden" name="vSubId"  />
        </li>
        <li class="testPopb">
            <section class="testDiv second-div">
            </section>
            <input type="hidden" name="vCourseId"  />
        </li>
    </ul>
</section>
</form>
<script type="text/javascript">
    var arr = [];
    <?php
    $index=0;
    foreach($data as $v1){
        echo "arr[$index]={'index':1,'id':".$v1['id'].",'pid':0,'name':'".$v1['name']."'};";
        $index++;
        foreach($v1['courses'] as $v2){
            echo "arr[$index]={'index':2,'id':".$v2['id'].",'pid':".$v2['category_name'].",'name':'".$v2['course_name']."'};";
            $index++;
            foreach($v2['courseSections'] as $v3){
                echo "arr[$index]={'index':3,'id':".$v3['id'].",'pid':".$v3['course_id'].",'name':'".$v3['name']."'};";
                $index++;
            }
        }
    }
    ?>
    $(document).on('click','.first-div p',function(){
        var id=$(this).data('id');
        $('.second-div').empty();
        // alert(arr.length);
        for(var i=0;i<arr.length;i++){
            // console.log(arr[i]['index']+'--'+arr[i]['pid']);
            if (arr[i]['index'] == 2 && arr[i]['pid']==id){
                $('.second-div').append("<p data-id=\""+arr[i]['id']+"\">"+arr[i]['name']+"</p>");
            }
        }
    })
    function findHead(page){
        var url = '?r=admin/papermanage/findhead&p='+page;
        var data = $('#formHead').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: data,
            success: function (data) {
                $('#findhead').html(data);
            }
        });
    }
    $(document).on('click','.testHead figure',function(e){
        //科目是否添加颜色，图片是否变
        var oneImg = $(this).find('img');
        var my = $(this).index();
        $(this).find('figcaption').addClass('testActive');
        $(this).siblings().find('figcaption').removeClass('testActive');
        if( oneImg.attr('src') == 'assets/images/phone/images/icon_down.png' ){
            oneImg.attr('src','assets/images/phone/images/icon_downa.png');
            $(this).siblings().find('img').attr('src','assets/images/phone/images/icon_down.png');
            $('.yeUp').addClass('testFixed');
            $('.testPop').show();
        }else{
            oneImg.attr('src','assets/images/phone/images/icon_down.png');
            $('.testHead figure figcaption').removeClass('testActive');
            $('.yeUp').removeClass('testFixed');
            $('.testPop').hide();
        }
        $('.testPop ul li').eq(my).show().siblings().hide();
    })

    //.选择后添加移出
    $(document).on('click','.testDiv p',function(){
        $(this).addClass('testDivActive').siblings().removeClass('testDivActive');
        $('.yeUp').removeClass('testFixed');
        $('.testHead figure figcaption').removeClass('testActive');
        $('.testPop').hide();
        $('.testHead figure img').attr('src','assets/images/phone/images/icon_down.png');
    })

    //科目换值
    $(document).on('click','.testPopa .testDiv p',function(){
        $('input[name="vSubId"]').val($(this).data('id'));
        var testDiv = $(this).html();
        $('.testHa').html(testDiv);
        findHead(1);
    })
    //课程换值
    $(document).on('click','.testPopb .testDiv p',function(){
        $('input[name="vCourseId"]').val($(this).data('id'));
        var testDiv = $(this).html();
        $('.testHb').html(testDiv);
        findHead(1);
    })

</script>