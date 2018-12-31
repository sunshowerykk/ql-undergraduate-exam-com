<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
/* css調用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
//echo Html::cssFile('assets/css/public.css?r='.time());

?>
<div class="container" id='div' style="width: 320px;" xmlns="http://www.w3.org/1999/html">
        <table class="table table-bordered table-condensed table-hover">
            <tr>
                <td valign="top">
                    <ul id="fLeft" class="ztree" style="overflow:scroll;height:320px;width:250px;"></ul>
                    <div id="fLeft"></div>
                </td>
            </tr>
        </table>
    <div class="" style="text-align: right;padding: 2px;" id="notesRecBox" >
        <button type="button" class="btn btn-default btn-sm" onclick="artCloseDept();">关闭</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="getChecked('fLeft');">确认</button>
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
            onClick: null,
       //     onCheck:zTreeOnCheck
        }
    };
    var zNodes =<?print_r($d_data)?>;
    function beforeClick(treeId, treeNode) {
    }
    //点击事件
    //初始化
    $(function($) {
        $.fn.zTree.init($("#fLeft"), setting, zNodes);
        var treeObj = $.fn.zTree.getZTreeObj("fLeft");

        var curMenu = treeObj.getNodes()[0];
        treeObj.expandNode(curMenu, true, false, false);
    });
    function getChecked(treeId){
        var treeObj = $.fn.zTree.getZTreeObj(treeId);
        var cked=treeObj.getCheckedNodes(true);
        var names='';
        if(cked.length>0){
            for(var i=0;i<cked.length;i++){
                names+=','+cked[i].name;
            }
            if(names.length>1) names=names.substr(1);
            $('#vTitleName').val(names);
        }else{
            $('#vTitleName').val('');
        }
        artCloseDept();
        //这里做关窗口。

    }
    //回寫已選部門checkbox
    function nodeDeal(nodes,kvX,kvTrue,kvFalse) {
        for(i=0;i<nodes.length;i++){
            if($.inArray(nodes[i][kvX[0]],kvX[1])>=0){
                nodes[i][kvTrue[0]]=kvTrue[1];
            }else
                nodes[i][kvFalse[0]]=kvFalse[1];
        }
    }
    //关闭
    function artCloseDept(){
        dialog.get('loadtitle').close().remove();
    }
    function artCan(){
        $('#'+'<?=$rid?>').val('');
        $('#'+'<?=$rname?>').val('');
    }
</script>