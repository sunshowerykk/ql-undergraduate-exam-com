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
                <h1><b><?=$v['typenum']?>、<?=$v['typename']?></b></h1>
                <?foreach ($v['question'] as $q):?>
                    <?if($q['type']==1):?>
                        <?if($rop=="edit"):?>
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
                                                <label id=""><input type="radio" name="vAnswer[<?=$q['questionid']?>]" rel="" value="A" <?=$q['u_answer']=='A'?'checked':''?>/>A</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                    </dd>
                                </dl>
                            </li>
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
                                            </dd>
                                        </dl>
                                    </li>
                             <?endforeach;?>
                            <?endif;?>
                        <?else:?>
                            <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent" <?endif;?> >
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
                                </dl>
                            </li>
                        <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                 <?foreach ($q['capquestion'] as $c):?>
                                    <li <?if($c['questioncap']<>'1'):?>class="paperexamcontent" <?endif;?> >
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
                                        </dl>
                                    </li>
                                 <?endforeach;?>
                            <?endif;?>
                        <?endif?>
                    <?elseif ($q['type']==2):?>
                        <?if($rop=="edit"):?>
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
                                    </dd>
                                </dl>
                            </li>
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
                                            </dd>
                                        </dl>
                                    </li>
                                <?endforeach;?>
                            <?endif;?>
                        <?else:?>
                            <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent" <?endif;?> >
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
                                </dl>
                            </li>
                        <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                <?foreach ($q['capquestion'] as $c):?>
                                    <li <?if($c['questioncap']<>'1'):?>class="paperexamcontent" <?endif;?> >
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
                                        </dl>
                                    </li>
                                <?endforeach;?>
                            <?endif;?>
                        <?endif;?>
                    <?elseif ($q['type']==3 || $q['type']==4):?>
                        <?if($rop=="edit"):?>
                            <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty(trim($q['u_answer']))):?>NumActivePhone<?endif;?>" <?endif;?> >
                                <hgroup>
                                        <h6>第<?=$q['RowNum']?>题.<?=$q['question']?></h6>
                                </hgroup>
                                <section class="yuTian">
                                    <textarea  id="vAnswer<?=$q['questionid']?>" name="vAnswer[<?=$q['questionid']?>]"  cols="" rows=""
                                               style="resize:none;display: none;">
                                        <?=$q['u_answer']?>
                                    </textarea>
                                </section>
                            </li>
                        <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                <?foreach ($q['capquestion'] as $c):?>
                                    <li <?if($c['questioncap']<>'1'):?>class="paperexamcontent <?if( !empty(trim($c['u_answer']))):?>NumActivePhone<?endif;?>" <?endif;?> >
                                        <hgroup>
                                            <h6>第<?=$c['RowNum']?>小题.<?=$c['question']?></h6>
                                        </hgroup>
                                        <section class="yuTian">
                                    <textarea  id="vAnswer<?=$c['questionid']?>" name="vAnswer[<?=$c['questionid']?>]"  cols="" rows=""
                                               style="resize:none;display: none;">
                                        <?=$c['u_answer']?>
                                    </textarea>
                                        </section>
                                    </li>
                                <?endforeach;?>
                            <?endif;?>
                        <?else:?>
                            <li <?if($q['questioncap']<>'1'):?>class="paperexamcontent" <?endif;?> >
                                <hgroup>
                                        <h6>第<?=$q['RowNum']?>题.<?=$q['question']?></h6>
                                </hgroup>
                                <section class="yuTian">
                                    <textarea  id="vAnswer<?=$q['questionid']?>" name="vAnswer[<?=$q['questionid']?>]"  cols="" rows=""
                                               style="resize:none;display: none;">
                                    </textarea>
                                </section>
                            </li>
                        <?if($q['questioncap']=='1' && !empty($q['capquestion'])):?>
                                <?foreach ($q['capquestion'] as $c):?>
                                    <li <?if($c['questioncap']<>'1'):?>class="paperexamcontent" <?endif;?> >
                                        <hgroup>
                                                <h6>第<?=$c['RowNum']?>小题.<?=$c['question']?></h6>
                                        </hgroup>
                                        <section class="yuTian">
                                    <textarea  id="vAnswer<?=$c['questionid']?>" name="vAnswer[<?=$c['questionid']?>]"  cols="" rows=""
                                               style="resize:none;display: none;">
                                    </textarea>
                                        </section>
                                    </li>
                                <?endforeach;?>
                            <?endif;?>
                        <?endif?>
                    <?endif;?>
                <?endforeach;?>
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
            <figure class="teacFq" onclick="anLs();">
                <i></i>
                <figcaption>临时保存</figcaption>
            </figure>
            <figure class="anBlast">
                <i></i>
                <figcaption>交卷</figcaption>
            </figure>
        </div>
    </section>
    <!--放弃阅卷弹窗-->
    <section class="teacFqPop anJCha">
        <div class="teacPCen">
            <h6>提示</h6>
            <hgroup>
                <p>共有试题 <span class="allquestionnumber">50</span> 题，已做 <span class="yesdonumber">0</span> 题。您确认要交卷吗？</p>
            </hgroup>
            <div class="teacBtn">
                <button type="button" class="teacBtna">取消</button>
                <button type="button" onclick="check()">确定</button>
            </div>
        </div>
    </section>
    <section class="teacFqPop anALert">
        <input type="hidden" value="1" name="vEhStatus" id="vEhStatus">
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
    <!--<!--交卷弹窗-->-->
    <section class="teacFqPop anQuan">
        <div class="teacPCen">
            <h6>提示</h6>
            <div class="ptJq">
                <figure class="radio1">
                    <img src="assets/images/icon_Select.png" />
                    <figcaption>自阅卷</figcaption>
                </figure>
                <figure class="radio2">
                    <img src="assets/images/icon_Unselected.png" />
                    <figcaption>他人阅卷</figcaption>
                </figure>
                <input type="hidden" name="vGrade" id="anRadio" value="1" />
            </div>
            <hgroup>
                <p>本试卷里存在主观题(填空题、文字题等)，选择【自评分】方式后，你可以通过与参考答案的对比，自己估算和评价该部分试题的得分。而试卷里的客观题（选择题），则仍然由系统自动阅卷和评分。</p>
            </hgroup>
            <div class="teacBtn">
                <button type="button" class="teacBtna">取消</button>
                <button type="button" onclick="artSave('dialogForm')">确定</button>
            </div>
        </div>
    </section>
