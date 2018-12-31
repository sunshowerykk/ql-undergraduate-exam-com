
/*

 1、控制項震動  bj控制項 time震動時間  wh震動幅度px, fx動畫速度s
	flash('#abc',8,6,100);

 2、showalert(mess,title);
	 mess  提示的資訊
	 title 對話方塊的標題。
 3、showMessage('保存成功',3,'提示信息');
	 自動關閉提示信息
 4、showWin(this,toform);
	 data-url="erp.php?mode=usr&op=edit"
	 data-title="增加"
	 data-formid="frmUsrSave"


 */


/* 提示信息
 內容  content
 標題  title 空白不顯示
 */
function showalert(content,title){
    var d = dialog({
        title:title||'',
        content: content,
        okValue:'確定',
        ok: function () {
            d.close().remove();
        },
        //quickClose: true,
        onclose:function () {

        }
    });
    d.showModal();

}
/*
 * 控制項震動動畫
 * obj控制項
 * time震動時間長——短迴圈長度
 * wh震動幅度px
 * fx動畫速度s
 */
function flash(obj,time,wh,fx)
{
    $(function(){
        var $panel = $(obj);
        var offset = $panel.offset()-$panel.width();
        var x= offset.left;
        var y= offset.top;
        for(var i=1; i<=time; i++){
            if(i%2==0)
            {
                $panel.animate({left:'+'+wh+'px'},fx);
            }else
            {
                $panel.animate({left:'-'+wh+'px'},fx);
            }
        }
        $panel.animate({left:0},fx);
        $panel.offset({ top: y, left: x });

    })
}

/* 提示信息，設置顯示秒數
 內容  content
 秒數	sec
 標題  title 空白不顯示
 */
function showMessage(content,sec,title){
    var d = dialog({
        title:title||'',
        //width:300,
        content: content,
        quickClose: true,
        onclose:function () {
            clearInterval(timer);
        }
    });
    d.show();
    var i=1;
    var fn = function(){
        t = sec-i;
        t = t+' 秒自動關閉';
        t = '<div style="font-size:12px">'+t+'</div>';
        t = t+'<br>'+'<div style="font-size:14px">'+content+'</div>';
        d.content(t);
        if (i>=sec){
            clearInterval(timer);
            d.close().remove();
        }
        i++;
    }
    timer = setInterval(fn,1000);
    fn();
}
/* 檢查輸入的內容有交性,頁面防呆
 fmBox   驗證的框

 .fm-must   需驗證的欄位必須引入
 .fn-num-error 輸入數值錯誤 【***】輸入有誤
 .fm-must-num  【***】計算錯誤
  data-chk   提示的欄位名稱（欄位必須輸入）

 .fm-chk-data  自定義顯示信息
  data-msg      自定義顯示信息內容

 */

function checkWithClass(fmBox) {
    var allMust = $(".fm-must", $("#"+fmBox));
    var cwc = "", chk = "", patEmpty = /^\s+|\s+$/g, patNum = /^\d+(\.\d+$|$)/;
    allMust.each(function () {
        if ($(this).hasClass('fm-num-error'))
            return true; //相當於for中的continue,如果return false就相當於break;
        if ($(this).is(":text") || $(this).is("textarea")|| $(this).is(":password")) {
            if ($(this).val().replace(patEmpty, "") == "" && 'undefined' != typeof $(this).data("chk"))
                cwc += "【" + $(this).data("chk") + "】必须输入!<br>";
        } else if ($(this).is(":radio") || $(this).is(":checkbox")) {
            var rd = $("[name=" + ($(this).attr("name") || $(this).attr("id")) + "]");
            if (rd.length == 0 || rd.filter(":checked").length == 0) {
                if ('undefined' != typeof $(this).data("chk"))
                    cwc += "【" + $(this).data("chk") + "】未選擇!<br>";
            }
        } else if ($(this).is("select")) {
            if ($(this).val().replace(patEmpty, "") == "" && 'undefined' != typeof $(this).data("chk")) {
                cwc += "【" + $(this).data("chk") + "】必须输入!<br>";
            }
        }
    });
    //遍曆fm-num-error錯的欄位
    var allNumErr = $(".fm-num-error", $("#"+fmBox));
    allNumErr.each(function () {
        $('undefined' != $(this).data('chk'))
        cwc += "【" + $(this).data("chk") + "】輸入有誤!<br>";
    });
    //遍曆需要計算卻值錯誤的欄位fm-must-num
    var allMustNum = $(".fm-must-num", $("#"+fmBox));
    allMustNum.each(function () {
        if ('undefined' != $(this).data('chk') && !patNum.test($(this).val())) {
            cwc += "【" + $(this).data("chk") + "】計算有誤!<br>";
        }
    });
    var chkData = $(".fm-chk-data", $("#"+fmBox));
    chkData.each(function () {
        if ('undefined' != typeof $(this).data("msg"))
            cwc += $(this).data("msg") + "<br>";
    });

    return cwc;
}
/*驗證輸入的內容，加入class*/
function chkInput(that,type){
    var m = $(that);
    var str = $.trim(m.val());
    if (type=='int'){				//整數
        var n = /^-?\d+$/;
        var r = n.test(str); //整數返回true
        if (!r)
            m.addClass('fm-chk-data');
        else
            m.removeClass('fm-chk-data');

    }else if (type=='pint'){		//非負整數（正整數 + 0）
        var n = /^\d+$/;
        var r = n.test(str);
        if (!r)
            m.addClass('fm-chk-data');
        else
            m.removeClass('fm-chk-data');
    }else if (type=='pfloat'){		//非負浮點數（正浮點數 + 0）
        var n = /^\d+(\.\d+)?$/;
        var r = n.test(str);
        if (!r)
            m.addClass('fm-chk-data');
        else
            m.removeClass('fm-chk-data');
    }else if (type=='float'){		//浮點數
        var n = /^-?\d+(\.\d+)?$/;
        var r = n.test(str);
        if (!r)
            m.addClass('fm-chk-data');
        else
            m.removeClass('fm-chk-data');
    }

}
/*  彈出框 需自定如下屬性
	地址	data-url="erp.php?mod=usr&op=add"
	標題	data-title="增加"
	ID      data-id="aa"  artDialog 唯一ID，用于关闭
	例子	<button type="button" data-url="erp.php?mod=usr&op=add" data-title="增加" onclick="showWin(that);" >新增機構</button>
*/

function showWin(that){
    var m = $(that);
    var wait = dialog({	});//等待提醒
    //alert(m.data('url'));
    wait.show();
    var d = dialog({ //彈出框
        title: m.data('title'),
        id: m.data('id'),
        lock:true
    });
    // jQuery ajax
    $.ajax({
        cache: false,timeout : 3000,
        type: 'get',
        url: m.data('url'),
        async:false,
        success: function (data) {
            d.content(data);
            wait.close().remove();//關閉等待提醒窗口
            //d.focus();
            d.showModal();
            if(typeof m.data('focus')!='undefined')
                $('#'+ m.data('focus')).length>0 && $('#'+ m.data('focus')).focus().select();
        },
        error: function(data){
            var er = dialog({
                content: '讀取數據失敗，請重試！'
            });
            er.show();
            setTimeout(function () {
                er.close().remove();
            }, 2000);
        },
        beforeSend	: function(data){
        }
    });
}
/*调入部门查询
 cname 返回名称的位置
 cid   返回代码的位置
 */
function loadDept(rname,rid,csrf,except){
    var er = dialog();//等待提醒
    er.show();
    var d = dialog({ //彈出框
        title: '部门选择',
        id: 'loaddept',
        lock:true
    });
    var ridval = $('#'+rid).val();
    $.ajax({
        cache: false,timeout : 3000,
        type: 'post',
        data:'rid='+ rid+
        '&rname='+rname+
        '&except='+except+
        '&ridval='+ridval+
        '&_csrf='+csrf,
        url: '?r=system/dept/finddept',
        success: function (data) {
            d.content(data);
            er.close().remove();//關閉等待提醒窗口
            //d.focus();
            d.showModal();
        },
        error: function(data){
            var er = dialog({
                content: '讀取數據失敗，請重試！'
            });
            er.show();
            setTimeout(function () {
                er.close().remove();
            }, 2000);
        },
        beforeSend	: function(data){
        }
    });
}

/*调入权限查询
 cname 返回名称的位置
 cid   返回代码的位置
 */
function loadRole(cname,cid,csrf){
    var er = dialog();//等待提醒
    er.show();
    var d = dialog({ //弹出框
        title: '角色选择',
        id: 'loadrole',
        lock:true
    });
    // jQuery ajax
    var ridval = $('#'+cid).val();
    $.ajax({
        cache: false,timeout : 3000,
        type: 'post',
        data:'rid='+ cid+
        '&rname='+cname+
        '&ridval='+ridval+
        '&_csrf='+csrf,

        url: '?r=system/role/indexrole',
        success: function (data) {
            d.content(data);
            er.close().remove();//关闭等待提醒窗口
            //d.focus();
            d.showModal();
        },
        error: function(data){
            var er = dialog({
                content: '读取数据失败，请重试！'
            });
            er.show();
            setTimeout(function () {
                er.close().remove();
            }, 2000);
        },
        beforeSend : function(data){
        }
    });
}

/*调入单据类型返回，提交时需求验证单据类型是否正确
 cname 返回名称的位置
 cid   返回代码的位置
 c1 = 'ERP';  //SysId
 c2 = 'INV';  //ModID
 c3 = '(1)';  //Property
 k = 加密认证,SysId ModID Property
 */
function GetType(cname,cid,c1,c2,c3,k){
    var billid= $('#'+cid).val();
    if(billid==""){
        $('#'+cname).html('');	    //角色名称
        return false;
    }
    var url = '?r=base/billtype/gettype&c1='+c1+'&c2='+c2+'&c3='+c3+'&c4='+billid+'&_k='+k+'&_f='+(new Date()).getTime();
    $.ajax({
        url:url
        ,type:'get'
        ,dataType: "json"
        ,success:function(res) {
            if (/\[1111]/i.test(res)) {
                $('#' + cid).val('');	    //角色代码
                $('#' + cname).html('');	    //角色名称
                return false;
            }if (/\[2222]/i.test(res)) {
                $('#'+cname).html('异常222');	    //角色名称
                return false;
            }else {
                $('#'+cname).html(res.BillName);		//角色名称
            }
        }
    });
}

/*
 /*
 物料分类调用 LoadMatype
 类似 LoadDialogChoose的调用方式
 defineString=new LoadMatype(list,funcName);
 先在首页 初始化
 loadMatype=new LoadMatype({"name":"vParentName,spParentName","id":"vParentId"},'loadMatype');
 命名一个自定义的func的名称loadMatype
 参数，list为json格式，key为tree的node的属性，除了name，id，如果有其他自定义属性也可以往里面加，
 funcName为自定名称defineString
 因为这个函数的弹出窗口是固定的，方式和LoadDialogChoose类型那边不解析了。
 */
