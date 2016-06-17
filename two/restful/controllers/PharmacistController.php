<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\TblInterfaceCallStaff;     //接口调用人员表
use app\models\TblStaff;                  //员工表
/**
 * ================================================================================================================
 *
 * 润医阁 抓药师端App接口控制器
 * $Author: liuzhen $
 * PharmacistController  2016-05-27 15:30:08Z liuzhen $
 *
 * ================================================================================================================
 */

class PharmacistController extends Controller
{
    public function actionCeshi(){
        return $this->renderPartial('ceshi');
    }
    //抓药师登录
    public function actionLogin(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_POST['token'])?$_POST['token']:"";
        if($token==""){
            $login_list['code'] = "100";
            $login_list['data'] = "";
            $login_list['errormsg'] = "请输入token";
            echo json_encode($login_list);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login_list['code'] = "100";
            $login_list['data'] = "";
            $login_list['errormsg'] = "您没有权限调用本接口";
            echo json_encode($login_list);die;
        }
      $mobile = isset($_POST['mobile'])?$_POST['mobile']:"";
        if($mobile == ""){
            $login_list['code'] = "100";
            $login_list['data'] = "";
            $login_list['errormsg'] = "手机号不能为空";
            echo json_encode($login_list);die;
        }
      $password = isset($_POST['password'])?$_POST['password']:"";
        if($password == ""){
            $login_list['code'] = "100";
            $login_list['data'] = "";
            $login_list['errormsg'] = "密码不能为空";
            echo json_encode($login_list);die;
        }
      $staff = new TblStaff();
      $staff_list = $staff->find()->where(['mobile'=>$mobile])->asArray()->one();
      if($staff_list==""){
            $login_list['code'] = "100";
            $login_list['data'] = "";
            $login_list['errormsg'] = "账号不存在";
            echo json_encode($login_list);die;
        }
      if($staff_list['password_hash'] != $password){
          $login_list['code'] = "100";
          $login_list['data'] = "";
          $login_list['errormsg'] = "密码错误";
          echo json_encode($login_list);die;
      }
        $login_list['code'] = "200";
        $login_list['data'] = $staff_list;
        $login_list['msg'] = "登录成功";
        echo json_encode($login_list);die;
      }
    //代配处方
    public function actionUnfinished(){

    }
}
?>