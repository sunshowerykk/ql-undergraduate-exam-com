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
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框s
echo Html::jsFile('assets/js/exam/mplugin.js');
//echo Html::jsFile('assets/js/exam/plugin.js');

?>
<!--  内容区域 -->
<div class="contentTwo" style="overflow:auto">
    <!--  顶部 -->
    <div class="teAnHead homeTwo ">
        <div class="anHeadCon">
            <div class="anHeadLeft">
                <h6><?=$exam_data['examname']?></h6>
                <p>科目：<?=$exam_data['examsubname']?><br />
                    课程：<?=$exam_data['examcoursename']?><br />
                    节次：<?=$exam_data['examcoursesectionname']?><br />
                    试卷总分：<?=$exam_data['examscore']?><br />
                    答题时间：<?=$exam_data['examtime']?></p>
            </div>
            <div class="teAnCen">
                <div class="anHeadRightA">
                    <img src="assets/images/ticon_time.png" />
                    <p>倒计时</p>
                    <div class="anTime"  id="timer" data-timer="20160628140203">
                        <span id="timer_h">00</span>:
                        <span id="timer_m">00</span>:
                        <span id="timer_s">00</span>
                    </div>
                </div>
            </div>
            <div class="anHeadRight">
                <div class="teAntxt"><a href="TeHome.html">返回待批改阅卷</a></div>
                <ul class="anHeadRightB">
                    <li class="anJc" onclick="Linshi();">临时保存</li>
                    <li class="teFq">放弃阅卷</li>
                    <li class="anBlast" onclick="endsave();">保存提交阅卷</li>
                </ul>

            </div>

        </div>
    </div>
    <!-- 选项卡开始 -->
    <div class="anTab">
        <div class="anTabHead">
            <ul>
                <li class="anActive">单选题</li>
                <li>多选题</li>
                <li>填空题</li>
                <li>文字题</li>
            </ul>
        </div>
        <!--选项卡-->
        <form action="?r=checkmanage/dealexam/savehead" method="post" id="dialogForm" >
            <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <input type='hidden' name='_k' value='<?=$rk?>' />
            <input type='hidden' name='vP' value='<?=$rp?>' />
            <input type='hidden' name='vEhTime' value='<?=pub::chkData($eh_data,'ehtime')?>' />
            <input type='hidden' name='vEhId' value='<?=pub::chkData($eh_data,'ehid')?>' />
            <input type='hidden' name='vExamId' value='<?=$exam_data['examid']?>' />
            <input type='hidden' name='vStartTime' value='<?=$starttime?>' />
            <input type='hidden' name='vGardeStatus' id="vGardeStatus" value='2' />
            <input type='hidden' name='vUserId' value='<?=Yii::$app->user->identity->id?>' />
            <input type='hidden' name='vUserName' value='<?=Yii::$app->user->identity->UserName?>' />
            <div class="ptDla">
                <dl>
                    <dd class="anNumA">一、单选题
                        <div class="anNum">
                            <ul>
                                <?foreach ($question_data['type1'] as $v):?>
                                    <?if(!empty($v['u_answer'])):?>
                                        <li class="NumActive"><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?else:?>
                                        <li ><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?endif;?>
                                <?endforeach;?>
                            </ul>
                        </div>
                        <div id="danxuan" >
                            <ul>
                                <?foreach ($question_data['type1'] as $v):?>
                                    <li class="paperexamcontent" id="qu_<?=$v['questionid']?>">
                                        <br> <span>第<?=$v['RowNum']?>题</span>
                                        <span><?=$v['question']?></span>
                                        <span><?=$v['questionselect']?></span>
                                        <?for ($i=1;$i<=$v['questionselectnumber'];$i++):?>
                                            <?if($i==1):?>
                                                <label ><input type="radio" name="vAnswer[<?=$v['questionid']?>]" rel="" value="A" <?=$v['u_answer']=='A'?'checked':''?> disabled="disabled" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==2):?>
                                                <label ><input type="radio" name="vAnswer[<?=$v['questionid']?>]" rel="" value="B" <?=$v['u_answer']=='B'?'checked':''?> disabled="disabled" />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==3):?>
                                                <label ><input type="radio" name="vAnswer[<?=$v['questionid']?>]" rel="" value="C" <?=$v['u_answer']=='C'?'checked':''?> disabled="disabled" />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==4):?>
                                                <label ><input type="radio" name="vAnswer[<?=$v['questionid']?>]" rel="" value="D" <?=$v['u_answer']=='D'?'checked':''?> disabled="disabled" />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==5):?>
                                                <label ><input type="radio" name="vAnswer[<?=$v['questionid']?>]" rel="" value="E" <?=$v['u_answer']=='E'?'checked':''?> disabled="disabled" />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==6):?>
                                                <label ><input type="radio" name="vAnswer[<?=$v['questionid']?>]" rel="" value="F" <?=$v['u_answer']=='F'?'checked':''?> disabled="disabled" />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==7):?>
                                                <label ><input type="radio" name="vAnswer[<?=$v['questionid']?>]" rel="" value="G" <?=$v['u_answer']=='G'?'checked':''?> disabled="disabled" />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?endif?>
                                        <?endfor;?>
                                        <br/><span>考生答案：<?if($v['u_answer']==$v['questionanswer']):?>
                                                <?=$v['u_answer']?>
                                                <input type="hidden" name="vScore[<?=$v['questionid']?>]"  value="<?=$v['questionscore']?>">
                                            <?elseif ($v['u_answer']<>$v['questionanswer'] && $v['u_answer']!=""):?>
                                                <input type="hidden" name="vErrors[<?=$v['questionid']?>]" value="<?=$v['u_answer']?>">
                                                <span style="color: red"><?=$v['u_answer']?></span>
                                            <?else:?>
                                                <span style="color: red">未作答</span>
                                                <input type="hidden" name="vErrors[<?=$v['questionid']?>]" value="<?=$v['u_answer']?>">
                                            <?endif;?>
                                            </span>
                                        <br/><span>参考答案：<?=$v['questionanswer']?></span>
                                        <br/><span>答案解析：<?=$v['questiondescribe']?></span>
                                        <br/><span><span><a href="<?=$v['questionvideo']?>">视频讲解</a></span></span>
                                    </li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    </dd>
                    <dd class="anNumB">二、多选题
                        <div class="anNum">
                            <ul>
                                <?foreach ($question_data['type2'] as $v):?>
                                    <?if(!empty($v['u_answer'])):?>
                                        <li class="NumActive"><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?else:?>
                                        <li ><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?endif;?>
                                <?endforeach;?>
                            </ul>
                        </div>
                        <div id="duoxuan" >
                            <ul>
                                <?foreach ($question_data['type2'] as $v):?>
                                    <li class="paperexamcontent" id="qu_<?=$v['questionid']?>">
                                        <br> <span>第<?=$v['RowNum']?>题</span>
                                        <span><?=$v['question']?></span>
                                        <span><?=$v['questionselect']?></span>
                                        <?
                                        $u_Answer="";
                                        if(!empty($v['u_answer'])){
                                            foreach($v['u_answer'] as $u){
                                                $u_Answer.=$u;
                                            }
                                        }else{
                                            $u_Answer="";
                                        }
                                        ?>
                                        <?for ($i=1;$i<=$v['questionselectnumber'];$i++):?>
                                            <?if($i==1):?>
                                                <label ><input type="checkbox" name="vAnswer[<?=$v['questionid']?>][<?=$i?>]" rel="" value="A" <?if(strpos($u_Answer,'A') !== false):?>checked="checked"<?endif;?> disabled="disabled" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==2):?>
                                                <label ><input type="checkbox" name="vAnswer[<?=$v['questionid']?>][<?=$i?>]" rel="" value="B" <?if(strpos($u_Answer,'B') !== false):?>checked="checked"<?endif;?> disabled="disabled" />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==3):?>
                                                <label ><input type="checkbox" name="vAnswer[<?=$v['questionid']?>][<?=$i?>]" rel="" value="C" <?if(strpos($u_Answer,'C') !== false):?>checked="checked"<?endif;?> disabled="disabled" />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==4):?>
                                                <label ><input type="checkbox" name="vAnswer[<?=$v['questionid']?>][<?=$i?>]" rel="" value="D" <?if(strpos($u_Answer,'D') !== false):?>checked="checked"<?endif;?> disabled="disabled" />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==5):?>
                                                <label ><input type="checkbox" name="vAnswer[<?=$v['questionid']?>][<?=$i?>]" rel="" value="E" <?if(strpos($u_Answer,'E') !== false):?>checked="checked"<?endif;?> disabled="disabled" />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==6):?>
                                                <label ><input type="checkbox" name="vAnswer[<?=$v['questionid']?>][<?=$i?>]" rel="" value="F" <?if(strpos($u_Answer,'F') !== false):?>checked="checked"<?endif;?> disabled="disabled" />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?elseif($i==7):?>
                                                <label ><input type="checkbox" name="vAnswer[<?=$v['questionid']?>][<?=$i?>]" rel="" value="G" <?if(strpos($u_Answer,'G') !== false):?>checked="checked"<?endif;?> disabled="disabled" />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?endif?>
                                        <?endfor;?>
                                    </li>
                                    <br/><span>考生答案：<?if($u_Answer==$v['questionanswer']):?>
                                            <?=$u_Answer?>
                                            <input type="hidden" name="vScore[<?=$v['questionid']?>]"  value="<?=$v['questionscore']?>">
                                        <?elseif ($u_Answer<>$v['questionanswer'] && $v['u_answer']!=""):?>
                                            <input type="hidden" name="vErrors[<?=$v['questionid']?>]" value="<?=$u_Answer?>">
                                            <span style="color: red"><?=$u_Answer?></span>
                                        <?else:?>
                                            <input type="hidden" name="vErrors[<?=$v['questionid']?>]" value="<?=$u_Answer?>">
                                            <span style="color: red">未作答</span>
                                        <?endif;?>
                                            </span>
                                    <br/><span>参考答案：<?=$v['questionanswer']?></span>
                                    <br/><span>答案解析：<?=$v['questiondescribe']?></span>
                                    <br/><span><span><a href="<?=$v['questionvideo']?>">视频讲解</a></span></span>
                                <?endforeach;?>
                            </ul>
                        </div>
                    </dd>
                    <dd class="anNumC">三、填空题
                        <div class="anNum">
                            <ul>
                                <?foreach ($question_data['type3'] as $v):?>
                                    <?if(!empty($v['u_answer'])):?>
                                        <li class="NumActive"><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?else:?>
                                        <li ><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?endif;?>
                                <?endforeach;?>
                            </ul>
                        </div>
                        <div id="tiankong" >
                            <ul>
                                <?foreach ($question_data['type3'] as $v):?>
                                    <li class="paperexamcontent" id="qu_<?=$v['questionid']?>">
                                        <br> <span>第<?=$v['RowNum']?>题</span>
                                        <span><?=$v['question']?></span>
                                    </li>
                                    <br/><span>考生答案：<?if(empty(trim($v['u_answer']))):?>

                                            <span style="color:red;">未作答</span>

                                        <?else:?>
                                            <?=$v['u_answer']?>
                                        <?endif;?>
                                    </span>
                                    <br/><span>参考答案：<?=$v['questionanswer']?></span>
                                    <br/><span>答案解析：<?=$v['questiondescribe']?></span>
                                    <br/><span>评分：<input  type="text" id="question<?=$v['questionid']?>" class="c-i-4" onblur="sroce(<?=$v['questionid']?>,<?=$v['questionscore']?>);" name="vScore[<?=$v['questionid']?>]" >
                                                 <input type="hidden" id="vErrors<?=$v['questionid']?>" name="vErrors[<?=$v['questionid']?>]" value="<?=$v['u_answer']?>">
                                    </span>
                                    <br/><span>评语：<input type="text" name="vComment[<?=$v['questionid']?>]" placeholder="在此输入评语"></span>
                                    <br/><span>答案解析：</span>
                                    <br/><span><span><a href="<?=$v['questionvideo']?>">视频讲解</a></span></span>
                                <?endforeach;?>
                            </ul>
                        </div>
                    </dd>
                    <dd class="anNumD">四、文字题
                        <div class="anNum">
                            <ul>
                                <?foreach ($question_data['type4'] as $v):?>
                                    <?if(!empty($v['u_answer'])):?>
                                        <li class="NumActive"><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?else:?>
                                        <li ><a href="#qu_<?=$v['questionid']?>"><?=$v['RowNum']?></a></li>
                                    <?endif;?>
                                <?endforeach;?>
                            </ul>
                        </div>
                        <div id="tiankong" >
                            <ul>
                                <?foreach ($question_data['type4'] as $v):?>
                                    <li class="paperexamcontent" id="qu_<?=$v['questionid']?>">
                                        <br> <span>第<?=$v['RowNum']?>题</span>
                                        <span><?=$v['question']?></span>
                                    </li>
                                    <br/><span>考生答案：<?if(empty(trim($v['u_answer']))):?>

                                            <span style="color:red;">未作答</span>

                                        <?else:?>
                                            <?=$v['u_answer']?>
                                        <?endif;?>
                                    </span>
                                    <br/><span>参考答案：<?=$v['questionanswer']?></span>
                                    <br/><span>答案解析：<?=$v['questiondescribe']?></span>
                                    <br/><span>评分：<input type="text" onblur="sroce(<?=$v['questionid']?>,<?=$v['questionscore']?>);" class="c-i-4" name="vScore[<?=$v['questionid']?>]">
                                        <input type="hidden" id="vErrors<?=$v['questionid']?>" name="vErrors[<?=$v['questionid']?>]" value="<?=$v['u_answer']?>">
                                    </span>
                                    <br/><span>评语：<input type="text" name="vComment[<?=$v['questionid']?>]" placeholder="在此输入评语"></span>
                                    <br/><span>答案解析：</span>
                                    <br/><span><span><a href="<?=$v['questionvideo']?>">视频讲解</a></span></span>

                                <?endforeach;?>
                            </ul>
                        </div>
                    </dd>
                </dl>
            </div>

    </div>


