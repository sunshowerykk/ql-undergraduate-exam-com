<?php

use yii\helpers\Html;
use app\models\pub;
use app\models\langs;
/* css调用 echo Html::cssFile('assets/css/notes/main.css');  */
//echo Html::cssFile('assets/artDialog/ui-dialog.css');
//echo Html::cssFile('assets/css/public.css');
//echo Html::jsFile('assets/js/jquery-1.8.1.min.js');
////echo Html::jsFile('assets/js/jquery.form.js');
//echo Html::jsFile('assets/artDialog/dialog-plus.js');  //弹出框
?>
<style>
    ul li{
        list-style-type:none;
    }
</style>
<div style="width: 850px;">
    <div style="overflow-y:auto; padding:2px;margin-bottom: 5px">
        <div id="FindHead">
            <?//begin增加修改字段排版位置?>
            <form action="?r=hotel/hotelhouse/savehead" method="post" id="dialogForm" class="form-inline">
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                <input type='hidden' name='_k' value='<?=$rk?>' />
                <input type='hidden' name='vP' value='<?=$rp?>' />
                <input type='hidden' name='vHouseId' value='<?=pub::chkData($r_data,'houseid')?>' />
                <input type='hidden' name='vCID' value='<?=$CID?>' />
                <table class="table table-bordered table-condensed" style="table-layout: fixed;word-break:break-all; word-wrap:break-word;">
                    <tr class="tr-list">
                        <th style="text-align:right;width: 80px">房间编号：</th>
                        <td style="text-align:left;">
                            <input type="text"
                                   class="c-set  input-sm c-tab" data-chk='房间编号'
                                   placeholder="房间编号"
                                   name='vHouseName' maxlength="30" style="width: 140px"
                                   value="<?=pub::chkData($r_data,'housenumber')?>" />
                        </td>
                        <th style="width:80px;">酒店名称：</th>
                        <td style="width:200px;text-align:left">
                            <input type="text" style="display:inline;width:120px;"
                                   class="c-set  input-sm c-tab" name='vHotelName' id='vHotelName'
                                   data-chk='酒店名称' maxlength="30"
                                   value="<?=pub::chkData($r_data,'hotelname')?>" readonly="readonly" />
                            <a href="javascript:void(0)" title="选择酒店名称" style="text-decoration:none;"
                               class="s-ib s-call"
                               data-url="?r=hotel/hotelinfo/indexhotel"
                               data-id="dialogHotel"
                               data-title="选择酒店名称"
                               onclick="loadHotel01.fire(this);" >调入
                            </a>
                            <a href="javascript:void(0)" title="清空房型" style="margin:0 2px;"
                               class="s-ib s-clear"
                               onclick="loadHotel01.clear();">
                            </a>
                            <input type="hidden" name='vHotelId' id='vHotelId' value="<?=pub::chkData($r_data,'hotelid','')?>">
                        </td>
                        <th style="width:80px;">房型：</th>
                        <td style="width:200px;text-align:left">
                            <input type="text" style="display:inline;width:120px;"
                                   class="c-set  input-sm c-tab" name='vTypeName' id='vTypeName'
                                   data-chk='房型'
                                   value="<?=pub::chkData($r_data,'typename','')?>" readonly="readonly" />
                            <a href="javascript:void(0)" title="选择房型" style="text-decoration:none;"
                               class="s-ib s-call"
                               data-url="?r=system/housetype/indextype"
                               data-id="dialogCls"
                               data-title="选择房型"
                               onclick="loadCls01.fire(this);" >调入
                            </a>
                            <a href="javascript:void(0)" title="清空房型" style="margin:0 2px;"
                               class="s-ib s-clear"
                               onclick="loadCls01.clear();">
                            </a>
                            <input type="hidden" name='vTypeId' id='vTypeId' value="<?=pub::chkData($r_data,'typeid','')?>">
                        </td>
                    </tr>
                    <tr class="tr-list">
                        <th style="text-align:right;">房间价格：</th>
                        <td style="text-align:left;">
                            <input type="text"
                                   class="c-fp-2 input-sm c-tab" data-chk='房间价格'
                                   placeholder="房间价格"
                                   name='vPrice' maxlength="30" style="width: 140px"
                                   value="<?=pub::chkData($r_data,'price')?>" />
                        </td>
                        <th style="text-align:right;">房间标签：</th>
                        <td style="text-align: left;" colspan="3">
                                            <input name="vTitleName"   class="c-set input-sm c-tab" id="vTitleName" value="<?= pub::chkData($r_data, 'titlename', "") ?>"
                                                      style="width:400px;resize:none;" data-chk='房间标签'
                                                      readonly="readonly" />
                                <input type="hidden" name="vTitleId" id="vTitleId"
                                       value="<?= pub::chkData($r_data, 'titleid', "") ?>"/>
                                <a href="javascript:void(0)" title="选择标签"
                                   class="s-ib s-call"
                                   onclick="loadTitle('vTitleName','vTitleId','<?= Yii::$app->request->csrfToken ?>');return false;">调入</a>

                                <a href="javascript:void(0)" class="s-ib s-clear" title="清空选择" onclick="cleartext();"></a>
                        </td>
                    </tr>
                    <tr>
                        <th>房间图片</th>
                        <td colspan="5">
                            <div class="container">
                                <div class="demo">
                                    <a class="btn btn-info btn-xs" id="btn">上传房间图片</a>
                                    <ul id="ul_pics" class="ul_pics clearfix"></ul>
                                    <?if($rop=='edit'):?>
                                        <?foreach ($p_data1 as $v):?>
                                            <li style="list-style-type:none;">
                                                <div style=" float:left; display:inline" id="img<?=$v['FileId']?>">
                                                    <img style="width:140px;height:120px;"  src='<?=$v['FilePath']?>'/>
                                                    <i onclick=delimg('<?=$v['FileId']?>');>
                                                        <img  title="删除图片" src='assets/img/access_disallow.gif'/>
                                                    </i>
                                                    <input type='hidden' id='vSrc<?=$v['FileId']?>' value='<?=$v['FilePath']?>'>
                                                </div>
                                            </li>
                                        <?endforeach;?>
                                    <?endif;?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">显示排序:</th>
                        <td style="text-align:left;">
                            <input type="text"
                                   class="c-i-4  input-sm c-tab" data-chk='排序'
                                   placeholder="排序"
                                   name='vRank' maxlength="30" style="width: 140px"
                                   value="<?=pub::chkData($r_data,'rank')?>" />
                        </td>
                        <th style="text-align:right;">备注信息:</th>
                        <td style="text-align:left;" >
                            <input
                                   class="input-sm c-tab " data-chk='备注信息'
                                   name='vRemark'  value="<?=pub::chkData($r_data,'remark')?>"
                            />
                        </td>
                        <th style="text-align:right;">输入人员:</th>
                        <td style="text-align:left;" >
                            <span><?=pub::chkData($r_data,'Inuser',Yii::$app->user->identity->UserName)?></span>
                        </td>
                    </tr>
                </table>
            </form>
            <?//end增加修改字段排版位置?>
        </div>
        <?//子表明细字段排版位置?>
        <div id="addDetail"  class="Detail">
        </div>
    </div>
    <div class="" style="text-align: right;padding: 2px;border-top: 2px solid #e5e5e5;" >
        <button type="button" class="btn btn-default btn-sm" onclick="artClose('artHead');">取消</button>
        <button type="button" class="btn btn-primary btn-sm c-fire" onclick="artSave('dialogForm')">保存</button>
    </div>
</div>
<script>
    function cleartext(){
        $("#ReceiptName").val('');
        $("#ReceiptId").val('');
    }
    //图片封面上传
    var uploader = new plupload.Uploader({ //创建实例的构造方法
        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
        browse_button: 'btn', // 上传按钮
        url: '/?r=hotel/hotelinfo/uphead&c1=<?=$CID?>&c2=1', //远程上传地址
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
            url: '?r=hotel/hotelinfo/deluphead',
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
    function loadTitle(rname, rid, csrf) {
        var er = dialog();//等待提醒
        er.show();
        var d = dialog({ //彈出框
            title: '标签选择',
            id: 'loadtitle',
            lock: true
        });
        // jQuery ajax
        var url = '?r=hotel/hotelhouse/findtitle';
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
                $('#vRecField').val(decodeURIComponent($('#ReceiptId').val()));
                er.close().remove();//關閉等待提醒窗口
                //d.focus();
                d.showModal();
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
    }
</script>