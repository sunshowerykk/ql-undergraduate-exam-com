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
echo Html::jsFile('assets/ueditor_frontpage/ueditor.config.js');   //编辑器
echo Html::jsFile('assets/ueditor_frontpage/ueditor.all.min.js');  //编辑器
echo Html::jsFile('assets/ueditor_frontpage/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/ueditor_frontpage/kityformula-plugin/addKityFormulaDialog.js');   //公式编辑器
echo Html::jsFile('assets/ueditor_frontpage/kityformula-plugin/defaultFilterFix.js');  //公式编辑器
echo Html::jsFile('assets/ueditor_frontpage/kityformula-plugin/getKfContent.js'); //公式编辑器

?>
<!--  内容区域 -->
<div class="contentTwo" style="overflow:auto">
    <!--  顶部 -->
    <div class="anHead">
        <div class="anHeadCon">
            <div class="anHeadLeft">
                <h6><?=$exam_data['examname']?></h6>
                <p>科目：<?=$exam_data['examsubname']?><br />
                    课程：<?=$exam_data['examcoursename']?><br />
                    节次：<?=$exam_data['examcoursesectionname']?><br />
                    试卷总分：<?=$exam_data['examscore']?><br />
                    答题时间：<?=$exam_data['examtime']?></p>
            </div>
            <div class="anHeadRight">
                <div class="anHeadRightA">
                    <img src="assets/images/icon_time.png" />
                    <p>倒计时</p>
                    <div class="anTime"  id="timer">
                        <span id="timer_h">00</span>:
                        <span id="timer_m">00</span>:
                        <span id="timer_s">00</span>
                    </div>
                </div>
                <ul class="anHeadRightB">
                    <li class="anJc"><a  href="?r=admin/papermanage" >返回</a></li>
                </ul>

            </div>

        </div>
    </div>

    <!-- 选项卡开始 -->
    <div class="anTab">
        <div class="anTabHead">
            <ul>
                <?foreach ($t_data as $key=>$v):?>
                    <?if($key==0):?>
                        <li class="anActive" ><a href="#ti_<?=$v['typeid']?>"><?=$v['typenum']?>、<?=$v['typename']?></a></li>
                    <?else:?>
                        <li ><a href="#ti_<?=$v['typeid']?>"><?=$v['typenum']?>、<?=$v['typename']?></a></li>
                    <?endif;?>
                <?endforeach;?>
            </ul>
        </div>
            <!--选项卡-->
        <form action="?r=student/student/savehead" method="post" id="dialogForm" >
            <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <input type='hidden' name='_k' value='<?=$rk?>' />
            <input type='hidden' name='vP' value='<?=$rp?>' />
            <input type='hidden' name='vEhTime' value='<?=pub::chkData($eh_data,'ehtime')?>' />
            <input type='hidden' name='vEhId' value='<?=pub::chkData($eh_data,'ehid')?>' />
            <input type='hidden' name='vExamId' value='<?=$exam_data['examid']?>' />
            <input type='hidden' name='vStartTime' value='<?=$starttime?>' />
            <input type='hidden' name='vUserId' value='<?=yii::$app->session['studentuser']['userid']?>' />
            <input type='hidden' name='vUserName' value='<?=yii::$app->session['studentuser']['username']?>' />
        <div class="ptDla">
            <dl>
                <?foreach ($question_data as $v):?>
                    <dd class="anNumA" style="padding-top:20px;"><span id="ti_<?=$v['typeid']?>"><b><?=$v['typenum']?>、<?=$v['typename']?>（<?=$v['typeinfo']?>）</b></span>
                    <div class="anNum">
                        <ul>
                            <?foreach ($v['question'] as $q):?>
                                    <li ><a href="#qu_<?=$q['questionid']?>"><?=$q['RowNum']?></a></li>
                            <?endforeach;?>
                        </ul>
                    </div>
                    <div id="danxuan" >
                        <ul>
                    <?foreach ($v['question'] as $q):?>
                        <?if($q['type']==1):?>
                            <li class="paperexamcontent" id="qu_<?=$q['questionid']?>">
                                  <br> <span>第<?=$q['RowNum']?>题</span>
                                <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                <span><?=$q['questionselect']?></span>
                                <?for ($i=1;$i<=$q['questionselectnumber'];$i++):?>
                                    <?if($i==1):?>
                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="A" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?elseif($i==2):?>
                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="B"  />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?elseif($i==3):?>
                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="C"  />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?elseif($i==4):?>
                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="D"  />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?elseif($i==5):?>
                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="E"  />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?elseif($i==6):?>
                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="F"  />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?elseif($i==7):?>
                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="G"  />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?endif?>
                                <?endfor;?>
                                <?if($q['questioncap']<>'1'):?>
                                <br/><span>参考答案：<?=$q['questionanswer']?></span>
                                <br/><span>答案解析：<?=$q['questiondescribe']?></span>
                                <?if(!empty($q['questionvideo'])):?>
                                    <br/><span><span><a href="javascript:void(0)" data-url="<?=$q['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                                <?endif;?>
                                <?endif;?>
                                <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                    <div class="anNum">
                                        <ul>
                                            <?foreach ($q['capquestion'] as $c):?>
                                                    <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                            <?endforeach;?>
                                        </ul>
                                    </div>
                                     <ul>
                                        <?foreach ($q['capquestion'] as $c):?>
                                            <li class="paperexamcontent" id="qu_<?=$c['questionid']?>">
                                                <br> <span>第<?=$c['RowNum']?>小题</span>
                                                <span><?=substr($c['question'],3,strlen($c['question'])-3); ?></span>
                                                <span><?=$c['questionselect']?></span>
                                                <?for ($i=1;$i<=$c['questionselectnumber'];$i++):?>
                                                    <?if($i==1):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="A" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==2):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="B"  />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==3):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="C"  />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==4):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="D"  />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==5):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="E"  />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==6):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="F"  />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==7):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="G"  />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?endif?>
                                                <?endfor;?>
                                                <br/><span>参考答案：<?=$c['questionanswer']?></span>
                                                <br/><span>答案解析：<?=$c['questiondescribe']?></span>
                                                <?if(!empty($c['questionvideo'])):?>
                                                    <br/><span><span><a href="javascript:void(0)" data-url="<?=$c['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                                                <?endif;?>
                                            </li>
                                        <?endforeach;?>
                                     </ul>
                                <?endif;?>
                            </li>

                        <?elseif ($q['type']==2):?>
                                <li class="paperexamcontent" id="qu_<?=$q['questionid']?>">
                                     <br> <span>第<?=$q['RowNum']?>题</span>
                                    <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                    <span><?=$q['questionselect']?></span>
                                    <?for ($i=1;$i<=$q['questionselectnumber'];$i++):?>
                                        <?if($i==1):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="A" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==2):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="B"/>B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==3):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="C"/>C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==4):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="D"/>D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==5):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="E"/>E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==6):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="F"/>F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==7):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="G"/>G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?endif?>
                                    <?endfor;?>
                                    <?if($q['questioncap']<>'1'):?>
                                    <br/><span>参考答案：<?=$q['questionanswer']?></span>
                                    <br/><span>答案解析：<?=$q['questiondescribe']?></span>
                                    <?if(!empty($q['questionvideo'])):?>
                                        <br/><span><span><a href="javascript:void(0)" data-url="<?=$q['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                                    <?endif;?>
                                    <?endif;?>
                                    <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                        <div class="anNum">
                                            <ul>
                                                <?foreach ($q['capquestion'] as $c):?>
                                                    <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                <?endforeach;?>
                                            </ul>
                                        </div>
                                        <ul>
                                            <?foreach ($q['capquestion'] as $c):?>
                                                <li class="paperexamcontent" id="qu_<?=$c['questionid']?>">
                                                     <br> <span>第<?=$c['RowNum']?>小题</span>
                                                    <span><?=substr($c['question'],3,strlen($c['question'])-3); ?></span>
                                                    <span><?=$c['questionselect']?></span>
                                                    <?for ($i=1;$i<=$c['questionselectnumber'];$i++):?>
                                                        <?if($i==1):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="A" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==2):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="B"/>B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==3):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="C"/>C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==4):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="D"/>D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==5):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="E"/>E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==6):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="F"/>F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==7):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="G"/>G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?endif?>
                                                    <?endfor;?>
                                                    <?if($c['questioncap']<>'1'):?>
                                                        <br/><span>参考答案：<?=$c['questionanswer']?></span>
                                                        <br/><span>答案解析：<?=$c['questiondescribe']?></span>
                                                        <?if(!empty($c['questionvideo'])):?>
                                                            <br/><span><span><a href="javascript:void(0)" data-url="<?=$c['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                                                        <?endif;?>
                                                    <?endif;?>
                                                </li>
                                            <?endforeach;?>
                                        </ul>
                                    <?endif;?>
                                </li>
                        <?elseif ($q['type']==3 || $q['type']==4):?>
                                <li class="paperexamcontent" id="qu_<?=$q['questionid']?>">
                                     <br> <span>第<?=$q['RowNum']?>题</span>
                                    <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                    <?if($q['questioncap']<>'1'):?>
                                    <textarea  id="vAnswer<?=$q['questionid']?>" name="vAnswer[<?=$q['questionid']?>]"  cols="" rows=""
                                               style="resize:none;display: none;">
                                    </textarea>
                                    <?endif;?>
                                </li>
                            <?if($q['questioncap']<>'1'):?>
                            <br/><span>参考答案：<?=$q['questionanswer']?></span>
                            <br/><span>答案解析：<?=$q['questiondescribe']?></span>
                            <?if(!empty($q['questionvideo'])):?>
                                <br/><span><span><a href="javascript:void(0)" data-url="<?=$q['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                            <?endif;?>
                            <?endif;?>
                            <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                <div class="anNum">
                                    <ul>
                                        <?foreach ($q['capquestion'] as $c):?>
                                            <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                        <?endforeach;?>
                                    </ul>
                                </div>
                                <ul>
                                    <?foreach ($q['capquestion'] as $c):?>
                                        <li class="paperexamcontent" id="qu_<?=$c['questionid']?>">
                                            <br> <span>第<?=$c['RowNum']?>小题</span>
                                            <span><?=substr($c['question'],3,strlen($c['question'])-3); ?></span>
                                            <textarea  id="vAnswer<?=$c['questionid']?>" name="vAnswer[<?=$c['questionid']?>]"  cols="" rows=""
                                                       style="resize:none;display: none;">
                                            </textarea>
                                        </li>
                                        <?if($c['questioncap']<>'1'):?>
                                            <br/><span>参考答案：<?=$c['questionanswer']?></span>
                                            <br/><span>答案解析：<?=$c['questiondescribe']?></span>
                                            <?if(!empty($c['questionvideo'])):?>
                                                <br/><span><span><a href="javascript:void(0)" data-url="<?=$c['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                                            <?endif;?>
                                        <?endif;?>
                                    <?endforeach;?>
                                </ul>
                            <?endif;?>
                        <?endif;?>
                    <?endforeach;?>
                        </ul>
                    </div>
                </dd>
                <?endforeach;?>
            </dl>
        </div>

    </div>


