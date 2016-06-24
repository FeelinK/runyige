<?php

namespace app\controllers;

use app\models\DoctorFeedbackForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TblPrescription;             //药方模型
class RunyigeController extends Controller
{
    //根据药方ID搜索药方
    public function actionPrint(){
        $prescription_id= $_GET['prescription_id'];
        $prescription = new TblPrescription();
        $prescription_list = $prescription->find()->where(['prescription_id' =>  $prescription_id])->asArray()->one();
        if(empty($prescription_list)){
            $login['code'] = "201";
            $login['message'] = "暂无数据";
            echo json_encode($login);die;
        }else{
            $list['code'] = "200";
            $list['message'] = "ok";
            $list['data'] = $prescription_list;
            echo json_encode($list);die;
        }
    }
    //根据日期搜索
    public function actionDate()
    {
        $time = $_GET['time'];
        $prescription = new TblPrescription();
        $where = "created_at like '$time%'";
        $prescription_list = $prescription->find()->where($where)->asArray()->all();
        if (empty($prescription_list)) {
            $login['code'] = "201";
            $login['message'] = "暂无数据";
            echo json_encode($login);
            die;
        } else {
            $list['code'] = "200";
            $list['message'] = "ok";
            $list['data'] = $prescription_list;
            echo json_encode($list);die;
        }
    }
}