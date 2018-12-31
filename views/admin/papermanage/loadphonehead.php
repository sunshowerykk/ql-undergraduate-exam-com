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
echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/addKityFormulaDialog.js');   //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/defaultFilterFix.js');  //公式编辑器
echo Html::jsFile('assets/ueditor/kityformula-plugin/getKfContent.js'); //公式编辑器

?>
<section class="yuBg">
    <hgroup>
        <h5><?=$exam_data['examname']?></h5>
        <p><?=$exam_data['examsubname']?> / <?=$exam_data['examcoursename']?>/<?=$exam_data['examcoursesectionname']?></p>
        <p>试卷总分 <?=$exam_data['examscore']?>分 <span>答题时间<?=$exam_data['examtime']?>分钟</span></p>
    </hgroup>
</section>
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
    <section class="testYu yuTop teacCorrTop">
        <!--单选题-->
        <?foreach ($question_data as $v):?>
            <ul>
                <h1><?=$v['typenum']?>、<?=$v['typename']?></h1>
                <?foreach ($v['question'] as $q):?>
                    <?if($q['type']==1):?>
                            <li class="paperexamcontent" >
                                <hgroup>
                                    <h6><b>第<?=$q['RowNum']?>题.<?=$q['question']?></b></h6>
                                </hgroup>
                                <dl class="yuRadio">
                                    <dd>
                                        <?=$q['questionselect']?>
                                    </dd>
                                    <dd>
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
                                    </dd>
                                    <?if($q['questioncap']<>'1'):?>
                                        <dd>
                                            <p>参考答案： <?=$q['questionanswer']?></p>
                                        </dd>
                                    <?endif;?>
                                </dl>
                            </li>
                        <?if($q['questioncap']<>'1'):?>
                            <div class="teacBg">
                                <p>答案解析：<?=$q['questiondescribe']?></p>
                            </div>
                            <?if(!empty($q['questionvideo'])):?>
                                <div class="teacA">
                                    <a href="<?=$q['questionvideo']?>" target="view_window">
                                        <img src="assets/images/phone/images/icon_mv.png" />
                                        <p>视频讲解</p>
                                    </a>
                                </div>
                            <?endif;?>
                        <?endif;?>
                      <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                        <?foreach ($q['capquestion'] as $c):?>
                                <li class="paperexamcontent" >
                                    <hgroup>
                                        <h6>第<?=$c['RowNum']?>小题.<?=$c['question']?></h6>
                                    </hgroup>
                                    <dl class="yuRadio">
                                        <dd>
                                            <?=$c['questionselect']?>
                                        </dd>
                                        <dd>
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
                                        </dd>
                                        <?if($c['questioncap']<>'1'):?>
                                            <dd>
                                                <p>参考答案： <?=$c['questionanswer']?></p>
                                            </dd>
                                        <?endif;?>
                                    </dl>
                                </li>
                                <?if($c['questioncap']<>'1'):?>
                                    <div class="teacBg">
                                        <p>答案解析：<?=$c['questiondescribe']?></p>
                                    </div>
                                    <?if(!empty($c['questionvideo'])):?>
                                        <div class="teacA">
                                            <a href="<?=$c['questionvideo']?>" target="view_window">
                                                <img src="assets/images/phone/images/icon_mv.png" />
                                                <p>视频讲解</p>
                                            </a>
                                        </div>
                                    <?endif;?>
                                <?endif;?>
                        <?endforeach;?>
                      <?endif;?>
                    <?elseif ($q['type']==2):?>
                            <li class="paperexamcontent" >
                                <hgroup>
                                        <h6>第<?=$q['RowNum']?>题.<?=$q['question']?></h6>
                                </hgroup>
                                <dl class="yucheck">
                                    <dd>
                                        <?=$q['questionselect']?>
                                    </dd>
                                    <dd>
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
                                    </dd>
                                    <?if($q['questioncap']<>'1'):?>
                                        <dd>
                                            <p>参考答案： <?=$q['questionanswer']?></p>
                                        </dd>
                                    <?endif;?>
                                </dl>
                            </li>
                        <?if($q['questioncap']<>'1'):?>
                            <div class="teacBg">
                                <p>答案解析：<?=$q['questiondescribe']?></p>
                            </div>
                            <?if(!empty($q['questionvideo'])):?>
                                <div class="teacA">
                                    <a href="<?=$q['questionvideo']?>" target="view_window">
                                        <img src="assets/images/phone/images/icon_mv.png" />
                                        <p>视频讲解</p>
                                    </a>
                                </div>
                            <?endif;?>
                        <?endif;?>
                     <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                        <?foreach ($q['capquestion'] as $c):?>
                                <li class="paperexamcontent" >
                                    <hgroup>
                                        <h6>第<?=$c['RowNum']?>小题.<?=$c['question']?></h6>
                                    </hgroup>
                                    <dl class="yucheck">
                                        <dd>
                                            <?=$c['questionselect']?>
                                        </dd>
                                        <dd>
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
                                        </dd>
                                        <?if($c['questioncap']<>'1'):?>
                                            <dd>
                                                <p>参考答案： <?=$c['questionanswer']?></p>
                                            </dd>
                                        <?endif;?>
                                    </dl>
                                </li>
                                <?if($c['questioncap']<>'1'):?>
                                    <div class="teacBg">
                                        <p>答案解析：<?=$c['questiondescribe']?></p>
                                    </div>
                                    <?if(!empty($c['questionvideo'])):?>
                                        <div class="teacA">
                                            <a href="<?=$c['questionvideo']?>" target="view_window">
                                                <img src="assets/images/phone/images/icon_mv.png" />
                                                <p>视频讲解</p>
                                            </a>
                                        </div>
                                    <?endif;?>
                                <?endif;?>
                        <?endforeach;?>
                        <?endif;?>
                    <?elseif ($q['type']==3 || $q['type']==4):?>
                            <li class="paperexamcontent" >
                                <hgroup>
                                        <h6>第<?=$q['RowNum']?>题.<?=$q['question']?></h6>
                                </hgroup>
                                <section class="yuTian">
                                    <textarea  id="vAnswer<?=$q['questionid']?>" name="vAnswer[<?=$q['questionid']?>]"  cols="" rows=""
                                               style="resize:none;display: none;">
                                    </textarea>
                                </section>
                                <?if($q['questioncap']<>'1'):?>
                                    <dl class="yuRadio">
                                        <dd class="teacColorb">
                                            <p>参考答案：<?=$q['questionanswer']?></p>
                                        </dd>
                                        <dd class="teacColorb">
                                            <p>答案解析：<?=$q['questiondescribe']?></p>
                                        </dd>
                                    </dl>
                                    <?if(!empty($q['questionvideo'])):?>
                                        <div class="teacA">
                                            <a href="<?=$q['questionvideo']?>" target="view_window">
                                                <img src="assets/images/phone/images/icon_mv.png" />
                                                <p>视频讲解</p>
                                            </a>
                                        </div>
                                    <?endif;?>
                                <?endif;?>
                            </li>
                        <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                            <?foreach ($q['capquestion'] as $c):?>
                                <li class="paperexamcontent" >
                                    <hgroup>
                                        <h6>第<?=$c['RowNum']?>小题.<?=$c['question']?></h6>
                                    </hgroup>
                                    <section class="yuTian">
                                    <textarea  id="vAnswer<?=$c['questionid']?>" name="vAnswer[<?=$c['questionid']?>]"  cols="" rows=""
                                               style="resize:none;display: none;">
                                    </textarea>
                                    </section>
                                    <?if($c['questioncap']<>'1'):?>
                                        <dl class="yuRadio">
                                            <dd class="teacColorb">
                                                <p>参考答案：<?=$c['questionanswer']?></p>
                                            </dd>
                                            <dd class="teacColorb">
                                                <p>答案解析：<?=$c['questiondescribe']?></p>
                                            </dd>
                                        </dl>
                                        <?if(!empty($c['questionvideo'])):?>
                                            <div class="teacA">
                                                <a href="<?=$c['questionvideo']?>" target="view_window">
                                                    <img src="assets/images/phone/images/icon_mv.png" />
                                                    <p>视频讲解</p>
                                                </a>
                                            </div>
                                        <?endif;?>
                                    <?endif;?>
                                </li>
                            <?endforeach;?>
                        <?endif;?>
                        <?endif?>
                <?endforeach;?>
                <button type="button" class="adminHeadBtn yuBtn"><a href="?r=admin/papermanage">返回试卷管理</a></button>
            </ul>
        <?endforeach;?>
    </section>
    <section class="teacfooter">
        <div class="teacfooterCen">
            <hgroup>
                <h6><span id="timer_h">00</span>:<span id="timer_m">00</span>:<span id="timer_s">00</span></h6>
                <p>用时</p>
            </hgroup>
            <figure class="anJc">
                <i></i>
                <figcaption>检查</figcaption>
            </figure>
            <figure class="teacFq">
                <i></i>
                <figcaption>临时保存</figcaption>
            </figure>
            <figure class="anBlast">
                <i></i>
                <figcaption>交卷</figcaption>
            </figure>
        </div>
    </section>
