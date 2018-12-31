<?php
namespace app\models;

use Yii;
use yii\base\Model;


class langs extends Model
{
    private static $lang = array(
        'noright' => '您無權使用此功能！',
        'infotitle' =>'提示信息',
        'saveOK' => '保存成功。',
        'delOK' => '删除成功。',
        'Confirm' => '审核成功。',
        'cConfirm' => '还原成功。',
        'neterror' => '网络提交错误！',
        'checkerror' => '异常操作！',
        'noOnly' => '【rid】重复，保存失败，请修正',
        'nologin' => '登录已过期，请重新登录系统！',

    );

    public static function get($r){  //取出自定提示信息

        $result = empty(self::$lang[$r])?"沒有定義的常量":self::$lang[$r];
        $result = "<div style='margin: 20px'>$result</div>";

        return $result;
    }
    public static function getTxt($r){

        $result = empty(self::$lang[$r])?"沒有定義的常量":self::$lang[$r];
        return $result;
    }

}

