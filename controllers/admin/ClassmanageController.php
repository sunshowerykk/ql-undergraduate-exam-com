<?php
namespace app\controllers\admin; //basic 二级目录控制器
use Yii;
use yii\db\Exception;
use app\core\base\BaseController;
use app\models\langs;
use app\models\pub;
use app\models\cupage;

class ClassmanageController extends BaseController
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
        }else {
            $this->layout = "mainindex"; //指定框架
        }
       // $this->layout = "mainindex"; //指定框架
        $view = Yii::$app->view->params['data']="1";
        $part = array(

        );
        if ( pub::is_mobile() ) {
            return $this->render('p_index', $part);
        }else {
            return $this->render('index', $part);
        }
    }
    public function actionFindphonehead($p='1'){
        parent::actionIndex();//调用父方法
        $this->layout = 0; //指定框架
        $view = Yii::$app->view->params['data']="1"; //给框架加参数
        $req = Yii::$app->request;
        //接收GET，POST的数据及验证
        $page = $req->get('p',$p);
        $perNumber=10;
        //$page 如果没有值,则赋值1
        $startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
        $startCount = $startCount<0?0:$startCount;
        $url="https://api.kaoben.top/courses/nodes?page=".$startCount."&pernumber=".$perNumber;
        $ch = curl_init(); //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch); //释放curl句柄
        curl_close($ch);
        $data=json_decode($output,true);
        $totalNumber=$data['sectionsCount'];
        $total_pages=ceil($totalNumber/$perNumber); //计算出总页数
        //接受的分页数 $page（P）大于总页数，赋值成总页数
        $page = $page>$total_pages?$total_pages:$page;
        $part= array(
            'total_rows'=>$totalNumber, #(必须)
            'method'    =>'ajax', #(必须)
            'ajax_func_name'=>'findhead',
            'parameter'=>"",  #(必须)
            'now_page'  =>$page,  #(必须)
            'list_rows'=>$perNumber, #(可选) 默认为15
        );
        $pages= new Cupage($part);
        $part = array(
            'data'=>$data['data'],
            'page'=>$pages,
            // 's_data'=>$s_data,
            'detail' => array(),
        );
        if ($req->isAjax){ //ajax提交
            return $this->renderAjax('findphonehead',$part); //不调用layout
        }else{   //普通提交
            return $this->render('findphonehead',$part); //不调用layout
        }
    }
    public function actionFindhead($p='1'){
            parent::actionIndex();//调用父方法
            $this->layout = 0; //指定框架
            $view = Yii::$app->view->params['data']="1"; //给框架加参数
            $req = Yii::$app->request;
            //接收GET，POST的数据及验证
            $page = $req->get('p',$p);
            $perNumber=10;
            //$page 如果没有值,则赋值1
            $startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
            $startCount = $startCount<0?0:$startCount;
            $url="https://api.kaoben.top/courses/nodes?page=".$startCount."&pernumber=".$perNumber;
            $ch = curl_init(); //设置选项，包括URL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $output = curl_exec($ch); //释放curl句柄
            curl_close($ch);
            $data=json_decode($output,true);
            $totalNumber=$data['sectionsCount'];
            $total_pages=ceil($totalNumber/$perNumber); //计算出总页数
            //接受的分页数 $page（P）大于总页数，赋值成总页数
            $page = $page>$total_pages?$total_pages:$page;
            $part= array(
                'total_rows'=>$totalNumber, #(必须)
                'method'    =>'ajax', #(必须)
                'ajax_func_name'=>'findhead',
                'parameter'=>"",  #(必须)
                'now_page'  =>$page,  #(必须)
                'list_rows'=>$perNumber, #(可选) 默认为15
            );
            $pages= new Cupage($part);
            $part = array(
                'data'=>$data['data'],
                'page'=>$pages,
                // 's_data'=>$s_data,
                'detail' => array(),
            );
            if ($req->isAjax){ //ajax提交
                return $this->renderAjax('findhead',$part); //不调用layout
            }else{   //普通提交
                return $this->render('findhead',$part); //不调用layout
            }
        }
    //科目数据调用
    public function actionIndexsection(){
        $req = Yii::$app->request;
        $this->layout = 0; //不調用layout模板
        $rFuncName=$req->get('funcName','');
        //返回值处理或调用模板
        $data = array();
        $part = array(
            'rData'=>$data,
            'rFuncName'=>$rFuncName,
        );
        //返回值处理或调用模板
        if (Yii::$app->request->isAjax){ //ajax提交
            return $this->renderAjax('indexsection',$part); //不調用layout
        }else{   //普通提交
            return $this->render('indexsection',$part); //不調用layout
        }
    }
    public function actionFindsection($qFuncName=''){
        $req = Yii::$app->request;
        $this->layout = 0; //不調用layout模板
        //接收GET，POST的数据及验证
        $page = $req->get('p',1);
        $cFuncName=$req->post('funcName',$qFuncName);
        $perNumber=10;
        //$page 如果没有值,则赋值1
        $startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
        $startCount = $startCount<0?0:$startCount;
        $url="https://api.kaoben.top/courses/nodes?page=".$startCount."&pernumber=".$perNumber;
        $ch = curl_init(); //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch); //释放curl句柄
        curl_close($ch);
        $data=json_decode($output,true);
        $totalNumber=$data['sectionsCount'];
        $total_pages=ceil($totalNumber/$perNumber); //计算出总页数
        //接受的分页数 $page（P）大于总页数，赋值成总页数
        $page = $page>$total_pages?$total_pages:$page;
        $part= array(
            'total_rows'=>$totalNumber, #(必须)
            'method'    =>'ajax', #(必须)
            'ajax_func_name'=>$cFuncName.'.find',
            'parameter'=>"",  #(必须)
            'now_page'  =>$page,  #(必须)
            'list_rows'=>$perNumber, #(可选) 默认为15
        );
        $pages= new Cupage($part);
        //返回值处理或调用模板
        $part = array(
            'rData'=>$data['data'],
            'rPage'=>$pages,
            'rFuncName'=>$cFuncName,
        );
        if ($req->isAjax){ //ajax提交
            return $this->renderAjax('findsection',$part); //不調用layout
        }else{   //普通提交
            return $this->render('findsection',$part); //不調用layout
        }
    }//end of actionFindtype
}