</div>
</form>
<style>
	.vedioDiv {
		position:absolute;
		width:80%;
		height:50%;
		left:10%;
		background:#FFF;
		top:10%;
		border:1px solid #DDDDDD;
		border-radius:10px;
		display:none;
        z-index: 9999999999;
	}
	.vedioDiv .vedioClose{
		float:right;
		font-size:18px;
		padding-right:20px;
	}
</style>
<div class="vedioDiv">
	<div class="vedioClose">关闭</div>
</div>
<script type="text/javascript">
    fieldsCheck=new FieldsCheck();
    $(function() {		
		$(document).on('click','.vedioPlay',function(){
			var  video='<video  controls="true" controlslist="nodownload" preload="none" width="100%" autoplay height="100%" src="'+$(this).data('url')+'" data-setup="{}"><source src="'+$(this).data('url')+'" type="video/mp4"/></video>';
			$('.vedioDiv').append(video).fadeIn();
		}).on('click','.vedioClose',function(){
			$('.vedioDiv').fadeOut().find('video').remove();
		})
		
       // $('.ptDla dl dd').eq(0).show().siblings().hide();
        //检查弹窗
        $('.anJc').click(function(){
            $('.anJCha').fadeIn();
        })
        //检查弹窗隐藏
        $('.anJcTit img, .anJcBtnA').click(function(){
            $('.anJCha').fadeOut();
        })

        // //选项卡
        $('.anTabHead ul li').click(function(){
            $(this).addClass('anActive').siblings().removeClass('anActive');
            // var my = $(this).index();
            // $('.ptDla dl dd').eq(my).show().siblings().hide();
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




        //提示
        // $('.anJcBao').click(function(){
        //     $('.anQuan').fadeOut();
        //     $('.anTs').fadeIn();
        // })
        // $('.anJcTit img').click(function(){
        //     if($("#anRadio").val==1){}
        //     $('.anTs').fadeOut();
        // })

        //临时保存
        $('.anLshi').click(function(){
            $('.anQuan').fadeOut();
            $('.anLs').fadeIn();
            $('#vEhStatus').val('2');
        })
        // $('.anJcTit img').click(function(){
        //     $('.anLs').fadeOut();
        // })
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
    <?foreach ($question_data as $v):?>
    <?foreach ($v['question'] as $q):?>
    <?if($q['type']==3 || $q['type']==4):?>
    <?if($q['questioncap']<>'1'):?>
        var ue<?=$q['questionid']?>;
        if (ue<?=$q['questionid']?>) {
            ue<?=$q['questionid']?>.destroy();
        }
        ue<?=$q['questionid']?> = new UE.ui.Editor({
            initialFrameWidth: '55%',
            initialFrameHeight: '80',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            initialStyle: 'p{font-size:13px} body{background:#EEEEEE;}'
        });
        ue<?=$q['questionid']?>.render('vAnswer<?=$q['questionid']?>');
        // ueA.render('ueRemarks2');
        ue<?=$q['questionid']?>.addListener("ready", function () {
            $('#vAnswer<?=$q['questionid']?>').show();
        });
    <?elseif($q['questioncap']=='1' && !empty($q['capquestion'])):?>
    <?foreach ($q['capquestion'] as $c):?>
        var ue<?=$c['questionid']?>;
        if (ue<?=$c['questionid']?>) {
            ue<?=$c['questionid']?>.destroy();
        }
        ue<?=$c['questionid']?> = new UE.ui.Editor({
            initialFrameWidth: '55%',
            initialFrameHeight: '80',
            initialContent: '',
            enableAutoSave: false,
            pasteplain: true,
            autoSyncData: true,
            initialStyle: 'p{font-size:13px} body{background:#EEEEEE;}'
        });
        ue<?=$c['questionid']?>.render('vAnswer<?=$c['questionid']?>');
        // ueA.render('ueRemarks2');
        ue<?=$c['questionid']?>.addListener("ready", function () {
            $('#vAnswer<?=$c['questionid']?>').show();
        });
    <?endforeach;?>
    <?endif;?>
    <?endif;?>
    <?endforeach;?>
    <?endforeach;?>
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
                time:<?=$exam_data['examtime']?>,
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
    function check() {
        $('.anJCha').fadeOut();
        $('.anQuan').fadeIn();
    }

</script>