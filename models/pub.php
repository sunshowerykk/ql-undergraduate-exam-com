<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Connection;
use yii\log\FileTarget;

class pub extends Model
{

    public static function CAD1($val,$field){
        $r = empty($val)?"":(empty($val[$field])?"":$val[$field]);
        return $r;
    }
    //字節轉成MB
    public static function formatBytes($size)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
        return round($size, 2) . $units[$i];
    }
    //寫日誌
    /* web.php [log] [targets]
                    'home'=>[ //自定义Log
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['home'],
                    'logFile' => '@app/runtime/logs/requests.log',
                    'maxFileSize' => 1024*2,
                    'maxLogFiles' => 20,

                ],
     */
    public static function wrlog($info, $model = 'debug')
    {
        $ts = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $path =$ts[1]['class'].'->'.$ts[1]['function'].'<'. $ts[0]['line'].'>';


        $conf = Yii::$app->log->targets['home'];
        $usr = "";
        if (!Yii::$app->user->isGuest) { //记录操作用户
            $usr = "[".Yii::$app->user->identity->UserName.']';
        }
        $time = microtime(true);
        $conf->logFile =Yii::$app->getRuntimePath().'/logs/'.$model.'/'.date('Y-m-d').'/debug.log';
        $log = new FileTarget($conf);
        $info =chr(13).'  '.$usr.print_r($info,true);
        $log->messages[] = [$info,1,$path,$time];
        $log->export();

    }

    /*檢查提交的欄位是否正確
      $val  檢查的內容
      $type 檢查的類型,如果@开头,则视为自定义正则匹配，@后面跟自定义正则表达式,如："@/^-?\\d{1,2}(\\.\\d{0,4})$/",//至少2位整数，0-4位小数
            @/^.{1,10}$/,1-10位字符，没有去前后空格
      $info 提示的信息
      $json true用json false不用json
    */
    public static function chkPost($val,$type,$info,$json = false){
        if ($json) { //判断 json类型
            $info = '{"_code":"'.$info.'"}';
        }
        if ($type == 'int') { //整数
            if (!preg_match("/^-?\d*$/i", $val)) {
                print_r($info);
                Yii::$app->end();
            }
        }else if ($type == 'Pint') { //匹配非负整数（正整数 + 0）
            if (!preg_match("/^-?\d*$/i",$val)) {
                print_r($info);
                Yii::$app->end();
            }
        }else if ($type == 'float'){//浮点数
            if (!preg_match("/^-?([1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0)$/i", $val)) {
                print_r($info);
                Yii::$app->end();
            }
        }else if ($type == 'Pfloat'){ ////匹配非负浮点数（正浮点数 + 0）
            if (!preg_match("/^[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0?\.0+|0$/i", $val)) {
                print_r($info);
                Yii::$app->end();
            }
        }else if (strpos($type,'@') === 0){//@开头的为自定义正则匹配
            if(strlen($type)>1){
                $pat=substr($type,1);
                if (!preg_match($pat, $val)) {
                    print_r($info);
                    Yii::$app->end();
                }
            }
        }else if($type == ''){
            if (trim($val)=='') {
                print_r($info);
                Yii::$app->end();
            }
        }
        return $val;
    }
    public static function getHtml($result){
        $r = "<div style='margin: 10px'>$result</div>";
        return $r;
    }
    /*页面解析md5返回add,edit,1
    public static function deFormMD5($md5,$id = ""){
        $key = 'sw3856';
        if (Yii::$app->user->isGuest) { //过期或未登录
            $key1 = 'error';
        }else{
            $key1 = Yii::$app->user->identity->UserName;
        }
        $vadd = md5('add'.$id.$key.$key1);
        $vedit = md5('edit'.$id.$key.$key1);
        $vk = md5($id.$key.$key1);
        $r = '';
        if($md5==$vadd){
            $r = 'add';
        }else if($md5 == $vedit){
            $r = 'edit';
        }else if ($md5 == $vk){
            $r = '1';
        }
        return $r;
    }//end of deFormMD5
   */
    /*类型add新增,edit修改*/
    public static function enFormMD5($t,$id = ""){
        $key = 'sw3856';
        if (Yii::$app->user->isGuest) { //过期或未登录
            $key1 = 'error';
        }else{
            $key1 = Yii::$app->user->identity->UserName;
        }
        /*if($t=='add'){
            $r = md5('add'.$key);
        }elseif ($t=='edit' && $id!=''){
            $r = md5('edit'.$id.$key);
        }elseif ($t=='del' && $id!=''){
            $r = md5('del'.$id.$key);
        }else{
            $r=md5($t.$id.$key);
        }*/
        $r=md5($t.$id.$key.$key1);
        return $r;
    }
    public static function enFormMD52($t,$id = ""){
        $key = 'sw3856';
        /*if($t=='add'){
            $r = md5('add'.$key);
        }elseif ($t=='edit' && $id!=''){
            $r = md5('edit'.$id.$key);
        }elseif ($t=='del' && $id!=''){
            $r = md5('del'.$id.$key);
        }else{
            $r=md5($t.$id.$key);
        }*/
        $r=md5($t.$id.$key);
        return $r;
    }
    /*驗證操作的唯一關鍵字是否正確
    public static function chkID($k,$id){
        //驗證提交信息合法性//验证唯一ID
        $kv = pub::enFormMD5(Yii::$app->user->identity->UserName,$id);
        if ($k<>$kv){
            $r = "验证失败，无提交！";
            print_r($r);
            Yii::$app->end();
        }

    }*/
    /*验证是否为手机用户访问*/
    public static function isMobile(){
        $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
        function CheckSubstrs($substrs,$text){
            foreach($substrs as $substr)
                if(false!==strpos($text,$substr)){
                    return true;
                }
            return false;
        }
        $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
        $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

        $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||
            CheckSubstrs($mobile_token_list,$useragent);

        if ($found_mobile){
            return true;
        }else{
            return false;
        }
    }

    /*取角色的權限*/
    public static function get($r){
        if (Yii::$app->user->isGuest) {
            return 0;
        }
        $right = Yii::$app->user->identity->RoleID.$r;
        $result = Yii::$app->cache->get(strtolower($right))==""?0:1;
        return $result;
    }
    /*驗證數據變量
      $t_data  数组参数
      $t_id    数组ID
      $t_val   返回默认值
      $t_len   *1 乘1, 0 不操作；大于0，字符串截取
    */
    public static function chkData($t_data,$t_id,$t_val = "",$t_len = "0"){

        if ($t_id<>""){
            $r = isset($t_data[$t_id]); //变量存在为true,不存在False
            if ($r == true) {
                $r = $t_data[$t_id];//empty($t_data[$t_id])?$t_val:$t_data[$t_id];
                if (substr($t_len,0,1)=='*'){//*1,乘1
                    $r = $r * 1;
                }elseif($t_len>0){//字符串截取
                $r = substr($r,0,$t_len);
            }
            }else{;
                $r = $t_val;
            }

        }else{
            $r = isset($t_data[$t_id])?$t_data:$t_val;
        }
        return $r;
    }
    public static function chkData2($t_data,$t_id,$t_val = "",$t_len = "0"){

        if ($t_id<>""){
            $r = isset($t_data[$t_id]); //变量存在为true,不存在False
            if ($r == true) {
                $r = $t_data[$t_id];//empty($t_data[$t_id])?$t_val:$t_data[$t_id];
                if (substr($t_len,0,1)=='*'){//*1,乘1
                    $r = $r * 1;
                }elseif($t_len>0){//字符串截取
                    $r = substr($r,10,$t_len);
                }
            }else{;
                $r = $t_val;
            }

        }else{
            $r = isset($t_data[$t_id])?$t_data:$t_val;
        }
        return $r;
    }

    /*更新緩存*/
    public static function UpdateCache(){
        //清空緩存
        Yii::$app->cache->flush();
        //產生權限緩存
        $sql = "select CONCAT(aaa.RoleID,aaa.ModID,rCode) as rName,rValue from sys_rightdetail aaa,
               (SELECT aa.ModID,bb.RoleID
               FROM sys_mode aa, sys_right bb
               WHERE aa.ModID = bb.ModID  AND ModType='P' and
                     (modParent IN (SELECT a.ModID
                            FROM sys_mode a, sys_right b
                            WHERE a.ModID = b.ModID AND b.RoleID=bb.RoleID  AND ModType = 'M') OR ModType = 'M')
                ) bbb
            where aaa.RoleID=bbb.RoleID and aaa.ModID=bbb.ModID and aaa.RoleID<>'0'";

        $qright = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($qright as $val){
            Yii::$app->cache->set(strtolower($val['rName']),$val['rValue']);
        }

    }
    /* 短信发送
    http://14.23.153.70:9999/smshttp?act=sendmsg&unitid=100&UserName=test&passwd=test&msg=text&phone=13911111111,18911111111&port=&sendtime=2008-01-01 12:00:00
    $data = array
		(
		'unitid'=>$uid,					//用户账号
        'UserName'=>$uid,					//用户账号
		'passwd'=>md5($pwd.$uid),			//MD5位32密码,密码和用户名拼接字符
		'mobile'=>$mobile,				//号码
		'msg'=>$content,			//内容
        'port'=>'',
		'sendtime'=>$sendtime,  //date('Y-m-d H:i:s')
		);
	$re= postSMS($http,$data);			//POST方式提交


     */
    public static function  postSMS($mobile,$content='')
    {
        //$content = iconv("GB2312","UTF-8",$content); //将utf-8转为gb2312再发
        //$url = "http://service.winic.org:8009/sys_port/gateway/?";
        $url = "http://14.23.153.70:9999/smshttp?act=sendmsg";
        $data = array
        (
            'unitid'=>'112645',//企业代码
            'UserName'=> "bolxrmyy01",				//用户账号
            'passwd'=> md5("6299283"),			//MD5位32密码
            'phone'=> $mobile,	//号码
            'msg'=> $content,			//内容
            'sendtime'=> "",//date('Y-m-d H:i:s'),  //date('Y-m-d H:i:s')
            /*
            'id'=> "nicklyj",					//用户账号
            'pwd'=> "Qaz123456",				//密码
            'to'=> "$mobile",	//号码
            'content'=> $content,			//内容
            'time'=>"",
            */
        );
        $row = parse_url($url);

        $host = $row['host'];
        $port = empty($row['port'])?"80":$row['port'];
        $file = empty($row['path'])?"":$row['path'];
        $post = empty($row['query'])?"":$row['query']."&";
        while (list($k,$v) = each($data))
        {
            $post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
        }
        //print_r($post);Yii::$app->end();
        $post = substr( $post , 0 , -1 );
        $len = strlen($post);
        $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp)) {
                $receive .= fgets($fp, 128);
            }
            fclose($fp);
            $receive = explode("\r\n\r\n",$receive);
            unset($receive[0]);
            return implode("",$receive);
        }
    }
    //取出部门树图含已经停用的
    /*
        $pid = 上級ID
        $type = 查詢類型 1-有效的部門 0-失效的部門  空-全部部門
        $except 排除的部門含下級
    */
    public static function loadDept($pid = '0',$type = '',$except = ''){
        $wheretype = "";
        if ($type<>""){
            $wheretype = " AND IsEnabled='1' ";
        }
        if ($except<>""){
            $wheretype .= " AND DeptID not in('$except') ";
        }
        $c_tree = "";
        $sql="SELECT * FROM sys_dept WHERE ParentDeptID='".$pid."' $wheretype ORDER BY IsEnabled desc,SortID,UniqueID";
        $qry1 = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($qry1 as $c1) {
            $sql="SELECT * FROM sys_dept WHERE ParentDeptID='".$c1['DeptID']."' $wheretype ORDER BY IsEnabled desc,SortID,UniqueID";
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            if (count($data)>0){
                $c_tree0 =pub::loadDept($c1['DeptID'],$type,$except);
                $c_tree = $c_tree. "{ id:'".$c1['DeptID']."', pId:'".$pid."', name:'".$c1['DeptName']."'},".$c_tree0 ;
            }else{
                $c_tree = $c_tree ."{ id:'".$c1['DeptID']."', pId:'".$c1['ParentDeptID']."', name:'".$c1['DeptName']."'},";
            }
        }
        return $c_tree;
    }

    //2016/08/11 替換textarea中的換行符,encode判斷是否編碼，替換<為$lt之類
    public static function text2html($s,$encode=1,$isRpl=1){
        //先替換換行符
        if($encode){
            $s=htmlspecialchars($s);
        }
        if($isRpl==1)
            $s=str_replace(array("\r\n", "\r", "\n"), '<br />', $s);
        return $s;
    }
    /* 锁定单别表,要在事务前进行
     * $BillId  单别
     * 0 失败 1 成功
     */
    public static function LockNum($BillId){
        //锁表   取号锁标识，1、锁，0、未锁
        $sql = "update erp_BillType set Locks=1 where Locks=0 and BillId='$BillId' ";
        $qrt = Yii::$app->db->createCommand($sql)->execute();
        return $qrt;
    }
    /* 解锁单别表,要在事务失败异常时进行
     * $BillId  单别
     */
    public static function UnLockNum($BillId){
        //锁表   取号锁标识，1、锁，0、未锁
        $sql = "update erp_BillType set Locks=0 where BillId='$BillId' ";
        $qrt = Yii::$app->db->createCommand($sql)->execute();
        return 1;
    }
    /* 产生单别表 分三步：
     * 1、事务开始之前：进行锁表 pub::LockNum('单别') 返回-（1 成功 0 失败）
     * 2、事务进行过程：进行取号 pub::GetNum('单别')  返回-（0 取号失败 -1 锁定失败 其他成功）
     * 3、事务进行失败：进行解锁 pub::UnLockNum('单别')
     $vLock = pub::LockNum('C10');//进行锁表
     if ($vLock==0){
        $r = '取号失败(锁)，重试再联络MIS专员！';
      }
     $tra1 = Yii::$app->db->beginTransaction();
     try{
        if ($vLock==0){ //锁表失败结束
            throw new Exception($r);
        }
        $cMyId = pub::GetNum('C10'); //进行取号
        if ($cMyId=='0'){
          $r = '取号失败(取)，重试再联络MIS专员！';
          throw new Exception($r);
        }else if($cMyId=='-1'){
          $r = '取号失败(取锁)，重试再联络MIS专员！';
          throw new Exception($r);
        }
        try{ //提交错误
            $tra1->commit();
        }catch (Exception $e){
            pub::wrlog($e->getMessage());
            $r = "保存失败请重试再联络MIS专员！";
            throw new Exception($r);
        }
     }catch (Exception $e) {
        $tra1->rollBack();
        pub::UnLockNum('C10'); //进行解锁
        throw new Exception($r);
     }
     * $BillId  单别
     * 0 取号失败 -1 锁定失败 其他成功
     */
    public static function GetNum($BillId){
        //取号锁标识，1、锁，0、未锁
        $sql ="select UseNum from erp_BillType where Locks=1 and BillId='$BillId'";
        $qryNum = Yii::$app->db->createCommand($sql)->queryOne();
        if (!empty($qryNum)){ //直接取出新号码并前补0 6位
            //取单号：201612 00001
            $cYm = date('Ym',time());
            $uNum = $qryNum['UseNum'];
            $qYm = substr($uNum,0,6);
            $qNum = substr($uNum,6,5);
            if ($cYm==$qYm){
                $UseNum = $qYm.sprintf("%05d", $qNum+1);
            }else{
                $UseNum = $cYm.sprintf("%05d", 1);
            }
            //下面是取流水号
            //$UseNum = $qryNum['UseNum']+1;
            //新号更新到已使用号码 在相关单保存事务更新后写入数据库
            $sql = "update erp_BillType set Locks=0 ,UseNum='$UseNum' where Locks=1 and BillId='$BillId'";
            $qrt = Yii::$app->db->createCommand($sql)->execute();
            if ($qrt>0){
                return $UseNum;
            }else{ //取号失败
                return '0';
            }
        }else{ //锁定失败
            return '-1';
        }
    }

    /*
     * sql like用bindValue替换，
     * 组sql时 and Id like :Id excape '!'
     * 替换时，$qry->bindValue(":Id",pub::sqlLike($Id,'!','lr'));
     * '!'表示escape后面转义符，默认是'!',如果$cep='',直接返回null
     * 'lr'表示是左边加'%'及右边加'%',默认是'lr'，''空是两边都不加
     */
    public static function sqlLike($str,$ecp='!',$lr='lr'){
        if(trim($ecp)=='') return null;
        $patLike="/[".trim($ecp)."%]/";
        $str=preg_replace($patLike,trim($ecp).'$0',$str);
        if(strpos(strtolower($lr),'l')!==false)
            $str='%'.$str;
        if(strpos(strtolower($lr),'r')!==false)
            $str.='%';
        return $str;
    }//end of sqlLike

//生成guid
    public static function guid() {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }//end of guid;
    public static function is_mobile(){

        // returns true if one of the specified mobile browsers is detected
        // 如果监测到是指定的浏览器之一则返回true

        $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";

        $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";

        $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";

        $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";

        $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";

        $regex_match.=")/i";

        // preg_match()方法功能为匹配字符，既第二个参数所含字符是否包含第一个参数所含字符，包含则返回1既true
        return preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
    }
}//end of class

