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
    <div class="homeTwo ">
        <div class=" sheeteHead">
            <div class="anHeadLeft">
                <h6><?=$exam_data['examname']?></h6>
                <p>科目：<?=$exam_data['examsubname']?><br />
                    课程：<?=$exam_data['examcoursename']?><br />
                    节次：<?=$exam_data['examcoursesectionname']?><br />
                    试卷总分：<?=$exam_data['examscore']?><br />
                    答题时间：<?=$exam_data['examtime']?></p>
            </div>
            <div class="anHeadLeft sheeteCen">
                <h6>阅卷卡</h6>
                <p>考生姓名：<?=$eh_data['username']?><br />
                    交卷时间：<?=date('Y-m-d H:i:s',$eh_data['ehendtime'])?><br />
                    考试用时： <?
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
                    ?><br />
                    考试得分：<span><?=$eh_data['ehscore']?>分</span>（总分<?=$exam_data['examscore']?>）</p>
            </div>
            <div class="sheeteRight">
                <a href="?r=student/myexam/errorhead&c1=<?=pub::chkData($eh_data,'ehid')?>&_k=<?=$rk?>"><i></i>错题本</a>
                <a href="?r=student/myexam">返回我的答卷</a>
            </div>
        </div>
    </div>

    <!-- 选项卡开始 -->
    <div class="anTab">
        <div class="anTabHead">
            <ul>
                <?foreach ($t_data as $key=>$v):?>
                    <?if($key==0):?>
                        <li class="anActive" ><a href="#ti_<?=$v['typeid']?>"><b><?=$v['typenum']?>、<?=$v['typename']?></b></a></li>
                    <?else:?>
                        <li ><a href="#ti_<?=$v['typeid']?>"><?=$v['typenum']?>、<?=$v['typename']?></a></li>
                    <?endif;?>
                <?endforeach;?>
            </ul>
        </div>
        <!--选项卡-->
            <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <input type='hidden' name='_k' value='<?=$rk?>' />
            <input type='hidden' name='vP' value='<?=$rp?>' />
            <input type='hidden' name='vEhId' value='<?=pub::chkData($eh_data,'ehid')?>' />
        <div class="ptDla">
            <dl>
                <?foreach ($question_data as $v):?>
                    <dd class="anNumA"><span id="ti_<?=$v['typeid']?>"><?=$v['typenum']?>、<?=$v['typename']?>（<?=$v['typeinfo']?>）</span>
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
                                            <span><?=$q['question']?></span>
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
                                                    <?elseif ($q['u_answer']<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                                        <span style="color: red"><?=$q['u_answer']?></span>
                                                    <?else:?>
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
                                                                <?elseif ($c['u_answer']<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                                    <span style="color: red"><?=$c['u_answer']?></span>
                                                                <?else:?>
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
                                                    <?elseif ($u_Answer<>$q['questionanswer'] && $q['u_answer']!=""):?>
                                                        <span style="color: red"><?=$u_Answer?></span>
                                                    <?else:?>
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
                                                                <?elseif ($u_Answer<>$c['questionanswer'] && $c['u_answer']!=""):?>
                                                                    <span style="color: red"><?=$u_Answer?></span>
                                                                <?else:?>
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
                                                <br/><span>评分：<span><?=$q['t_score']?></span></span>
                                                <br/><span>评语：<span><?=$q['t_content']?></span>
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
                                                            <br/><span>评分：<span><?=$c['t_score']?></span></span>
                                                            <br/><span>评语：<span><?=$c['t_content']?></span>
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
</script>