</form>
<script type="text/javascript">
    <?foreach ($question_data as $v):?>
    <?foreach ($v['question'] as $q):?>
    <?if($q['type']==3 || $q['type']==4):?>
    <?if($q['questioncap']<>'1'):?>
    var ue<?=$q['questionid']?>;
    if (ue<?=$q['questionid']?>) {
        ue<?=$q['questionid']?>.destroy();
    }
    ue<?=$q['questionid']?> = new UE.ui.Editor({
        initialFrameWidth: '100%',
        initialFrameHeight: '200',
        initialContent: '',
        enableAutoSave: false,
        pasteplain: true,
        autoSyncData: true,
        initialStyle: 'p{font-size:13px}'
    });
    ue<?=$q['questionid']?>.render('vAnswer<?=$q['questionid']?>');
    // ueA.render('ueRemarks2');
    ue<?=$q['questionid']?>.addListener("ready", function () {
        $('#vAnswer<?=$q['questionid']?>').show();
    });
    ue<?=$q['questionid']?>.addListener("contentChange", function () {
        var content=ue<?=$q['questionid']?>.getContent();
        //   var cardLi = $('a[href=#qu_<?=$q['questionid']?>]'); // 根据题目ID找到对应答题卡
        if(content!=null && content.length!=0){
            // 设置已答题
            if(!$("#vAnswer<?=$q['questionid']?>").parent().parent().hasClass('NumActivePhone')){
                $("#vAnswer<?=$q['questionid']?>").parent().parent().addClass('NumActivePhone');
                $('.yesdonumber').html($(".NumActivePhone").length);
            }
        }else if(content.length==0){
            if($("#vAnswer<?=$q['questionid']?>").parent().parent().hasClass('NumActivePhone')){
                $("#vAnswer<?=$q['questionid']?>").parent().parent().removeClass('NumActivePhone');
                $('.yesdonumber').html($(".NumActivePhone").length);
            }
        }
    });
    <?elseif($q['questioncap']=='1' && !empty($q['capquestion'])):?>
    <?foreach ($q['capquestion'] as $c):?>
    var ue<?=$c['questionid']?>;
    if (ue<?=$c['questionid']?>) {
        ue<?=$c['questionid']?>.destroy();
    }
    ue<?=$c['questionid']?> = new UE.ui.Editor({
        initialFrameWidth: '100%',
        initialFrameHeight: '200',
        initialContent: '',
        enableAutoSave: false,
        pasteplain: true,
        autoSyncData: true,
        initialStyle: 'p{font-size:13px}'
    });
    ue<?=$c['questionid']?>.render('vAnswer<?=$c['questionid']?>');
    // ueA.render('ueRemarks2');
    ue<?=$c['questionid']?>.addListener("ready", function () {
        $('#vAnswer<?=$c['questionid']?>').show();
    });
    ue<?=$c['questionid']?>.addListener("contentChange", function () {
        var content=ue<?=$c['questionid']?>.getContent();
        //   var cardLi = $('a[href=#qu_<?=$c['questionid']?>]'); // 根据题目ID找到对应答题卡
        if(content!=null && content.length!=0){
            // 设置已答题
            if(!$("#vAnswer<?=$c['questionid']?>").parent().parent().hasClass('NumActivePhone')){
                $("#vAnswer<?=$c['questionid']?>").parent().parent().addClass('NumActivePhone');
                $('.yesdonumber').html($(".NumActivePhone").length);
            }
        }else if(content.length==0){
            if($("#vAnswer<?=$c['questionid']?>").parent().parent().hasClass('NumActivePhone')){
                $("#vAnswer<?=$c['questionid']?>").parent().parent().removeClass('NumActivePhone');
                $('.yesdonumber').html($(".NumActivePhone").length);
            }
        }
    });
    <?endforeach;?>
    <?endif;?>
    <?endif;?>
    <?endforeach;?>
    <?endforeach;?>

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

</script>