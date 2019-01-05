<?php
namespace app\controllers\admin; //basic 二级目录控制器
use Yii;
use yii\db\Exception;
use app\core\base\BaseController;
use app\models\langs;
use app\models\pub;
use app\models\cupage;

class PapermanageController extends BaseController
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
            $this->layout = "mainphone";
            $view = Yii::$app->view->params['data']="2"; //给框架加参数
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
            $part = array(
                 'data'=>$data,
                // 's_data'=>$s_data,
                'detail' => array(),
                'rK' => pub::enFormMD5('add', '')
            );
        }else {
            $this->layout = "mainindex"; //指定框架
            $view = Yii::$app->view->params['data']="2"; //给框架加参数
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
        $where = " where 1=1 ";
        if(!empty($cSubId)){
            $cSubId=trim($cSubId); /*去除变量所以空格*/
            $where .=" and a.examsubid = '$cSubId'";
        }
        if(!empty($cCourseId)){
            $cCourseId=trim($cCourseId); /*去除变量所以空格*/
            $where .=" and a.examcourseid = '$cCourseId'";
        }
        $perNumber=10; //每页显示的记录数
        $sql = "SELECT count(1) FROM sys_exam a  $where ";
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
        $sql = "select a.*,b.questioncount from sys_exam a LEFT JOIN (select examid,count(*) as questioncount from sys_question GROUP BY examid )b ON a.examid=b.examid  $where order by examid DESC limit $startCount,$perNumber ";
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

    public function actionFindtype($p='1',$examid=""){    //查询动作
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        $page = $req->get('p',$p);
        $examid = $req->get('type',$examid);
        $where = " where 1=1 and a.examid=".$examid;
        $perNumber=10; //每页显示的记录数
        $sql = "SELECT count(1) FROM sys_type a  $where ";
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
            'ajax_func_name'=>'findtype',
            'parameter'=>"",  #(必须)
            'now_page'  =>$page,  #(必须)
            'list_rows'=>$perNumber, #(可选) 默认为15
        );
        $pages= new Cupage($part);
        $sql = "select a.*,b.examname from sys_type a LEFT JOIN sys_exam b on  a.examid=b.examid $where order by a.typeid DESC limit $startCount,$perNumber ";
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
                return $this->renderAjax('findtypephone',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findtypephone',$part); //不调用layout
            }
        }else{
            if ($req->isAjax){ //ajax提交
                return $this->renderAjax('findtype',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findtype',$part); //不调用layout
            }
        }
    }
    public function actionCreatehead(){  //新增加的view
        $req = Yii::$app->request;
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
            $this->layout = "mainphone";
            $view = Yii::$app->view->params['data']="2"; //给框架加参数
            $part = array(
                'data'=>$data,
                'r_data'=>"",
                'rp'=>1,
                'rop'=>"add",
                'rk'=>pub::enFormMD5('add')
            );
        }else {
            $this->layout = "mainindex"; //指定框架
            $view = Yii::$app->view->params['data']="2"; //给框架加参数
            $part = array(
                'r_data'=>"",
                'rp'=>1,
                'rop'=>"add",
                'rk'=>pub::enFormMD5('add')
            );
        }
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createphonehead', $part);
        }else {
            return $this->render('createhead', $part);
        }
    }
    public function actionCopyhead(){  //新增加的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        $this->layout = "mainindex"; //指定框架
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        $c1=$req->get("c1","");
        $_k=$req->get("_k","");
        $link='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"] ."?r=student/student/toexam"."&examid=".$c1."&_k=".$_k;
       // file_put_contents('E:/log/l' . time() . '.txt', print_r($sql, true), FILE_APPEND);
        $part = array(
            "link"=>$link
        );
        return $this->render('copyhead', $part);
        }
    public function actionSavehead(){    //新加保存
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        if (!$req->isPost){
            $r = '非法提交，无法使用！!';
            return $this->renderContent($r);
        }
        $r = "[0000]";
        $cId=$req->post("vExamId","");
        $cExamsubId=$req->post("vExamsubId","");
        $cExamcourseid=$req->post("vExamcourseid","");
        $cExamsectionid=$req->post("vExamsectionid","");
        $cP = $req->post('vP',"");
        $cPaperName = pub::chkPost($req->post('vPaperName',""),"","【试卷名称】不能为空");
        $cSubject = pub::chkPost($req->post('vSubject',""),"","【科目】不能为空");
        $cClass = pub::chkPost($req->post('vClass',""),"","【课程】不能为空");
        $cSection= pub::chkPost($req->post('vSection',""),"","【节次】不能为空");
        $cScore= pub::chkPost($req->post('vScore',""),"","【试卷总分】不能为空");
        $cExamTime = pub::chkPost($req->post('vExamTime',""),"","【试卷总分】必须输入");
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
                try {
                    $data = array(
                        'examid'=>$cId,
                        'examname'=>$cPaperName,
                        'examsubid' => $cExamsubId,
                        'examsubname'    =>$cSubject,
                        'examcourseid'    =>$cExamcourseid,
                        'examcoursename' => $cClass,
                        'examcoursesectionid'    =>$cExamsectionid,
                        'examcoursesectionname'    =>$cSection,
                        'examscore'    =>$cScore,
                        'examtime'    =>$cExamTime,
                        'examinuser'=>Yii::$app->user->identity->UserName,
                        'examintime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts = Yii::$app->db->createCommand()->insert('sys_exam', $data)->execute();
                    $examid=Yii::$app->db->getLastInsertID();
                    $tra1->commit();
                }catch (Exception $e) {
                    pub::wrlog($e->getMessage());
                    $r = "新增保存失败！";
                    throw new Exception($r);
                }
            } elseif ($ck==$cedit) { //修改保存
                try {
                    $data = array(
                        'examname'=>$cPaperName,
                        'examsubid' => $cExamsubId,
                        'examsubname'    =>$cSubject,
                        'examcourseid'    =>$cExamcourseid,
                        'examcoursename' => $cClass,
                        'examcoursesectionid'    =>$cExamsectionid,
                        'examcoursesectionname'    =>$cSection,
                        'examscore'    =>$cScore,
                        'examtime'    =>$cExamTime,
                        'examinuser'=>Yii::$app->user->identity->UserName,
                        'examintime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts=Yii::$app->db->createCommand()->update('sys_exam', $data, ['examid' => $cId])->execute();
                    $examid=$cId;
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
        $res.=',"examid":"'.$examid.'"';
        $res.='}';
        //返回值处理或调用模板
        if ($req->isAjax){ //ajax提交
            return $this->renderContent($res);
        }else{   //普通提交
            return $this->render('add');
        }
    }
    public function actionEdithead(){  //修改的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        //接收GET，POST的数据及验证
        $cId = $req->get('c1','');
        $cK=$req->get('_k','');
        if($cK!=pub::enFormMD5('edit',$cId))
            return $this->renderContent(langs::get('checkerror'));
        //取出信息
        $sql = "select * from sys_exam where examid='$cId'";
        $r_data=Yii::$app->db->createCommand($sql)->queryOne();

        $part = array(
            'r_data'=>$r_data,
            'rp'=>$req->get('p',1), //当前页码
            'rk'=>pub::enFormMD5('edit',$cId)
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createphonehead', $part);
        }else {
            return $this->render('createhead', $part);
        }
    }//end of EitdHead
    public function actionIndexdetail()
    {
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        $cExamId = $req->get('c1','');
        $sql="select * from sys_type where examid='$cExamId' order by typeid";
        $t_data=Yii::$app->db->createCommand($sql)->queryAll();
        $part = array(
             't_data'=>$t_data,
             'examid'=>$cExamId,
            'detail' => array(),
            'rK' => pub::enFormMD5('add', '')
        );
        if ( pub::is_mobile() ) {
            return $this->render('indexdetailphone', $part);
        }else {
            return $this->render('indexdetail', $part);
        }
    }
    public function actionIndextype()
    {
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        $cExamId = $req->get('c1','');
        $part = array(
            // 'data'=>$data,
            'examid'=>$cExamId,
            'detail' => array(),
            'rK' => pub::enFormMD5('add', '')
        );
        if ( pub::is_mobile() ) {
            return $this->render('indextypephone', $part);
        }else {
            return $this->render('indextype', $part);
        }
    }
    public function actionIndexcap()
    {
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        $cQId = $req->get('c1','');
        $part = array(
            // 'data'=>$data,
            'QId'=>$cQId,
            'detail' => array(),
            'rK' => pub::enFormMD5('add', '')
        );
        if ( pub::is_mobile() ) {
            return $this->render('indexcapphone', $part);
        }else {
            return $this->render('indexcap', $part);
        }
    }
    public function actionCreatequestion(){  //新增加的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        $typeid = $req->get('typeid','');
        $examid = $req->get('examid','');
        $cap = $req->get('cap','');
        $sql="select typeid,typename,type from sys_type where  typeid= '$typeid'";
        $t_data=Yii::$app->db->createCommand($sql)->queryOne();
        $part = array(
            'cap'=>$cap,
            't_data'=>$t_data,
            'examid'=>$examid,
            'r_data'=>"",
            'rp'=>1,
            'rop'=>"add",
            'rk'=>pub::enFormMD5('add')
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createphone', $part);
        }else {
            return $this->render('createquestion', $part);
        }
    }
    public function actionCreatecap(){  //新增加的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        $QId = $req->get('QId','');
        $sql="select * from sys_question where  questionid= '$QId'";
        $Q_data=Yii::$app->db->createCommand($sql)->queryOne();
        $sql="select * from sys_type where typeid='".$Q_data['questiontype']."'";
        $t_data=Yii::$app->db->createCommand($sql)->queryOne();
        $part = array(
            't_data'=>$t_data,
            'Q_data'=>$Q_data,
            'r_data'=>"",
            'rp'=>1,
            'rop'=>"add",
            'rk'=>pub::enFormMD5('add')
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createcapphone', $part);
        }else {
            return $this->render('createcap', $part);
        }
    }
    public function actionCreatetype(){  //新增加的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        $examid = $req->get('examid','');
        $part = array(
            'examid'=>$examid,
            'r_data'=>"",
            'rp'=>1,
            'rop'=>"add",
            'rk'=>pub::enFormMD5('add')
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createtypephone', $part);
        }else {
            return $this->render('createtype', $part);
        }
    }
    public function actionEditdetail(){  //修改的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        //接收GET，POST的数据及验证
        $cId = $req->get('c1','');
        $cK=$req->get('_k','');
        $ccap=$req->get('cap','');
        if($cK!=pub::enFormMD5('edit',$cId))
            return $this->renderContent(langs::get('checkerror'));
        //取出信息
        $sql = "select * from sys_question where questionid='$cId'";
        $r_data=Yii::$app->db->createCommand($sql)->queryOne();
        $sql="select typeid,typename,type from sys_type where  typeid= '".$r_data['questiontype']."'";
        $t_data=Yii::$app->db->createCommand($sql)->queryOne();
        $part = array(
            'cap'=>$ccap,
            't_data'=>$t_data,
            'r_data'=>$r_data,
            'rp'=>$req->get('p',1), //当前页码
            'rk'=>pub::enFormMD5('edit',$cId),
            'rop'=>'edit'
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createphone', $part);
        }else {
            return $this->render('createquestion', $part);
        }
    }//end of EitdHead
    public function actionEditcap(){  //修改的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        $this->layout = "mainindex"; //指定框架
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";//手机指定框架
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        //接收GET，POST的数据及验证
        $cId = $req->get('c1','');
        $cK=$req->get('_k','');
       // $ccap=$req->get('cap','');
        if($cK!=pub::enFormMD5('edit',$cId))
            return $this->renderContent(langs::get('checkerror'));
        //取出信息
        $sql = "select * from sys_question where questionid='$cId'";
        $r_data=Yii::$app->db->createCommand($sql)->queryOne();
        $sql="select typeid,typename,type from sys_type where  typeid= '".$r_data['questiontype']."'";
        $t_data=Yii::$app->db->createCommand($sql)->queryOne();
        $part = array(
            't_data'=>$t_data,
            'r_data'=>$r_data,
            'rp'=>$req->get('p',1), //当前页码
            'rk'=>pub::enFormMD5('edit',$cId),
            'rop'=>'edit'
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createcapphone', $part);
        }else {
            return $this->render('createcap', $part);
        }
    }//end of EitdHead

    public function actionSavetype(){    //新加保存
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        if (!$req->isPost){
            $r = '非法提交，无法使用！!';
            return $this->renderContent($r);
        }
        $r = "[0000]";
        $cId=$req->post("vTypeId","");
        $cExamId=$req->post("vExamId","");
        $cP = $req->post('vP',"");
        $cTypeNum = pub::chkPost($req->post('vTypeNum',""),"","【题号】不能为空");
        $cTypeName = pub::chkPost($req->post('vTypeName',""),"","【名称】不能为空");
        $cTypeInfo = pub::chkPost($req->post('vTypeInfo',""),"","【题型说明】不能为空");
        $cType= pub::chkPost($req->post('vType',""),"","【所属类型】不能为空");
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
                try {
                    $data = array(
                        'examid'=>$cExamId,
                        'typenum'=>$cTypeNum,
                        'typename' => $cTypeName,
                        'typeinfo'    =>$cTypeInfo,
                        'type'    =>$cType,
                        'inuser'=>Yii::$app->user->identity->UserName,
                        'intime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts = Yii::$app->db->createCommand()->insert('sys_type', $data)->execute();
                    $tra1->commit();
                }catch (Exception $e) {
                    pub::wrlog($e->getMessage());
                    $r = "新增保存失败！";
                    throw new Exception($r);
                }
            } elseif ($ck==$cedit) { //修改保存
                try {
                    $data = array(
                        'examid'=>$cExamId,
                        'typenum'=>$cTypeNum,
                        'typename' => $cTypeName,
                        'typeinfo'    =>$cTypeInfo,
                        'type'    =>$cType,
                        'inuser'=>Yii::$app->user->identity->UserName,
                        'intime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts=Yii::$app->db->createCommand()->update('sys_type', $data, ['typeid' => $cId])->execute();
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
    public function actionEdittype(){  //修改的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="2"; //给框架加参数
        //接收GET，POST的数据及验证
        $cId = $req->get('c1','');
        $cK=$req->get('_k','');
        if($cK!=pub::enFormMD5('edit',$cId))
            return $this->renderContent(langs::get('checkerror'));
        //取出信息
        $sql = "select * from sys_type where typeid='$cId'";
        $r_data=Yii::$app->db->createCommand($sql)->queryOne();

        $part = array(
            'r_data'=>$r_data,
            'rp'=>$req->get('p',1), //当前页码
            'rk'=>pub::enFormMD5('edit',$cId),
            'rop'=>'edit'
        );
        //返回值处理或调用模板
        if ( pub::is_mobile() ) {
            return $this->render('createtypephone', $part);
        }else {
            return $this->render('Createtype', $part);
        }
    }//end of EitdHead

    public function actionSavequestion(){    //新加保存
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        if (!$req->isPost){
            $r = '非法提交，无法使用！!';
            return $this->renderContent($r);
        }
        $r = "[0000]";
        $cId=$req->post("vQId","");
        $cType=$req->post("vTypeId","");
        $cExamId=$req->post("vExamId","");
        $cCap=$req->post("vCap","");
        $cP = $req->post('vP',"");
        $cQuestion = pub::chkPost($req->post('vQuestion',""),"","【题干】不能为空");
        if($cCap==1){
            $cQuestionScore="";
            $cQuestionselect="";
            $cNumber="";
            $cAnswer="";
            $cQuestiondescribe="";
            $cQuestionvideo="";
            $cQuestionCap=1;
        }else{
            $cQuestionCap=0;
            $cQuestionScore = pub::chkPost($req->post('vQuestionScore',""),"","【设定分值】不能为空");
            $sql="select * from sys_type where typeid='$cType'";
            $t_data=Yii::$app->db->createCommand($sql)->queryOne();
            if($t_data['type']==2){
                $cAnswerbox = $req->post('vAnswer',"");
                if(!empty($cAnswerbox)){
                    $cAnswer="";
                    foreach($cAnswerbox as $v){
                        $cAnswer.=$v;
                    }
                }
                else{
                    $r = '【参考答案】不能为空！';
                    return $this->renderContent($r);
                }
            }else{
                $cAnswer= pub::chkPost($req->post('vAnswer',""),"","【参考答案】不能为空");
            }
            if($t_data['type']==3 || $t_data['type']==4){
                $cQuestionselect="";
                $cNumber="";
            }else{
                $cQuestionselect = pub::chkPost($req->post('vQuestionselect',""),"","【备选项】不能为空");
                $cNumber= pub::chkPost($req->post('vNumber',""),"","【备选数量】不能为空");
            }
            $cQuestiondescribe = pub::chkPost($req->post('vQuestiondescribe',""),"","【习题解析】必须输入");
            $cQuestionvideo = $req->post('vQuestionvideo',"");
        }

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
                try {
                    $data = array(
                        'examid'=>$cExamId,
                        'questiontype'=>$cType,
                        'question'=>$cQuestion,
                        'questionselect' => $cQuestionselect,
                        'questionselectnumber'    =>$cNumber,
                        'questionanswer'    =>$cAnswer,
                        'questiondescribe' => $cQuestiondescribe,
                        'questionscore'    =>$cQuestionScore,
                        'questionvideo'    =>$cQuestionvideo,
                        'questioncap'=>$cQuestionCap,
                        'questionuser'=>Yii::$app->user->identity->UserName,
                        'questioncreatetime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts = Yii::$app->db->createCommand()->insert('sys_question', $data)->execute();
                    $tra1->commit();
                }catch (Exception $e) {
                    pub::wrlog($e->getMessage());
                    $r = "新增保存失败！";
                    throw new Exception($r);
                }
            } elseif ($ck==$cedit) { //修改保存
                try {
                    $data = array(
                        'examid'=>$cExamId,
                        'questiontype'=>$cType,
                        'question'=>$cQuestion,
                        'questionselect' => $cQuestionselect,
                        'questionselectnumber'    =>$cNumber,
                        'questionanswer'    =>$cAnswer,
                        'questiondescribe' => $cQuestiondescribe,
                        'questionscore'    =>$cQuestionScore,
                        'questionvideo'    =>$cQuestionvideo,
                        'questioncap'=>$cQuestionCap,
                        'questionuser'=>Yii::$app->user->identity->UserName,
                        'questioncreatetime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts=Yii::$app->db->createCommand()->update('sys_question', $data, ['questionid' => $cId])->execute();
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
    public function actionSavecap(){    //新加保存
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        if (!$req->isPost){
            $r = '非法提交，无法使用！!';
            return $this->renderContent($r);
        }
        $r = "[0000]";
        $cId=$req->post("vQId","");
        $cType=$req->post("vTypeId","");
        $cExamId=$req->post("vExamId","");
        $cPId=$req->post("vPId","");
        $cP = $req->post('vP',"");
        $cQuestion = pub::chkPost($req->post('vQuestion',""),"","【题干】不能为空");
            $cQuestionCap=0;
            $cQuestionScore = pub::chkPost($req->post('vQuestionScore',""),"","【设定分值】不能为空");
            $sql="select * from sys_type where typeid='$cType'";
            $t_data=Yii::$app->db->createCommand($sql)->queryOne();
            if($t_data['type']==2){
                $cAnswerbox = $req->post('vAnswer',"");
                if(!empty($cAnswerbox)){
                    $cAnswer="";
                    foreach($cAnswerbox as $v){
                        $cAnswer.=$v;
                    }
                }
                else{
                    $r = '【参考答案】不能为空！';
                    return $this->renderContent($r);
                }
            }else{
                $cAnswer= pub::chkPost($req->post('vAnswer',""),"","【参考答案】不能为空");
            }
            if($t_data['type']==3 || $t_data['type']==4){
                $cQuestionselect="";
                $cNumber="";
            }else{
                $cQuestionselect = pub::chkPost($req->post('vQuestionselect',""),"","【备选项】不能为空");
                $cNumber= pub::chkPost($req->post('vNumber',""),"","【备选数量】不能为空");
            }
            $cQuestiondescribe = pub::chkPost($req->post('vQuestiondescribe',""),"","【习题解析】必须输入");
            $cQuestionvideo = $req->post('vQuestionvideo',"");

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
                try {
                    $data = array(
                        'examid'=>$cExamId,
                        'questiontype'=>$cType,
                        'question'=>$cQuestion,
                        'questionselect' => $cQuestionselect,
                        'questionselectnumber'    =>$cNumber,
                        'questionanswer'    =>$cAnswer,
                        'questiondescribe' => $cQuestiondescribe,
                        'questionscore'    =>$cQuestionScore,
                        'questionvideo'    =>$cQuestionvideo,
                        'questioncap'=>$cQuestionCap,
                        'questionparent'=>$cPId,
                        'questionuser'=>Yii::$app->user->identity->UserName,
                        'questioncreatetime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts = Yii::$app->db->createCommand()->insert('sys_question', $data)->execute();
                    $tra1->commit();
                }catch (Exception $e) {
                    pub::wrlog($e->getMessage());
                    $r = "新增保存失败！";
                    throw new Exception($r);
                }
            } elseif ($ck==$cedit) { //修改保存
                try {
                    $data = array(
                        'examid'=>$cExamId,
                        'questiontype'=>$cType,
                        'question'=>$cQuestion,
                        'questionselect' => $cQuestionselect,
                        'questionselectnumber'    =>$cNumber,
                        'questionanswer'    =>$cAnswer,
                        'questiondescribe' => $cQuestiondescribe,
                        'questionscore'    =>$cQuestionScore,
                        'questionvideo'    =>$cQuestionvideo,
                        'questioncap'=>$cQuestionCap,
                        'questionparent'=>$cPId,
                        'questionuser'=>Yii::$app->user->identity->UserName,
                        'questioncreatetime'=>date('Y-m-d H:i:s',time()),
                    );
                    $ts=Yii::$app->db->createCommand()->update('sys_question', $data, ['questionid' => $cId])->execute();
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
    public function actionLoadhead(){  //新增加的view
        $req = Yii::$app->request;
        parent::actionIndex();//调用父方法
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";
            $view = Yii::$app->view->params['data']="2"; //给框架加参数
        }else {
            $this->layout = "mainindex"; //指定框架
            $view = Yii::$app->view->params['data']="exam"; //给框架加参数
        }

        $examid = $req->get('c1',"");
        $cK=$req->get('_k','');
        if($cK!=pub::enFormMD5('open',$examid))
            return $this->renderContent(langs::get('checkerror'));
        $sql="select * from sys_exam where examid='$examid'";
        $exam_data = Yii::$app->db->createCommand($sql)->queryOne();

        $sql="select * from sys_type where examid='$examid'  order by typeid";
        $t_data= Yii::$app->db->createCommand($sql)->queryAll();
        $question_data= array();
        foreach ($t_data as $key=>$val){
            $sql="Select (@i:=@i+1) as RowNum, A.*,C.type from sys_question A left join sys_type C on A.questiontype=C.typeid ,(Select @i:=0) B  WHERE A.examid='$examid'  AND  questionparent='0'
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
        //file_put_contents('E:/log/l' . time() . '.txt', print_r($question_data, true), FILE_APPEND);
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
            return $this->render('loadphonehead', $part);
        }else {
            return $this->render('loadhead', $part);
        }
    }
    public function actionFinddetail($p='1',$typeid="",$examid=""){    //查询动作
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        $page = $req->get('p',$p);
        $typeid=$req->get('typeid',$typeid);
        $examid=$req->get('examid',$examid);
        $where = " where 1=1 and questionparent='0' ";
        if(!empty($typeid)){
            $typeid=trim($typeid); /*去除变量所以空格*/
            $where .=" and a.questiontype = '$typeid'";
        }
        if(!empty($examid)){
            $examid=trim($examid); /*去除变量所以空格*/
            $where .=" and a.examid = '$examid'";
        }
        $perNumber=10; //每页显示的记录数
        $sql = "SELECT count(1) FROM sys_question a  left join sys_type b on a.questiontype=b.typeid  $where ";
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
            'ajax_func_name'=>'finddetail'.$typeid,
            'parameter'=>"",  #(必须)
            'now_page'  =>$page,  #(必须)
            'list_rows'=>$perNumber, #(可选) 默认为15
        );
        $pages= new Cupage($part);
        $sql = "select a.*,b.typename from sys_question a left join sys_type b on a.questiontype=b.typeid $where order by a.questionid DESC limit $startCount,$perNumber ";
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
                return $this->renderAjax('finddetailphone',$part); //不调用layout
            }else{   //普通提交
                return $this->render('finddetailphone',$part); //不调用layout
            }
        }else {
            if ($req->isAjax){ //ajax提交
                return $this->renderAjax('finddetail',$part); //不调用layout
            }else{   //普通提交
                return $this->render('finddetail',$part); //不调用layout
            }
        }
    }
    public function actionFindcap($p='1',$QId=""){    //查询动作
        $req = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        $page = $req->get('p',$p);
        $QId=$req->get('QId',$QId);
        $where = " where 1=1 ";
        if(!empty($QId)){
            $QId=trim($QId); /*去除变量所以空格*/
            $where .=" and a.questionparent = '$QId'";
        }
        $perNumber=10; //每页显示的记录数
        $sql = "SELECT count(1) FROM sys_question a  left join sys_type b on a.questiontype=b.typeid  $where ";
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
            'ajax_func_name'=>'findcap',
            'parameter'=>"",  #(必须)
            'now_page'  =>$page,  #(必须)
            'list_rows'=>$perNumber, #(可选) 默认为15
        );
        $pages= new Cupage($part);
        $sql = "select a.*,b.typename from sys_question a left join sys_type b on a.questiontype=b.typeid $where order by a.questionid DESC limit $startCount,$perNumber ";
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
                return $this->renderAjax('findcapphone',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findcapphone',$part); //不调用layout
            }
        }else {
            if ($req->isAjax){ //ajax提交
                return $this->renderAjax('findcap',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findcap',$part); //不调用layout
            }
        }
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
            Yii::$app->db->createCommand()->delete('sys_exam',['examid'=>$c1])->execute();
            $tra1->commit();
        }catch (Exception $e) {
            $tra1->rollBack();
            pub::wrlog($e->getMessage());
            $r = "删除失败！";
        }
        return $this->renderContent($r);
    }
    public function actionDeldetail(){    //删除 ajax提交自己加参数判断
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
        $ctype=$req->get('type','');
        //验证提交信息合法性  验证唯一ID
        if($cK!=pub::enFormMD5('del',$c1))
            return $this->renderContent(langs::get('checkerror'));
        //删除信息
        $tra1 = Yii::$app->db->beginTransaction();
        try{
            Yii::$app->db->createCommand()->delete('sys_question',['questionid'=>$c1])->execute();
            $tra1->commit();
        }catch (Exception $e) {
            $tra1->rollBack();
            pub::wrlog($e->getMessage());
            $r = "删除失败！";
        }
        $res='{"code":"'.$r.'"';
        $res.=',"type":"'.$ctype.'"';
        $res.='}';
        return $this->renderContent($res);
    }
    public function actionDeltype(){    //删除 ajax提交自己加参数判断
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
            Yii::$app->db->createCommand()->delete('sys_type',['typeid'=>$c1])->execute();
            $tra1->commit();
        }catch (Exception $e) {
            $tra1->rollBack();
            pub::wrlog($e->getMessage());
            $r = "删除失败！";
        }
        return $this->renderContent($r);
    }
    public function actionDelcap(){    //删除 ajax提交自己加参数判断
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
            Yii::$app->db->createCommand()->delete('sys_question',['questionid'=>$c1])->execute();
            $tra1->commit();
        }catch (Exception $e) {
            $tra1->rollBack();
            pub::wrlog($e->getMessage());
            $r = "删除失败！";
        }
        return $this->renderContent($r);
    }
}
