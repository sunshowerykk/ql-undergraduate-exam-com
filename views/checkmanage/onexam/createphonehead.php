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
echo Html::jsFile('assets/js/exam/mplugin.js');
//echo Html::jsFile('assets/js/exam/plugin.js');

?>
<section class="yuBg">
    <hgroup>
        <h5><?=$exam_data['examname']?></h5>
        <p><?=$exam_data['examsubname']?> / <?=$exam_data['examcoursename']?>/<?=$exam_data['examcoursesectionname']?></p>
        <p>试卷总分 <?=$exam_data['examscore']?>分 <span>答题时间<?=$exam_data['examtime']?>分钟</span></p>
    </hgroup>
</section>
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
    <section class="testYu yuTop teacCorrTop">
        <!--单选题-->
        <?foreach ($question_data as $v):?>
            <ul>
                <h1><b><?=$v['typenum']?>、<?=$v['typename']?></b></h1>
                <?foreach ($v['question'] as $q):?>
                    <?if($q['type']==1):?>
                        <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty($q['u_answer'])):?>NumActivePhone<?endif;?>" <?endif;?> >
                            <hgroup>
                                <h6>第<?=$q['RowNum']?>题.<?=$q['question']?></h6>
                            </hgroup>
                            <dl class="yuRadio">
                                <dd>
                                    <?=$q['questionselect']?>
                                </dd>
                                <dd>
                                    <?for ($i=1;$i<=$q['questionselectnumber'];$i++):?>
                                        <?if($i==1):?>
                                            <label id=""><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="A" <?=$q['u_answer']=='A'?'checked':''?> disabled="disabled"/>A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==2):?>
                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="B" <?=$q['u_answer']=='B'?'checked':''?> disabled="disabled"/>B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==3):?>
                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="C" <?=$q['u_answer']=='C'?'checked':''?> disabled="disabled"/>C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==4):?>
                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="D" <?=$q['u_answer']=='D'?'checked':''?> disabled="disabled"/>D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==5):?>
                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="E" <?=$q['u_answer']=='E'?'checked':''?> disabled="disabled"/>E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==6):?>
                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="F" <?=$q['u_answer']=='F'?'checked':''?> disabled="disabled"/>F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==7):?>
                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="G" <?=$q['u_answer']=='G'?'checked':''?> disabled="disabled"/>G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?endif?>
                                    <?endfor;?>
                                </dd>
                                <?if($q['questioncap']<>'1'):?>
                                    <dd>
                                        <p>考生答案：<?if($q['u_answer']==$q['questionanswer']):?>
                                                <?=$q['u_answer']?>
                                                <input type="hidden" name="vScore[<?=$q['questionid']?>]"  value="<?=$q['questionscore']?>">
                                            <?elseif ($q['u_answer']<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                                <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$q['u_answer']?>">
                                                <span style="color: red"><?=$q['u_answer']?></span>
                                            <?else:?>
                                                <span style="color: red">未作答</span>
                                                <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$q['u_answer']?>">
                                            <?endif;?>
                                        </p>
                                    </dd>
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
                                <li <?if($c['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty($c['u_answer'])):?>NumActivePhone<?endif;?>" <?endif;?> >
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
                                                    <label id=""><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="A" <?=$c['u_answer']=='A'?'checked':''?> disabled="disabled"/>A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==2):?>
                                                    <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="B" <?=$c['u_answer']=='B'?'checked':''?> disabled="disabled"/>B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==3):?>
                                                    <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="C" <?=$c['u_answer']=='C'?'checked':''?> disabled="disabled"/>C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==4):?>
                                                    <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="D" <?=$c['u_answer']=='D'?'checked':''?> disabled="disabled"/>D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==5):?>
                                                    <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="E" <?=$c['u_answer']=='E'?'checked':''?> disabled="disabled"/>E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==6):?>
                                                    <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="F" <?=$c['u_answer']=='F'?'checked':''?> disabled="disabled"/>F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==7):?>
                                                    <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="G" <?=$c['u_answer']=='G'?'checked':''?> disabled="disabled"/>G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?endif?>
                                            <?endfor;?>
                                        </dd>
                                        <?if($c['questioncap']<>'1'):?>
                                            <dd>
                                                <p>考生答案：<?if($c['u_answer']==$c['questionanswer']):?>
                                                        <?=$c['u_answer']?>
                                                        <input type="hidden" name="vScore[<?=$c['questionid']?>]"  value="<?=$c['questionscore']?>">
                                                    <?elseif ($c['u_answer']<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$c['u_answer']?>">
                                                        <span style="color: red"><?=$c['u_answer']?></span>
                                                    <?else:?>
                                                        <span style="color: red">未作答</span>
                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$c['u_answer']?>">
                                                    <?endif;?>
                                                </p>
                                            </dd>
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
                        <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty($q['u_answer'])):?>NumActivePhone<?endif;?>" <?endif;?> >
                            <hgroup>
                                <h6>第<?=$q['RowNum']?>题.<?=$q['question']?></h6>
                            </hgroup>
                            <dl class="yucheck">
                                <dd>
                                    <?=$q['questionselect']?>
                                </dd>
                                <dd>
                                    <?
                                    $u_Answer="";
                                    if(!empty($q['u_answer'])){
                                        foreach($q['u_answer'] as $u){
                                            $u_Answer.=$u;
                                        }
                                    }
                                    ?>
                                    <?for ($i=1;$i<=$q['questionselectnumber'];$i++):?>
                                        <?if($i==1):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="A" <?if(strpos($u_Answer,'A') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==2):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="B" <?if(strpos($u_Answer,'B') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==3):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="C" <?if(strpos($u_Answer,'C') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==4):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="D" <?if(strpos($u_Answer,'D') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==5):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="E" <?if(strpos($u_Answer,'E') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==6):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="F" <?if(strpos($u_Answer,'F') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?elseif($i==7):?>
                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="G" <?if(strpos($u_Answer,'G') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?endif?>
                                    <?endfor;?>
                                </dd>
                                <?if($q['questioncap']<>'1'):?>
                                    <dd>
                                        <p>考生答案：<?if($u_Answer==$q['questionanswer']):?>
                                                <?=$u_Answer?>
                                                <input type="hidden" name="vScore[<?=$q['questionid']?>]"  value="<?=$q['questionscore']?>">
                                            <?elseif ($u_Answer<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                                <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$u_Answer?>">
                                                <span style="color: red"><?=$u_Answer?></span>
                                            <?else:?>
                                                <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$u_Answer?>">
                                                <span style="color: red">未作答</span>
                                            <?endif;?>
                                        </p>
                                    </dd>
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
                                <li <?if($c['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty($c['u_answer'])):?>NumActivePhone<?endif;?>" <?endif;?> >
                                    <hgroup>
                                        <h6>第<?=$c['RowNum']?>小题.<?=$c['question']?></h6>
                                    </hgroup>
                                    <dl class="yucheck">
                                        <dd>
                                            <?=$c['questionselect']?>
                                        </dd>
                                        <dd>
                                            <?
                                            $u_Answer="";
                                            if(!empty($c['u_answer'])){
                                                foreach($c['u_answer'] as $u){
                                                    $u_Answer.=$u;
                                                }
                                            }
                                            ?>
                                            <?for ($i=1;$i<=$c['questionselectnumber'];$i++):?>
                                                <?if($i==1):?>
                                                    <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="A" <?if(strpos($u_Answer,'A') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==2):?>
                                                    <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="B" <?if(strpos($u_Answer,'B') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==3):?>
                                                    <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="C" <?if(strpos($u_Answer,'C') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==4):?>
                                                    <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="D" <?if(strpos($u_Answer,'D') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==5):?>
                                                    <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="E" <?if(strpos($u_Answer,'E') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==6):?>
                                                    <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="F" <?if(strpos($u_Answer,'F') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?elseif($i==7):?>
                                                    <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="G" <?if(strpos($u_Answer,'G') !== false):?>checked="checked"<?endif;?> disabled="disabled"/>G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?endif?>
                                            <?endfor;?>
                                        </dd>
                                        <?if($c['questioncap']<>'1'):?>
                                            <dd>
                                                <p>考生答案：<?if($u_Answer==$c['questionanswer']):?>
                                                        <?=$u_Answer?>
                                                        <input type="hidden" name="vScore[<?=$c['questionid']?>]"  value="<?=$c['questionscore']?>">
                                                    <?elseif ($u_Answer<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$u_Answer?>">
                                                        <span style="color: red"><?=$u_Answer?></span>
                                                    <?else:?>
                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$u_Answer?>">
                                                        <span style="color: red">未作答</span>
                                                    <?endif;?>
                                                </p>
                                            </dd>
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
                        <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty(trim($q['u_answer']))):?>NumActivePhone<?endif;?>" <?endif;?> >
                            <hgroup>
                                <h6>第<?=$q['RowNum']?>题.<?=$q['question']?></h6>
                            </hgroup>
                            <?if($q['questioncap']<>'1'):?>
                                <dl class="yuRadio">
                                    <dd class="teacColora">
                                        <p>考生答案：<?if(empty(trim($q['u_answer']))):?>

                                                <span style="color:red;">未作答</span>

                                            <?else:?>
                                                <?=$q['u_answer']?>
                                            <?endif;?>
                                        </p>
                                    </dd>
                                    <dd class="teacColorb">
                                        <p>参考答案：<?=$q['questionanswer']?></p>
                                    </dd>
                                    <dd class="teacColorb">
                                        <p>答案解析：<?=$q['questiondescribe']?></p>
                                    </dd>
                                </dl>
                                <div class="teacTk">
                                    <input  type="text" id="question<?=$q['questionid']?>" placeholder="请评分,本题（<?=$q['questionscore']?>）分" value="<?=pub::chkData($q,'t_score')?>" class="c-i-4" onblur="sroce(<?=$q['questionid']?>,<?=$q['questionscore']?>);" name="vScore[<?=$q['questionid']?>]" >
                                    <input type="hidden" id="vErrors<?=$q['questionid']?>" name="vErrors[<?=$q['questionid']?>]" value="<?=$q['u_answer']?>">
                                </div>
                                <div class="teacTk teacTkTxt">
                                    <textarea name="vComment[<?=$q['questionid']?>]" placeholder="在此输入评语"><?=pub::chkData($q,'t_content')?></textarea>
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
                        </li>
                        <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                            <?foreach ($q['capquestion'] as $c):?>
                                <li <?if($c['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty(trim($c['u_answer']))):?>NumActivePhone<?endif;?>" <?endif;?> >
                                    <hgroup>
                                        <h6>第<?=$c['RowNum']?>小题.<?=$c['question']?></h6>
                                    </hgroup>
                                    <?if($c['questioncap']<>'1'):?>
                                        <dl class="yuRadio">
                                            <dd class="teacColora">
                                                <p>考生答案：<?if(empty(trim($c['u_answer']))):?>

                                                        <span style="color:red;">未作答</span>

                                                    <?else:?>
                                                        <?=$c['u_answer']?>
                                                    <?endif;?>
                                                </p>
                                            </dd>
                                            <dd class="teacColorb">
                                                <p>参考答案：<?=$c['questionanswer']?></p>
                                            </dd>
                                            <dd class="teacColorb">
                                                <p>答案解析：<?=$c['questiondescribe']?></p>
                                            </dd>
                                        </dl>
                                        <div class="teacTk">
                                            <input  type="text" id="question<?=$c['questionid']?>" placeholder="请评分,本题（<?=$c['questionscore']?>）分" value="<?=pub::chkData($c,'t_score')?>"  class="c-i-4" onblur="sroce(<?=$c['questionid']?>,<?=$c['questionscore']?>);" name="vScore[<?=$c['questionid']?>]" >
                                            <input type="hidden" id="vErrors<?=$c['questionid']?>" name="vErrors[<?=$c['questionid']?>]" value="<?=$c['u_answer']?>">
                                        </div>
                                        <div class="teacTk teacTkTxt">
                                            <textarea name="vComment[<?=$c['questionid']?>]" placeholder="在此输入评语"><?=pub::chkData($c,'t_content')?></textarea>
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
                                </li>
                            <?endforeach;?>
                        <?endif;?>
                    <?endif;?>
                <?endforeach;?>
            </ul>
        <?endforeach;?>
    </section>
</form>
<section class="teacfooter">
    <div class="teacfooterCen">
        <hgroup>
            <h6><span id="timer_h">00</span>:<span id="timer_m">00</span>:<span id="timer_s">00</span></h6>
            <p>用时</p>
        </hgroup>
        <figure onclick="Linshi();">
            <i></i>
            <figcaption>临时保存</figcaption>
        </figure>
        <figure class="teacFq">
            <a href="javascript:void(0)" style="text-decoration:none;color:#fff; " class="btn btn-info btn-xs"
               data-url="?r=checkmanage/onexam/waivehead&c1=<?=pub::chkData($eh_data,'ehid')?>&_k=<?=Pub::enFormMD5('edit',pub::chkData($eh_data,'ehid'))?>"
               data-confirm='确认要放弃这张试卷吗？成功将返回【待批改试卷】'
               data-id="artHead"
               onclick="artWaive(this);return false;">
                <i></i>
                <figcaption>
                    放弃阅卷
                </figcaption>
            </a>
        </figure>
        <figure onclick="endsave();">
            <i></i>
            <figcaption>保存提交阅卷</figcaption>
        </figure>
    </div>
</section>

<!--放弃阅卷弹窗-->
<section class="teacFqPop">
    <div class="teacPCen">
        <h6>提示</h6>
        <hgroup>
            <p>一旦放弃阅卷，<br>试卷批阅权将被释放，<br>是否放弃？</p>
        </hgroup>
        <div class="teacBtn">
            <button type="button" class="teacBtna">否</button>
            <button type="button">是</button>
        </div>
    </div>
</section>
<section class="teacFqPop anALert">
    <div class="teacPCen">
        <h6>提示</h6>
        <hgroup>
            <p></p>
        </hgroup>
        <div class="teacBtn ptteacBtn">
            <button type="button">确定</button>
        </div>
    </div>
</section>
<script type="text/javascript">
    fieldsCheck=new FieldsCheck();
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
        $('#vGardeStatus').val('3');
        $('.anALert').fadeIn();
        artSave('dialogForm');
        $(".anALert p").html("临时保存成功，点击【确定】继续阅卷。")
        $('.anALert .teacBtn button').click(function(){
            $('.anALert').fadeOut();
        })
    }
    function endsave() {
        $('#vGardeStatus').val('2');
        $('.anALert').fadeIn();
        artSave('dialogForm');
        $(".anALert p").html("保存阅卷成功，点击【确定】跳转到【已批试卷】。")
        $('.anALert .teacBtn button').click(function(){
            $('.anALert').fadeOut();
            window.location.href ="?r=checkmanage/endexam";
        })
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
    function artWaive(that){
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
                            url:url,
                            type: 'post',
                            data: {"_csrf":'<?= Yii::$app->request->csrfToken ?>'},
                            success: function (data) {
                                if (/\[0000\]/i.test(data)) {
                                    window.location.href ="?r=checkmanage/dealexam";
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