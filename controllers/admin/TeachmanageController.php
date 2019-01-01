<?php
namespace app\controllers\admin; //basic 二级目录控制器
use Yii;
use yii\db\Exception;
use app\core\base\BaseController;
use app\models\langs;
use app\models\pub;
use app\models\cupage;

class TeachmanageController extends BaseController
{
    public function beforeAction($action)
    {
        return $this->renderContent(langs::get('noright'));
        return true;
    }

    public function actions()
    { //默认执行动作
        parent::actions();//调用父方法
    }

    public function actionIndex()
    {
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="3";
        $part = array(
        );
        if ( pub::is_mobile() ) {
            return $this->render('p_index', $part);
        }else {
            return $this->render('index', $part);
        }

    }
    public function actionFindhead($p='1'){    //查询动作
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        $page = $req->get('p',$p);
        $perNumber=10; //每页显示的记录数
        $where=" where 1=1 and RoleID =2 ";
        $sql = "SELECT count(1) FROM sys_user a $where ";
        //print_r($sql);
        $count=Yii::$app->db->createCommand($sql)->queryScalar();
        $totalNumber=$count;
        $total_pages=ceil($totalNumber/$perNumber); //计算出总页数
        //接受的分页数 $page（P）大于总页数，赋值成总页数
        $page = $page>$total_pages?$total_pages:$page;

        //$page 如果没有值,则赋值1
        $startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
        $startCount = $startCount<0?0:$startCount;
        $part= array(
            'total_rows'=>$totalNumber, #(必须)
            'method'    =>'ajax', #(必须)
            'ajax_func_name'=>'findHead',
            'parameter'=>"",  #(必须)
            'now_page'  =>$page,  #(必须)
            'list_rows'=>$perNumber, #(可选) 默认为15
        );
        $pages= new Cupage($part);
        $sql = "select * from sys_user $where order by id DESC limit $startCount,$perNumber ";
        //  print_r ($sql);
        $d_data = Yii::$app->db->createCommand($sql)->queryAll();
        //返回值处理或调用模板
        $part = array(
            'd_data'=>$d_data,
             'page'=>$pages,
            'rK'=>pub::enFormMD5('add','')
        );
        if ( pub::is_mobile() ) {
            if ($req->isAjax){ //ajax提交
                return $this->renderAjax('findphonehead',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findphonehead',$part); //不调用layout
            }
        }else {
            if ($req->isAjax){ //ajax提交
                return $this->renderAjax('findhead',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findhead',$part); //不调用layout
            }
        }

    }
    public function actionCreatehead(){  //新增加的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="3";
        $cCID =pub::guid();//图片唯一id
        //接收GET，POST的数据及验证
        $part = array(
            'CID'=>$cCID,
            'r_data'=>"",
            'rp'=>1,
            'rop'=>"add",
            'rk'=>pub::enFormMD5('add')
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('Createphonehead', $part);
        }else {
            return $this->render('createhead', $part);
        }
    }
    public function actionEdithead(){  //修改的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="3"; //给框架加参数
        //接收GET，POST的数据及验证
        $cId = $req->get('c1','');
        $cK=$req->get('_k','');
        if($cK!=pub::enFormMD5('edit',$cId))
            return $this->renderContent(langs::get('checkerror'));
        //取出信息
        $sql = "select a.*,b.FileId,b.FilePath from sys_user a LEFT JOIN sys_file b on  a.CID=b.FileID where a.id='$cId'";
        $r_data=Yii::$app->db->createCommand($sql)->queryOne();
        $part = array(
            'CID'=>$r_data['CID'],
            'r_data'=>$r_data,
            'rp'=>$req->get('p',1), //当前页码
            'rop'=>"edit",
            'rk'=>pub::enFormMD5('edit',$cId)
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('Createphonehead', $part);
        }else {
            return $this->render('createhead', $part);
        }
    }//end of EitdHead
    public function actionSavehead(){    //新加保存
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        if (!$req->isPost){
            $r = '非法提交，无法使用！!';
            return $this->renderContent($r);
        }
        $r = "[0000]";
        $cId=$req->post("vId","");
        $cCID=$req->post("vCID","");
        $cP = $req->post('vP',"");
        $cSubject=$req->post("vSubject","");
        $cExamsubId=$req->post("vExamsubId","");
        $cClass=$req->post("vClass","");
        $cExamcourseid=$req->post("vExamcourseid","");
        $cSection=$req->post("vSection","");
        $cExamsectionid = pub::chkPost($req->post('vExamsectionid',""),"","【节次名称】不能为空");
        $cPhone = pub::chkPost($req->post('vPhone',""),"","【手机号码】不能为空");
        $cUserName = pub::chkPost($req->post('vUserName',""),"","【姓名】不能为空");
        $cPassWord1= pub::chkPost($req->post('vPassWord1',""),"","【密码】不能为空");
        $cPassWord2= pub::chkPost($req->post('vPassWord2',""),"","【密码】不能为空");
        if ($cPassWord1<>$cPassWord2){
            print_r("两次密码输入不一致！");
            Yii::$app->end();
        }
        $cContent = $req->post('vContent',"");
        $ck=$req->post('_k','');
        $cadd=pub::enFormMD5("add");
        $cedit=pub::enFormMD5("edit",$cId);
        $tra1 = Yii::$app->db->beginTransaction();
        try {
            if (!$req->isPost){
                $r = '非法提交，无法使用！!';
                throw new Exception($r);
            }
            if ($ck==$cadd) { //增加
                //判断用户是否重复，用户账号唯一
                $sql = "select count(1) FROM sys_user WHERE UserName ='" . $cUserName . "'";
                $count = Yii::$app->db->createCommand($sql)->queryScalar();
                if ($count > 0) {
                    $r = '添加的用户已经重复，请修改后再保存！';
                } else {
                    try {
                        $data = array(
                            'UserName' => $cUserName,
                            'UserFull'=>$cUserName,
                            'UserPwd' => md5($cPassWord1),
                            'RoleID' => 2,
                            'UserType' => 2,
                            'Phone' => $cPhone,
                            'UserInfo' => $cContent,
                            'UserStatus' => 1,
                            'SubId'=>$cExamsubId,
                            'SubName'=>$cSubject,
                            'CourseId'=>$cExamcourseid,
                            'CourseName'=>$cClass,
                            'SectionId'=>$cExamsectionid,
                            'SectionName'=>$cSection,
                            'CID'=>$cCID,
                            'InTime'=>date('Y-m-d h:i:s',time()),
                            'InUserName'=>Yii::$app->user->identity->UserName,
                        );
                        $ts = Yii::$app->db->createCommand()->insert('sys_user', $data)->execute();
                         $userid= Yii::$app->db->getLastInsertID();
                        $section = explode(",", $cExamsectionid );
                        foreach ($section as $v){
                           $data2= array(
                               'userid'=>$userid,
                               'sectionid'=>str_replace('t','',$v),
                           );
                            Yii::$app->db->createCommand()->insert('sys_teachrole', $data2)->execute();
                        }
                        $tra1->commit();
                    } catch (Exception $e) {
                        pub::wrlog($e->getMessage());
                        $r = "新增保存失败！";
                        throw new Exception($r);
                    }
                }
            } elseif ($ck==$cedit) { //修改保存
                //判断用户是否重复，用户账号唯一
                //先删除所有权限，再新增
                Yii::$app->db->createCommand()->delete('sys_teachrole', ['userid' => $cId])->execute();
                $section = explode(",", $cExamsectionid );
                foreach ($section as $v){
                    $data2= array(
                        'userid'=>$cId,
                        'sectionid'=>str_replace('t','',$v),
                    );
                    Yii::$app->db->createCommand()->insert('sys_teachrole', $data2)->execute();
                }
                    try {
                        $data = array(
                            'UserName' => $cUserName,
                            'UserFull'=>$cUserName,
                            'UserPwd' => md5($cPassWord1),
                            'RoleID' => 2,
                            'UserType' => 2,
                            'Phone' => $cPhone,
                            'UserInfo' => $cContent,
                            'UserStatus' => 1,
                            'SubId'=>$cExamsubId,
                            'SubName'=>$cSubject,
                            'CourseId'=>$cExamcourseid,
                            'CourseName'=>$cClass,
                            'SectionId'=>$cExamsectionid,
                            'SectionName'=>$cSection,
                            'CID' => $cCID,
                            'InTime' => date('Y-m-d h:i:s', time()),
                            'InUserName' => Yii::$app->user->identity->UserName,
                        );
                        $ts = Yii::$app->db->createCommand()->update('sys_user', $data, ['id' => $cId])->execute();
                        $tra1->commit();
                    } catch (Exception $e) {
                        pub::wrlog($e->getMessage());
                        $r = "新增保存失敗請重試再联络技术专员！";
                        throw new Exception($r);
                }
            } else { //验证失败，不能保存
                $r = langs::get('checkerror');
                throw new Exception($r);
            }
        } catch (Exception $e) {
            $tra1->rollBack();
            pub::wrlog($e->getMessage());
            $r = $e->getMessage();
        }
        $res='{"_code":"'.$r.'"';
        $res.='}';
        //返回值处理或调用模板
        if ($req->isAjax){ //ajax提交
            return $this->renderContent($res);
        }else{   //普通提交
            return $this->render('add');
        }
    }

    public function actionUphead(){    //删除 ajax提交自己加参数判断
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        $r = "[0000]";
        if (!$req->isPost){
            $r = '非法提交，无法使用！';
            return $this->renderContent($r);
        }
        $cCId = $req->get('c1',"");
        //
        // $cUID =pub::guid();//唯一值
        $typeArr = array("jpg", "png", "gif","ico");
        $path = Yii::$app->basePath.'/web/Data/';
        if (isset($_POST)) {
            //開始保存上傳的文檔
            //得到上传的临时文件流
            $name = $_FILES['file']['name'];
            //$size = $_FILES['file']['size'];
            $name_tmp = $_FILES['file']['tmp_name'];
            $fileSize = formatBytes($_FILES['file']['size']);
            $fileExt =preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$name); //得到擴展名
            $fileAtt = date('His').strtolower(random(16)).".".$fileExt; //得到新的文件名稱，數字+小寫字母組合
            //最后保存服务器地址
            $path_ym=date("Ym");				//年月
            $path_d=date("d");					//当日
            $tmpPath = $path.$path_ym.'/';
            if(!is_dir($tmpPath)){
                mkdir($tmpPath,0777,true);
            }
            $tmpPath = $tmpPath.$path_d.'/';
            if(!is_dir($tmpPath)){
                mkdir($tmpPath,0777,true);
            }
            $fileAtt = $path_ym."/".$path_d."/".$fileAtt;
            if (empty($name)) {
                echo json_encode(array("error" => "您还未选择图片"));
                exit ;
            }
            $type = strtolower(substr(strrchr($name, '.'), 1));
            //获取文件类型

            if (!in_array($type, $typeArr)) {
                echo json_encode(array("error" => "请上传jpg,png或gif类型的图片！"));
                exit ;
            }
            if ($fileSize > (1800 * 2500)) {
                echo json_encode(array("error" => "图片大小已超过1000KB！"));
                exit ;
            }

            // $pic_name = time() . rand(10000, 99999) . "." . $type;
            //图片名称
            $pic_url = $path . $fileAtt;
            //上传后图片路径+名称
            if (move_uploaded_file($name_tmp, $pic_url)) {//临时文件转移到目标文件夹
                $data = array(
                    'FileId' => $cCId,
                    'FileExtension' => $fileExt,
                    'FilePath'=>'Data/'.$fileAtt,
                    'FileSize'=>$fileSize,
                    'InTime'=>date('Y-m-d',time()),
                    'InUser'=>Yii::$app->user->identity->UserName,
                );
                try{ //提交错误
                    Yii::$app->db->createCommand()->insert('sys_file', $data)->execute();
                }catch (Exception $e){
                    pub::wrlog($e->getMessage());
                    $r = "保存失败请重试再联系技术专员！";
                    throw new Exception($r);
                }
                $pic='Data/'.$fileAtt;
                echo json_encode(array("error" => "0", "pic" => $pic, "name" => $fileAtt,"uid" =>$cCId));
            } else {
                echo json_encode(array("error" => "上传有误，请检查服务器配置！"));
            }
        }
        // return $this->renderContent($r);
    }
    public function actionDeluphead(){    //删除 ajax提交自己加参数判断
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        $imgurl=$req->post('src','');
        $UId=$req->post('uid','');
        $r = "[0000]";
        if (!$req->isPost){
            $r = '非法提交，无法使用！';
            return $this->renderContent($r);
        }
        $tra1 = Yii::$app->db->beginTransaction();
        try {
            $where = array(
                'FilePath'=>$imgurl,
                'FileId' => $UId,
            );
            // file_put_contents('E:/log/l'.time().'.txt', print_r($where, true), FILE_APPEND);
            $ts=Yii::$app->db->createCommand()->delete('sys_file', $where)->execute();
            //要刪除實體文件，
            if($ts==1){
                if(file_exists($imgurl)!=''){
                    unlink($imgurl);  //刪除本地文件
                    echo 1;
                }
                //還要把最大的版本號更新到主表
            }
            $tra1->commit();
        } catch (Exception $e) {
            pub::wrlog($e->getMessage());
            $r = "删除失败请重试或者联系开发人员！";
            throw new Exception($r);
        }
        // return $this->renderContent($r);
    }
    public function actionDelhead(){    //删除 ajax提交自己加参数判断
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        $r = "[0000]";
        if (!$req->isPost){
            $r = '非法提交，无法使用！';
            return $this->renderContent($r);
        }
        $c1= $req->get('c1',"");
        $cK=$req->get('_k','');
        //验证提交信息合法性  验证唯一ID
        if($cK!=pub::enFormMD5('del',$c1))
            return $this->renderContent(langs::get('checkerror'));
        //删除信息
        $tra1 = Yii::$app->db->beginTransaction();
        try{
            Yii::$app->db->createCommand()->delete('sys_user',['id'=>$c1])->execute();
            $tra1->commit();
        }catch (Exception $e) {
            $tra1->rollBack();
            pub::wrlog($e->getMessage());
            $r = "删除失败！";
        }
        return $this->renderContent($r);
    }
    ////顯示部門zTree,多選部門
    public function actionFindtitle(){
        $request = Yii::$app->request;
        $this->layout = 0; //不調用layout模板
        $rid = $request->post('rid',"");
        $rname = $request->post('rname',"");
        $ridval =urldecode( $request->post('ridval',""));
        $except = $request->post('except',"");
        //返回值处理或调用模板
        //$a=pub::Enable_dept('Null');
        $checked=array();
        if(preg_match_all("/\[#?(\w+)\]/",$ridval,$out)){
            $checked=$out[1];
        }
        $a=$this->titleCreate();
        //file_put_contents('E:/log/l'.time().'.txt', print_r($a, true), FILE_APPEND);
        $d_data = "["."{name: '阅卷科目选择','chkDisabled':true,children: ".$a."}"."]";
        //file_put_contents('E:/log/l'.time().'.txt', print_r($d_data, true), FILE_APPEND);
        //return $this->renderContent(print_r($d_data,1));
        $part = array(
            'd_data'=>$d_data,
            'rid'=>$rid,
            'rname'=>$rname,
            'ridval'=>$ridval,
        );
        //返回值处理或调用模板
        if (Yii::$app->request->isAjax){ //ajax提交
            return $this->renderAjax('finddeptcheck',$part); //不調用layout
        }else{   //普通提交
            return $this->render('finddeptcheck',$part); //不調用layout
        }
    }
    public function titleCreate(){//多选标签
        $url="https://api.kaoben.top/courses/all-nodes";
        $ch = curl_init(); //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch); //释放curl句柄
        curl_close($ch);
        $data=json_decode($output,true);
        //file_put_contents('E:/log/l'.time().'.txt', print_r($data, true), FILE_APPEND);
      //  $sql="SELECT * FROM sys_title WHERE status=1 ORDER BY titleid";
       // $qry1 = Yii::$app->db->createCommand($sql)->queryAll();
//        $c_tree=array();
//        $c_tree1=array();
//        $c_tree2=array();
        $c_tree3=array();
        // $c_tree="{id:'0', pId:0, open:true,name:'test1'},";
        foreach ($data as $c1) {
            $c_tree=array("id"=>"f".$c1['id'],"pId"=>1,"type"=>1,"open"=>"false","name"=>$c1['name'],'children'=>array());
            foreach ($c1['courses'] as $t){
                $c_tree1=array("id"=>"s".$t['id'],"pId"=>"f".$t['category_name'],"type"=>2,"open"=>"false","name"=>$t['course_name'],'children'=>array());
                foreach ($t['courseSections'] as $v){
                    $c_tree2=array("id"=>"t".$v['id'],"pId"=>"s".$v['course_id'],"type"=>3,"open"=>"false","name"=>$v['name']);
                    array_push($c_tree1['children'],$c_tree2);
                }
                array_push($c_tree['children'],$c_tree1);
               // $c_tree['children']=$c_tree1;
            }
            array_push($c_tree3,$c_tree);
        }
        $c_tree=json_encode($c_tree3);

        return $c_tree;
    }
}
function random($length, $numeric = 0) { //随机数
    $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
    if($numeric) {
        $hash = '';
    } else {
        $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
        $length--;
    }
    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $seed{mt_rand(0, $max)};
    }
    return $hash;
}
function formatBytes($size) {//读取大小
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}