</form>
<script type="text/javascript">
    fieldsCheck=new FieldsCheck();
    $(function() {
        $('.ptDla dl dd').eq(0).show().siblings().hide();
        //检查弹窗
        $('.anJc').click(function(){
            $('.anJCha').fadeIn();
        })
        // //检查弹窗隐藏
        $('.anJCha .teacBtn .teacBtna').click(function(){
            $('.anJCha').fadeOut();
        })
        $('.anQuan .teacBtn .teacBtna').click(function(){
            $('.anQuan').fadeOut();
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
            $("#vEhStatus").val('1');
        })
        //单选
        $('.radio1 img').click(function(){
            if($(this).attr('src')=='assets/images/icon_Unselected.png'){
                $(this).attr('src','assets/images/icon_Select.png');
                $('.radio2 img').attr('src','assets/images/icon_Unselected.png');
                $('#anRadio').val('1')
                // $(this).find('p').css('color','#db2c1b');
                // $(this).find('input').val('1');
                // sibling.find('p').css('color','#333333');
            }
        })
        $('.radio2 img').click(function(){
            if($(this).attr('src')=='assets/images/icon_Unselected.png'){
                $(this).attr('src','assets/images/icon_Select.png');
                $('.radio1 img').attr('src','assets/images/icon_Unselected.png');
                $('#anRadio').val('2')
                // $(this).find('p').css('color','#db2c1b');
                // $(this).find('input').val('1');
                // sibling.find('p').css('color','#333333');
            }
        })

        $('li dd input').click(function() {
            // debugger;
            var checked=false;
           // var examId = $(this).closest('li').attr('id'); // 得到题目ID
            //   console.log($(this).parent().parent().find("input").length);
          //  console.log($(this).parent().parent().parent().parent().find("input").length);
            $(this).parent().parent().parent().parent().find("input").each(function () {
                if($(this).is(":checked")){
                    checked=true;
                }
            })
            if(!checked){
                if(!$(this).hasClass('NumActivePhone')){
                    $(this).parent().parent().parent().parent().removeClass('NumActivePhone');
                    $('.yesdonumber').html($(".NumActivePhone").length);
                }
            }else{
                if(!$(this).hasClass('NumActivePhone')){
                    $(this).parent().parent().parent().parent().addClass('NumActivePhone');
                    $('.yesdonumber').html($(".NumActivePhone").length);
                }
            }
        });
        $('.allquestionnumber').html($('.paperexamcontent').length);
        $('.yesdonumber').html($(".NumActivePhone").length);
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
                $('.teacBtn .teacBtna').remove();
                $(".anQuan p").html("考试时间到，请选择阅卷方式后 点击【确定】！")
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
    function anLs() {
        $("#vEhStatus").val('2');
        $('.anALert').fadeIn();
        $(".anALert p").html("临时保存成功，点击【确定】继续考试。退出后可以在我的答卷中继续考试！")
        artSave('dialogForm');
        $('.anALert .teacBtn button').click(function(){
            $('.anALert').fadeOut();
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
            dataType:'json',
            success: function(result){
                //返回提示信息
                if(typeof result.code!='undefined' && '[0000]'==result.code){
                    var ehid=result.ehid;
                    if($("#vEhStatus").val()==2){
                        $("input[name='vEhId']").val(ehid);
                    }else {
                        if ($("#anRadio").val() == 1) {
                            $('.anQuan').fadeOut();
                            $(".anALert p").html("【自评分阅卷】交卷成功，点击【确定】进行自评分！")
                            $('.anALert').fadeIn();
                            $('.anALert .teacBtn button').click(function () {
                                window.location.href = "?r=student/myexam/createhead&c1=" + ehid + "&_k=<?=$rk?>";
                            })
                        } else {
                            $('.anQuan').fadeOut();
                            $(".anALert p").html("【交卷成功】<br/>已指派专人批阅，请耐心等待阅卷结果<br/>并登陆【我的答卷】查看答案及成绩！")
                            $('.anALert').fadeIn();
                            $('.anALert .teacBtn button').click(function () {
                                window.location.href = "?r=student/myexam";
                            })
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