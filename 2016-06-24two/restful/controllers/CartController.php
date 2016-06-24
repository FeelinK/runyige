<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TblHospital;
use app\models\TblPrescription;
use app\models\TblInterfaceCallStaff;
class CartController extends Controller
{
    //药方接口信息接口
    public function actionCart()
    {




      $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $prescription_list['defeated'] = "0";
            $prescription_list['data'] = "请输入您的token";
            return json_encode($prescription_list);die;
       }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $prescription_list['defeated'] = "0";
          $prescription_list['data'] = "您没有权限调用本接口";
          return json_encode($prescription_list);die;
      }
        if(isset($_GET['types'])){
            if($_GET['types']=='types'){ //根据分类搜索
                $where = (!empty($_GET['type'])) ? ['patient_type_name' => $_GET['type']] : "";
                $prescription_list = TblPrescription::find()->where($where)->asArray()->all();
            }elseif($_GET['types']=='hospital'){//根据医院搜索
                $where = (!empty($_GET['hospital_name'])) ? ['hospital_name' => $_GET['hospital_name']] : "";
                $prescription_list = TblPrescription::find()->where($where)->asArray()->all();
            }elseif($_GET['types']=='stay'){//根据待配和已配分类搜索
                if(isset($_GET['prescription_status'])){
                    $where = ($_GET['prescription_status']=="stay_with") ? ['<', 'prescription_status', 6] : ['prescription_status'=>6];
                    $prescription_list = TblPrescription::find()->where($where)->asArray()->all();
                }else{
                    $prescription_list['defeated'] = "0";
                    $prescription_list['data'] = "请传入正确参数";
                }
            }elseif($_GET['types']=='search'){
                $search_name = (!empty($_GET['search_name'])) ? $_GET['search_name']: "";
                $db=Yii::$app->db;
                $sql = "select * from tbl_prescription where ( hospital_name like %$search_name% or doctor_name like %$search_name% or patient_name like %$search_name% or prescription_id like $search_name)";
                $prescription_list=$db->createCommand($sql)->execute();

            }
            if($prescription_list){
                $prescription_list['success'] = 1;
            }else{
                $prescription_list = 0;
            }
        }else{
            $prescription_list['code'] = 100;
            $prescription_list['data'] = "请传入正确参数";
        }
        return json_encode($prescription_list);
    }


   //所有的医馆接口

    public function actionHospital(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $prescription_list['defeated'] = "0";
            $prescription_list['data'] = "请输入您的token";
            return json_encode($prescription_list);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $prescription_list['defeated'] = "0";
            $prescription_list['data'] = "您没有权限调用本接口";
            return json_encode($prescription_list);die;
        }
        $hospital = new TblHospital();//所有医院模型
        $hospital_list = $hospital->find()->select('hospital_name')->asArray()->all();//所有医院
        if($hospital_list){
            $hospital_list['success'] = 1;
        }else{
            $hospital_list['success'] = 0;
        }
        return json_encode($hospital_list);
    }
    public function actionAaa()
    {
        @$url = "http://101.200.232.66/restful/web/index.php?r=cart/cart&token=1&types=types";
        $list = file_get_contents($url);
        $aa=json_decode($list);
        var_dump($aa);
    }
}