LoadMatype=function(list,funcName) {
    var _self=this;
    this.nodes='';
    this._list=list;
    this.url='?r=base/matype/indexmatype';
    this.title='物料分類';
    this.id='dialogMatypeTree';
    this.isClose=typeof arguments[3]!='undefined'?arguments[3]:1;
    this._funcName=funcName;
    this.noChoose='';
    this.setting={
        view: {selectedMulti: false, expandSpeed: "fast"},
        edit: {enable: true, showRemoveBtn: false, showRenameBtn: false},
        data: {keep: {parent: true}, simpleData: {enable: true}},
        callback: {onClick: ''}
    };
    //tree的初始化
    this.init=function(){
        var treeId=_self.id;
        var selId=typeof arguments[0]!='undefined'?arguments[0]:'';
        _self.setting.callback.onClick=_self.clk;
        $.fn.zTree.init($("#" + treeId), _self.setting, _self.nodes);
        var treeObj = $.fn.zTree.getZTreeObj(treeId);
        if (selId != '') {
            var defaultNode = treeObj.getNodeByParam("id", selId, null);	//獲取第一級ID
            treeObj.selectNode(defaultNode);		//標記第一級
        }
    };//end of init

    //彈出觸發
    //rootId根id，
    this.fire=function(){
        var rootId = typeof arguments[0]!= 'undefined'?arguments[0]:"0";
        var filter = typeof arguments[1]!= 'undefined'?arguments[1]:"";
        var status = typeof arguments[2]!= 'undefined'?arguments[2]:"";
        var noChoose=typeof arguments[3]!='undefined'?arguments[3]:"";
        _self.noChoose=noChoose;
        var url=_self.url+"&funcName="+_self._funcName+"&c1=" + rootId + "&c2=" + filter + "&c3=" + status+"&c4="+noChoose
        var wait = dialog({});//等待提醒
        wait.show();
        var d = dialog({
            title: _self.title,
            id: _self.id, lock: true
        });
        // jQuery ajax
        $.ajax({
            cache: false, timeout: 3000,
            type: 'get',
            url: url,
            async: false,
            success: function (res) {
                d.content(res);
                wait.close().remove();//關閉等待提醒窗口
                d.showModal();
            },
            error: function (res) {
                var er = dialog({content: '讀取數據失敗，請重試！'});
                er.show();
                setTimeout(function () {
                    er.close().remove();
                }, 2000);
            }
        });
        d.showModal();
    };//end of fire

    //節點點擊事件
    this.clk=function(event, treeId, treeNode, clickFlag) {
        var l=_self._list;
        if (typeof l == 'string') return false;
        var no=','+_self.noChoose+',';
        var idPat=new RegExp(','+treeNode.id+',','ig');
        var pPat=/,p,/ig;
        var sPat=/,s,/ig;
        if(idPat.test(no))
            return false;
        if(pPat.test(no) && treeNode.isParent)
            return false;
        if(sPat.test(no) && !treeNode.isParent)
            return false;
        for(et in l){
            tmp=l[et].split(',');
            for(i=0;i<tmp.length;i++){
                if(typeof treeNode[et]=='undefined')
                    return false;
                if ($('#' + tmp[i]).length == 1)
                    tmpField = $('#' + tmp[i]);
                else if ($('[name=' + tmp[i] + ']').length)
                    tmpField = $('[name=' + tmp[i] + ']');
                else return false;
                if (tmpField.is('input,select')) tmpField.val(treeNode[et]);
                else tmpField.html(treeNode[et]);
            }//end of for tmp
        }//end of for l
        if(_self.isClose!=0) _self.close();
    };//end of clk

    //清空栏位
    this.clear=function(){
        var list=_self._list;
        //遍历
        for(et in list){
            if(typeof list[et]!='undefined'){
                //需要赋值的栏位
                tags=list[et].split(',');
                //循环所有栏位
                for(i=0;i<tags.length;i++){
                    if ($('#' + tags[i]).length == 1)
                        tmp = $('#' + tags[i]);
                    else if ($('[name=' + tags[i] + ']').length)
                        tmp = $('[name=' + tags[i] + ']');
                    else continue;
                    if (tmp.is('input,select')) tmp.val('');
                    else tmp.html('');
                }//end of for
            }//end of if
        }//end of for in
    };//end of clear

    //彈出關閉
    this.close=function(){
        if(typeof dialog!='undefined' && typeof dialog.get(_self.id)!='undefined')
            dialog.get(_self.id).close().remove();
    };//end of close
};//end of LoadMatype

/*
 通用弹出窗口，选择JS,LoadDialogChoose(list,funcName,find,exact)
 list：json对象,key对应"选择"的data属性，如data-maid的key是maid,
 而value对应页面需要传值的栏位，下面maid的value: vMaId，那么点击选择后，会给id=vMaid或者name=vMaid的栏位赋值data-maid的值，
 需要赋值多个用逗号隔开，另这里data-maid对应的的值最好html编码一下，参见view/material/findmaterial.php的“选择”
 funcName：初始化对象的名称，因为JS的反射很难用，这里直接把名称传过去；
 find[可选参数]:弹出窗口查询的参数，json格式必须有url,formid,area。url查询提交的url，formid查询的数据form，area查询结果数据放置位置id
 需要先在index页初始化,如下，调用物料信息的弹出选择
 exact[可选参数]:用于input的类blur事件触发精确查询，参数json需要url,及data精确查询的栏位id或name的用逗号隔开的字串，每个栏位后面跟
 	#1（井号+数字）表示该栏位的位数必须和数据长度一样才会触发，#1,4表示1-4位会触发查询，#1|3|5表示1，3，5个长度会触发.多个栏位同时验证，注意唯一性，且data里的栏位不会被回写赋值，
 	ex参数为不清空的栏位，逗号隔开，不带参数时 data里的查询数据不清空也不回写
 loadMaterial=new LoadDialogChoose({"maid":"vMaId","maname":"vMaName,spMaName"
										,"unitname":"vUnitName","maspace":"vMaSpace"}
									,'loadMaterial'
									,{"url":"?r=storage/material/findmaterial","formid":"dialogMaterialForm"
										,"area":"dialogMaList"}
									,{"url":"?r=storage/material/getmaterial","data":"vMaId#4"
										,"ex":""});
 调用弹出按钮实例
 <a href="javascript:void(0)" title="选择物料单位" style="text-decoration:none;"
 data-url="?r=storage/material/material"
 data-id="dialogMaterial"
 data-title="物料资料"
 onclick="loadMaterial.fire(this);" >调入
 </a>
 <a href="javascript:void(0)" title="取消物料单位" style="margin-left:6px;"
 onclick="loadMaterial.clear();">_
 </a>
 调用按钮，需要data-url,data-id,data-title三个属性，url为弹出窗口的触发url，id为弹出dialog的id，title为弹出窗口的标题
 onclick的触发方式为 上面实例对象 loadMaterial.fire(this);其中fire为方法内部包装的方法
 清空按钮，只需要直接 调用 loadMaterial.clear(ect); 会自动清空所有需要赋值的栏位,ect为不清空的栏位，逗号隔开，不带参数全清

 --------，以上是 调用设置，下面是要配合这个JS被调用的controller及view需要配合一些
 1、弹出页触发的控制器需要get接收funcName，并作为参数能被view取到
 $rFuncName=$req->get('funcName','');
 ...
 $part = array(
 'd_data'=>$d_data,
 'rFuncName'=>$rFuncName,
 );

 2、弹出页的查询form的隐藏栏位需要有 funcName，从上面获取,这里没加php解释符
 <input type="hidden" name="funcName" value="$rFuncName" />
 查询和关闭按钮的写法，除了查询需要相应的data，方法名称就需要用到上面传过来的funcName了
 <button type="button" class="btn btn-info btn-sm"
 	onclick="=$rFuncName.find(this);">查询</button>
 <button type="button" class="btn btn-default btn-sm" onclick="$rFuncName.close();">关闭</button>
 3、弹出页的view里调用查询的runAction，需另外加个参数qFuncName
 Yii::$app->runAction('storage/material/findmaterial',array('qFuncName'=>$rFuncName))
 所有接收的action要带参数public function actionFindmaterial($qFuncName)
 4、查询控制器的分页需要改分页点击方法的参数
	 $param= array(
		 'total_rows'=>$totalNumber, #(必须)
		 'method'    =>'ajax', #(必须)
		 'ajax_func_name'=>$cFuncName.'.find',
		 'parameter'=>"",  #(必须)
		 'now_page'  =>$page,  #(必须)
		 'list_rows'=>$perNumber, #(可选) 默认为15
	 );
 5、精确输入查询，在初始化时，第四个参数 exact，确定url，和传递参数data:"p1,p2,p3"和ex(except)例外清空的栏位，此栏位不清空
 	调用方法 funcName.exact()
 	实例：loadMaterial.exact();
 	ect为查询不到数据时需要保留输入数值的栏位，不带参数时 data里的查询数据不清空也不回写
目前可用的查询数据
----物料资料----
	find
 {"url":"?r=storage/material/findmaterial","formid":"dialogMaterialForm","area":"dialogMaList"}
	exact
 {"url":"?r=storage/material/getmaterial","data":"","ex":""}
 ----物料资料----
 */
//调用物料资料
LoadDialogChoose=function(list,funcName) {
    var _self=this;
    //栏位对应
    this._list=list;
    this._dialogId='';
    this._name=funcName;
    this._find=typeof arguments[2]!='undefined'?arguments[2]:'';
    this._exact=typeof arguments[3]!='undefined'?arguments[3]:'';

    //弹出窗口触发
    this.fire=function(that) {
        var s=$(that);
        _self._dialogId= s.data('id');
        var wait = dialog({});//等待提醒
        wait.show();
        var d = dialog({
            title: s.data('title'),
            id: s.data('id'), lock: true
        });
        // jQuery ajax
        $.ajax({
            cache: false, timeout: 3000,
            type: 'get',
            url: s.data('url'),
            async:false,
            data:{"funcName":_self._name},
            success: function (res) {
                d.content(res);
                wait.close().remove();//關閉等待提醒窗口
                d.showModal();
            },
            error: function (res) {
                var er = dialog({content: '讀取數據失敗，請重試！'});
                er.show();
                setTimeout(function () {
                    er.close().remove();
                }, 2000);
            }
        });
        d.showModal();
    };//end of fire

    //弹出页查询动作触发
    this.find=function(p){
        var f=_self._find;
        if(typeof f=="string") return false;
        var data = $('#'+f['formid']).serialize();
        $.ajax({
            url: f['url']+'&p='+p,
            type: 'post',
            data: data,
            success: function (data) {
                $('#'+ f['area']).html(data);
            }
        });
    };//end of find

    //查询结果选择触发
    this.clk=function(that) {
        var s=$(that);
        var list=_self._list;
        var flag=typeof arguments[1]!='undefined'?arguments[1]:'1';
        if(typeof list=='string') return false;
        var v='';
        //var trg=new Array(new Array(),new Array());
        //var tmpName='';
        //遍历
        for(et in list){
            if(typeof list[et]!='undefined'){
                //需要赋值的栏位
                tags=list[et].split(',');
                //循环所有栏位
                for(var i=0;i<tags.length;i++){
                    if ($('#' + tags[i]).length == 1){
                        //tmpName='#'+tags[i];
                        tmp = $('#' + tags[i]);
                    }else if($('[name=' + tags[i] + ']').length == 1){
                        //tmpName='[name=' + tags[i] + ']';
                        tmp = $('[name=' + tags[i] + ']');
                    }else{
                        continue;
                    }
                    v=typeof s.data(et.toLowerCase())!='undefined'?s.data(et.toLowerCase()):'';
                    if (tmp.is('input,select')){
                        tmp.val(v);
                        if('oninput' in document.documentElement && hasEvent(tmp,'input',$(document))){
                            tmp.trigger('input');
                        }else if('onpropertychange' in document.documentElement && hasEvent(tmp,'propertychange',$(document))) {
                            tmp.trigger('propertychange');
                        }
                    } else tmp.html(v);
                }//end of for
            }//end of if
        }//end of for in
        if(flag-0) _self.close(_self._dialogId);
    };//end of clk

    //input精确输入查询
    this.exact=function(){
        var e=_self._exact;
        var exp='';
        if(typeof e=="string") return false;
        var tmp=e['data'].split(','),tmpL='',tmpR='',arrArea='',areaL='',areaR='',arr='',v='',flag=0,fields={};
        var data={};
        for(i=0;i<tmp.length;i++){
            arr=tmp[i].split(/[^-\w\|]/);
            tmpL=arr[0];
            exp+=','+tmpL;
            exp+=typeof e["ex"]!='undefined'?','+e["ex"]+',':',';
            if ($('#' + tmpL).length == 1)
                field = $('#' + tmpL);
            else if ($('[name=' + tmpL + ']').length)
                field = $('[name=' + tmpL + ']');
            else continue;
            v=field.val();
            fields[tmpL]=v;
            //范围判定
            tmpR=arr.length==2?arr[1]:'';
            //过滤掉所有非数字及非-,|隔开是固定位数，可跳位数3|5|9
            tmpR=tmpR.toString().replace(/[^-\d\|]/g,'');
            if(!/\|/.test(tmpR)){
                arrArea=tmpR.split('-');
                areaL=arrArea[0];
                areaR=arrArea.length>=2?arrArea[1]:-1;
                if(/^\d+$/.test(areaL)){
                    if(areaR==='' && v.length-areaL<0){
                        flag=1;
                        break;
                    }else if(areaR===-1 && v.length!=areaL){
                        flag=1;
                        break;
                    }else if(/^\d+$/.test(areaR) && (v.length-areaL<0 || v.length-areaR>0)){
                        flag=1;
                        break;
                    }
                }else if(/^\d+$/.test(areaR) && v.length-areaR>0){
                    flag=1;
                    break;
                }
            }else if(!/-/.test(tmpR)){
                tmpR='|'+tmpR+'|';
                tmpR=tmpR.replace(/\|\s*(\d)\s*\|/g,function(m,m1) {
                    return ','+m1+',';
                });
                var pR=new RegExp(","+ v.length.toString()+",",'i');
                if(!pR.test(tmpR)){
                    flag=1;
                    break;
                }
            }
            data["c"+(i+1)]=v;
        }
        if(flag==1){
            _self.clear(exp);
            return false;
        }
        $.ajax({
            url: e['url'],
            type: 'post',
            dataType:'json',
            data: data,
            success: function (res) {
                if(res['_code']=="[0000]"){
                    var list=_self._list;
                    var v='';
                    if(typeof list=='string') return false;
                    //遍历//查询栏位不需要回写
                    for(et in list){
                        if(typeof list[et]!='undefined'){
                            //需要赋值的栏位
                            tags=list[et].split(',');
                            //循环所有栏位
                            for(i=0;i<tags.length;i++){
                                if ($('#' + tags[i]).length == 1)
                                    tmp = $('#' + tags[i]);
                                else if ($('[name=' + tags[i] + ']').length)
                                    tmp = $('[name=' + tags[i] + ']');
                                else continue;
                                if(typeof res[et.toLowerCase()]=='undefined'){
                                    if(exp.indexOf(','+tags[i]+',')>=0) {
                                        continue;
                                    }else v='';
                                }else{
                                    if(typeof fields[tags[i]]!='undefined' && fields[tags[i]].toLowerCase()!=tmp.val().toLowerCase()){
                                        return false;
                                    }
                                    if(exp.indexOf(','+tags[i]+',')>=0)
                                        continue;
                                    v=res[et.toLowerCase()];
                                }
                                if (tmp.is('input,select')) tmp.val(v);
                                else tmp.html(v);
                            }//end of for
                        }//end of if
                    }//end of for in
                }else _self.clear(exp);
            }
        });
    };//end of exact

    //清空赋值栏位
    this.clear=function(){
        var list=_self._list;
        var exp=typeof arguments[0]!='undefined'?','+arguments[0]+',':'';
        //遍历
        for(et in list){
            if(typeof list[et]!='undefined'){
                //需要赋值的栏位
                tags=list[et].split(',');
                //循环所有栏位
                for(i=0;i<tags.length;i++){
                    if ($('#' + tags[i]).length == 1)
                        tmp = $('#' + tags[i]);
                    else if ($('[name=' + tags[i] + ']').length)
                        tmp = $('[name=' + tags[i] + ']');
                    else continue;
                    if(exp.indexOf(','+tags[i]+',')>=0)
                        continue;
                    if (tmp.is('input,select')) tmp.val('');
                    else tmp.html('');
                }//end of for
            }//end of if
        }//end of for in
    };

    this.close=function() {
        if(typeof dialog!='undefined' && typeof dialog.get(_self._dialogId)!='undefined')
            dialog.get(_self._dialogId).close().remove();
    }
};//end of LoadDialogChoose

