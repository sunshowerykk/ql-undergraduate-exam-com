<?php
namespace app\controllers\student; //basic 二级目录控制器
use Yii;
use yii\db\Exception;
use app\core\base\BaseController;
use app\models\langs;
use app\models\pub;
use app\models\cupage;
use app\models\LoginForm;

class StudentController extends BaseController
{
//    public function beforeAction($action)
//    {
//        return $this->renderContent(langs::get('noright'));
//        return true;
//    }
    public function actions()
    { //默认执行动作
        parent::actions();//调用父方法
    }
    public function actionIndex()
    {
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
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
            //   file_put_contents('E:/log/l' . time() . '.txt', print_r($data, true), FILE_APPEND);
            $this->layout = "mainphone";//手机指定框架
            $view = Yii::$app->view->params['data']="7"; //给框架加参数
            $part = array(
                'data'=>$data,
                // 's_data'=>$s_data,
                'detail' => array(),
                'rK' => pub::enFormMD5('add', '')
            );
        }else {
            $this->layout = "mainindex"; //指定框架
            $view = Yii::$app->view->params['data']="7"; //给框架加参数
            $part = array(
                // 'data'=>$data,
                // 's_data'=>$s_data,
                'detail' => array(),
                'rK' => pub::enFormMD5('add', '')
            );
        }
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
        $cSubId = $req->post('vSubId',"");
        $cCourseId = $req->post('vCourseId',"");
        $cSectionId = $req->post('vSectionId',"");
        $where = " where 1=1 ";
        if(!empty($cSubId)){
            $cSubId=trim($cSubId); /*去除变量所以空格*/
            $where .=" and examsubid = '$cSubId'";
        }
        if(!empty($cCourseId)){
            $cCourseId=trim($cCourseId); /*去除变量所以空格*/
            $where .=" and examcourseid = '$cCourseId'";
        }
        if(!empty($cSectionId)){
            $cSectionId=trim($cSectionId); /*去除变量所以空格*/
            $where .=" and examcoursesectionid = '$cSectionId'";
        }
        $perNumber=10; //每页显示的记录数
        $sql = "SELECT count(1) FROM sys_exam $where ";
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
        $sql = "select * from sys_exam  $where order by examid DESC limit $startCount,$perNumber ";
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
        }else{
            if ($req->isAjax){ //ajax提交
                return $this->renderAjax('findhead',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findhead',$part); //不调用layout
            }
        }
    }
    public function actionToexam(){
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        $examid = $req->get('examid',"");
        $cK=$req->get('_k','');
       // file_put_contents('E:/log/l' . time() . '.txt', print_r($cK, true), FILE_APPEND);
        $ctoken=$req->get('token','');
        if(!empty($ctoken)){
            $url="https://api.kaoben.top/users/islogin?access-token=".$ctoken;
            $ch = curl_init(); //设置选项，包括URL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $output = curl_exec($ch); //释放curl句柄
            curl_close($ch);
            $data=json_decode($output,true);
            if($data['status']==1){
                yii::$app->session['studentuser']=$data['user'];
                $_csrf =Yii::$app->request->csrfToken;
                $post=array("_csrf"=>$_csrf,"LoginForm"=>array("UserName"=>"student","UserPwd"=>"admin"));
                $model = new LoginForm();
                if ($post['LoginForm']['UserPwd']=='' or $post['LoginForm']['UserName']=='' ){
                    $status = '用戶名和密碼必須輸入!';
                    return $this->renderContent($status);
                }
                if($model->load($post)) {
                    if($model->login()){ //登陆成功
                        return $this->redirect('/?r=student/student/createhead&examid='.$examid."&_k=".$cK);
                    }else//登陆失败
                        $status = '用户名或密码错误，登录失败';
                    return $this->renderContent($status);
                }else{
                    $status = '系统错误！';
                    return $this->renderContent($status);
                }
            }
            //file_put_contents('E:/log/l' . time() . '.txt', print_r($data, true), FILE_APPEND);
        }
    }
    public function actionLoadexam(){
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        $c1 = $req->get('c1',"");
        $cK=$req->get('_k','');
        // file_put_contents('E:/log/l' . time() . '.txt', print_r($cK, true), FILE_APPEND);
        $ctoken=$req->get('token','');
        if(!empty($ctoken)){
            $url="https://api.kaoben.top/users/islogin?access-token=".$ctoken;
            $ch = curl_init(); //设置选项，包括URL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $output = curl_exec($ch); //释放curl句柄
            curl_close($ch);
            $data=json_decode($output,true);
            if($data['status']==1){
                yii::$app->session['studentuser']=$data['user'];
                $_csrf =Yii::$app->request->csrfToken;
                $post=array("_csrf"=>$_csrf,"LoginForm"=>array("UserName"=>"student","UserPwd"=>"admin"));
                $model = new LoginForm();
                if ($post['LoginForm']['UserPwd']=='' or $post['LoginForm']['UserName']=='' ){
                    $status = '用戶名和密碼必須輸入!';
                    return $this->renderContent($status);
                }
                if($model->load($post)) {
                    if($model->login()){ //登陆成功
                        return $this->redirect('/?r=student/myexam/loadhead&c1='.$c1."&_k=".$cK);
                    }else//登陆失败
                        $status = '用户名或密码错误，登录失败';
                    return $this->renderContent($status);
                }else{
                    $status = '系统错误！';
                    return $this->renderContent($status);
                }
            }
            //file_put_contents('E:/log/l' . time() . '.txt', print_r($data, true), FILE_APPEND);
        }
    }
    public function actionCreatehead(){  //新增加的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone"; //指定框架
            $view = Yii::$app->view->params['data']="7"; //给框架加参数
        }else{
            $this->layout = "mainindex"; //指定框架
            $view = Yii::$app->view->params['data']="exam"; //给框架加参数
        }
        $examid = $req->get('examid',"");
        $cK=$req->get('_k','');
       // file_put_contents('E:/log/l' . time() . '.txt', print_r($cK, true), FILE_APPEND);
        if($cK!=pub::enFormMD52('exam',$examid))
            return $this->renderContent(langs::get('checkerror'));
        $sql="select * from sys_exam where examid='$examid'";
        $exam_data = Yii::$app->db->createCommand($sql)->queryOne();//取出试卷信息
        $sql="select * from sys_type where examid='$examid'  order by typeid";
        $t_data= Yii::$app->db->createCommand($sql)->queryAll();//取出题型
        $question_data= array();
        foreach ($t_data as $key=>$val){
            $sql="Select (@i:=@i+1) as RowNum, A.*,C.type from sys_question A left join sys_type C on A.questiontype=C.typeid ,(Select @i:=0 ) B  WHERE A.examid='$examid'  AND  questionparent='0'
                 AND A.questiontype='".$val['typeid']."' ";
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($data as $k=>$v ){
                if($v['questioncap']==1){
                    $sql="Select (@i:=@i+1) as RowNum, A.*,C.type from sys_question A left join sys_type C on A.questiontype=C.typeid ,(Select @i:=0 ) B  WHERE 
                          A.questionparent='".$v['questionid']."'";
                    $cap_data = Yii::$app->db->createCommand($sql)->queryAll();
                    $data[$k]= array_merge(array('capquestion'=>$cap_data),$v);
                }else{
                    $data[$k]= array_merge(array('capquestion'=>""),$v);
                }
            }
            $question_data[$key]=array_merge(array('question'=>$data),$val);
        }
       // file_put_contents('E:/log/l' . time() . '.txt', print_r($question_data, true), FILE_APPEND);
        $part = array(
            't_data'=>$t_data,
            'starttime'=>time(),
            'question_data'=>$question_data,
            'exam_data'=>$exam_data,
            'eh_data'=>"",
            'rp'=>1,
            'rop'=>"add",
            'rk'=>pub::enFormMD5('add')
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('Createphonehead', $part);
        }else{
            return $this->render('createhead', $part);
        }
    }
    public function actionEdithead(){  //修改的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone"; //指定框架
            $view = Yii::$app->view->params['data']="7"; //给框架加参数
        }else{
            $this->layout = "mainindex"; //指定框架
            $view = Yii::$app->view->params['data']="exam"; //给框架加参数
        }
        //接收GET，POST的数据及验证
        $cId = $req->get('c1','');
        $cK=$req->get('_k','');
        if($cK!=pub::enFormMD5('edit',$cId))
            return $this->renderContent(langs::get('checkerror'));
        //取出信息
        $sql="select * from sys_examhistory where ehid='$cId'";
        $eh_data = Yii::$app->db->createCommand($sql)->queryOne();//取出临时保存的考试记录



        $examid=$eh_data['ehexamid'];//试卷id
        $answer=unserialize($eh_data['ehanswer']);//取出临时保存的考试答案
        $r_data=array();
        foreach($answer as $key=>$val){
            $r_data[]=array("u_questionid"=>$key,"u_answer"=>$val);
        }//取出临时保存的考试答案
        $sql="select * from sys_type where examid='$examid'  order by typeid";
        $t_data= Yii::$app->db->createCommand($sql)->queryAll();//取出题型


        $sql="select * from sys_exam where examid='$examid'";
        $exam_data = Yii::$app->db->createCommand($sql)->queryOne();//取出试卷信息

        $question_data= array();
        foreach ($t_data as $key=>$val) {
            $sql="Select (@i:=@i+1) as RowNum, A.*,C.type from sys_question A left join sys_type C on A.questiontype=C.typeid ,(Select @i:=0 ) B  WHERE A.examid='$examid'  AND  questionparent='0'
                 AND A.questiontype='".$val['typeid']."' ";
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($data as $k=>$v ){
                if($v['questioncap']==1){
                    $sql="Select (@i:=@i+1) as RowNum, A.*,C.type from sys_question A left join sys_type C on A.questiontype=C.typeid ,(Select @i:=0 ) B  WHERE 
                          A.questionparent='".$v['questionid']."'";
                    $cap_data = Yii::$app->db->createCommand($sql)->queryAll();
                    foreach ($cap_data as $ckey =>$cval){
                        $cap_data[$ckey]['u_answer']="";
                        foreach ($r_data as $rkey => $rval){
                            if($cval['questionid']==$rval['u_questionid']){
                                $cap_data[$ckey]['u_answer']=$rval['u_answer'];
                                break;
                            }
                        }
                    }
                    $data[$k]= array_merge(array('capquestion'=>$cap_data),$v);
                }else{
                    $data[$k]= array_merge(array('capquestion'=>""),$v);
                }
            }
            foreach ($data as $key1 => $val1){
                    $data[$key1]['u_answer']="";
                    foreach ($r_data as $key2 => $val2){
                        if($val1['questionid']==$val2['u_questionid']){
                            $data[$key1]['u_answer']=$val2['u_answer'];
                            break;
                        }
                    }
            }
            $question_data[$key] = array_merge(array('question' => $data), $val);
        }//取出试题
      //  file_put_contents('E:/log/l' . time() . '.txt', print_r($question_data, true), FILE_APPEND);
        $part = array(
            't_data'=>$t_data,
            'starttime'=>time(),
            'question_data'=>$question_data,
            'exam_data'=>$exam_data,
            'eh_data'=>$eh_data,
            'rp'=>$req->get('p',1), //当前页码
            'rk'=>pub::enFormMD5('edit',$cId),
            'rop'=>"edit"
        );
        //返回值处理或调用模板
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('Createphonehead', $part);
        }else{
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
        $cId=$req->post("vEhId","");
        $sql="select count(*) from sys_examhistory where ehid='$cId'";
        $countnum=Yii::$app->db->createCommand($sql)->queryScalar();
        if($cId!="" && $countnum ==1){
            $ck=pub::enFormMD5("edit",$cId);
        }else{
            $ck=$req->post('_k','');
        }
        $cExamId=$req->post("vExamId","");
        $cStartTime=$req->post("vStartTime","");
        $cEndTime=time();
        $cUserId=$req->post("vUserId","");
        $cEhTimep=$req->post("vEhTime","");
        $cUserName=$req->post("vUserName","");
        $cGrade=$req->post("vGrade","");
        $cAnswer=$req->post("vAnswer","");
        $cAnswer=serialize($cAnswer);
        $cEhStatus=$req->post("vEhStatus","");
        $cadd=pub::enFormMD5("add");
        $cedit=pub::enFormMD5("edit",$cId);
        $tra1 = Yii::$app->db->beginTransaction();
        $sql="select count(*) from sys_examhistory where userid='$cUserId' and ehexamid='$cExamId'";
        $countuser=Yii::$app->db->createCommand($sql)->queryScalar();
        if($countuser>0){
            $tra1 = Yii::$app->db->beginTransaction();
                Yii::$app->db->createCommand()->delete('sys_examhistory',['userid'=>$cUserId,'ehexamid'=>$cExamId])->execute();
                $tra1->commit();
        }
        try {
            if (!$req->isPost){
                $r = '非法提交，无法使用！!';
                throw new Exception($r);
            }
            if ($ck==$cadd) { //增加
                $cEhTime=$cEndTime-$cStartTime;
                try {
                    $data = array(
                        'ehid'=>$cId,
                        'ehexamid'=>$cExamId,
                       // 'ehscorelist' => ,
                        'ehanswer'    =>$cAnswer,
                        'ehtime'    =>$cEhTime,
                       // 'ehscore' => ,
                        'ehstarttime'    =>$cStartTime,
                        'ehendtime'    =>$cEndTime,
                        'ehgrade'    =>$cGrade,
                        'ehstatus'    =>$cEhStatus,
                        'userid'=>$cUserId,
                        'username'=>$cUserName,
                    );
                    $ts = Yii::$app->db->createCommand()->insert('sys_examhistory', $data)->execute();
                   $ehid= Yii::$app->db->getLastInsertID();
                    $tra1->commit();
                }catch (Exception $e) {
                    pub::wrlog($e->getMessage());
                    $r = "新增保存失败！";
                    throw new Exception($r);
                }
            } elseif ($ck==$cedit) { //修改保存
                $cEhTime=$cEndTime-$cStartTime+$cEhTimep;
                try {
                    $data = array(
                        'ehexamid'=>$cExamId,
                        // 'ehscorelist' => ,
                        'ehanswer'    =>$cAnswer,
                        'ehtime'    =>$cEhTime,
                        // 'ehscore' => ,
                        'ehstarttime'    =>$cStartTime,
                        'ehendtime'    =>$cEndTime,
                        'ehgrade'    =>$cGrade,
                        'ehstatus'    =>$cEhStatus,
                        'userid'=>$cUserId,
                        'username'=>$cUserName,
                    );
                    $ts=Yii::$app->db->createCommand()->update('sys_examhistory', $data, ['ehid' => $cId])->execute();
                    $ehid=$cId;
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

        $res='{"code":"'.$r.'"';
        $res.=',"ehid":"'.$ehid.'"';
        $res.='}';
        //返回值处理或调用模板
        if ($req->isAjax){ //ajax提交
            return $this->renderContent($res);
        }else{   //普通提交
            return $this->render('add');
        }
    }
}
