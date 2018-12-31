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
echo Html::jsFile('assets/ueditor_frontpage/ueditor.all.js');  //编辑器
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
                    <li class="anJc">检查</li>
                    <li class="anLshi">临时保存</li>
                    <li class="anBlast">交卷</li>
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
                        <dd class="anNumA"><span id="ti_<?=$v['typeid']?>"><b><?=$v['typenum']?>、<?=$v['typename']?>（<?=$v['typeinfo']?>）</b></span>
                            <div class="anNum">
                                <ul>
                                    <?foreach ($v['question'] as $q):?>
                                        <?if($rop=="edit"):?>
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
                                        <?else:?>
                                                <li ><a href="#qu_<?=$q['questionid']?>"><?=$q['RowNum']?></a></li>
                                        <?endif;?>
                                    <?endforeach;?>
                                </ul>
                            </div>
                            <div id="danxuan" >
                                <ul>
                                    <?foreach ($v['question'] as $q):?>
                                        <?if($q['type']==1):?>
                                            <?if($rop=="edit"):?>
                                                <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
                                                    <br> <span>第<?=$q['RowNum']?>题</span>
                                                    <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                                    <span><?=$q['questionselect']?></span>
                                                    <?for ($i=1;$i<=$q['questionselectnumber'];$i++):?>
                                                        <?if($i==1):?>
                                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="A" <?=$q['u_answer']=='A'?'checked':''?>/>A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==2):?>
                                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="B" <?=$q['u_answer']=='B'?'checked':''?> />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==3):?>
                                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="C" <?=$q['u_answer']=='C'?'checked':''?> />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==4):?>
                                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="D" <?=$q['u_answer']=='D'?'checked':''?> />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==5):?>
                                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="E" <?=$q['u_answer']=='E'?'checked':''?> />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==6):?>
                                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="F" <?=$q['u_answer']=='F'?'checked':''?> />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==7):?>
                                                            <label ><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="G" <?=$q['u_answer']=='G'?'checked':''?> />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?endif?>
                                                    <?endfor;?>
                                                    <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                                        <div class="anNum">
                                                            <ul>
                                                                <?foreach ($q['capquestion'] as $c):?>
                                                                    <?if($rop=="edit"):?>
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
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
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
                                                                            <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="A" <?=$c['u_answer']=='A'?'checked':''?>/>A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==2):?>
                                                                            <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="B" <?=$c['u_answer']=='B'?'checked':''?> />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==3):?>
                                                                            <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="C" <?=$c['u_answer']=='C'?'checked':''?> />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==4):?>
                                                                            <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="D" <?=$c['u_answer']=='D'?'checked':''?> />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==5):?>
                                                                            <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="E" <?=$c['u_answer']=='E'?'checked':''?> />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==6):?>
                                                                            <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="F" <?=$c['u_answer']=='F'?'checked':''?> />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==7):?>
                                                                            <label ><input type="radio" name="vAnswer[<?=$c['questionid']?>]" rel="" value="G" <?=$c['u_answer']=='G'?'checked':''?> />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?endif?>
                                                                    <?endfor;?>
                                                                </li>
                                                            <?endforeach;?>
                                                        </ul>
                                                    <?endif;?>
                                                </li>
                                            <?else:?>
                                                <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
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
                                                                </li>
                                                            <?endforeach;?>
                                                        </ul>
                                                    <?endif;?>
                                                </li>
                                            <?endif?>
                                        <?elseif ($q['type']==2):?>
                                            <?if($rop=="edit"):?>
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
                                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="A" <?if(strpos($u_Answer,'A') !== false):?>checked="checked"<?endif;?> />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==2):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="B" <?if(strpos($u_Answer,'B') !== false):?>checked="checked"<?endif;?> />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==3):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="C" <?if(strpos($u_Answer,'C') !== false):?>checked="checked"<?endif;?> />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==4):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="D" <?if(strpos($u_Answer,'D') !== false):?>checked="checked"<?endif;?> />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==5):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="E" <?if(strpos($u_Answer,'E') !== false):?>checked="checked"<?endif;?> />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==6):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="F" <?if(strpos($u_Answer,'F') !== false):?>checked="checked"<?endif;?> />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?elseif($i==7):?>
                                                            <label ><input type="checkbox" name="vAnswer[<?=$q['questionid']?>][<?=$i?>]" rel="" value="G" <?if(strpos($u_Answer,'G') !== false):?>checked="checked"<?endif;?> />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?endif?>
                                                    <?endfor;?>
                                                    <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                                        <div class="anNum">
                                                            <ul>
                                                                <?foreach ($q['capquestion'] as $c):?>
                                                                    <?if($rop=="edit"):?>
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
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
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
                                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="A" <?if(strpos($u_Answer,'A') !== false):?>checked="checked"<?endif;?> />A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==2):?>
                                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="B" <?if(strpos($u_Answer,'B') !== false):?>checked="checked"<?endif;?> />B</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==3):?>
                                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="C" <?if(strpos($u_Answer,'C') !== false):?>checked="checked"<?endif;?> />C</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==4):?>
                                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="D" <?if(strpos($u_Answer,'D') !== false):?>checked="checked"<?endif;?> />D</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==5):?>
                                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="E" <?if(strpos($u_Answer,'E') !== false):?>checked="checked"<?endif;?> />E</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==6):?>
                                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="F" <?if(strpos($u_Answer,'F') !== false):?>checked="checked"<?endif;?> />F</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?elseif($i==7):?>
                                                                            <label ><input type="checkbox" name="vAnswer[<?=$c['questionid']?>][<?=$i?>]" rel="" value="G" <?if(strpos($u_Answer,'G') !== false):?>checked="checked"<?endif;?> />G</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <?endif?>
                                                                    <?endfor;?>
                                                                </li>
                                                            <?endforeach;?>
                                                        </ul>
                                                    <?endif;?>
                                                </li>
                                            <?else:?>
                                                <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
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
                                                                </li>
                                                            <?endforeach;?>
                                                        </ul>
                                                    <?endif;?>
                                                </li>
                                            <?endif?>
                                        <?elseif ($q['type']==3 || $q['type']==4):?>
                                            <?if($rop=="edit"):?>
                                                <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
                                                    <br> <span>第<?=$q['RowNum']?>题</span>
                                                    <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                                    <?if($q['questioncap']<>'1'):?>
                                                    <textarea  id="vAnswer<?=$q['questionid']?>" name="vAnswer[<?=$q['questionid']?>]"  cols="" rows=""
                                                               style="resize:none;display: none;">
                                                       <?=$q['u_answer']?>
                                                        </textarea>
                                                    <?endif;?>
                                                    <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                                        <div class="anNum">
                                                            <ul>
                                                                <?foreach ($q['capquestion'] as $c):?>
                                                                    <?if($rop=="edit"):?>
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
                                                                    <?else:?>
                                                                        <li ><a href="#qu_<?=$c['questionid']?>"><?=$c['RowNum']?></a></li>
                                                                    <?endif;?>
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
                                                                        <?=$c['u_answer']?>
                                                                     </textarea>
                                                                </li>
                                                            <?endforeach;?>
                                                        </ul>
                                                    <?endif;?>
                                                </li>
                                            <?else:?>
                                                <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent"<?endif;?> id="qu_<?=$q['questionid']?>">
                                                    <br> <span>第<?=$q['RowNum']?>题</span>
                                                    <span><?=substr($q['question'],3,strlen($q['question'])-3); ?></span>
                                                    <?if($q['questioncap']<>'1'):?>
                                                    <textarea  id="vAnswer<?=$q['questionid']?>" name="vAnswer[<?=$q['questionid']?>]"  cols="" rows=""
                                                               style="resize:none;display: none;">
                                                          </textarea>
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
                                                            <?endforeach;?>
                                                        </ul>
                                                    <?endif;?>
                                                </li>
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