/*
* 判断 對象是否包含某個事件
* obj：要判斷的對象
* eve：事件名稱，jquery的事件庫
* arguments[2]：事件觸發的對象，如delegate是$(document).delegate(obj,function(){}); $(document)為arguments[2]
* */
function hasEvent(obj,eve){
    var o=null;
    var res=false;
    if(obj instanceof jQuery)
        o=obj;
    else{
        if ($('#' + obj).length == 1)
            o = $('#' + obj);
        else if ($('[name=' + obj + ']').length)
            o = $('[name=' + obj + ']');
        else return false;
    }
    var b=null;
    if(typeof arguments[2]!=undefined){
        if(arguments[2] instanceof jQuery)
            b=arguments[2];
        else{
            if ($('#' + arguments[2]).length == 1)
                b = $('#' + arguments[2]);
            else if ($('[name=' + arguments[2] + ']').length)
                b = $('[name=' +arguments[2] + ']');
            else return false;
        }
    }
    var events=null;
    if(b!==null && b.length>0){
        events=$._data(b[0],'events');
    }else{
        events= $._data(o[0],'events');
    }
    if(events && events[eve]){
        var eves=events[eve];
        for(i=0;i<eves.length;i++){
            var sor=eves[i]['selector'];

            if(b){
                if(o.is($(sor)))
                    return true;
            }else{
                if(sor===null)
                    return true;
            }
        }
    }
    return false;
};//end of hasEvent


/*
 栏位按tab、回车键循序此z-index层级下一个栏位，遇到末尾栏位时如果是回车就触发提交的按钮
 调用格式
 tabNext(csTab,csEnd,csFire);
 实例:tabNext('c-tab','c-end','c-fire');
 csTab【可选】:所有需要循序的栏位增加此栏位，支持tabIndex排序从0开始，如果空或者不加将循序此z-index层级中的所有有效input
 csEnd【可选】:配合csFire使用，两者缺一就无效，多个以第一个为有效，循序到此栏位时再按回车将触发csFire标记的栏位的click
 csFire【可选】：配合csEnd使用，多个以第一有效，循序到csEnd时再回车触发此按钮的click事件
 注意：栏位写死 排除“hidden(visible)、readonly、option、button、disabled”的栏位，就算加了csTab一样不会循序
 */
tabNext=function(){
    var csTab=typeof arguments[0]!='undefined'?arguments[0]:''
        ,csEnd=typeof arguments[1]!='undefined'?arguments[1]:''
        ,csFire=typeof arguments[2]!='undefined'?arguments[2]:'';
    //全局劫持回车的提交
    $(document).unbind("keydown.tabNext").bind("keydown.tabNext",function(e) {
        var self= $(e.target);
        var keyV= e.which;
        if(!self.is('textarea') && (keyV==13 || keyV==9)){
            e.preventDefault();
            var box=$(e.target);
            while(!box.is('html') && !box.is('body') && box.css('z-index')=='auto'){
                box=box.parent();
            }
            csTab= $.trim(csTab);
            csEnd= $.trim(csEnd);
            csFire= $.trim(csFire);
            var els=box.find((csTab!=''?'.'+csTab:'')+':not(:button,:hidden,:disabled,[readonly],option,[tabindex^=-])');
            var end=new Array();
            if(csEnd!='')
                end=els.filter('.'+csEnd+':first');
            var fire=new Array();
            if(csFire!='')
                fire=box.find('.'+csFire+':first');
            var sTab=self.get(0).tabIndex;
            var sIdx=els.index(self);
            var sPos=sTab+'#'+sIdx;
            var nextPos=0,cTab= 0;
            var arrTab=new Array(),arr=new Array();

            //先判断tabIndex
            els.each(function() {
                cTab=this.tabIndex;
                cIdx=els.index(this);
                arrTab.push(cTab);
                arr.push(cTab+'#'+cIdx);
            });
            if(arr.length==0) return false;
            //寻找tab的最大值及最小值
            arr.sort(function(x,y){
                return x.split(/\D/)[0]-y.split(/\D/)[0]>0;
            });
            arrPos=$.inArray(sPos,arr);
            if(arrPos+1>=arr.length)
                nextPos=arr[0].split(/\D/)[1];
            else nextPos=arr[arrPos+1].split(/\D/)[1];
            if(keyV==13 && end.length==1 && fire.length==1 && end.is(self))
                fire.trigger('click');
            else{
                next=els.eq(nextPos);
                if(next.is(":text") || next.is("textarea"))
                    next.select();
                next.focus();
            }
        }
    });
};//end of tabNext




/*
	artdialog的關閉方法，包含俩个func和2个变量
	dialogTreeInit(nodeId,treeId)
	dialogTreeClick
 	dialogNodes节点集合
 	dialogSetting树设置配置
	传入dialog的id来关闭
 */
function artClose(id){
    if(typeof dialog!='undefined' && typeof dialog.get(id)!='undefined')
        dialog.get(id).close().remove();
}//end of artClose


!(function() {
    //checkbox全选切换
    //box为外层大容器，不存在就默认document
    //sw为全选元素的标识,类名就要加.，id要#，要符合jQuery的选择器规则
    //cksCls_u全选按钮选中时要加的class，如果没设定会自定义一个标识class
    //cks为被控制的元素的标识，需符合jQuery选择器的规则
    //cksCls_u被控制的元素选中时要加的class，如果没设定会自定义一个标识class
    //checkAll('.checkAll-x','.checkAll-y','.tr-csw');
    //checkAll('.chkTestA','.chkTestB','.tr-csw','checkall-testA','checkall-testB');
    window.checkAll=function(sw,cks,box,swCls_u,cksCls_u){
        var _self=this;
        var now=(new Date).getTime();
        this.swCls=typeof swCls_u=='undefined'?'check-all-sw-'+now:swCls_u;
        this.cksCls=typeof cksCls_u=='undefined'?'check-all-cks-'+now:cksCls_u;
        this._cc=function(x,y,isSW) {
            jQuery(document).undelegate(x,'.checkall').delegate(x,'click.checkall',function(event) {
                var e=event.currentTarget;
                var c=typeof box=='undefined'?document:jQuery(e).closest(box.replace(/^\s+|\s+$/g,''));
                var mXs=c.find(x),mYs=c.find(y);
                var lenX=mXs.length,lenY=mYs.length;
                //如果控制多于一个就跳出
                if(isSW==1 && lenX==0) return true;
                var cls=isSW==1?_self.swCls:_self.cksCls;
                jQuery(e).toggleClass(cls);
                var mXs_cked=mXs.filter('.'+cls);
                var lenX_cked=mXs_cked.length;
                if(isSW==1){
                    lenX_cked=jQuery(e).hasClass(cls)?1:0;
                    if(lenX_cked!=0){
                        _self._check(mXs,true,_self.swCls);
                        _self._check(mYs,true,_self.cksCls);
                    }else{
                        _self._check(mXs,false,_self.swCls);
                        _self._check(mYs,false,_self.cksCls);
                    }
                }else{
                    if(lenX_cked!=0){
                        if(lenX_cked==lenX) _self._check(mYs,true,_self.swCls);
                        else _self._check(mYs,false,_self.swCls);
                    }else _self._check(mXs,false,_self.swCls);
                }
            });
        };
        this._check=function(ms,tf,cls) {
            var b=tf==true?true:false;
            jQuery.each(ms,function() {
                if(typeof this.checked!='undefined') this.checked=b;
                if(b) jQuery(this).addClass(cls);
                else  jQuery(this).removeClass(cls);
            });
        };
        this._init=function() {
            if(typeof sw=='undefined' || typeof cks=='undefined') return true;
            if(/^\s*$/.test(sw) || /^\s*$/.test(cks)) return true;
            sw=sw.replace(/^\s+|\s+$/g,'');
            cks=cks.replace(/^\s+|\s+$/g,'');
            this._cc(sw,cks,1);
            this._cc(cks,sw);
        };
        this._init();
    };//end of CheckALl;
})();


