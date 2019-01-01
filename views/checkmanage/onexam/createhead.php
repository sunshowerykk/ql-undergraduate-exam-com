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
                <div class="teAntxt" onclick="backpage();"><a herf="">返回批改中阅卷</div>
                <ul class="anHeadRightB">
                    <li class="anJc" onclick="Linshi();">临时保存</li>
                    <li class="teFq">
                        <a href="javascript:void(0)" style="text-decoration:none;color:#fff; " class="btn btn-info btn-xs"
                           data-url="?r=checkmanage/onexam/waivehead&c1=<?=pub::chkData($eh_data,'ehid')?>&_k=<?=Pub::enFormMD5('edit',pub::chkData($eh_data,'ehid'))?>"
                           data-confirm='确认要放弃这张试卷吗？成功将返回【待批改试卷】'
                           data-id="artHead"
                           onclick="artWaive(this);return false;">放弃阅卷</a>
                    </li>
                    <li class="anBlast" onclick="endsave();">保存提交阅卷</li>
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
                    <?foreach ($question_data as $v):?>
                        <dd class="anNumA"><span id="ti_<?=$v['typeid']?>"><b><?=$v['typenum']?>、<?=$v['typename']?>（<?=$v['typeinfo']?>）</b></span>
                            <div class="anNum">
                                <ul>
                                    <?foreach ($v['question'] as $q):?>
                                        <?if(is_array($q['u_answer'])):?>
                                            <?if( !empty($q['u_answer'])):?>
                                                <li class="NumActive"><a href="#qu_<?=$q['questionid']?>"><?=$q['RowNum']?></a></li>
                                            <?else:?>
                                                <li ><a href="#qu_<?=$q['questionid']?>"><?=$q['RowNum']?></a></li>
                                            <?endif;?>
                                        <?else:?>
                                            <?if( !empty(trim($q['u_answer']))):?>
                                                <li class="NumActive"><a href="#qu_<?=$q['questionid']?>"><?=$q['RowNum']?></a></li>
                                            <?else:?>
                                                <li ><a href="#qu_<?=$q['questionid']?>"><?=$q['RowNum']?></a></li>
                                            <?endif;?>
                                        <?endif;?>
                                    <?endforeach;?>
                                </ul>
                            </div>
                            <div id="danxuan" >
                                <ul>
                                    <?foreach ($v['question'] as $q):?>
                                        <?if($q['type']==1):?>
                                            <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
                                                <br> <span>第<?=$q['RowNum']?>题</span>
                                                <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                                <span><?=$q['questionselect']?></span>
                                                <?for ($i=1;$i<=$q['questionselectnumber'];$i++):?>
                                                    <?if($i==1):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="A" <?=$q['u_answer']=='A'?'checked':''?> disabled="disabled" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==2):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="B" <?=$q['u_answer']=='B'?'checked':''?> disabled="disabled" />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==3):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="C" <?=$q['u_answer']=='C'?'checked':''?> disabled="disabled" />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==4):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="D" <?=$q['u_answer']=='D'?'checked':''?> disabled="disabled" />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==5):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="E" <?=$q['u_answer']=='E'?'checked':''?> disabled="disabled" />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==6):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="F" <?=$q['u_answer']=='F'?'checked':''?> disabled="disabled" />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==7):?>
                                                        <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="G" <?=$q['u_answer']=='G'?'checked':''?> disabled="disabled" />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?endif?>
                                                <?endfor;?>
                                                <?if($q['questioncap']<>'1'):?>
                                                    <br/><span>考生答案：<?if($q['u_answer']==$q['questionanswer']):?>
                                                            <?=$q['u_answer']?>
                                                            <input type="hidden" name="vScore[<?=$q['questionid']?>]"  value="<?=$q['questionscore']?>">
                                                        <?elseif ($q['u_answer']<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                                            <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$q['u_answer']?>">
                                                            <span style="color: red"><?=$q['u_answer']?></span>
                                                        <?else:?>
                                                            <span style="color: red">未作答</span>
                                                            <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$q['u_answer']?>">
                                                        <?endif;?>
                                                        </span>
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
                                                                <?if(is_array($c['u_answer'])):?>
                                                                    <?if( !empty($c['u_answer'])):?>
                                                                        <li class="NumActive"><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?endif;?>
                                                                <?else:?>
                                                                    <?if( !empty(trim($c['u_answer']))):?>
                                                                        <li class="NumActive"><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?endif;?>
                                                                <?endif;?>
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
                                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="A" <?=$c['u_answer']=='A'?'checked':''?> disabled="disabled" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==2):?>
                                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="B" <?=$c['u_answer']=='B'?'checked':''?> disabled="disabled" />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==3):?>
                                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="C" <?=$c['u_answer']=='C'?'checked':''?> disabled="disabled" />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==4):?>
                                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="D" <?=$c['u_answer']=='D'?'checked':''?> disabled="disabled" />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==5):?>
                                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="E" <?=$c['u_answer']=='E'?'checked':''?> disabled="disabled" />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==6):?>
                                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="F" <?=$c['u_answer']=='F'?'checked':''?> disabled="disabled" />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==7):?>
                                                                        <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="G" <?=$c['u_answer']=='G'?'checked':''?> disabled="disabled" />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?endif?>
                                                                <?endfor;?>
                                                                <br/><span>考生答案：<?if($c['u_answer']==$c['questionanswer']):?>
                                                                        <?=$c['u_answer']?>
                                                                        <input type="hidden" name="vScore[<?=$c['questionid']?>]"  value="<?=$c['questionscore']?>">
                                                                    <?elseif ($c['u_answer']<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$c['u_answer']?>">
                                                                        <span style="color: red"><?=$c['u_answer']?></span>
                                                                    <?else:?>
                                                                        <span style="color: red">未作答</span>
                                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$c['u_answer']?>">
                                                                    <?endif;?>
                                                                             </span>
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
                                            <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
                                                <br> <span>第<?=$q['RowNum']?>题</span>
                                                <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                                <span><?=$q['questionselect']?></span>
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
                                                        <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="A" <?if(strpos($u_Answer,'A') !== false):?>checked="checked"<?endif;?> disabled="disabled" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==2):?>
                                                        <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="B" <?if(strpos($u_Answer,'B') !== false):?>checked="checked"<?endif;?> disabled="disabled" />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==3):?>
                                                        <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="C" <?if(strpos($u_Answer,'C') !== false):?>checked="checked"<?endif;?> disabled="disabled" />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==4):?>
                                                        <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="D" <?if(strpos($u_Answer,'D') !== false):?>checked="checked"<?endif;?> disabled="disabled" />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==5):?>
                                                        <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="E" <?if(strpos($u_Answer,'E') !== false):?>checked="checked"<?endif;?> disabled="disabled" />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==6):?>
                                                        <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="F" <?if(strpos($u_Answer,'F') !== false):?>checked="checked"<?endif;?> disabled="disabled" />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?elseif($i==7):?>
                                                        <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="G" <?if(strpos($u_Answer,'G') !== false):?>checked="checked"<?endif;?> disabled="disabled" />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?endif?>
                                                <?endfor;?>
                                                <?if($q['questioncap']<>'1'):?>
                                                    <br/><span>考生答案：<?if($u_Answer==$q['questionanswer']):?>
                                                            <?=$u_Answer?>
                                                            <input type="hidden" name="vScore[<?=$q['questionid']?>]"  value="<?=$q['questionscore']?>">
                                                        <?elseif ($u_Answer<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                                            <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$u_Answer?>">
                                                            <span style="color: red"><?=$u_Answer?></span>
                                                        <?else:?>
                                                            <input type="hidden" name="vErrors[<?=$q['questionid']?>]" value="<?=$u_Answer?>">
                                                            <span style="color: red">未作答</span>
                                                        <?endif;?>
                                                     </span>
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
                                                                <?if(is_array($c['u_answer'])):?>
                                                                    <?if( !empty($c['u_answer'])):?>
                                                                        <li class="NumActive"><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?endif;?>
                                                                <?else:?>
                                                                    <?if( !empty(trim($c['u_answer']))):?>
                                                                        <li class="NumActive"><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?endif;?>
                                                                <?endif;?>
                                                            <?endforeach;?>
                                                        </ul>
                                                    </div>
                                                    <ul>
                                                        <?foreach ($q['capquestion'] as $c):?>
                                                            <li class="paperexamcontent" id="qu_<?=$c['questionid']?>">
                                                                <br> <span>第<?=$c['RowNum']?>小题</span>
                                                                <span><?=substr($c['question'],3,strlen($c['question'])-3); ?></span>
                                                                <span><?=$c['questionselect']?></span>
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
                                                                        <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="A" <?if(strpos($u_Answer,'A') !== false):?>checked="checked"<?endif;?> disabled="disabled" />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==2):?>
                                                                        <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="B" <?if(strpos($u_Answer,'B') !== false):?>checked="checked"<?endif;?> disabled="disabled" />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==3):?>
                                                                        <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="C" <?if(strpos($u_Answer,'C') !== false):?>checked="checked"<?endif;?> disabled="disabled" />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==4):?>
                                                                        <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="D" <?if(strpos($u_Answer,'D') !== false):?>checked="checked"<?endif;?> disabled="disabled"  />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==5):?>
                                                                        <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="E" <?if(strpos($u_Answer,'E') !== false):?>checked="checked"<?endif;?> disabled="disabled" />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==6):?>
                                                                        <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="F" <?if(strpos($u_Answer,'F') !== false):?>checked="checked"<?endif;?> disabled="disabled" />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?elseif($i==7):?>
                                                                        <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="G" <?if(strpos($u_Answer,'G') !== false):?>checked="checked"<?endif;?> disabled="disabled" />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?endif?>
                                                                <?endfor;?>
                                                                <br/><span>考生答案：<?if($u_Answer==$c['questionanswer']):?>
                                                                        <?=$u_Answer?>
                                                                        <input type="hidden" name="vScore[<?=$c['questionid']?>]"  value="<?=$c['questionscore']?>">
                                                                    <?elseif ($u_Answer<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$u_Answer?>">
                                                                        <span style="color: red"><?=$u_Answer?></span>
                                                                    <?else:?>
                                                                        <input type="hidden" name="vErrors[<?=$c['questionid']?>]" value="<?=$u_Answer?>">
                                                                        <span style="color: red">未作答</span>
                                                                    <?endif;?>
                                                                                 </span>
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
                                        <?elseif ($q['type']==3 || $q['type']==4):?>
                                            <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
                                                <br> <span>第<?=$q['RowNum']?>题</span>
                                                <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                                <?if($q['questioncap']<>'1'):?>
                                                    <br/><span>考生答案：<?if(empty(trim($q['u_answer']))):?>

                                                            <span style="color:red;">未作答</span>

                                                        <?else:?>
                                                            <?=$q['u_answer']?>
                                                        <?endif;?>
                                                    </span>
                                                    <br/><span>参考答案：<?=$q['questionanswer']?></span>
                                                    <br/><span>答案解析：<?=$q['questiondescribe']?></span>
                                                    <br/><span style="color: red">本题分值：<?=$q['questionscore']?></span>
                                                    <br/><span>评分：<input  type="text" id="question<?=$q['questionid']?>" value="<?=pub::chkData($q,'t_score')?>" class="c-i" onblur="sroce(<?=$q['questionid']?>,<?=$q['questionscore']?>);" name="vScore[<?=$q['questionid']?>]" >
                                                 <input type="hidden" id="vErrors<?=$q['questionid']?>" name="vErrors[<?=$q['questionid']?>]" value='<?=$q['u_answer']?>'></span>
                                                    <br/><span>评语：<input type="text" name="vComment[<?=$q['questionid']?>]" value="<?=pub::chkData($q,'t_content')?>" placeholder="在此输入评语"></span>
                                                    <?if(!empty($q['questionvideo'])):?>
                                                        <br/><span><span><a href="javascript:void(0)" data-url="<?=$q['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                                                    <?endif;?>
                                                <?endif;?>
                                                <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                                    <div class="anNum">
                                                        <ul>
                                                            <?foreach ($q['capquestion'] as $c):?>
                                                                <?if(is_array($c['u_answer'])):?>
                                                                    <?if( !empty($c['u_answer'])):?>
                                                                        <li class="NumActive"><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?endif;?>
                                                                <?else:?>
                                                                    <?if( !empty(trim($c['u_answer']))):?>
                                                                        <li class="NumActive"><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?endif;?>
                                                                <?endif;?>
                                                            <?endforeach;?>
                                                        </ul>
                                                    </div>
                                                    <ul>
                                                        <?foreach ($q['capquestion'] as $c):?>
                                                            <li class="paperexamcontent" id="qu_<?=$c['questionid']?>">
                                                                <br> <span>第<?=$c['RowNum']?>小题</span>
                                                                <span><?=substr($c['question'],3,strlen($c['question'])-3); ?></span>
                                                                <br/><span>考生答案：<?if(empty(trim($c['u_answer']))):?>

                                                                        <span style="color:red;">未作答</span>

                                                                    <?else:?>
                                                                        <?=$c['u_answer']?>
                                                                    <?endif;?>
                                                                     </span>
                                                                <br/><span>参考答案：<?=$c['questionanswer']?></span>
                                                                <br/><span>答案解析：<?=$c['questiondescribe']?></span>
                                                                <br/><span style="color: red">本题分值：<?=$c['questionscore']?></span>
                                                                <br/><span>评分：<input  type="text" id="question<?=$c['questionid']?>" value="<?=pub::chkData($c,'t_score')?>" class="c-i" onblur="sroce(<?=$c['questionid']?>,<?=$c['questionscore']?>);" name="vScore[<?=$c['questionid']?>]" />
                                                                    <input type="hidden" id="vErrors<?=$c['questionid']?>" name="vErrors[<?=$c['questionid']?>]" value='<?=$c['u_answer']?>' /></span>
                                                                <br/><span>评语：<input type="text" name="vComment[<?=$c['questionid']?>]" value="<?=pub::chkData($c,'t_content')?>" placeholder="在此输入评语"></span>
                                                                <?if(!empty($c['questionvideo'])):?>
                                                                    <br/><span><span><a href="javascript:void(0)" data-url="<?=$c['questionvideo']?>" class="vedioPlay">视频讲解</a></span></span>
                                                                <?endif;?>
                                                            </li>
                                                        <?endforeach;?>
                                                    </ul>
                                                <?endif;?>
                                            </li>
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
                <div class="anJcBtnB anTsBtn" >确定</div>
            </div>
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
        //检查弹窗
        $('.anJc').click(function(){
            $('.anJCha').fadeIn();
        })
        $('.anLs .anJcBtn .anJcBtnB').click(function(){
            $('.anLs').fadeOut();
        })
        //选项卡
        $('.anTabHead ul li').click(function(){
            $(this).addClass('anActive').siblings().removeClass('anActive');
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
    function backpage() {
        $(".anHeadRight .teAntxt").find("a").attr("href","?r=checkmanage/onexam")
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