<!-- 检查  -->
<div class="anJCha">
    <div class="anJChaCen">
        <div class="anJcTit">检查<img src="assets/images/icon_close.png" /></div>
        <div class="anJcCen">
            <h1>共有试题 <span class="allquestionnumber">50</span> 题，已做 <span class="yesdonumber">0</span> 题。您确认要交卷吗？</h1>
            <div class="anJcTxt">
                <p>当前账号：<?=yii::$app->session['studentuser']['username']?></p>
            </div>
            <div class="anJcBtn">
                <div class="anJcBtnA">取消</div>
                <div class="anJcBtnB " onclick="check()">确定</div>
            </div>
        </div>
    </div>
</div>


<!-- 交卷  -->
<div class="anQuan">
    <div class="anJChaCen">
        <div class="anJcTit">选择阅卷方式<img src="assets/images/icon_close.png" /></div>
        <div class="anJcCen">
            <div class="anQuanRadio">
                    <ul>
                        <li class="anQuanActive">
                            <img src="assets/images/icon_Select.png" />
                            <p>自评分</p>
                            <input type="radio" name="vGrade" id="anRadio" value="1" checked="checked" />
                        </li>
                        <li>
                            <img src="assets/images/icon_Unselected.png" />
                            <p>他人阅卷</p>
                            <input type="radio" name="vGrade" id="anRadio" value="2" />
                        </li>
                    </ul>
            </div>
            <div class="anJcTxt" id="anJcTxt">
                <p></p>
            </div>
            <div class="anJcTxt">
                <p>本试卷里存在主观题(填空题、文字题等)，选择【自评分】方式后，你可以通过与参考答案的对比，自己估算和评价该部分试题的得分。而试卷里的客观题（选择题），则仍然由系统自动阅卷和评分</p>
            </div>
            <div class="anJcBtn">
                <div class="anJcBtnA">取消</div>
                <div class="anJcBtnB anJcBao" onclick="artSave('dialogForm')">确定</div>
            </div>
        </div>
    </div>