!(function() {
    //鼠标移入移出变色，目前移入颜色固定为#f0f0f0,移出为transparent
    //line为要变色的行的标记class(.css),id(#id),name(name)
    //exception为要排除变色的类，如果lineC中点击变色了
    //，那么鼠标移入移出的变色就不能覆盖有这个类的,默认是line-c-mark
    //lineCH('.tr-csw','#frmModeSave');	lineC 点击，lineH移动，lineCH两个
    window.lineH=function(line,excep) {
        var d=0;
        if(typeof arguments[2]!='undefined') d=arguments[2];
        jQuery(document).undelegate(line,'.linehr').delegate(line,'mouseover.linehr',function(event) {
            excep=typeof excep=='undefined'?'line-c-mark':excep;
            var e=jQuery(event.currentTarget);
            if(!jQuery(event.currentTarget).hasClass(excep)){
                e.addClass("line-h-mark");
                if(d!=0)e.css("background-color","#F0F0F0");
            }
        }).undelegate(line,'mouseout.lineht').delegate(line,'mouseout.lineht',function(event) {
            var e=jQuery(event.currentTarget);
            e.removeClass("line-h-mark");
            if(d!=0)e.css("background-color","transparent");
        });
    };

    //单击行变色，目前单击变色为#BFFFFF
    //line为要变色的行的标记class(.css),id(#id),name(name)
    //container为line的容器，如果不加容器，document(全局)都会触发颜色切换，标记方式和line一致
    window.lineC=function(line,container) {
        var d=0;
        if(typeof arguments[2]!='undefined')d=arguments[2];
        jQuery(document).undelegate(line,'.linec').delegate(line,'click.linec',function(event) {
            var c;
            if(typeof container!='undefined'){
                if(jQuery(event.currentTarget).closest(container).length>0)
                    c=jQuery(event.currentTarget).closest(container);
                else return true;
            }else c=jQuery(document);
            cLine=c.find(line);
            cLine.removeClass('line-c-mark');
            if(d!=0) cLine.css('background-color','transparent');
            cur=c.find(jQuery(event.currentTarget));
            cur.addClass('line-c-mark');
            if(d!=0) cur.css('background-color','#5bc0de');
        });
    };

    //经过和点击合并
    window.lineCH=function(line,container) {
        var d=0;
        if(typeof arguments[2]!='undefined') d=1;
        var exce='line-c-mark';
        if(typeof arguments[3]!='undefined') exce=arguments[3];
        lineH.call(this,line,exce,d);
        lineC.call(this,line,container,d);
    };//

})();

//输入验证 FieldsCheck
/*
 调用方式
 fc=new FieldsCheck(box);//初始化
 box为容器，可以为document，或初始化把box内的所有符合的类的元素都包括
 fc.keyMark(item);//触发验证
 item为要指定验证的对象，如果item是个容器那么将验证item内所有符合的类的元素，如果是个输入元素且有符合的
 类，那么将验证此元素，如果没有参数，那么将验证初始化中box内所有符合类的元素，验证方式是加上标记类
 fc.keyFire(item);//栏位值改变时触发输入限制
 参数形式和上面一个一样，这个会在栏位值改变时限制输入，必须输入符合类验证的格式
 fc.checkMsg(box);//验证并返回验证结果
 box为容器，验证容器内的符合元素，如果不带参数将与初始化中的box一样。
 实际是触发fc.keyMark();并对有异常标记类的元素坐异常信息捕捉并返回到数组中，最后直接返回数组
 数字规则
 [if]pe：第一位i、f表明是整数或者小数,第二位是p，如果没有p，则第二位是e
 s[ul]et：规则第一位必须为s，第二位如有u或者l，其他后排,et不分前后
 20170406 add
 因为值截取会改变value，而栏位绑定了多个事件，执行的顺序不可以控制，只能在value改变后再次出发一次 其他的事件。(这种一个元素绑定多个
 	同一事件的方法要改)
 新方法
 xxxx.setFunc({'#id':'func1','[name=xxx]','func2'});
 如：fieldsCheck.setFunc({'#spContractId':'loadConClass.exact'});
 */
