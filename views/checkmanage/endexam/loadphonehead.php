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
    <section class="kanTop">
        <hgroup>
            <h6><?=$eh_data['username']?><span><?=$eh_data['ehscore']?>分</span><span>(总分<?=$exam_data['examscore']?>)</span></h6>
            <p>交卷时间 <?=date('Y-m-d H:i:s',$eh_data['ehendtime'])?><span>考试用时<?
                    $remain = $eh_data['ehtime']%86400;
                    $hours = intval($remain/3600);

                    // 分
                    $remain = $eh_data['ehtime']%3600;
                    $mins = intval($remain/60);
                    // 秒
                    $secs = $remain%60;
                    if($hours!=0){
                        echo ($hours."小时".$mins."分".$secs."秒");
                    }else{
                        echo ($mins."分".$secs."秒");
                    }
                    ?></span></p>
        </hgroup>
    </section>
</section>
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
                                        <?elseif ($q['u_answer']<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                            <span style="color: red"><?=$q['u_answer']?></span>
                                        <?else:?>
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
                                                <?elseif ($c['u_answer']<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                    <span style="color: red"><?=$c['u_answer']?></span>
                                                <?else:?>
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
                                        <?elseif ($u_Answer<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                            <span style="color: red"><?=$u_Answer?></span>
                                        <?else:?>
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
                                                <?elseif ($u_Answer<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                    <span style="color: red"><?=$u_Answer?></span>
                                                <?else:?>
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
                                <input  type="text" id="question<?=$q['questionid']?>" placeholder="请评分,本题（<?=$q['questionscore']?>）分" disabled="disabled" value="<?=pub::chkData($q,'t_score')?>" class="c-i-4" onblur="sroce(<?=$q['questionid']?>,<?=$q['questionscore']?>);" name="vScore[<?=$q['questionid']?>]" >
                            </div>
                            <div class="teacTk teacTkTxt">
                                <textarea name="vComment[<?=$q['questionid']?>]" disabled="disabled" placeholder="在此输入评语"><?=pub::chkData($q,'t_content')?></textarea>
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
                                        <input  type="text" id="question<?=$c['questionid']?>" placeholder="请评分,本题（<?=$c['questionscore']?>）分" disabled="disabled" value="<?=pub::chkData($c,'t_score')?>" class="c-i-4" onblur="sroce(<?=$c['questionid']?>,<?=$c['questionscore']?>);" name="vScore[<?=$c['questionid']?>]" >
                                    </div>
                                    <div class="teacTk teacTkTxt">
                                        <textarea name="vComment[<?=$c['questionid']?>]" disabled="disabled" placeholder="在此输入评语"><?=pub::chkData($c,'t_content')?></textarea>
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
<section class="teacfooter">
    <div class="teacfooterCen ptteacfooterCen">
        <hgroup>
            <h6><?
                $remain = $eh_data['ehgardetime']%86400;
                $hours = intval($remain/3600);

                // 分
                $remain = $eh_data['ehgardetime']%3600;
                $mins = intval($remain/60);
                // 秒
                $secs = $remain%60;
                if($hours!=0){
                    echo ($hours."小时".$mins."分".$secs."秒");
                }else{
                    echo ($mins."分".$secs."秒");
                }
                ?></h6>
            <p>用时</p>
        </hgroup>
        <figure>
            <a href="?r=checkmanage/dealexam">
            <i></i>
            <figcaption>待批改试卷</figcaption>
            </a>
        </figure>
    </div>
</section>