</div>

<!-- 交卷确定提示  -->
<div class="anTs">
    <div class="anJChaCen">
        <div class="anJcTit">提示</div>
        <div class="anJcCen">
            <div class="anTsFlex">
                <img src="assets/images/icon_Success.png" />
                <p></p>
            </div>
            <div class="anJcBtn">
                <div class="anJcBtnB anTsBtn" ><a href=""></a></div>
            </div>
        </div>
    </div>
</div>
<!-- 临时保存  -->
<div class="anLs">
    <div class="anJChaCen">
        <div class="anJcTit">提示</div>
        <input type="hidden" value="1" name="vEhStatus" id="vEhStatus">
        <div class="anJcCen">
            <div class="anTsFlex">
                <p>临时保存成功，可前往【我的答卷】进行继续答题</p>
            </div>
            <div class="anJcBtn">
                <div class="anJcBtnB anTsBtn" onclick="artSave('dialogForm')">确定</div>
            </div>
        </div>
    </div>
</div>

</form>

<script type="text/javascript">
    fieldsCheck=new FieldsCheck();
    $(function() {
       // $('.ptDla dl dd').eq(0).show().siblings().hide();
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
        })


        //交卷显示
        $('.anBlast').click(function(){
            $("#vEhStatus").val("1");
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
            var checked=false;
            var examId = $(this).closest('li').attr('id'); // 得到题目ID
         //   console.log($(this).parent().parent().find("input").length);
            $(this).parent().parent().find("input").each(function () {
                if($(this).is(":checked")){
                    checked=true;
                }
            })
            if(!checked){
                var cardLi = $('a[href=#' + examId + ']'); // 根据题目ID找到对应答题卡
                // 设置已答题
                if(cardLi.parent().hasClass('NumActive')){
                    cardLi.parent().removeClass('NumActive');
                    $('.yesdonumber').html($(".NumActive").length);
                }
            }else{
                var cardLi = $('a[href=#' + examId + ']'); // 根据题目ID找到对应答题卡
                // 设置已答题
                if(!cardLi.parent().hasClass('NumActive')){
                    cardLi.parent().addClass('NumActive');
                    $('.yesdonumber').html($(".NumActive").length);
                }
            }
         });


        $('.allquestionnumber').html($('.paperexamcontent').length);
        $('.yesdonumber').html($(".NumActive").length);
    });
    // $(document).on('change','li div .view',function(){
    //     console.log("1111");
    // })
    // $('li div').bind('div propertychange', function(){
    //     console.log("1111");
    // });
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
    ue<?=$q['questionid']?>.addListener("contentChange", function () {
        var content=ue<?=$q['questionid']?>.getContent();
        var cardLi = $('a[href=#qu_<?=$q['questionid']?>]'); // 根据题目ID找到对应答题卡
        if(content!=null && content.length!=0){
            // 设置已答题
            if(!cardLi.parent().hasClass('NumActive')){
                cardLi.parent().addClass('NumActive');
                $('.yesdonumber').html($(".NumActive").length);
            }
        }else if(content.length==0){
            if(cardLi.parent().hasClass('NumActive')){
                cardLi.parent().removeClass('NumActive');
                $('.yesdonumber').html($(".NumActive").length);
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
        initialFrameWidth: '55%',
        initialFrameHeight: '200',
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
    ue<?=$c['questionid']?>.addListener("contentChange", function () {
        var content=ue<?=$c['questionid']?>.getContent();
        var cardLi = $('a[href=#qu_<?=$c['questionid']?>]'); // 根据题目ID找到对应答题卡
        if(content!=null && content.length!=0){
            // 设置已答题
            if(!cardLi.parent().hasClass('NumActive')){
                cardLi.parent().addClass('NumActive');
                $('.yesdonumber').html($(".NumActive").length);
            }
        }else if(content.length==0){
            if(cardLi.parent().hasClass('NumActive')){
                cardLi.parent().removeClass('NumActive');
                $('.yesdonumber').html($(".NumActive").length);
            }
        }

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
                    $('.anJcTit img, .anJcBtnA').remove();
                    $("#anJcTxt p").html("考试时间到，请选择阅卷方式后 点击【确定】！")
                    $(".anBlast").click();
            }
        }
            setting.lefttime = parseInt(data);
            countdown(setting);
    });
    function check() {
        $('.anJCha').fadeOut();
        $('.anQuan').fadeIn();
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
            dataType:'json',
            success: function(result){
                //返回提示信息
                if(typeof result.code!='undefined' && '[0000]'==result.code){
                    var ehid=result.ehid;
                    if($("#vEhStatus").val()==2){
                        $("input[name='vEhId']").val(ehid);
                        $('.anLs').fadeOut();
                    }else{
                        if($("input[name='vGrade']:checked").val()==1){
                            $('.anQuan').fadeOut();
                            $('.anTs .anJcBtn').find('a').attr('href','?r=student/myexam/createhead&c1='+ehid+'&_k=<?=$rk?>');
                            $('.anTs .anTsFlex').find('p').html("交卷成功");
                            $('.anTs .anJcBtn').find('a').text("自评分阅卷");
                            $('.anTs').fadeIn();
                        }else{
                            $('.anQuan').fadeOut();
                            $('.anTs .anJcBtn').find('a').attr('href','?r=student/myexam');
                            $('.anTs .anTsFlex').find('p').html("交卷成功<br/>已指派专人批阅，请耐心等待阅卷结果<br/>并登陆【我的答卷】查看答案及成绩");
                            $('.anTs .anJcBtn').find('a').text("他人阅卷");
                            $('.anTs').fadeIn();
                        }
                    }
                   // history.back(-1);
                    //跳轉分頁
                    // findHead(1);
                }else{
                    showalert(result,'<?=langs::getTxt('infotitle')?>');
                }
            },
            error:function(){
                showMessage('<?=langs::getTxt('neterror')?>',2,'<?=langs::getTxt('infotitle')?>');
            }
        });
    }

</script>