FieldsCheck = function () {
    var _self = this, arg = typeof arguments[0] != 'undefined' ? arguments[0] : document;
    this._box = '';
    this._el = '';
    this.dEl = ':text,input:hidden,:password,:radio,:checkbox,textarea,select';
    this.dInput = ':text,input:hidden,:password,textarea';
    this.func='';
    this.dCheck = 'select,:checkbox,:radio';
    this.dBox = 'body,div,form,table,tbody,th,tr,td,span,label,a,ul,ol,li,h1,h2,h3,h4,h5,h6,fieldset,legend';
    this.EmptyClass = 'c-empty';
    this.MsgEmpty = '不能为空！';
    this.UnCheckedClass = 'c-unchk';
    this.MsgUnChecked = '未选择！';
    this.IntErrClass = 'c-i-err';
    this.MsgIntErr = '整数格式错误！';
    this.FloatErrClass = 'c-f-err';
    this.MsgFloatErr = '小数格式错误！';
    this.StrErrClass = 'c-s-err';
    this.MsgStrErr = '输入长度错误！';
    this.cPat = /^c\-([fi](?:p?e?)|s(?:[ul]?e?t?|[ul]?t?e?))(-\w+)?(-\w+)?$/;

    //一套css對應,c-[if]p?e?，p为非负，c-s[ul]?e?，ul为大小写标记，e为非空标记
    var classFormat = {
        "c-i": "\\-?\\d*", //數字類型，默認只要是數字類型
        "c-i-1": "\\-?\\d?", //1位整数
        "c-i-2": "\\-?\\d{0,2}", //1-2位整数
        "c-i-3": "\\-?\\d{0,3}", //1-3位整数
        "c-i-4": "\\-?\\d{0,4}", //1-4位整数
        "c-i-5": "\\-?\\d{0,5}", //1-5位整数
        "c-i-6": "\\-?\\d{0,6}", //1-6位整数
        "c-i-7": "\\-?\\d{0,7}", //1-7位整数
        "c-i-8": "\\-?\\d{0,8}", //1-8位整数
        "c-i-9": "\\-?\\d{0,9}", //1-9位整数
        "c-i-10": "\\-?\\d{0,10}", //1-10位整数
        "c-i-11": "\\-?\\d{0,11}", //1-11位整数
        "c-ip": "([1-9]\\d*)?",
        "c-ip-1": "\\d?", //1位整数
        "c-ip-2": "\\d{0,2}", //1-2位整数
        "c-ip-3": "\\d{0,3}", //1-3位整数
        "c-ip-4": "\\d{0,4}", //1-4位整数
        "c-ip-5": "\\d{0,5}", //1-5位整数
        "c-ip-6": "\\d{0,6}", //1-6位整数
        "c-ip-7": "\\d{0,7}", //1-7位整数
        "c-ip-8": "\\d{0,8}", //1-8位整数
        "c-ip-9": "\\d{0,9}", //1-9位整数
        "c-ip-10": "\\d{0,10}", //1-10位整数
        "c-ip-11": "\\d{0,11}", //1-11位整数

        "c-f": "(-?\\d+\\.?\\d*)?", //浮點型，可以是整形,
        "c-f-2": "(-?\\d+\\.?\\d{0,2})?", //0-2位小数
        "c-f-4": "(-?\\d+\\.?\\d{0,4})?", //0-4位小数
        "c-f-12-4": "(-?\\d{1,2}(\\.\\d{0,4}))?", //至少2位整数，0-4位小数
        "c-fp": "(\\d+\\.?\\d*)?",
        "c-fp-2": "(\\d+\\.?\\d{0,2})?", //0-2位小数
        "c-fp-4": "(\\d+\\.?\\d{0,4})?", //0-4位小数

        "c-s": "[\\S\\s]*", //所有字符
        "c-s-1": "[\\S\\s]",
        "c-s-2": "[\\S\\s]{0,2}",
        "c-s-3": "[\\S\\s]{0,3}",
        "c-s-4": "[\\S\\s]{0,4}",
        "c-s-5": "[\\S\\s]{0,5}",
        "c-s-6": "[\\S\\s]{0,6}",
        "c-s-7": "[\\S\\s]{0,7}",
        "c-s-8": "[\\S\\s]{0,8}",
        "c-s-9": "[\\S\\s]{0,9}",
        "c-s-10": "[\\S\\s]{0,10}",
        "c-s-11": "[\\S\\s]{0,11}",
        "c-s-50": "[\\S\\s]{0,50}"

    };

    //實際存在的class
    var entityClassForm = {};

    //非匹配提示
    var classMsg = {
        "c-i": "為整數，輸入格式錯誤。",
        "c-i-1": "為1位整數，輸入格式錯誤。",
        "c-i-2": "為2位整數，輸入格式錯誤。",
        "c-i-3": "為3位整數，輸入格式錯誤。",
        "c-i-4": "為4位整數，輸入格式錯誤。",
        "c-i-5": "為5位整數，輸入格式錯誤。",
        "c-i-6": "為6位整數，輸入格式錯誤。",
        "c-i-7": "為7位整數，輸入格式錯誤。",
        "c-i-8": "為8位整數，輸入格式錯誤。",
        "c-i-9": "為9位整數，輸入格式錯誤。",
        "c-i-10": "為10位整數，輸入格式錯誤。",
        "c-i-11": "為11位整數，輸入格式錯誤。",
        "c-ip": "為非負整數，輸入格式錯誤。",
        "c-ip-1": "為1位非負整數，輸入格式錯誤。",
        "c-ip-2": "為2位非負整數，輸入格式錯誤。",
        "c-ip-3": "為3位非負整數，輸入格式錯誤。",
        "c-ip-4": "為4位非負整數，輸入格式錯誤。",
        "c-ip-5": "為5位非負整數，輸入格式錯誤。",
        "c-ip-6": "為6位非負整數，輸入格式錯誤。",
        "c-ip-7": "為7位非負整數，輸入格式錯誤。",
        "c-ip-8": "為8位非負整數，輸入格式錯誤。",
        "c-ip-9": "為9位非負整數，輸入格式錯誤。",
        "c-ip-10": "為10位非負整數，輸入格式錯誤。",
        "c-ip-11": "為11位非負整數，輸入格式錯誤。",

        "c-f": "為小數，輸入格式錯誤。",
        "c-f-2": "保留不多於2位小數，輸入格式錯誤。",
        "c-f-4": "保留不多於4位小數，輸入格式錯誤。",
        "c-f-12-4": "1-2位整數，0至4位小數，輸入格式錯誤。",
        "c-fp": "為非負小數，輸入格式錯誤。",
        "c-fp-2": "保留不多於2位非負小數，輸入格式錯誤。",
        "c-fp-4": "保留不多於4位非負小數，輸入格式錯誤。",

        "c-s": "不能為空。",
        "c-s-1": "不能超過1個字。",
        "c-s-2": "不能超過2個字。",
        "c-s-3": "不能超過3個字。",
        "c-s-4": "不能超過4個字。",
        "c-s-5": "不能超過5個字。",
        "c-s-6": "不能超過6個字。",
        "c-s-7": "不能超過7個字。",
        "c-s-8": "不能超過8個字。",
        "c-s-9": "不能超過9個字。",
        "c-s-10": "不能超過10個字。",
        "c-s-11": "不能超過11個字。",
        "c-s-50": "不能超过50個字符！"
    };

    var pCls = /^\.[a-z_][-\w]*$/,
        pId = /^#[\$\w]+$/,
        pName = /^\[name[!\^\$\*]?=[\w\[\]]+\]$/i,
        pBox = /^(body|div|form|table|tbody|th|tr|td|tfoot|thead|span|p|label|a|ul|ol|li|h1|h2|h3|h4|h5|h6|fieldset|legend|em|i|abbr|audio|b|big|button|caption|center|cite|code|dd|li|ol|embed|font|dl|dt|footer|form|head|header|map|mark|applet|option|pre|q|rp|rt|ruby|samp|small|strong|sub|summary|sup|title)$/i,
        pInput = /^(:text|input:hidden|:password|:radio|:checkbox:|textarea|select|:checked)$/i,
        pS = /^\s+|\s+$/g;

    var getEl = function (os) {
        if (os == document) return $(os);
        var arO = os.split(',');
        var obj = '';
        for (i = 0; i < arO.length; i++) {
            arO[i] = arO[i].replace(pS, '');
            if (pCls.test(arO[i])) {
                obj += ',' + arO[i];
            } else if (pId.test(arO[i])) {
                obj += ',' + arO[i];
            } else if (pName.test(arO[i])) {
                obj += ',' + arO[i];
            } else if (pBox.test(arO[i])) {
                obj += ',' + arO[i];
            } else if (pInput.test(arO[i])) {
                obj += ',' + arO[i];
            }
        }
        if (obj.length > 0) {
            obj = obj.substr(1);
            return $(obj);
        } else return '';
    }; //end of func getEl

    //返回容器裏可以綁定的類
    var getCls = function (box) {
        if (!box instanceof $) return '';
        var res = new Array(), tmp = "";
        for (em in classFormat) {
            if (box.find("." + em).length > 0 && $.inArray("." + em, res) < 0) {
                res.push("." + em);
            } else {
                var tmpC = getClassRenew(em);
                for (i = 0; i < tmpC.length; i++) {
                    tmp = tmpC[i];
                    if (box.find("." + tmp).length > 0 && $.inArray("." + tmp, res) < 0) {
                        res.push("." + tmp);
                    }
                } //end of for i
            }
        } //end of classFormat[i]
        return res.join(",");
    };
    //檢查欄位是否是符合classFormat的欄位，如果是就放入到entityClassForm
    var chkClassFormat = function () {
        var el = ""
        if (typeof arguments[0] != 'undefined') {
            if (arguments[0] instanceof $) el = arguments[0];
            else el = $(arguments[0]);
        } else return false;
        if (el.length != 1 || !el.is(_self.dEl)) return false;
        var flag = 0;
        for (em in classFormat) {
            if (el.hasClass(em)) {
                entityClassForm[em] = classFormat[em];
                flag = 1;
                break;
            } else {
                var tmpC = getClassRenew(em);
                for (i = 0; i < tmpC.length; i++) {
                    tmp = tmpC[i];
                    if (el.hasClass(tmp)) {
                        entityClassForm[tmp] = classFormat[em];
                        flag = 1;
                        break;
                    }
                } //end of for i
            }
        } //end of classFormat[i]
        if (flag == 1) return true;
        else return false;
    }; //end of chkClassFormat

    var init = function () {
        var o = typeof arguments[0] != 'undefined' ? arguments[0] : document;
        var tmp = $(o);
        var _s;
        for (var i = 0; i < tmp.length; i++) {
            _s = $(tmp[i]);
            if (_s.is(document) || _s.is(_self.dBox)) {
                if (_self._box instanceof $) {
                    _self._box.add(_s);
                } else _self._box = _s;
                if (_self._el instanceof $) {
                    _self._el.add(_s.find(_self.dEl));
                } else _self._el = _s.find(_self.dEl);
            } else if (_s.is(_self.dEl)) {
                if (_self._el instanceof $) {
                    _self._el.add(_s);
                } else _self._el = _s;
            }
        }
    }; //end of init
    init(arg);

    var getMsg = function (jq) {
        if (!jq instanceof $) return '';
        for (et in classMsg) {
            if (jq.hasClass(et)) {
                return classMsg[et];
            }
        }
        return false;
    }; //end of inMsg

    this.setFormat = function (c, p) {
        c = c.replace(/\s/g, '');
        p = p.replace(/\s/g, '');
        m = typeof arguments[2] != 'undefined' ? arguments[2] : '';
        et = c.split('-')[1];
        if (c == "" || p == "" || !/^([fi]p?e?)|(s[ul]?e?t?)$/.test(et)) return false;
        classFormat[c] = p;
        entityClassForm[c] = p;
        if (m != '')
            _self.setMsg(c, m);
    }; //end of setFormat

    this.setMsg = function (c, m) {
        c = c.replace(/\s/g, '');
        m = m.replace(/\s/g, '');
        if (c == "" || m == "") return false;
        classMsg[c] = m;
    }; //end of setMsg

    //获取类字符的类型，c-s-qwe，第二位
    var getClassPart = function (c, n) {
        var r = c.match(_self.cPat);
        if (r == null) return '';
        var len = r.length;
        if (n > len) return '';
        if (typeof r[n] != 'undefined') return r[n].replace(/\-/g, '');
        else return '';
    };

    //获取类的第二部分
    var getClassSec = function (c) {
        return getClassPart(c, 1);
    }; //end of getClassType

    //获取类的第三部分
    var getClassThir = function (c) {
        return getClassPart(c, 2).replace(/\-/g, '');
    }; //end of getClassThir

    //获取右侧
    var getClassRight = function (c) {
        var r = c.match(_self.cPat);
        if (r == null) return '';
        var len = r.length;
        if (len < 2) return '';
        else {
            var res = '';
            for (i = 2; i < len; i++) {
                if (typeof r[i] != 'undefined') {
                    res += '-' + r[i].replace(/\-/g, '');
                }
            }
            return res != '' ? res.substr(1) : res;
        }
    }; //end of getClassRight

    //判断什么类型 (i/f/s) 整形/浮点/字串
    var getClassType = function (c) {
        var sec = getClassSec(c);
        if (sec.indexOf('i') == 0) return 'i';
        else if (sec.indexOf('f') == 0) return 'f';
        else if (sec.indexOf('s') == 0) return 's';
        else return '';
    }; //end of getCType

    //判断是去空格，默认第三位开始判断,标识符t
    getIsTrim = function (c) {
        var sec = getClassSec(c);
        var t = getClassType(c);
        if ((t == 's') && sec.indexOf('t') >= 1) return true;
        else return false;
    };

    //如果是数字，判断是否是非负,标识符p
    var getIsP = function (c) {
        var sec = getClassSec(c);
        var t = getClassType(c);
        if ((t == 'i' || t == 'f') && sec.indexOf('p') == 1) return true;
        else return false;
    }; //end of getIsP

    //判断是否大写,标识符u
    var getIsU = function (c) {
        var sec = getClassSec(c);
        var t = getClassType(c);
        if (t == 's' && sec.indexOf('u') == 1) return true;
        else return false;
    }; //end of getIsU

    //判断是否小写,标识符l
    var getIsL = function (c) {
        var sec = getClassSec(c);
        var t = getClassType(getClassSec(c));
        if ((t == 's') && sec.indexOf('l') == 1) return true;
        else return false;
    }; //end of getIsU

    //判断是否需要判断空值，如果类的第二位及之后加了e，就表明要防呆空值
    var getIsEmp = function (c) {
        var sec = getClassSec(c);
        if (sec.indexOf('e') >= 1) return true;
        else return false;
    }; //end of getIsEmp

    //组合class,
    var getClassRenew = function (c) {
        var t = getClassType(c).replace(/\-/g, "");
        var rgt = getClassRight(c).replace(/\-/g, "");
        var res = new Array();
        if (t == 'i' || t == 'f') {
            res.push(c);
            res.push('c-' + t + 'e' + (rgt != '' ? '-' + rgt : ''));
            res.push('c-' + t + 'p' + (rgt != '' ? '-' + rgt : ''));
            res.push('c-' + t + 'pe' + (rgt != '' ? '-' + rgt : ''));
        } else if (t == 's') {
            var tmp = new Array('u', 'l', 'e', 't', 'ue', 'ut', 'le', 'et', 'te', 'lt', 'uet', 'ute', 'let', 'lte');
            for (i = 0; i < tmp.length; i++) {
                res.push('c-' + t + tmp[i] + (rgt != '' ? '-' : '') + rgt);
            }
        }
        return res;
    }; //end of getClassRenew

    //获取栏位的值 包括value和html
    this.getValue = function (jq) {
        var res = '';
        if (!jq instanceof $) return res;
        if (jq.is(':text,:hidden,:password,select') || jq.is('textarea')) {
            res = jq.val();
        } else if (jq.is(":checkbox,:radio")) {
            if (jq.is(':checked'))
                res = jq.val();
           else if (typeof jq.attr('name') != 'undefined' && $('[name=' + jq.attr('name').replace('[','').replace(']','').replace('[','').replace(']','') + ']:checked').length == 1) {
            //else if (typeof jq.attr('name') != 'undefined') {
               res = $('[name=' + jq.attr('name') + ']:checked').val();
            }
        } else if (jq.is(pBox))
            res = jq.html();
        return res;
    }; //end of getValue

    //设置栏位的值，包括value和html
    this.setValue = function (jq, v) {
        if (!jq instanceof $) return false;
        if (jq.is(':text,:hidden,:password') || jq.is("textarea")) {
            jq.val(v);
        } else if (jq.is(pBox))
            jq.html(v);
    }; //end of setValue

    //獲取容器的第一個 文本節點
    this.getLabel = function (jq) {
        var res = '';
        if (!jq instanceof $ || jq.is(document)) return res;
        if (jq.is(_self.dBox)) {
            res = jq.contents().filter(function () {
                return this.nodeType === 3;
            }).text();
        } else {
            var p = jq.parent();
            res = _self.getLabel(p);
        }
        return res;
    }; //end of getLabel

    //遍曆,对不符合的做增加标记类
    this.markCheck = function (jq) {
        if (!jq instanceof $) return false;
        var pat = '', errCls = '', flag = 0, trueC = '', trm = true;
        jq.removeClass(_self.EmptyClass);
        v = _self.getValue(jq);
        for (em in classFormat) {
            if (jq.hasClass(em)) {
                flag = 1;
                trueC = em;
            } else {
                var tmpC = getClassRenew(em);
                for (i = 0; i < tmpC.length; i++) {
                    if (jq.hasClass(tmpC[i])) {
                        flag = 1;
                        trueC = tmpC[i];
                        break;
                    }
                }
            }
            if (flag == 1) {
                tmp = classFormat[em];
                trm = getIsTrim(trueC);
                if (trm) v = v.replace(/^\s+|\s+$/g, '');
                emp = getIsEmp(trueC);
                if (emp) {
                    if (v == "") {
                        jq.addClass(_self.EmptyClass);
                        break;
                    } else jq.removeClass(_self.EmptyClass);
                }
                t = getClassType(trueC);
                if (t == 'i') errCls = _self.IntErrClass;
                else if (t == "f") errCls = _self.FloatErrClass;
                else if (t == "s") errCls = _self.StrErrClass;
                else continue;
                if (jq.is(':checkbox') || jq.is(':radio')) {
                    var jName = "";
                    if (typeof jq.attr('name') != "undefined")
                        jName = jq.attr("name").replace(/[\[\]]/g, '');
                    if (jName != '' && $('[name=' + jName + ']:checked').length == 1) {
                        jq = $('[name=' + jName + ']:checked');
                    } else if (!jq.is(':checked')) {
                        jq.addClass(_self.UnCheckedClass);
                        break;
                    }
                } else if (!(jq.is(_self.dInput) || jq.is('textarea') || jq.is(document) || jq.is(_self.dBox))) {
                    break;
                }
                pat = new RegExp('^' + tmp + '$');
                if (!pat.test(v)) {
                    jq.addClass(errCls);
                    /*
                    if (getIsU(trueC))
                        v = v.toUpperCase();
                    else if (getIsL(trueC))
                        v = v.toLowerCase();
                    _self.setValue(jq, v);
                    */
                } else {
                    jq.removeClass(errCls);
                }
                break;
            }
        } //end of for
        return true;
    }; //end of markCheck

    //匹配截取第一个
    this.valueCheck = function (jq) {
        if (!jq instanceof $) return false;
        var tmp = '', v = '', pat = '', r = '', t = '', flag = 0, trueC = '', trm = true;
        if (jq.is(_self.dInput) || jq.is('textarea') || jq.is(document) || jq.is(_self.dBox)) {
            v = _self.getValue(jq);
            for (em in classFormat) {
                if (jq.hasClass(em)) {
                    flag = 1;
                    trueC = em;
                } else {
                    var tmpC = getClassRenew(em);
                    for (i = 0; i < tmpC.length; i++) {
                        if (jq.hasClass(tmpC[i])) {
                            flag = 1;
                            trueC = tmpC[i];
                            break;
                        }
                    }
                }
                if (flag == 1) {
                    tmp = classFormat[em];
                    pat = new RegExp(tmp);
                    trm = getIsTrim(trueC);
                    if (trm) v = v.replace(/^\s+|\s+$/g, '');
                    if (!jq.is("textarea")) {
                        r = v.match(pat);
                        if (r != null) {
                            v = '';
                            t = getClassType(trueC);
                            if (t == 'f' || /[^()]*\([^()]*\)[^()]*/.test(tmp)) {
                                v = r[0];
                            } else {
                                for (k = 0; k < r.length; k++) {
                                    if (typeof r[k] != 'undefined')
                                        v += '' + r[k];
                                }
                            }
                            if (getIsU(trueC))
                                v = v.toUpperCase();
                            else if (getIsL(trueC))
                                v = v.toLowerCase();
                            _self.setValue(jq, v);
                        } else _self.setValue(jq, '');
                    } else {
                        var subs = getClassThir(em).replace(/\-/g, "");
                        if (/\d+/.test(subs)) {
                            v = v.substr(0, (subs <= v.length ? subs : v.length));
                            _self.setValue(jq, v);
                        }
                    }
                    break;
                } //end of if hasClass
            } //end of classFormat[i]
        } //end of if is
    }; //end of valueCheck

    //使用input propertychange代替keydown
    this.keyFire = function () {
        var box = typeof arguments[0] != 'undefined' ? getEl(arguments[0]) : $(document);
        var esp = typeof arguments[1] != 'undefined' ? getEl(arguments[1]) : '';
        var els = '', el = "";
        if (!(box instanceof $)) return false;
        if (box.is(document) || box.is(_self.dBox)) {
            el=$(_self.dEl,box);
        } else if (box.is(_self.dEl)) {
            el = box;
        };
        if (!$.support.leadingWhitespace) { ////IE 6-8
            el.bind("contextmenu", function () { return false; });
            $(document).undelegate(el,'keyup.fieldscheck paste.fieldscheck')
                .delegate($(_self.dEl,box),'keyup.fieldscheck paste.fieldscheck', function (e) {
                    var jq = $(e.target);
                    if (!chkClassFormat(jq)) return false;
                    if (els != '' && els.index(jq) < 0) return false;
                    if (esp != '' && esp.index(jq) >= 0) return false;
                    _self.valueCheck(jq);
                    exeFunc(jq);
                }); //end of bind
        } else {
            $(document).undelegate(el,'input.fieldscheck propertychange.fieldscheck')
                .delegate(el,'input.fieldscheck propertychange.fieldscheck', function (e) {
                    var jq = $(e.target);
                    if (!chkClassFormat(jq)) return false;
                    if (esp != '' && esp.index(jq) >= 0) return false;
                    _self.valueCheck(jq);
                    exeFunc(jq);
                }); //end of delegate
        }
    }; //end of keyFire

    this.setFunc=function(){
        var param = typeof arguments[0] != 'undefined' ? arguments[0] : '';
        if(_self.isJson(param)){
            _self.func=param;
        }
    };

    var exeFunc=function(el){
        var p=_self.func;
        var func='';
        if(!_self.isJson(p)) return false;
        for(m in p){
            if(el.is($(m,_self._box))){
                if(/^.*\(\)$/.test(p[m]))
                    func=p[m];
                else func=p[m]+'()';
                eval(func);
            }//end of if
        }//end of for
    };

    this.isJson=function(param){
        if(typeof(param) == "object" && Object.prototype.toString.call(param).toLowerCase() == "[object object]" && !param.length) return 1
        else return 0;
    };

    this.keyMark = function () {
        var box = typeof arguments[0] != 'undefined' ? getEl(arguments[0]) : $(document);
        var esp = typeof arguments[1] != 'undefined' ? getEl(arguments[1]) : '';
        var els = '', el = "";
        if (!(box instanceof $)) return false;
        if (box.is(document) || box.is(_self.dBox)) {
            el = $(_self.dEl,box);
        } else if (box.is(_self.dEl)) {
            el = box;
        };
        if (!$.support.leadingWhitespace) { ////IE 6-8
            el.bind("contextmenu", function () { return false; });
            $(document).undelegate(el, 'keyup.fieldscheck1 paste.fieldscheck1')
                .delegate(el, 'keyup.fieldscheck1 paste.fieldscheck1', function (e) {
                    var jq = $(e.target);
                    if (!chkClassFormat(jq)) return false;
                    if (els != '' && els.index(jq) < 0) return false;
                    if (esp != '' && esp.index(jq) >= 0) return false;
                    _self.markCheck(jq);
                }); //end of bind
        } else {
            $(document).undelegate(el, 'input.fieldscheck propertychange.fieldscheck')
                .delegate(el, 'input.fieldscheck propertychange.fieldscheck', function (e) {
                    var jq = $(e.target);
                    if (!chkClassFormat(jq)) return false;
                    if (els != '' && els.index(jq) < 0) return false;
                    if (esp != '' && esp.index(jq) >= 0) return false;
                    _self.markCheck(jq);
                }); //end of delegate
        }
    }; //end of keyMark

    //總體驗證,返回提示的数组
    this.checkMsg = function () {
        var box = typeof arguments[0] != 'undefined' ? getEl(arguments[0]) : _self._box;
        var esp = typeof arguments[1] != 'undefined' ? getEl(arguments[1]) : '';
        if (!(box instanceof $ && box.is(_self.dBox))) return false;
        var jq = '', res = [], msg = '', label = '', markC = "";
        var tmp = box.find(_self.dEl);
        for (var i = 0; i < tmp.length; i++) {
            jq = $(tmp[i]);
            if (esp != '' && esp.index(jq) >= 0) continue;
            _self.markCheck(jq);
            if (jq.hasClass(_self.EmptyClass)) {
                //console.log(jq);
                msg = getMsg(jq) || _self.MsgEmpty;
            } else if (jq.hasClass(_self.UnCheckedClass)) {
                msg = getMsg(jq) || _self.MsgUnChecked;
            } else if (jq.hasClass(_self.IntErrClass)) {
                msg = getMsg(jq) || _self.MsgIntErr;
            } else if (jq.hasClass(_self.FloatErrClass)) {
                msg = getMsg(jq) || _self.MsgFloatErr;
            } else if (jq.hasClass(_self.StrErrClass)) {
                msg =getMsg(jq) ||  _self.MsgStrErr;
            } else continue;
            if (typeof jq.data('msg') != 'undefined' && jq.data('msg').replace(/^\s+|\s+$/g, '') != '') {
                res.push(jq.data('msg').replace(/^\s+|\s+$/g, ''));
                continue;
            } else {
                label = _self.getLabel(jq);
            }

            if (/^\s|\s$/.test(label)) label = '';
            if (typeof jq.data('check') != 'undefined') label = jq.data('check');
            else if (typeof jq.data('chk') != 'undefined') label = jq.data('chk');
            if (label == '') {
                label = "有欄位";
            }
            res.push('【' + label + '】' + msg);
        }
        return res;
    }; //end of checkMsg
};//end of FieldsCheck

