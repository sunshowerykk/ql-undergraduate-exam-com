<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\pub;

class HomeController extends Controller
{
    public function actions()
    {
        //用户登录验证
        if (Yii::$app->user->isGuest) {
            $this->redirect(array('login/index'));
        }
    }
    public function actionIndex()
    {
        if ( pub::is_mobile() ) {
            $this->layout = "mainphone";
        }else {
            $this->layout = "mainindex"; //指定框架
        }
        $view = Yii::$app->view->params['data']="1";  //给框架加参数
        //$view->params['layoutCss']='active';
		$request = Yii::$app->request;
        //功能菜單取出
//        $role = Yii::$app->user->identity->getRoleId();
//        $confMenu = getMenu($role);
        $confMenu = array(
            'confMenu'=>"",
        );
        return $this->render('index',$confMenu);
    }
    public function actionMenu(){

    }
    public function actionLogin()
    {
        $this->layout = 0;
        $model = new LoginForm();
        if(!Yii::$app->user->isGuest){
            //登陆成功
            return $this->redirect(['index']);
        }
        $post = Yii::$app->request->post();
        if($model->load($post))
        {
            if($model->login()){
                //登陆成功
                return $this->redirect(['index']);
            }else
                //登陆失败
                $status = '用户名或密码错误，登录失败';
            return $this->render('login',['model'=>$model,'status'=>$status]);
        }
        else
        {
            return $this->render('login', [
                'model' => $model,
                'status' =>"",
            ]);
        }

    }

    public function actionLogout()
    {
        Yii::$app->user->logout(false);
        return $this->redirect(['index']);
        //return $this->goHome();

    }

    public function actionError(){
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            //return $this->render('error', ['exception' => $exception]);
            pub::wrlog($exception);
            return $this->renderContent('发生未知错误，请联络MIS专员-HomeC') ;
        }
    }


}

//
//function getMenu111($t){ //取出权限菜单,未使用
//    //$sql = "select * from ".$t." order by ModIndex";
//    /*$sql = "select a.* from sys_mode a,sys_right b where a.ModID=b.ModID and roleID='$t'
//            order by ModIndex";
//    $sql = "select a.* from sys_mode a,sys_right b where a.ModID=b.ModID and roleID='$t' and
//            (ModParent in (select a.ModID from sys_mode a,sys_right b where a.ModID=b.ModID
//            and roleID='$t' and ModType='M') or ModType='M') order by ModIndex";*/
//
//    $sql = "select a.* from sys_mode a,sys_right b where a.ModID=b.ModID and roleID='$t' and
//            (ModParent in (select a.ModID from sys_mode a,sys_right b where a.ModID=b.ModID
//            and roleID='$t' and ModType='M') or ModType='M') order by ModIndex";
//    $qry = Yii::$app->db->createCommand($sql);
//    $i = -1;
//    $value = $qry->queryAll();
//    $m = array();
//    foreach ($value as $val ) {
//        if ($val['ModType'] == 'M') {
//            $i = $i + 1;
//            $m[$i]['text'] = $val['ModName'];
//            $m[$i]['collapsed'] = true;
//        } else {
//            $ma['id'] = substr($val['ModID'], 3, 100);
//            $ma['text'] = $val['ModName'];
//            $ma['href'] = $val['ModUrl'];
//            $ma['reload'] = false; //swz  item.get('reload'),判断是否自动重载刷新main-min.js
//            $m[$i]['items'][] = $ma;
//        }
//
//    }
//    $abc = '[{' .
//        '"id":"web",' .
//        '"homePage" : "",' .
//        '"menu":' . json_encode($m) .
//        '}' .
//        ']';
//    $abc = str_replace("\"", "'", $abc);
//    return $abc;
//}
//function getMenu($t){ //取出权限菜单
//
//    $sql = "select a.* from sys_mode a,sys_right b where a.ModID=b.ModID and roleID='$t' and ModType='M' order by ModIndex";
//	$qry = Yii::$app->db->createCommand($sql);
//    $i = -1;
//    $value = $qry->queryAll();
//    $m = array();
//    foreach ($value as $val ) {
//        $i = $i + 1;
//        $m[$i]['text'] = $val['ModName'];
//        $m[$i]['collapsed'] = true;
//        //取子
//        $sql = "select a.* from sys_mode a,sys_right b where a.ModID=b.ModID and roleID='$t' and a.ModParent='".$val['ModID']."' and ModType='P' order by ModIndex";
//	   $qryp = Yii::$app->db->createCommand($sql)->queryAll();
//        foreach ($qryp as $valP ) {
//            $ma['id'] = substr($valP['ModID'], 3, 100);
//            $ma['text'] = $valP['ModName'];
//            $ma['href'] = $valP['ModUrl'];
//            $ma['reload'] = false; //swz  item.get('reload'),判断是否自动重载刷新main-min.js
//            $m[$i]['items'][] = $ma;
//        }
//
//    }
//    $abc = '[{' .
//        '"id":"web",' .
//        '"homePage" : "",' .
//        '"menu":' . json_encode($m) .
//        '}' .
//        ']';
//    $abc = str_replace("\"", "'", $abc);
//    return $abc;
//}