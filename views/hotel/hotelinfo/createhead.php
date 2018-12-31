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
<div style="width: 850px;">
    <div style="overflow-y:auto; padding:2px;margin-bottom: 5px">
        <div id="FindHead">
            <?//begin增加修改字段排版位置?>
            <form action="?r=hotel/hotelinfo/savehead" method="post" id="dialogForm" class="form-inline">
                <input type='hidden' id='_csrf' name='_csrf'  value='<?= Yii::$app->request->csrfToken ?>' />
                <input type='hidden' name='_k' value='<?=$rk?>' />
                <input type='hidden' name='vP' value='<?=$rp?>' />
                <input type='hidden' name='vHotelId' value='<?=pub::chkData($r_data,'hotelid')?>' />
                <input type='hidden' name='vCID' value='<?=$CID?>' />
                <table class="table table-bordered table-condensed" style="table-layout: fixed;word-break:break-all; word-wrap:break-word;">
                    <tr class="tr-list">
                        <th style="text-align:right;width: 80px">酒店名称：</th>
                        <td style="text-align:left;">
                            <input type="text"
                                   class="c-set  input-sm c-tab" data-chk='酒店名称'
                                   placeholder="酒店名称"
                                   name='vHotelName' maxlength="30" style="width: 140px"
                                   value="<?=pub::chkData($r_data,'hotelname')?>" />
                        </td>
                        <th style="text-align:right;width: 80px">酒店简介：</th>
                        <td style="text-align:left;" colspan="3">
                            <input type="text"
                                   class="c-set  input-sm c-tab" data-chk='酒店简介'
                                   placeholder="酒店简介"
                                   name='vIntro' maxlength="120" style="width: 480px"
                                   value="<?=pub::chkData($r_data,'intro')?>" />
                        </td>
                    </tr>
                    <tr class="tr-list">
                        <th style="width:80px;text-align:right;">预定须知：</th>
                        <td style="width:160px;text-align:left;" colspan="5">
                            <textarea type="text"
                                      class="c-set  input-sm c-tab" data-chk='预定须知'
                                      name='vNotice'  style="width: 730px;" autofocus
                                      >
                                <?=pub::chkData($r_data,'notice')?>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 450px" colspan="6">
                            <div style="width:830px;text-align:center;">
                                <b>酒店地址：</b><input id="text_" name="vHoteladdress" type="text" data-chk='酒店地址'
                                                     class="c-set  input-sm c-tab"  value="<?=pub::chkData($r_data,'hoteladdress')?>" style="margin-right:40px;" onkeyup="searchByStationName();"/>
                                <input type="hidden" name="vCity" id="vCity" value="">
                                <b>查询结果(经纬度)</b><input id="result_" class="c-set  input-sm c-tab" type="text" name="vLng" readonly="readonly" value="<?=pub::chkData($r_data,'lat')?>,<?=pub::chkData($r_data,'lng')?>"  data-chk='经纬度' />
                                <input type="button" class="btn btn-primary btn-sm c-fire"  value="查询" onclick="searchByStationName();"/>
                                <div id="container"
                                     style="position: absolute;margin-top:30px;width: 830px;height: 350px;top: 50;border: 1px solid gray;overflow:hidden;">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>封面图片</th>
                        <td colspan="5">
                            <div class="container">
                                <div class="demo">
                                    <a class="btn btn-info btn-xs" id="btn1">上传封面图片</a>
                                    <ul id="ul_pics1" class="ul_pics clearfix1"></ul>
                                    <?if($rop=='edit'):?>
                                        <?foreach ($p_data1 as $v):?>
                                            <li style="list-style-type:none;">
                                                <div style=" float:left; display:inline" id="img<?=$v['FileId']?>">
                                                    <img style="width:140px;height:120px;"  src='<?=$v['FilePath']?>'/>
                                                    <i onclick=delimg1('<?=$v['FileId']?>');>
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
                        <th>轮播图片</th>
                        <td colspan="5">
                            <div class="container">
                                <div class="demo">
                                    <a class="btn btn-info btn-xs" id="btn2">上传轮播图片</a>
                                    <ul id="ul_pics2" class="ul_pics clearfix2"></ul>
                                    <?if($rop=='edit'):?>
                                        <?foreach ($p_data2 as $v):?>
                                            <li>
                                                <div style=" float:left; display:inline" id="img<?=$v['FileId']?>">
                                                    <img style="width:140px;height:120px;"  src='<?=$v['FilePath']?>'/>
                                                    <i onclick=delimg2('<?=$v['FileId']?>');>
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
                                   name='vOrder' maxlength="30" style="width: 140px"
                                   value="<?=pub::chkData($r_data,'order')?>" />
                        </td>
                        <th style="text-align:right;">是否推荐:</th>
                        <td style="text-align:left;">
                            <label style="vertical-align: middle;">
                                <input type="radio" value="0" name="vRecommend" style="vertical-align: middle;"
                                    <?=pub::chkData($r_data,'recommend',"1")?'':"checked"?>>否</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label style="vertical-align: middle;">
                                <input type="radio" value="1" name="vRecommend" style="vertical-align: middle;"
                                    <?=pub::chkData($r_data,'recommend',"1")?'checked':""?>  >是</label>
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
    var map = new BMap.Map("container");
    //var myCity = new BMap.LocalCity();
    //myCity.get(getCityByIP);
   // var map = new BMap.Map("allmap");
    var point = new BMap.Point(116.413387,39.910924);//地图初始中心点
   /// alert(point);
    map.centerAndZoom(point,12);


    var geolocation = new BMap.Geolocation();
    var gc = new BMap.Geocoder();
    geolocation.getCurrentPosition( function(r) {   //定位结果对象会传递给r变量

            if(this.getStatus() == BMAP_STATUS_SUCCESS)
            {  //通过Geolocation类的getStatus()可以判断是否成功定位。
                var pt = r.point;
                map.panTo(pt);//移动地图中心点
                //alert(r.point.lng);//X轴
                //alert(r.point.lat);//Y轴

                gc.getLocation(pt, function(rs){
                    var addComp = rs.addressComponents;
                   // alert(addComp.city);
                    //alert(addComp.province + addComp.city + addComp.district + addComp.street + addComp.streetNumber);
                });
            }
            else
            {
                //关于状态码
                //BMAP_STATUS_SUCCESS   检索成功。对应数值“0”。
                //BMAP_STATUS_CITY_LIST 城市列表。对应数值“1”。
                //BMAP_STATUS_UNKNOWN_LOCATION  位置结果未知。对应数值“2”。
                //BMAP_STATUS_UNKNOWN_ROUTE 导航结果未知。对应数值“3”。
                //BMAP_STATUS_INVALID_KEY   非法密钥。对应数值“4”。
                //BMAP_STATUS_INVALID_REQUEST   非法请求。对应数值“5”。
                //BMAP_STATUS_PERMISSION_DENIED 没有权限。对应数值“6”。(自 1.1 新增)
                //BMAP_STATUS_SERVICE_UNAVAILABLE   服务不可用。对应数值“7”。(自 1.1 新增)
                //BMAP_STATUS_TIMEOUT   超时。对应数值“8”。(自 1.1 新增)
                switch( this.getStatus() )
                {
                    case 2:
                        alert( '位置结果未知 获取位置失败.' );
                        break;
                    case 3:
                        alert( '导航结果未知 获取位置失败..' );
                        break;
                    case 4:
                        alert( '非法密钥 获取位置失败.' );
                        break;
                    case 5:
                        alert( '对不起,非法请求位置  获取位置失败.' );
                        break;
                    case 6:
                        alert( '对不起,当前 没有权限 获取位置失败.' );
                        break;
                    case 7:
                        alert( '对不起,服务不可用 获取位置失败.' );
                        break;
                    case 8:
                        alert( '对不起,请求超时 获取位置失败.' );
                        break;

                }
            }

        },
        {enableHighAccuracy: true}
    )
   // map.centerAndZoom(遂宁, 12);
    map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

    map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
    map.addControl(new BMap.OverviewMapControl()); //添加默认缩略地图控件
    map.addControl(new BMap.OverviewMapControl({ isOpen: true, anchor: BMAP_ANCHOR_BOTTOM_RIGHT }));   //右下角，打开

    var localSearch = new BMap.LocalSearch(map);
    localSearch.enableAutoViewport(); //允许自动调节窗体大小
    function searchByStationName() {
        map.clearOverlays();//清空原来的标注
        var keyword = document.getElementById("text_").value;
        localSearch.setSearchCompleteCallback(function (searchResult) {
            var poi = searchResult.getPoi(0);
            document.getElementById("result_").value = poi.point.lng + "," + poi.point.lat;
            var testpoint= poi.point.lng + "," + poi.point.lat;
          //  console.log(testpoint);
            map.centerAndZoom(poi.point, 13);
            var marker = new BMap.Marker(new BMap.Point(poi.point.lng, poi.point.lat));  // 创建标注，为要查询的地方对应的经纬度
            map.addOverlay(marker);
            var content = document.getElementById("text_").value + "<br/><br/>经度：" + poi.point.lng + "<br/>纬度：" + poi.point.lat;
            var infoWindow = new BMap.InfoWindow("<p style='font-size:14px;'>" + content + "</p>");
            marker.addEventListener("click", function () { this.openInfoWindow(infoWindow); });
            // marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
          //  var gc = new BMap.Geocoder();
            var newpoint = new BMap.Point(poi.point.lng, poi.point.lat);
            gc.getLocation(newpoint, function(rs){
                var addComp = rs.addressComponents;
                $("#vCity").val(addComp.province + "-" + addComp.city + "-" + addComp.district );
              //  alert(addComp.province + "- " + addComp.city + "- " + addComp.district );
            });
        });
        localSearch.search(keyword);
    }
    //图片封面上传
    var uploader1 = new plupload.Uploader({ //创建实例的构造方法
        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
        browse_button: 'btn1', // 上传按钮
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
                if ($("#ul_pics1").children("li").length == 1) {
                    alert("您上传的图片太多了！");
                    uploader1.destroy();
                } else {
                    var li = '';
                    plupload.each(files, function(file) { //遍历文件
                        li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                    });
                    $("#ul_pics1").append(li);
                    uploader1.start();
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
                $("#" + file.id).html("<div class='img' id='img" + data.uid + "'><img src='" + data.pic + "'/><i onclick=delimg1('" + data.uid + "');><img src='assets/img/access_disallow.gif'/></i><input type='hidden' id='vSrc" + data.uid + "' value='"+ data.pic +"'></div>");
            },
            Error: function(up, err) { //上传出错的时候触发
                alert(err.message);
            }
        }
    });
    uploader1.init();
    //轮播图上传
    var uploader2 = new plupload.Uploader({ //创建实例的构造方法
        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
        browse_button: 'btn2', // 上传按钮
        url: '/?r=hotel/hotelinfo/uphead&c1=<?=$CID?>&c2=2', //远程上传地址
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
        multi_selection: true, //true:ctrl多文件上传, false 单文件上传
        init: {
            FilesAdded: function(up, files) { //文件上传前
                if ($("#ul_pics2").children("li").length ==3) {
                    alert("您上传的图片太多了！");
                    uploader2.destroy();
                } else {
                    var li = '';
                    plupload.each(files, function(file) { //遍历文件
                        li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                    });
                    $("#ul_pics2").append(li);
                    uploader2.start();
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
                $("#" + file.id).html("<div class='img' id='img" + data.uid + "'><img src='" + data.pic + "'/><i onclick=delimg2('" + data.uid + "');><img src='assets/img/access_disallow.gif'/></i><input type='hidden' id='vSrc" + data.uid + "' value='"+ data.pic +"'></div>");
            },
            Error: function(up, err) { //上传出错的时候触发
                alert(err.message);
            }
        }
    });
    uploader2.init();
    function delimg1(uid) {//删除图片
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
    function delimg2(uid) {//删除图片
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
</script>