/*
isDate 判断是否是日期格式
(s,ft) s:输入字串支持(2017-01-01 01:01:01,2017/01/01 01:01:01)
	ft:日期格式 y:年,ym:年/月，md:月/日，ymd：年/月/日,ymdh：年/月/日 时,ymdhm:年/月/日 时:分,ymdhms：年/月/日 时:分:秒
 */
isDate = function (s, ft) {
    var patY = /^\d{4}$/,
        patYM = /^(\d{4})-(\d{1,2})/,
        patMD = /^(\d{1,2})-(\d{1,2})$/,
        patYMD = /^\d{4}-(\d{1,2})-(\d{1,2})$/,
        patYMDH = /^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2})$/,
        patYMDHM = /^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2})$/,
        patYMDHMS = /^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/,
        patHM = /^(\d{1,2}):(\d{1,2})$/,
        patHMS = /^(\d{1,2}):(\d{1,2}):(\d{1,2})$/,
        s = s.replace(/\//g, '-');
    var d,now = new Date(),r=null;
    ft=ft.tolowercase();
    if (ft == 'y') {
        r = s.match(patY);
        if (r == null) return false;
        d = new Date(r[0]);
        if (d.getFullYear() != r[0]) return false;
    } else if (ft == 'ym') {
        r = s.match(patYM);
        if (r == null) return false;
        d = new Date(r[1], r[2]);
        console.log(d.getMonth());
        if (d.getFullYear() != r[1]) return false;
        if (d.getMonth() != r[2]) return false;
    } else if (ft == 'md') {
        r = s.match(patMD);
        if (r == null) return false;
        d = new Date(now.getFullYear, r[2], r[3]);
        if (d.getMonth() != r[2]) return false;
        if (d.getDate() != r[3]) return false;
    } else if (ft == 'ymd') {
        r = s.match(patYMD);
        if (r == null) return false;
        d = new Date(r[1], r[2], r[3]);
        if (d.getFullYear() != r[1]) return false;
        if (d.getMonth() != r[2]) return false;
        if (d.getDate() != r[3]) return false;
    } else if (ft == 'ymdh') {
        r = s.match(patYMDH);
        if (r == null) return false;
        d = new Date(r[1], r[2], r[3], r[4])
        if (d.getFullYear() != r[1]) return false;
        if (d.getMonth() != r[2]) return false;
        if (d.getDate() != r[3]) return false;
        if (d.getHours() != r[4]) return false;
    } else if (ft == 'ymdhm') {
        r = s.match(patYMDHM);
        if (r == null) return false;
        d = new Date(r[1], r[2], r[3], r[4].r[5])
        if (d.getFullYear() != r[1]) return false;
        if (d.getMonth() != r[2]) return false;
        if (d.getDate() != r[3]) return false;
        if (d.getHours() != r[4]) return false;
        if (d.getMinutes() != r[5]) return false;
    } else if (ft == 'ymdhms') {
        r = s.match(patYMDHMS);
        if (r == null) return false;
        d = new Date(r[1], r[2].r[3], r[4], r[5], r[6]);
        if (d.getFullYear() != r[1]) return false;
        if (d.getMonth() != r[2]) return false;
        if (d.getDate() != r[3]) return false;
        if (d.getHours() != r[4]) return false;
        if (d.getMinutes() != r[5]) return false;
        if (d.getSeconds() != r[6]) return false;
    }else if(ft=='hm'){
        r = s.match(patHM);
        if (r == null) return false;
        d = new Date(now.getFullYear(), now.getMonth(),now.getDate(), r[0], r[1]);
        if (d.getHours() != r[0]) return false;
        if (d.getMinutes() != r[1]) return false;
    }else if(ft=='hms'){
        r = s.match(patHMS);
        if (r == null) return false;
        d = new Date(now.getFullYear(), now.getMonth(),now.getDate(), r[0], r[1],r[2]);
        if (d.getHours() != r[0]) return false;
        if (d.getMinutes() != r[1]) return false;
        if (d.getSeconds() != r[2]) return false;
    } else return false;
    return true;
}; //end of isDate

/*
 SuperQuery
 超級查詢，
 //查询按钮<input type="button" class="s-btn" value="高级查询" onclick="superQuery.win();" />
 //
调用方式：页面载入时$(function(){...});
 superQuery=new SuperQuery({
 'fieldsUrl':'?r=information/aqs/copen01/testsuper',//获取查询栏位的url
 'queryUrl':'?r=information/aqs/copen01/findhead',//查询提交url，超级查询或自动向[queryBox]里追加_sq=1超级查询标志=1表明是超级查询,
 	//另外 fieldsUrl中每多一个页签，就额外多追加一个textarea的隐藏栏位，命名规格是_sq+流水[1,2,3,...]
 'toArea':'#boxFindHeadRight',//查询结果丢到的区域
 'title':'高级查询',//弹出窗口的标题，
 'id':'artSuperQuery',//窗口的id，和【title】一起，如果只有一个超级查询，这2个属性可以不加，有默认值
 'queryBox':'#formHead'//呼应【queryUrl】，高级查询的查询条件追加的容器
 });
//另外后台接收时需要 调用 pub::superQueryCheck()对接收的_sq1,_sq2做防注入验证。
//另外查询根据标记栏位_sq=1，添加页面的注释[高级查询]
//fieldsUrl 栏位传的数据为JSON格式，"单头条件"为页签名称，对应值为二维数组格式，
//[[栏位代码,栏位名称,栏位类型(text/日期,select,checkbox),输入栏位默认值,输入栏位使用的类(可与fieldsCheck结合防呆)],[...]]
//输入栏位默认值(select,checkbox类型时,默认值可以为二维数组[[值,显示名称,选中标记(1)],[...]])
 $s='{"单头条件":[["a.TA001","单别","text","","c-sut-4"],["a.TA002","单号","text","","c-sut-15"],
 ["a.TA003","单据日期","ymd","2017/01/01",""],["a.TA004","审核状态","select",[["Y","已审核"],["N","未审核"]],""]
 ],
 "单身条件":[["b.TB001","单别","text","","c-sut-4"],["b.TB002","单号","text","","c-sut-15"],
 ["b.TB003","单据日期","ymd","2017/01/01",""],["b.TB004","审核状态","select",[["Y","已审核"],["N","未审核"]],""]
 ],
 "其他条件":[["c.TC001","单别","text","","c-sut-4"],["c.TC002","单号","text","","c-sut-15"],
 ["c.TC003","单据日期","ymd","2017/01/01",""],["c.TC004","审核状态","select",[["Y","已审核"],["N","未审核"]],""]
 ]
 }';
 */
