<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\pub;

class LoginController extends Controller
{
    public function actions(){
        $this->layout = 0;
    }
    public function actionIndex()
   {
        if(!Yii::$app->user->isGuest){ //登陆成功
            return $this->redirect('/');
        }else{
            if ( pub::is_mobile() ) {
                $sms= "nosm";
                return $this->render('loginphone', [
                    'model' => "",
                    'status' =>"",
                    'sms' => $sms,
                ]);
            }else{
                $sms= "nosm";
                return $this->render('login', [
                    'model' => "",
                    'status' =>"",
                    'sms' => $sms,
                ]);
            }
        }

    }
    //验收用户信息提交
    public function actionAjaxlogin(){
        $this->layout = 0;
        $req = Yii::$app->request;
        $access_token = $req->get('access-token',"");
        if(!empty($access_token)){
            $url="https://api.kaoben.top/users/islogin?access-token=".$access_token;
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
                        return $this->redirect('/');
                    }else//登陆失败
                        $status = '用户名或密码错误，登录失败';
                    return $this->renderContent($status);
                }else{
                    $status = '系统错误！';
                    return $this->renderContent($status);
                }
            }
        }else{
            $post = Yii::$app->request->post();
            //验证码确认
//            $code = isset($post['LoginForm']['chkCode'])?isset($post['LoginForm']['chkCode']):"";
//            session_start();
//            $scodetime = isset($_SESSION['swsmstime'])?$_SESSION['swsmstime']:0;
//            $scode = isset($_SESSION['swsms'])?$_SESSION['swsms']:"";
//            if ($scode<>""){
//                //验证码过期设置
//                $t = time()-$scodetime;
//                $min_only = intval(floor($t / 60));
//                if ($min_only>=5){
//                    $_SESSION['swsmstime'] = 0 ;
//                    $_SESSION['swsms'] = "";
//                    $status = "验证码已过期,需重新取得。";
//                    return $this->renderContent($status);
//                }
//
//                if ($code <> $scode){
//                    $status = '請輸入正確的驗證碼!';
//                    return $this->renderContent($status);
//                }
//            }

            //file_put_contents('D:/log/swz.txt', print_r($identity, true), FILE_APPEND);
            $model = new LoginForm();
            if ($post['LoginForm']['UserPwd']=='' or $post['LoginForm']['UserName']=='' ){
                $status = '用戶名和密碼必須輸入!';
                return $this->renderContent($status);
            }
            //$post['LoginForm']['rememberMe']=false ;
            if($model->load($post)) {
                if($model->login()){ //登陆成功
                    return $this->renderContent('1');
                }else//登陆失败
                    $status = '用户名或密码错误，登录失败';
                return $this->renderContent($status);
            }else{
                $status = '系统错误！';
                return $this->renderContent($status);
            }
        }

    }
    //等待信息
    public function actionGohome()
    {
        return $this->render('gohome',['status' =>""]);
    }
    //登出系统
    public function actionLogout()
    {
        Yii::$app->user->logout(false);
        return $this->redirect(['index']);
        //return $this->goHome();

    }
   //发送验证码
   public function actionAjaxsendsms(){
       $this->layout=0;
       //短信验收码保存
       session_start();
       $rr = rand(1111,9999);
       $code = "OA系統登錄驗證碼是：".$rr."，5分鐘后失效。";
       $a = pub::postSMS('15986953856,13509074113',$code);
       if (substr($a,0,1)=='0'){
            $_SESSION['swsms'] = $rr;
            $_SESSION['swsmstime'] = time();
            return $this->renderContent('0');
       }else{
            return $this->renderContent('获取失败，请重试');
       }

   }
}
