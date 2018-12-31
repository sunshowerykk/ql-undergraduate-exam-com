<?php

use yii\helpers\Html;
use app\models\langs;
use app\models\pub;
echo Html::jsFile('assets/js/jquery.zclip.min.js'); //copy
?>
<div class="contentRight">
    <div class="homeTit">试卷管理/复制连接</div>
    <div  class="ptFzDiv">
        <input type="text" value="<?=$link?>" id="link">
        <button id="copyBtn">复制链接</button>
    </div>
</div>

<script>
    $("#copyBtn").zclip({
        path:'/assets/js/ZeroClipboard.swf',
        copy:$('#link').val(),
        beforeCopy:function(){
            //some code
        },
        afterCopy:function(){
            alert("复制成功");
        }
    });
</script>
</body>