SuperQuery=function(){
    var _self=this,_args=arguments[0];
    this.fieldsUrl='';//取栏位资料的url
    this.queryUrl='';//提交查询资料的url
    this.toArea='';//结果放置位置
    this.cancelFunc='';//关闭窗口的调用func
    this.queryBox='';//页面的容器，formId或者其他 div的Id
    this.superFlag='_sq';//高级查询的标志栏位
    this.fieldsData='';//获取到的栏位资料[字段(唯一),名称,类型,默认值,防呆,额外class,内联样式],数组
    this.fieldsTab={};//{tabId:$()}
    this.fieldsL= {};//{tabId:$()}
    this.fieldsM={"a":"等于","b":"大于等于","c":"小于等于","d":"大于","e":"小于","f":"不等于","g":"起始于","h":"终止于","i":"包含"};
    this.fieldsMv={"a":"=","b":">=","c":"<=","d":">","e":"<","f":"<>","g":["like","*%"],"h":["like","%*"],"i":["like","%*%"]};
    this.fieldsR={};//{tabId,$()}
    this.contents=$();
    this.inputs={};//对应页签：值 {tabId:""}
    this.baseId='spQry';
    this.dialogTitle="设定查询";
    this.dialogId="artSuperQuery";
    this.now='';
    this.tabBoxId='';
    this.tabContentIds={};//contents与tabid对应{tabId:divId}
    this.l1Cls='c-sq-l1';//line1Id;
    this.l1rCls='c-sq-l1r';
    this.l2Cls='c-sq-l2';
    this.l3Cls='c-sq-l3';
    this.lbtn='';
    this.option='';
    this.flag=true;
    this.exception='';

    //判断undefined
    var isUnd=function(s){
        return typeof s=='undefined';
    }//end of isUnd

    //异常判断处理
    var fuckExp=function(){
        if(_self.flag){
            alert(_self.exception);
            return true;
        }
    }//end of fuckExp

    //类型获取
    var getType=function(s){
        return Object.prototype.toString.apply(s) || Object.prototype.toString.call(s);
    }//end of getType

    //生成时间戳
    var createUTC=function(){
        var now=_self.now;
        if(!$.isNumeric(now)){
            now=new Date();
            _self.now= Date.UTC(now.getFullYear(),now.getMonth(),now.getDate(),now.getHours(),now.getMinutes(),now.getSeconds(),now.getMilliseconds());
        }
        return _self.now;
    }//end of createUTC

    var createId=function(s){
        if(isUnd(s)) s='';
        return _self.baseId+'_'+s+createUTC();
    }//end of createId

    //json 通过value找key,(json,value,begin)
    var jsonV2K=function(){
        var args=arguments;
        if(getType(args[0])!='[object Object]' || getType(args[1])!='[object String]')
            return '';
        var json=args[0],val=args[1],begin='';
        if(getType(args[2])=='[object String]' || !isNaN(parseInt(args[2])))
            begin=args[2];
        begin=begin.replace(/^\s+|\s+$/g,'');
        var flag= 0,res="",count=0;
        for(var m in json){
            if(begin!=""){
                if(flag==0 && (m==begin || count==begin)){
                    flag=1
                }else flag++;
                if(flag<2) continue
            }
            if(json[m]==val){
                res=m;
                break;
            }
        }//end of for m in json
        return res;
    }//end of jsonV2K

    var jqAddClass=function(jq,cls) {
        var arr=cls.split(/[, ]/);
        for(var i=0;i<arr.length;i++){
            if(!(/\s/).test(arr[i]))
                jq.addClass(arr[i]);
        }
        return jq;
    }//end of jqAddClass

    //生成单个jquery对象
    var createJq=function(d,tabId){
        var name= $.trim(d[0]),label= $.trim(d[1]), typ=$.trim(d[2]),deft=d[3],cls=d[4],jq;
        switch (typ.toLowerCase()){
            case 'text':
                jq=$("<input type='text' data-name='"+name+"' name='"+name+"' value='' class='s-hidden' />")
                if(getType(deft)=='[object String]')
                    jq.val(deft);
                jq=jqAddClass(jq,cls);
                break;
            case 'select':
                jq=$("<select data-name='"+name+"' name='"+name+"' class='s-hidden'></select>");
                jq=jqAddClass(jq,cls);
                if(getType(deft)=='[object Array]'){
                    for(var i=0;i<deft.length;i++){
                        if(getType(deft[i])=='[object Array]' && deft[i].length>=2){
                            var tmp=$("<option value='"+deft[i][0]+"'>"+deft[i][1]+"</option>");
                            if(!isUnd(deft[i][2]) && deft[i][2]==1)
                                tmp.attr('selected','selected');
                            jq.append(tmp);
                        }//end of getType(deft[i])
                    }//end of for deft
                }//end of if getType(deft)
                break;
            case 'checkbox':
                if(getType(deft)=='[object Array]'){
                    var jq=$(),wp;
                    for(var i=0;i<deft.length;i++){
                        tmp=$("<input type='checkbox' name='"+name+"' value='' />");
                        if(getType(deft[i])=='[object Array]' && deft[i].length>1){
                            wp=$("<label class='s-ib'>"+deft[i][1]+"</label>");
                            tmp.val(deft[i][0]);
                            if(!isUnd(deft[i][2]) && deft[i][2]==1)
                                tmp.attr('checked','checked');
                            wp.append(tmp);
                        }else {
                            tmp.val(deft[i]);
                            wp=tmp;
                        }
                        jq=jq.add(wp);
                    }//end of for deft
                }else{
                    jq=$("<input type='checkbox' name='"+name+"' value='' />");
                    if(getType(deft)=='[object Array]' && deft.length>1) {
                        jq.val(deft[0]);
                        if(!isUnd(deft[2]) && deft[2]==1)
                            jq.attr('checked','checked');
                        jq=jq.wrap($("<label class='s-ib'>"+deft[1]+"</label>"));
                    }else jq.val(deft);
                }//end of getType(deft)
                jq=jq.wrap("<div class='s-ib s-hidden' data-name='"+name+"'></div>");
                break;
            case 'y'://日期格式的
                if(getType(deft)!='[object String]' && !isDate(deft,'y')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"yyyy\"})' />");
                break;
            case 'ym':
                if(getType(deft)!='[object String]' && !isDate(deft,'ym')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"yyyy/MM\"})' />");
                break;
            case 'md':
                if(getType(deft)!='[object String]' && !isDate(deft,'md')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"MM/ddM\"})' />");
                break;
            case 'ymd':
                if(getType(deft)!='[object String]' && !isDate(deft,'ymd')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"yyyy/MM/dd\"})' />");
                break;
            case 'ymdh':
                if(getType(deft)!='[object String]'&& !isDate(deft,'ymdh')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"yyyy/MM/dd HH\"})' />");
                break;
            case 'ymdhm':
                if(getType(deft)!='[object String]' && !isDate(deft,'ymdhm')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"yyyy/MM/dd HH:mm\"})' />");
                break;
            case 'ymdhms':
                if(getType(deft)!='[object String]' && !isDate(deft,'ymdhs')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"yyyy/MM/dd HH:mm:ss\"})' />");
                break;
            case 'hm':
                if(getType(deft)!='[object String]' && !isDate(deft,'hm')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"HH:mm\"})' />");
                break;
            case 'hms':
                if(getType(deft)!='[object String]' && !isDate(deft,'hms')) deft="";
                jq=$("<input type='text' class='Wdate s-input s-hidden' data-name='"+name+"' name='"+name+"' value='"+deft+"' onclick='WdatePicker({dateFmt:\"HH:mm:ss\"})' />");
                break;
            default: ;
        }//end of switch
        var op=$("<option data-name='"+name+"' value='"+name+"'>"+label+"["+name+"]"+"</option>");
        if(!isUnd(_self.fieldsL[tabId])){
            _self.fieldsL[tabId]=_self.fieldsL[tabId].add(op);
        }else _self.fieldsL[tabId]=op;
        if(!isUnd(_self.fieldsR[tabId])){
            _self.fieldsR[tabId]=_self.fieldsR[tabId].add(jq);
        }else _self.fieldsR[tabId]=jq;
    }//end of createJq

    var createTab=function(id,name,count){
        if(name=="") name="Tab"+count;
        var tmp=$("<div class='s-ib s-tab' data-tabid='' id='"+id+"'>"+name+"</div>");
        _self.fieldsTab[id]=tmp;
    }//end of creaTab

    //产生fields数据
    var createFields=function(){
        fuckExp();
        var data=_self.fieldsData;
        if(getType(data)!='[object Object]' || $.isEmptyObject(data))
            return true;
        var count=1;
        for(var m in data){
            var tabId=createId('tab'+count);
            createTab(tabId,m,count);
            var mv=data[m];
            for(var i=0;i<mv.length;i++){
                if(getType(mv[i])!='[object Array]' || mv[i].length<3)
                    continue;
                createJq(mv[i],tabId);
            }//end of for data
            count++;
        }
    }//end of createFields

    //取欄位資料
    this.getFieldsData=function(){
        var fieldsUrl=_self.fieldsUrl;
        if(getType(fieldsUrl)=='[object String]'){
            $.ajax({
                type:'get',
                dataType:'json',
                url:fieldsUrl,
                async:false,
                success:function(res){
                    if(res['_code']=='[0000]'){
                        if(!isUnd(res['data'])){
                            _self.flag=false;
                            _self.fieldsData=res['data'];
                        }else{
                            _self.flag=true;
                            _self.exception=res['_code'];
                        }//end of if
                    }else return true;
                }
            });//end of $.ajax
        }else return true;
    };//end of getFieldsData

    //queryBox的超级查询 查询结果存储到原始页面
    var querySave=function(){
        var queryBoxId=_self.queryBox,inputs=_self.inputs,saveObj=$(),queryBox=$(),superFlagId=_self.superFlag;
        if(getType(queryBoxId)=='[object String]' && $.trim(queryBoxId)!="")
            queryBox=$($.trim(queryBoxId));
        else return true;
        if(queryBox.length==1){
            var count=0;
            for(var m in inputs){
                count++;
                var k='_sq'+count;
                saveObj=queryBox.find("[name="+k+"]");
                if(saveObj.length>0){
                    saveObj.val(inputs[m]);
                }else{
                    var tmp=$("<textarea class='s-hidden' name='"+k+"'></textarea")
                    tmp.val(inputs[m]);
                    queryBox.prepend(tmp);
                }
            }//end of for inputs
        }
        if(getType(superFlagId)=='[object String]' && $.trim(superFlagId)!=""){
            superFlagId= $.trim(superFlagId);
            var superFlag=queryBox.find("[name="+superFlagId+"]");
            if(superFlag.length>0)
                superFlag.val("1");
            else queryBox.prepend($("<input type='hidden' name='"+superFlagId+"' value='1' />"));
        }
    }//end of querySave
    //左侧select绑定事件,按钮事件绑定
    var bindEven=function(){
        var cnt=_self.contents,
            inputs=_self.inputs,
            tab2Cont=_self.tabContentIds,
            tabBoxOuter=cnt.find('#'+_self.tabBoxId),
            lBtn=cnt.find('#'+_self.lbtn),
            sub=lBtn.find('[name='+_self.baseId+'_sub]'),
            cancel=lBtn.find('[name='+_self.baseId+'_cancel]'),
            l1ls=cnt.find('[name='+_self.baseId+'_selectL]'),
            aos=cnt.find('[name='+_self.baseId+'_ao]'),
            fm=_self.fieldsMv,
            areas=cnt.find('[name='+_self.baseId+'_area]'),
            clears=cnt.find('[name='+_self.baseId+'_clear]'),
            adds=cnt.find('[name='+_self.baseId+'_add]');
        //页签点击事件绑定
        var tabBox=tabBoxOuter.find('div.s-tab');
        tabBox.bind('click',function(){
            var el=$(this);
            if(el.hasClass('s-tabing'))
                return true;
            tabBox.removeClass('s-tabing');
            el.addClass('s-tabing');
            var tabId=tab2Cont[el.attr('id')];
            var cTab=cnt.find(".s-tabbox");
            var curTab=cTab.filter('#'+tabId);
            cTab.addClass("s-hidden");
            curTab.removeClass("s-hidden");
            curTab.find('[name='+_self.baseId+'_selectL]').trigger('change');
        });
        //页签内其他事件绑定
        //左侧select
        l1ls.bind('change',function(){
            var el=$(this),
                name=el.val(),
                tbl=el.closest('table'),
                l1=tbl.find('.'+_self.l1Cls),
                l1r=l1.find('.'+_self.l1rCls),
                rs=l1r.find(':input'),
                ops=l1.find('[name='+_self.baseId+'_selectM]').find('option');
            ops.eq(0).attr("selected",true);
            rs.addClass('s-hidden').removeClass('tg-sq-cked');
            $.each(rs,function(){
                var r=$(this);
                if(r.data('name')==name)
                    r.removeClass('s-hidden').addClass('tg-sq-cked');
            });//end of $.each
        });//end of click l1l
        //关系checkbox
        aos.bind("click keyup",function(){
            var el=$(this);
            el.closest('div').find(':checkbox').attr("checked",false);
            el.attr("checked",true);
        });//end of click aos
           //清除按钮
        clears.bind('click',function(){
            var el=$(this),
                div=el.closest('div.s-tabbox'),
                divId=div.attr('id'),
                tab2Id=_self.tabContentIds,
                tabId=jsonV2K(tab2Id,divId);
            inputs[tabId]='';
            div.find('[name='+_self.baseId+'_area]').val('');
        });//end of click clears
        //添加按钮
        adds.bind('click',function(){
            var el=$(this),
                div=el.closest('div.s-tabbox'),
                divId=div.attr('id'),
                tab2Id=_self.tabContentIds,
                tabId=jsonV2K(tab2Id,divId),
                l1=div.find('.'+_self.l1Cls),
                l1l=l1.find('[name='+_self.baseId+'_selectL]'),
                lv=l1l.val(),
                mv=l1.find('[name='+_self.baseId+'_selectM]').val(),
                r=l1.find('.'+_self.l1rCls).find('.tg-sq-cked'),
                rv=r.val().replace(/'/g,"''"),
                l2=div.find('.'+_self.l2Cls),
                ao=l2.find('[name='+_self.baseId+'_ao]'),
                l3=div.find('.'+_self.l3Cls),
                area=l3.find('[name='+_self.baseId+'_area]');
            var rStr="",str="",aoStr="",fv='';
            if(!isUnd(fm[mv])){
                fv=fm[mv];
                if(getType(fv)=='[object Array]'){
                    if(fv[0]=='like'){
                        rStr=fv[0]+" '"+fv[1].replace('*',rv)+"'";
                    }else return true;
                    if(rv=="") return true;
                }else{
                    rStr=fv+" '"+rv+"'";
                }//end of getType fv
                str=lv+" "+rStr;
                if(!isUnd(inputs[tabId])){
                    aoStr=ao.filter(":checked").val();
                    if($.trim(inputs[tabId])!="") str="\r\n "+aoStr+" "+str;
                    inputs[tabId]+=encodeURIComponent(str);
                }else{
                    inputs[tabId]=encodeURIComponent(str);
                }
                area.val(decodeURIComponent(inputs[tabId]));
            }else{
                return true;
            }//end of isUnd fm[mv]
        });//end of click adds

        //textarea添加手动
        areas.bind('keyup',function(){
            var el=$(this),
                div=el.closest('div.s-tabbox'),
                divId=div.attr('id'),
                tab2Id=_self.tabContentIds,
                tabId=jsonV2K(tab2Id,divId);
            inputs[tabId]=encodeURIComponent(el.val());
        });

        //查询按钮
        sub.bind('click',function(){
            if(_self.queryUrl!=""){
                var data={},inputs=_self.inputs,count= 0,k='_sq';
                for(var m in inputs){
                    count++;
                    k='_sq'+count;
                    data[k]=inputs[m]
                }
                var toArea=$(_self.toArea);
                $.ajax({
                    url:_self.queryUrl,
                    type:'post',
                    data:data,
                    success:function(res){
                        if(toArea.length>0)
                            toArea.html(res);
                        //页面开启超级查询的标志位
                        //超级查询的查询条件丢到form中
                        querySave();
                    },complete:function(){
                        cancel.trigger('click');
                    }
                });
            }//end of if
        });//
        //取消按钮(关闭)
        cancel.bind('click',function(){
            var func=_self.cancelFunc;
            if(_self.cancelFunc!="" && getType(window[func])=='[object Function]')
                eval(func+'()');
            else _self.winClose();
        });
    };//end of bindSelect

    //textarea 读取输入值
    var readInput=function(){
        var inputs=_self.inputs,
            html=_self.contents,
            tabCont=_self.tabContentIds;
        if(getType(inputs)!='[object Object]' || $.isEmptyObject(inputs))
            return true;
        for(var m in inputs){
            var tabContentBox=html.find("#"+tabCont[m]),
                area=tabContentBox.find("[name="+_self.baseId+"_area]");
            area.html(decodeURIComponent(inputs[m]));
        }

    }//end of readInput

    //绘制界面
    var createMain=function(){
        createFields();
        var id=createId();
        _self.trueId=id;
        //创建一个容器div.s-box
        var box=$("<div id='"+id+"' class='s-box'></div>");
        var tabBoxId=createId('tabBox');
        _self.tabBoxId=tabBoxId;
        var tabBox=$("<div id='"+tabBoxId+"' style='margin:0;width:100%;'></div>");
        //tab页签
        var tabs=_self.fieldsTab;
        var count=0;
        for(var t in tabs){
            count++;
            //页签内容div
            var tabContentId=createId('tc'+count);
            _self.tabContentIds[t]=tabContentId;
            var contBox=$("<div id='"+tabContentId+"' style='padding:0;margin:0;' class='s-tabbox s-hidden'></div>");
            tabBox.append(tabs[t]);
            //产生一个table
            var tbl=$("<table class='s-tbl'></table>");
            //第一行
            var line1Class=_self.l1Cls;
            var line1=$("<tr class='"+line1Class+"'><td style='width:190px;padding-bottom:2px;'></td><td style='width:95px;'></td><td style='width:155px;padding-bottom:2px;'></td></tr>");
            var td1s=line1.find('td'),td11=td1s.eq(0),td12=td1s.eq(1),td13=td1s.eq(2);
            //第一个td
            var l1Left=$("<select name='"+_self.baseId+'_selectL'+"' class='s-input' style='width:180px;'></select>");
            if(!isUnd(_self.fieldsL[t]))
                $.each(_self.fieldsL[t],function(){
                    l1Left.append($(this));
                });
            td11.append(l1Left);
            //第二个td
            var l1M=$("<select name='"+_self.baseId+'_selectM'+"' class='s-input' style='width:90px;'></select>");
            var ms=_self.fieldsM;
            for(var m in ms){
                l1M.append($("<option value='"+m+"'>"+ms[m]+"</option>"));
            }//end of for mid
            td12.append(l1M);
            //第三个td
            var l1RightClass=_self.l1rCls;
            var l1Right=$("<div class='s-ib "+l1RightClass+"' style='width:145px;'></div>");
            if(!isUnd(_self.fieldsR[t]))
                $.each(_self.fieldsR[t],function(){
                    var tmp=$(this);
                    tmp.css('width','99%');
                    l1Right.append(tmp);
                });
            td13.append(l1Right);
            tbl.append(line1);
            //产生第二行，关系标签和按钮
            var line2Class=_self.l2Cls;
            var line2=$("<tr class='"+line2Class+"'><td style='padding:2px;' colspan='2'></td><td style='padding:2px 10px 2px 0;text-align:right;'></td></tr>");
            var td2s=line2.find('td'),td21=td2s.eq(0),td22=td2s.eq(1);
            var p2Left=$("<div class='s-ib' style='width:99%;'><span style='font-size:12px;padding:0;margin-right:10px;'>条件关系</span></div>");
            p2Left.append($("<label class='s-ib' style='vertical-align:bottom;'>AND<input type='checkbox' name='"+_self.baseId+"_ao' value='AND' style='margin:0 2px;' checked='checked' /></label>"));
            p2Left.append($("<span class='s-ib'>&nbsp;&nbsp;</span>"));
            p2Left.append($("<label class='s-ib' style='vertical-align:bottom;'>OR<input type='checkbox' name='"+_self.baseId+"_ao' value='OR' /></label>"));
            td21.append(p2Left);
            var btnClear=$("<input type='button' name='"+_self.baseId+"_clear' class='s-btn s-reset' value='清除' style='margin:0 4px;' />");
            var btnAdd=$("<input type='button' name='"+_self.baseId+"_add' class='s-btn' value='添加' />");
            td22.append(btnClear);
            td22.append(btnAdd);
            tbl.append(line2);

            //第三行textarea区域
            var line3Class=_self.l3Cls;
            var line3=$("<tr class='"+line3Class+"'><td colspan='3' style='padding:2px;'></td></tr>"),td3=line3.find("td");
            var area=$("<textarea name='"+_self.baseId+"_area' class='s-input' style='width:99%;height:150px;'></textarea>");
            td3.append(area);
            tbl.append(line3);
            contBox.append(tbl);
            box.append(contBox);
        }//end of for tabs m
        //放到盒子里
        //最后一行，查询确认按钮区域
        var line0Id=createId('lbtn');
        _self.lbtn=line0Id
        var line0=$("<div id='"+line0Id+"' style='padding:2px;margin:0;text-align:center;vertical-align:middle;'></div>");
        var btnSub=$("<input type='button' name='"+_self.baseId+"_sub' class='s-btn' value='查询' style='margin:0 4px;' />");
        var btnCnl=$("<input type='button' name='"+_self.baseId+"_cancel' class='s-btn s-reset' value='取消' />");
        line0.append(btnSub);
        line0.append(btnCnl);
        box.append(line0);
        box.prepend(tabBox);
        _self.contents=box;
        readInput();
    }//end of createMain

    //弹出窗口
    this.win=function(){
        if(getType(_self.fieldsData)!='[object Object]' || !$.isEmptyObject(_self.fieldsData.length))
            _self.getFieldsData();
        if(_self.contents.length==0){
            createMain();
            bindEven();
        }
        var content=superQuery.getHtml();
        var d = dialog({
            title:_self.dialogTitle,
            id:_self.dialogId,
            content:content
        });
        d.showModal();
    }//end of win

    //关闭窗口
    this.winClose=function(){
        var dialogId=_self.dialogId;
        if(dialogId!="" && typeof dialog.get(dialogId)!='undefined')
            dialog.get(dialogId).close().remove();
    }

    //初始化
    this.init=function(args){
        if(!isUnd(args['fieldsUrl']))
            _self.fieldsUrl=args['fieldsUrl'];
        if(!isUnd(args['queryUrl']))
            _self.queryUrl=args['queryUrl'];
        if(!isUnd(args['toArea']))
            _self.toArea=args['toArea'];
        if(!isUnd(args['cancelFunc']))
            _self.cancelFunc=args['cancelFunc'];
        if(!isUnd(args['queryBox']))
            _self.queryBox=args['queryBox'];
        if(!isUnd(args['superFlag']))
            _self.superFlag=args['superFlag'];
        if(!isUnd(args['title']))
            _self.dialogTitle=args['title'];
        if(!isUnd(args['id']))
            _self.dialogId=args['id'];
    };//end of

    _self.init(_args);

    this.getHtml=function(){
        var cnt=_self.contents,
            tab=cnt.find('.s-tab').eq(0);
        tab.trigger('click');
        return cnt.get();
    };//end of getHtml
};//end of SuperQuery

function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);//search,查询？后面的参数，并匹配正则
    if(r!=null)return  unescape(r[2]); return null;
}