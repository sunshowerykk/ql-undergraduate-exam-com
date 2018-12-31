<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
echo Html::cssFile('assets/css/common.css');  //图片上传js
echo Html::cssFile('assets/css/style.css');  //图片上传css
echo Html::cssFile('assets/zTree/css/zTreeStyle/zTreeStyle.css?r='.time());
echo Html::cssFile('assets/zTree/css/demo.css?r='.time());
/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
echo Html::jsFile('assets/js/plupload.full.min.js');  //图片上userFlag传js
echo Html::cssFile('assets/artDialog/ui-dialog.css');
echo Html::cssFile('assets/css/public.css?r='.time());
echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
echo Html::jsFile('assets/js/jquery.form.js');
echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
echo Html::jsFile('assets/My97DatePicker/WdatePicker.js');//时间插件
echo Html::jsFile('assets/zTree/js/jquery.ztree.core-3.5.js');     //zTree插件
echo Html::jsFile('assets/zTree/js/jquery.ztree.excheck-3.5.js');     //zTree插件多選
//echo Html::jsFile('assets/ueditor/ueditor.config.js');   //编辑器
//echo Html::jsFile('assets/ueditor/ueditor.all.min.js');  //编辑器
//echo Html::jsFile('assets/ueditor/lang/zh-cn/zh-cn.js'); //编辑器
echo Html::jsFile('assets/js/pub.js?r='.time());  //自定义
?>
<div class="findcontainer">
    <div id="Head" class="" style="">
        <form class="" id="formHead">
            <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
            <table width="100%" class="table-condensed">
                <tr>
                    <th style="width: 80px;text-align:right;">输入时间：</th>
                    <td style="width:220px;">
                        <input class="Wdate fm-must" type="text" id="qDateTime1" name="qDateTime1" value=""
                               onclick="WdatePicker({position:{left:0,top:0},dateFmt: 'yyyy-MM-dd'})" style="width:90px;height:22px"/>
                        <span>-</span>
                        <input class="Wdate fm-must" type="text" id="qDateTime2" name="qDateTime2" value=""
                               onclick="WdatePicker({position:{left:0,top:0},dateFmt: 'yyyy-MM-dd'})" style="width:90px;height:22px"/>
                    </td>
                    <th style="width: 100px;text-align:right;">房间编号/ID:</th>
                    <td style="width: 120px;">
                        <input type="text" class="c-tab" name='qHouseName' placeholder="房间名称/ID" style="width: 110px">
                    </td>
                    <td style="text-align: right">
                        <button type="button" class="btn btn-info btn-sm c-fire" onclick="findHead(1);">查询</button>
                        <?if (pub::get('frmHotelHouseAdd')):?>
                        <button type="button" class="btn btn-info btn-sm"
                            data-url="?r=hotel/hotelhouse/createhead"
                            data-title="新增酒店房间"
                            data-id="artHead"
                            onclick="showWin(this);" >新增酒店房间</button>
                        <?endif?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div id="boxFindHead"  class="Head">
        <!--        --><?///* 不用查询明细时，可以接受模板参数进来 $detail  */?>
        <?=Yii::$app->runAction('hotel/hotelhouse/findhead')?>
    </div>
</div>

<script type="text/javascript">
    var ueA;
    window._csrf='<?= Yii::$app->request->csrfToken ?>';
    lineCH('.tr-list','#boxFindHead');
    lineH('.tr-list','#FindHead');

    //findcontainer
    fieldsCheck=new FieldsCheck();
    //fieldsCheck.keyMark();
    fieldsCheck.setFormat('c-su-5',"\\S{0,5}");
    fieldsCheck.setFormat('c-s-20',"\\S{0,20}");
    fieldsCheck.setFormat('c-s-18',"\\S{0,18}");
    fieldsCheck.setFormat("c-s-110","\\S{1,10}","为必须查询条件！");
    fieldsCheck.setFormat('c-fp-1-0',"\\d+(\\.\\d*)?");
    fieldsCheck.setMsg('c-fp-1-0',"至少有一位数字！");
    fieldsCheck.keyFire(document,'#qMaSpace');
    //保存按钮
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
                    artClose('artHead');
                    //跳轉分頁
                    findHead(1);
                }else{
                    showalert(result,'<?=langs::getTxt('infotitle')?>');
                }
            },
            error:function(){
                showMessage('<?=langs::getTxt('neterror')?>',2,'<?=langs::getTxt('infotitle')?>');
            }
        });
    }
    function findHead(page){
        var url = '?r=hotel/hotelhouse/findhead&p='+page;
        var data = $('#formHead').serialize();
        $.ajax({
            url:url,
            type: 'post',
            data: data,
            success: function (data) {
                $('#boxFindHead').html(data);
            }
        });
    }
    //关闭弹出框
    function artClose(id){
        dialog.get(id).close().remove();
    }
    /*
     js自身没有trim()函数取消字符串中的空白字符
     自定义函数：用正则替换掉空白字符
     */
    function trim(s) { return s.replace(/^\s+|\s+$/g, ""); }
    // loadCls=new LoadDialogChoose({"typename":"qTypeName"},"loadCls"
    //     ,{"url":"?r=system/housetype/findtype","formid":"dialogClsForm","area":"dialogClsList"});
    //调入房间类型
    loadCls01=new LoadDialogChoose({"typeid":"vTypeId","typename":"vTypeName"},"loadCls01"
        ,{"url":"?r=system/housetype/findtype","formid":"dialogClsForm","area":"dialogClsList"});
    //end
    //调入酒店名称
    loadHotel01=new LoadDialogChoose({"hotelid":"vHotelId","hotelname":"vHotelName"},"loadHotel01"
        ,{"url":"?r=hotel/hotelinfo/findhotel","formid":"dialogHotelForm","area":"dialogHotelList"});
    //end
<?if(pub::get('frmHotelHouseDel')):?>
    function artDel(that){
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
                            data: {"_csrf":_csrf},
                            success: function (data) {
                                if (/\[0000\]/i.test(data)) {
                                    findHead(m.data('p'));
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
<?endif;?>
</script>

