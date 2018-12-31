<?php

namespace app\controllers;

use app\models\langs;
use Yii;
use yii\web\Controller;
use app\models\pub;
use yii\db\Exception;

class ApitestController extends Controller
{
    public $enableCsrfValidation = false;
    public function actions(){
        return $this->renderContent(0);
    }
    public function actionIndex(){

    }
    public  function  actionGetaccesstoken(){
        $this->layout = 0;
        $curl = curl_init(); // 启动一个CURL会话
        $data=array(
            'phone' => '18811717528',
            'password'=>'12345678'
        );
       // $data2= json_encode($data);
        curl_setopt($curl, CURLOPT_URL, "https://api.kaoben.top/users/login"); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
      //  file_put_contents('E:/log/l' . time() . '.txt', print_r($tmpInfo, true), FILE_APPEND);
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据，json格式
    }
	public function actionGetexambyuser(){
		$req = Yii::$app->request;
        $this->layout = 0;
        $userid = $req->get('userid',"");
        $subid = $req->get('subid',"");
		$sql = "select a.ehid,a.ehexamid,a.ehscore,a.ehgardestatus,b.examcoursesectionname,b.examname FROM sys_examhistory a LEFT JOIN sys_exam b on a.ehexamid=b.examid WHERE a.userid='$userid' AND b.examsubid='$subid' AND a.ehstatus=1";
        $data=Yii::$app->db->createCommand($sql)->queryAll();
		$sql="select count(*) from sys_exam where examsubid ='$subid'";
        $examnum=Yii::$app->db->createCommand($sql)->queryScalar();//应考次数
        $sql="select count(*) FROM sys_examhistory a LEFT JOIN sys_exam b on a.ehexamid=b.examid WHERE a.userid='$userid' AND b.examsubid='$subid' AND ehscore>=60";
        $examuser=Yii::$app->db->createCommand($sql)->queryScalar();//应考次数
        if(!empty($data)){
            foreach ($data as $key => $val) {
                if($val['ehgardestatus']==2 && ($val['ehscore']>=60)){
                    $_k=Pub::enFormMD52('open',$val['ehid']);
                    $data[$key]['status'] = 1;
                    $data[$key]['link'] = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"] ."?r=student/student/loadexam"."&c1=".$val['ehid']."&_k=".$_k;;
                }elseif ($val['ehgardestatus']==1 || $val['ehgardestatus']==3){
                    $data[$key]['status'] = 3;
                    $data[$key]['link'] = "";
                }else{
                    $_k=Pub::enFormMD52('exam',$val['ehexamid']);
                    $data[$key]['status'] = 2;
                    $data[$key]['link'] ='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"] ."?r=student/student/toexam"."&examid=".$val['ehexamid']."&_k=".$_k;
                }
            }
        }
        $userdata=array_merge(array('examnum'=>$examnum,'examuser'=>$examuser,'list'=>$data));
        //file_put_contents('E:/log/l' . time() . '.txt', print_r($userdata, true), FILE_APPEND);

		return json_encode($userdata);
		
	}
}
