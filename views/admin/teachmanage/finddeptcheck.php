<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
/* css調用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
//echo Html::cssFile('assets/css/public.css?r='.time());

?>
<div class="container" id='div' style="width: 500px;" xmlns="http://www.w3.org/1999/html">
        <table class="table table-bordered table-condensed table-hover">
            <tr>
                <td valign="top">
                    <ul id="fLeft" class="ztree" style="overflow:scroll;height:400px;width:450px;"></ul>
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
            chkboxType: { "Y" : "ps", "N" : "ps" }
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
        var names1='';
        var id1='';
        var names2='';
        var id2='';
        var names3='';
        var id3='';
        if(cked.length>0){
            for(var i=0;i<cked.length;i++){
                if(cked[i].type==1){
                    names1+=','+cked[i].name;
                    id1+=','+cked[i].id;
                }else if(cked[i].type==2){
                    names2+=','+cked[i].name;
                    id2+=','+cked[i].id;
                }else if(cked[i].type==3){
                    names3+=','+cked[i].name;
                    id3+=','+cked[i].id;
                }
            }
            if(names1.length>1) names1=names1.substr(1);
            if(id1.length>1) id1=id1.substr(1);
            if(names2.length>1) names2=names2.substr(1);
            if(id2.length>1) id2=id2.substr(1);
            if(names3.length>1) names3=names3.substr(1);
            if(id3.length>1) id3=id3.substr(1);
           // console.log("name1="+names1,"id1="+id1,"names2="+names2,"id2="+id2,"names3="+names3,"id3="+id3)
            $('#vSubject').val(names1);
            $('#vExamsubId').val(id1);
            $('#vClass').val(names2);
            $('#vExamcourseid').val(id2);
            $('#vSection').val(names3);
            $('#vExamsectionid').val(id3);
        }else{
            $('#vSubject').val('');
            $('#vExamsubId').val('');
            $('#vClass').val('');
            $('#vExamcourseid').val('');
            $('#vSection').val('');
            $('#vExamsectionid').val('');
        }
        artCloseDept();
        //这里做关窗口。

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