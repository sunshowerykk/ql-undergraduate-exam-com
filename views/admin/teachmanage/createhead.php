<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::cssFile('assets/css/public.css?r='.time());
echo Html::jsFile('assets/js/plupload.full.min.js');  //图片上userFlag传js
echo Html::cssFile('assets/css/common.css');  //图片上传js
echo Html::cssFile('assets/css/style.css');  //图片上传css
echo Html::cssFile('assets/zTree/css/zTreeStyle/zTreeStyle.css?r='.time());
echo Html::jsFile('assets/zTree/js/jquery.ztree.core-3.5.js');     //zTree插件
echo Html::jsFile('assets/zTree/js/jquery.ztree.excheck-3.5.js');     //zTree插件多選
?>
<div class="contentRight">
    <div class="homeTit">阅卷人管理 / 新增阅卷人</div>
    <div class="homeCen addCen">
        <!-- 顶部搜索 -->
        <div class="homeCen addCen">
            <!-- 顶部搜索 -->
            <div class="homeCenTop adminAdd adTwoAdd">
                <form action="?r=admin/teachmanage/savehead" method="post" id="dialogForm" >
                    <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                    <input type='hidden' name='_k' value='<?=$rk?>' />
                    <input type='hidden' name='vP' value='<?=$rp?>' />
                    <input type='hidden' name='vCID' value='<?=$CID?>' />
                    <input type='hidden' name='vId' value='<?=pub::chkData($r_data,'id','')?>' />
                    <ul class="ptshiUl">
                    <!--    <li>
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;科目</label>
                            <div class="homeSele">
                                <input type="text" name="vSubject" value="<?=pub::chkData($r_data,'subname','')?>" placeholder="选择科目" data-chk='科目名称' readonly="readonly"/>
                                <input type="hidden" name="vExamsubId" value="<?=pub::chkData($r_data,'subid','')?>"/>
                            </div>
                            <a href="javascript:void(0)" title="选择科目名称" style="text-decoration:none;"
                               class="s-ib s-call ptTr"
                               data-url="?r=admin/classmanage/indexsection"
                               data-id="dialogHotel"
                               data-title="选择科目"
                               onclick="loadSection01.fire(this);" >调入
                            </a>
                            <a href="javascript:void(0)" title="清空" style="margin:0 2px;"
                               class="s-ib s-clear ptTr"
                               onclick="loadSection01.clear();">
                            </a>
                        </li> -->
                        <li>
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;科目</label>
                            <div class="homeSele homeSelePt">
                                <input placeholder="选择科目"   class="c-set input-sm c-tab" id="vSubject" name="vSubject" value="<?= pub::chkData($r_data, 'SubName', "") ?>"
                                       style="width:400px;resize:none;" data-chk='科目'
                                       readonly="readonly" />
                                <input type="hidden" name="vExamsubId" id="vExamsubId"
                                       value="<?= pub::chkData($r_data, 'SubId', "") ?>"/>
                            </div>
                            <a href="javascript:void(0)" title="选择科目"
                               class="s-ib s-call ptTr"
                               onclick="loadClass('vSubject','vExamsubId','<?= Yii::$app->request->csrfToken ?>');return false;">调入</a>

                            <a class="s-ib s-clear ptTr" href="javascript:void(0)" class="s-ib s-clear" title="清空选择" onclick="cleartext();"></a>
                        </li>
                        <li>
                            <label>课程</label>
                            <div class="homeSele">
                                <input type="text" name="vClass" id="vClass" placeholder="选择课程" value="<?=pub::chkData($r_data,'CourseName','')?>" data-chk='课程名称' readonly="readonly"/>
                                <input type="hidden" name="vExamcourseid" id="vExamcourseid" value="<?=pub::chkData($r_data,'CourseId','')?>"/>
                            </div>
                        </li>
                        <li>
                            <label>节次</label>
                            <div class="homeSele">
                                <input type="text" name="vSection" id="vSection" placeholder="选择节次" data-chk='节次名称' value="<?=pub::chkData($r_data,'SectionName','')?>" readonly="readonly"/>
                                <input type="hidden" name="vExamsectionid" id="vExamsectionid" value="<?=pub::chkData($r_data,'SectionId','')?>"/>
                            </div>
                        </li>
                        <li>
                            <label>手机号码</label>
                            <div class="homeSele">
                                <input type="text" class="c-i" name="vPhone" value="<?=pub::chkData($r_data,'Phone','')?>" data-chk='手机号码' placeholder="输入手机号码"/>
                            </div>
                        </li>

                        <li style="margin-left: 0px;">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名</label>
                            <div class="homeSele">
                                <input type="text" class="c-set" name="vUserName" value="<?=pub::chkData($r_data,'UserName','')?>" data-chk='姓名' placeholder="输入姓名"/>
                            </div>
                        </li>
                        <li>
                            <label>密码</label>
                            <div class="homeSele">
                                <input type="password" class="c-set" name="vPassWord1" value="" placeholder="输入密码" data-chk='密码'/>
                            </div>
                        </li>
                        <li>
                            <label>确认密码</label>
                            <div class="homeSele" >
                                <input type="password" class="c-set" name="vPassWord2" value="" placeholder="确认密码" data-chk='请再次输入'/>
                            </div>
                        </li>
                    </ul>
                    <div class="adminSc ">
                        <div class="adSc" id="btn">
                            上传照片
                        </div>
                        <ul id="ul_pics" class="ul_pics clearfix ptshiSc"></ul>
                        <?if($rop=='edit' && !empty($r_data['FileId'])):?>
                                <li style="list-style-type:none;">
                                    <div style=" float:left; display:inline" id="img<?=$r_data['FileId']?>">
                                        <img style="width:140px;height:120px;"  src='<?=$r_data['FilePath']?>'/>
                                        <i onclick=delimg('<?=$r_data['FileId']?>');>
                                            <img  title="删除图片" src='assets/img/access_disallow.gif'/>
                                        </i>
                                        <input type='hidden' id='vSrc<?=$r_data['FileId']?>' value='<?=$r_data['FilePath']?>'>
                                    </div>
                                </li>
                        <?endif;?>
                    </div>
                    <div class="adminSc adminTe">
                        <div class="adminTeDiv">
                            <label>教师介绍</label>
                            <textarea class="homeSele" name="vContent">
                                <?=pub::chkData($r_data,'UserInfo','')?>
                            </textarea>
                        </div>
                        <div class="adPopBtn">
                            <button type="button" onclick="artSave('dialogForm')">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cleartext(){
        $("#vExamsubId").val("");
        $("#vSubject").val("");
        $("#vExamcourseid").val("");
        $("#vClass").val("");
        $("#vSection").val("");
        $("#vExamsectionid").val("");
    }
    fieldsCheck=new FieldsCheck();
    fieldsCheck.setFormat('c-s-15',"\\S{0,15}");
    fieldsCheck.setFormat('c-s-20',"\\S{0,20}");
    fieldsCheck.setFormat('c-s-30',"\\S{0,30}");
    fieldsCheck.setFormat('c-s-50',"\\S{0,50}");
    fieldsCheck.setFormat('c-s-100',"\\S{0,100}");
    fieldsCheck.setFormat('c-i-30',"\\d{0,30}");
    fieldsCheck.setFormat('c-f-2',"\\d+\\.?\\d{0,3}");//0-3位小数
    fieldsCheck.keyFire();
    function artSave(formid){
        var msg=fieldsCheck.checkMsg('#'+formid);
        if(msg.length>0){      //返回的數組大於0的時候則有錯誤
            var al=msg.join('<br>');    //直接用br鏈接返回錯誤
            showalert(al,'<?=langs::getTxt('infotitle')?>');
            return false;
        }
        $("#"+formid).ajaxSubmit({
            async: false, //同步提交，不对返回值做判断，设置true
            success: function(result){
                //返回提示信息
                if (/\[0000\]/i.test(result)){
                    showMessage('<?=langs::getTxt('saveOK')?>',2,'<??>');
                    history.back(-1);
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

    //图片封面上传
    var uploader = new plupload.Uploader({ //创建实例的构造方法
        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
        browse_button: 'btn', // 上传按钮
        url: '/?r=admin/teachmanage/uphead&c1=<?=$CID?>', //远程上传地址
        flash_swf_url: 'assets/plupload/Moxie.swf', //flash文件地址
        silverlight_xap_url: 'assets/plupload/Moxie.xap', //silverlight文件地址
        filters: {
            max_file_size: '2000kb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
            mime_types: [ //允许文件上传类型
                {
                    title: "files",
                    extensions: "jpg,png,gif,ico"
                }
            ]
        },
        multi_selection: false, //true:ctrl多文件上传, false 单文件上传
        init: {
            FilesAdded: function(up, files) { //文件上传前
                if ($("#ul_pics").children("li").length ==1) {
                    alert("您上传的图片太多了！");
                    uploader.destroy();
                } else {
                    var li = '';
                    plupload.each(files, function(file) { //遍历文件
                        li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                    });
                    $("#ul_pics").append(li);
                    uploader.start();
                }
            },
            UploadProgress: function(up, file) { //上传中，显示进度条
                var percent = file.percent;
                $("#" + file.id).find('.bar').css({
                    "width": percent + "%"
                });
                $("#" + file.id).find(".percent").text(percent + "%");
            },
            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                var data = eval("(" + info.response + ")");
                $("#" + file.id).html("<div class='img' id='img" + data.uid + "'><img src='" + data.pic + "'/><i onclick=delimg('" + data.uid + "');><img src='assets/img/access_disallow.gif'/></i><input type='hidden' id='vSrc" + data.uid + "' value='"+ data.pic +"'></div>");
            },
            Error: function(up, err) { //上传出错的时候触发
                alert(err.message);
            }
        }
    });
    uploader.init();

    function delimg(uid) {//删除图片
        var src = $("#vSrc"+uid).val();
        var t ='img'+uid;
        $.ajax({
            url: '?r=admin/teachmanage/deluphead',
            type: 'post',
            data: {"src": src,"uid":uid},
            dataType:'json',
            success: function (data) {
                if (data == 1) {
                    $("#"+t).parent().remove();
                }
            }
        });
    }
    //选择标签
    function loadClass(rname, rid, csrf) {
        var er = dialog();//等待提醒
        er.show();
        var d = dialog({ //彈出框
            title: '科目选择',
            id: 'loadtitle',
            lock: true
        });
        // jQuery ajax
        var url = '?r=admin/teachmanage/findtitle';
        var ridval = encodeURIComponent($('#' + rid).val());
        $.ajax({
            cache: false, timeout: 3000,
            type: 'post',
            data: 'rid=' + rid +
                '&rname=' + rname +
                '&ridval=' + ridval +
                '&_csrf=' + csrf,
            url: url,
            success: function (data) {
                d.content(data);
                er.close().remove();//關閉等待提醒窗口
                //d.focus();
                d.showModal();
                renderChecked();
            },
            error: function (data) {
                var er = dialog({
                    content: '讀取數據失敗，請重試！'
                });
                er.show();
                setTimeout(function () {
                    er.close().remove();
                }, 2000);
            },
            beforeSend: function (data) {
            }
        });
    }//end of loadClass

    function renderChecked(){
        var id1=$('#vExamcourseid').val(),
            id2=$('#vExamsectionid').val(),
            id3=$('#vExamsubId').val(),
            arr=id1.split(",").concat(id2.split(','),id3.split(','));
       // console.log(arr);
        var treeObj = $.fn.zTree.getZTreeObj('fLeft'),obj='';

        for(var i=0;i<arr.length;i++){
            if(arr[i]!=''){
                obj=treeObj.getNodeByParam("id", arr[i], null);
                if(obj!=null)
                    treeObj.checkNode(obj,true,false);
            }
        }
    }//end of renderChecked
</script>