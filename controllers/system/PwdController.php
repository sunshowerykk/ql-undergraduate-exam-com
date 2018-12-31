<?php

namespace app\controllers\system; //notes 二级目录控制器

use Yii;
use yii\db\Exception;
use app\core\base\BaseController;
use app\models\langs;
use app\models\pub;
use app\models\cupage;

class PwdController extends BaseController
{
    public function beforeaction($action){
        $nochk=array('','');  //跳过权限控制的动作，如Search
        if(!in_array($action->id,$nochk)){
            //权限控制
        }
        return true;
    }
    public function actions(){ //默认执行动作
        //parent::actions();//调用父方法
    }
    public function actionIndex(){
        //parent::actionIndex();//调用父方法
        //$this->layout = "mainindex"; //指定框架
        //$view = Yii::$app->view;  //给框架加参数
        //接收GET，POST的数据及验证
        
        /*调用查询明细
          (大数据不能默认查询，调用默认模板，FindDetail中加入<?=$detail?>)
        */

        $part=array(
            'detail' => array(),
        );
        return $this->render('index',$part);
    }
    public function actionFindhead(){    //查询动作
        $request = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        $page = $request->get('p',1);
        $keyusrName = $request->post('keyusrName',"");
        $keyDeptId = $request->post('deptId',"");
        $keyUserStatus = $request->post('keyUserStatus',"");
        //用户账号查询或者名称查询
        $where = " where 1=1 ";
        if (!empty($keyusrName)){
            $keyusrName=trim($keyusrName); /*去除变量所以空格*/
            $where .=" and (UserName like '$keyusrName%'
               or UserFull like '$keyusrName%')";
        }
        //状态查询
        if ($keyUserStatus=="1"){
            //$keyUserStatus=trim($keyUserStatus); /*去除变量所以空格*/
            $where .=" and a.UserStatus = '1'";
        }
        if ($keyUserStatus=="0"){
            //$keyUserStatus=trim($keyUserStatus); /*去除变量所以空格*/
            $where .=" and a.UserStatus = '0'";
        }
        //部门查询
        if (!empty($keyDeptId)){
            $keyDeptId=trim($keyDeptId); /*去除变量所以空格*/
            $where .=" and a.DeptId = '$keyDeptId'";
        }
        $perNumber=15; //每页显示的记录数
        //$sql = "SELECT count(1) as total FROM sys_user $where";
        $sql = "SELECT count(1) as total FROM sys_user a LEFT JOIN sys_dept b ON a.DeptId=b.DeptId LEFT JOIN sys_role c ON a.RoleID=c.RoleID $where";
        $count=Yii::$app->db->createCommand($sql)->queryScalar();
        $totalNumber=$count;
        $total_pages=ceil($totalNumber/$perNumber); //计算出总页数
        //接受的分页数 $page（P）大于总页数，赋值成总页数
        $page = $page>$total_pages?$total_pages:$page;

        //$page 如果没有值,则赋值1
        $startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
        $startCount = $startCount<0?0:$startCount;
        $params= array(
            'total_rows'=>$totalNumber, #(必须)
            'method'    =>'ajax', #(必须)
            'ajax_func_name'=>'findHead',
            'parameter'=>"",  #(必须)
            'now_page'  =>$page,  #(必须)
            'list_rows'=>$perNumber, #(可选) 默认为15
        );
        $pages= new Cupage($params);
        //$sql = "SELECT * FROM sys_user  $where order by UserName  limit $startCount,$perNumber ";
        $sql = "SELECT a.*,b.DeptName,c.roleName FROM sys_user a LEFT JOIN sys_dept b ON a.DeptId=b.DeptId LEFT JOIN sys_role c ON a.RoleID=c.RoleID $where order by UserName  limit $startCount,$perNumber ";
        $qry = Yii::$app->db->createCommand($sql);
        $d_data = $qry->queryAll();

