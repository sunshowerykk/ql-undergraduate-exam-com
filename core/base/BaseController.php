<?php

namespace app\core\base;

use Yii;
use yii\web\Controller;
use app\models\langs;


class BaseController extends Controller
{
    public function actions()
    {
        //用户登录验证
        if (Yii::$app->user->isGuest) {
            if (Yii::$app->request->isAjax){
                print_r(langs::get('nologin'));
                Yii::$app->end();
            }else{
                $this->redirect(array('login/gohome'));
            }

        }
        /*取控制器名称 BaseController 为 base
          权限中的模块名称 frmbase
        */
        /*$conId = explode('/',trim($this->id,'/'));
        $modID = 'frm'.$conId;*/

    }

    public function actionIndex(){

    }
}