</div>



<!-- 交卷  -->


<!-- 交卷确定提示  -->
<div class="anTs">
    <div class="anJChaCen">
        <div class="anJcTit">提示</div>
        <div class="anJcCen">
            <div class="anTsFlex">
                <img src="assets/images/icon_Success.png" />
                <p>阅卷提交成功</p>
            </div>
            <div class="anJcBtn">
                <div class="anJcBtnB anTsBtn" ><a href="?r=checkmanage/endexam">确定</a></div>
            </div>
        </div>
    </div>
</div>
<!-- 临时保存  -->
<div class="anLs">
    <div class="anJChaCen">
        <div class="anJcTit">提示</div>
        <div class="anJcCen">
            <div class="anTsFlex">
                <p>临时保存成功，可前往【批改中试卷】进行继续批改</p>
            </div>
            <div class="anJcBtn">
                <div class="anJcBtnB anTsBtn" ><a href="?r=checkmanage/onexam">确定</a></div>
            </div>
        </div>
    </div>
</div>

</form>

<script type="text/javascript">
    fieldsCheck=new FieldsCheck();
    $(function() {
        $('.ptDla dl dd').eq(0).show().siblings().hide();
        //检查弹窗
        $('.anJc').click(function(){
            $('.anJCha').fadeIn();
        })
        //检查弹窗隐藏
        $('.anJcTit img, .anJcBtnA').click(function(){
            $('.anJCha').fadeOut();
        })

        //选项卡
        $('.anTabHead ul li').click(function(){
            $(this).addClass('anActive').siblings().removeClass('anActive');
            var my = $(this).index();
            $('.ptDla dl dd').eq(my).show().siblings().hide();
        })


        //交卷显示
        $('.anBlast').click(function(){
            $('.anQuan').fadeIn();
        })
        //交卷隐藏
        $('.anJcTit img, .anJcBtnA').click(function(){
            $('.anQuan').fadeOut();
        })

        //单选
        $('.anQuanRadio ul li').click(function(){
            var sibling = $(this).siblings();

            if($(this).find('img').attr('src')=='assets/images/icon_Unselected.png'){
                $(this).find('img').attr('src','assets/images/icon_Select.png');
                $(this).find('p').css('color','#db2c1b');
                $(this).find('input').attr('checked','checked');
                sibling.find('p').css('color','#333333');
                sibling.find('img').attr('src','assets/images/icon_Unselected.png');
                sibling.find('input').attr('checked',false);

            }else{
                $(this).find('input').attr('checked',false);
                $(this).find('img').attr('src','assets/images/icon_Unselected.png');
                $(this).find('p').css('color','#333333');
                sibling.find('p').css('color','#db2c1b');
                sibling.find('img').attr('src','assets/images/icon_Select.png');
                sibling.find('input').attr('checked','checked');
            }

        })

        $('li input').click(function() {
            // debugger;
            var examId = $(this).closest('li').attr('id'); // 得到题目ID
            var cardLi = $('a[href=#' + examId + ']'); // 根据题目ID找到对应答题卡
            // 设置已答题
            if(!cardLi.parent().hasClass('NumActive')){
                cardLi.parent().addClass('NumActive');
                $('.yesdonumber').html($(".NumActive").length);
            }
        });

        $('li textarea').bind('input propertychange', function(){
            console.log("1111");
        });
        $('.allquestionnumber').html($('.paperexamcontent').length);
        $('.yesdonumber').html($(".NumActive").length);
    });
    // var qindex = 0;
    // function gotoquestion(questid)
    // {
    //     $(".questionpanel").hide();
    //     $(".paperexamcontent").hide();
    //     $("#questions_"+questid).show();
    //     $("#questype_"+$("#questions_"+questid).attr('rel')).show();
    // }
    // function gotoindexquestion(index)
    // {
    //     $(".questionpanel").hide();
    //     $(".paperexamcontent").hide();
    //     $(".paperexamcontent").eq(index).show();
    //     $("#questype_"+$(".paperexamcontent").eq(index).attr('rel')).show();
    // }
    $(document).ready(function(){
        //  $.get('index.php?exam-app-index-ajax-lefttime&rand'+Math.random(),function(data){
        <?if(!empty($eh_data)):?>
        var data=<?=pub::chkData($eh_data,'ehtime')?>;
        <?else:?>
        var data=0;
        <?endif;?>
        var setting = {
            time:200,
            // time:0.1,
            hbox:$("#timer_h"),
            mbox:$("#timer_m"),
            sbox:$("#timer_s"),
            finish:function(){
            }
        }
        setting.lefttime = parseInt(data);
        countdown(setting);
    });
    function Linshi() {
        $(".anLs").fadeIn();
        $('#vGardeStatus').val('3');
        artSave('dialogForm');
    }
    function endsave() {
        $(".anTs").fadeIn();
        $('#vGardeStatus').val('2');
        artSave('dialogForm');
    }
    function artSave(formid){
        var msg=fieldsCheck.checkMsg('#'+formid);
        if(msg.length>0){      //返回的數組大於0的時候則有錯誤
            var al=msg.join('<br>');    //直接用br鏈接返回錯誤
            showalert(al,'<?=langs::getTxt('infotitle')?>');
            return false;
        }
        $("#"+formid).ajaxSubmit({
            async: false, //同步提交，不对返回值做判断，设置true
            //dataType:'json',
            success: function(result){
                //返回提示信息
                if (/\[0000\]/i.test(result)){
                }else{
                    showalert(result,'<?=langs::getTxt('infotitle')?>');
                }
            },
            error:function(){
                showMessage('<?=langs::getTxt('neterror')?>',2,'<?=langs::getTxt('infotitle')?>');
            }
        });
    }
    function  sroce(q_id,q_score) {
        var in_score=$("#question"+q_id).val();
        if(in_score>q_score){
            showMessage('评分不能大于该题分数！',3);
            $("#question"+q_id).val("")
        }else if (in_score<q_score) {
            $("#vErrors"+q_id).attr("disabled", false);
        }else {
            $("#vErrors"+q_id).attr("disabled", "disabled");
        }
    }

</script>