        //返回值处理或调用模板
        $part = array(
            'd_data'=>$d_data,
            'page'=>$pages,
        );
        if (Yii::$app->request->isAjax){ //ajax提交
            return $this->renderAjax('findhead',$part); //不调用layout
        }else{   //普通提交
            return $this->render('findhead',$part); //不调用layout
        }
    }
    public function actionCreatehead(){  //新增加的view
        $request = Yii::$app->request;
        $this->layout = 0; //不调用layout模板

        $part = array(
            'swhash'=> pub::enFormMD5("add"),
            'd_data'=>array(),
            'p'=>1,
        );
        //返回值处理或调用模板
        if (Yii::$app->request->isAjax){ //ajax提交
            return $this->renderAjax('Createhead',$part); //不调用layout
        }else{   //普通提交
            // return $this->render('');
        }
    }
    public function actionEdithead(){  //修改的view
        $request = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //权限控制

        //接收GET，POST的数据及验证
        $hid = Yii::$app->user->identity->UserName;
        if ($hid==""){
            return $this->renderContent('未登录！无法进行');
        }

        $part = array(
            'swhash'=> pub::enFormMD5("edit",$hid),
            'd_data'=>array(),
            'p'=>$request->get('p',1), //当前页码
        );
        //返回值处理或调用模板
        if ($request->isAjax){ //ajax提交
            return $this->renderAjax('createhead',$part); //不调用layout
        }else{   //普通提交
            return $this->render('createhead',$part);
        }
    }
    public function actionLoadhead(){   //显示信息
        $request = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        $hid = $request->get('hid',"");
        if ($hid==""){
            return $this->renderContent('非法操作！无法进行');
        }
        //验证提交信息合法性  验证唯一ID
        pub::chkID($request->get('_k',""),$hid);



        $part = array(
            'swhash'=> pub::enFormMD5("edit",$hid),
            'd_data'=>array(),
            'p'=>$request->get('p',1), //当前页码
        );
        //返回值处理或调用模板
        if ($request->isAjax){ //ajax提交
            return $this->renderAjax('loadhead',$part); //不调用layout
        }else{   //普通提交
            // return $this->render('add');
        }
    }
    public function actionSavehead(){    //新加保存
        $request = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //接收GET，POST的数据及验证
        if (!$request->isPost){
            $r = '非法提交，无法使用！';
            return $this->renderContent($r);
        }
        $r = "[0000]";
        $UserName = Yii::$app->user->identity->UserName;
        $UserPwd = pub::chkPost($request->post('UserPwd',""),"","【原始密码】必须输入");
        $UserPwd = md5($UserPwd);
        $UserPwd1 = pub::chkPost($request->post('UserPwd1',""),"","【新密码】必须输入");
        $UserPwd2 = pub::chkPost($request->post('UserPwd2',""),"","【确认密码】必须输入");
        //验证密码是否输入
        if ($UserPwd1<>$UserPwd2){
            print_r("两次密码输入不一致！");
            Yii::$app->end();
        }
        //验证用户密码输入是否正确
        $sql = "select UserPwd from sys_user where UserName='$UserName'";
        $pwd = Yii::$app->db->createCommand($sql)->queryScalar();
        if ($pwd<>$UserPwd){
            print_r("【原始密码】输入错误，请修改！");
            Yii::$app->end();
        }

        $data = array(
            'UserPwd' => md5($UserPwd1)
        );
        Yii::$app->db->createCommand()->update('sys_user', $data, ['UserName' => $UserName])->execute();

        $part = array(

        );

        //返回值处理或调用模板
        if ($request->isAjax){ //ajax提交
            return $this->renderContent($r);
        }else{   //普通提交
            // return $this->render('add');
        }
    }

    public function actionDelhead(){    //删除 ajax提交自己加参数判断
        $request = Yii::$app->request;
        $this->layout = 0; //不调用layout模板
        //权限控制
        $r = "[0000]";
        if (!$request->isPost){
            $r = '非法提交，无法使用！';
            return $this->renderContent($r);
        }

        //返回值处理或调用模板
        if ($request->isAjax){ //ajax提交
            return $this->renderAjax($r); //不调用layout
        }else{   //普通提交
            // return $this->render('add');
        }
    }
}
