<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
/* css調用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
//echo Html::cssFile('assets/css/public.css?r='.time());

?>
<div class="container" id='div' style="width: 280px;" xmlns="http://www.w3.org/1999/html">
    <div style="height: 350px; padding:2px;margin-bottom: 5px">
        <table class="table table-bordered table-condensed table-hover">
<!--            <tr>-->
<!--                <td colspan="2">-->
<!--                    <span style="background:#6bc30d;">&nbsp;&nbsp;被選中時:&nbsp;&nbsp;</span>-->
<!--                    <input type="checkbox" id="py" style="vertical-align: middle;" /><span style="vertical-align: middle;">關聯父</span>&nbsp;-->
<!--                    <input type="checkbox" id="sy" style="vertical-align: middle;"/><span style="vertical-align: middle;">關聯子</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
            <!--                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                    <span style="background: #6bc30d;">取消選中時:&nbsp;</span>-->
<!--                    <input type="checkbox" id="pn" style="vertical-align: middle;"/><span style="vertical-align: middle;">關聯父</span>&nbsp;-->
<!--                    <input type="checkbox" id="sn" style="vertical-align: middle;" /><span style="vertical-align: middle;">關聯子</span><br/>-->
<!--                </td>-->
<!--            </tr>-->
            <tr>
                <td valign="top">
                    <ul id="fLeft" class="ztree" style="overflow:scroll;height:320px;width:250px;"></ul>
                </td>
            </tr>
        </table>
    </div>
    <div class="" style="text-align: right;padding: 2px;" id="notesRecBox" >
        <input type="hidden" id="vRecField" name="vRecField" value="" />
        <button type="button" class="btn btn-default btn-sm" onclick="artCloseDept();">关闭</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="artSure('ReceiptName');">确认</button>
    </div>
</div>


<SCRIPT type="text/javascript">
    var setting = {
        view: {
            selectedMulti: false
        },
        check: {
            chkStyle: "checkbox",
            enable: true,
            autoCheckTrigger: true,
            chkboxType: { "Y": "", "N": "" }
        },
        data: {
            keep: {
                parent:true
                //leaf:true
            },
            simpleData: {
                enable: true
            }
        },
        callback: {
            onClick: onClick,
            onCheck:userCheck
        }
    };
    var zNodes =<?print_r($d_data)?>;
    function beforeClick(treeId, treeNode) {
    }
    //点击事件
    function onClick(event, treeId, treeNode, clickFlag) {
        var zTree = $.fn.zTree.getZTreeObj("TreeLeft");
       // FindAccount(1,treeNode.id,2);	//點擊部門刷新右邊列表
       // fieldToUser();
        // zTree.expandNode(treeNode);
    }
    // function FindAccount(page,d) {
    //     var url = '?r=office/notes/findaccount&p=' + page +'&d='+d;
    //     var data = $('#FindAccount').serialize();
    //     $.ajax({
    //         url: url,
    //         type: 'post',
    //         async:false,
    //         data: data,
    //         success: function (data) {
    //             $('#FindAccount').html(data);
    //         }
    //     });
    // }
    //初始化
    $(function($) {
        //var rid='<?=$ridval?>';
        //rid!='' && nodeDeal(zNodes,['id',rid.split(',')],['checked',true],['checked',false]);
        $.fn.zTree.init($("#fLeft"), setting, zNodes);
        var treeObj = $.fn.zTree.getZTreeObj("fLeft");
        var curMenu = treeObj.getNodes()[0];
        treeObj.expandNode(curMenu, true, false, false);
//        setCheck();
//        $("#py").bind("change", setCheck);
//        $("#sy").bind("change", setCheck);
//        $("#pn").bind("change", setCheck);
//        $("#sn").bind("change", setCheck);


    });



    //回寫已選部門checkbox
    function nodeDeal(nodes,kvX,kvTrue,kvFalse) {
        for(i=0;i<nodes.length;i++){
            if($.inArray(nodes[i][kvX[0]],kvX[1])>=0){
                nodes[i][kvTrue[0]]=kvTrue[1];
            }else
                nodes[i][kvFalse[0]]=kvFalse[1];
        }
    }
//    //關聯父子
//    function setCheck() {
//        var zTree = $.fn.zTree.getZTreeObj("fLeft"),
//            py = $("#py").attr("checked")? "p":"",
//            sy = $("#sy").attr("checked")? "s":"",
//            pn = $("#pn").attr("checked")? "p":"",
//            sn = $("#sn").attr("checked")? "s":"",
//            type = { "Y":py + sy, "N":pn + sn};
//        zTree.setting.check.chkboxType = type;
//    }
    //关闭
    function artCloseDept(){
        dialog.get('loadtitle').close().remove();
    }
    //確認已選部門
    function artSure(){
        var recFiled=encodeURIComponent($("#vRecField").val());
        $.ajax({
            type:'post',
            dataType:'json',
            data:{'vRecField':recFiled},
            url:'?r=office/notes/explainnotesrecv&_='+(new Date()).getTime(),
            success:function(res){
                if(res['_code']=="[0000]") {
                    $('#ReceiptName').val(res['data']);
                    $('#ReceiptId').val(recFiled);
                    artCloseDept();
                }else{
                    alert(res['data']);
                }
            }
        });
    }
    //清除已選部門
    function artCan(){
        $('#'+'<?=$rid?>').val('');
        $('#'+'<?=$rname?>').val('');
    }
</script>