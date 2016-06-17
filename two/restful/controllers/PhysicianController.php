<?php

namespace app\controllers;

use app\models\DoctorFeedbackForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TblInterfaceCallStaff;       //验证token模型
use app\models\TblStaff;                    //员工表
use app\models\TblDoctor;                   //医生模型
use app\models\TblPrescription;             //药方模型
use app\models\TblPatient;                  //病人表
use app\models\TblPrescriptionPhoto;        //药方照片表
use app\models\TblPrescriptionDetail;       //药材的用法用量
use app\models\TblCity;                     //城市表
use app\models\TbConfirmPhoto;              //超量确认
use app\models\TblProgressBoiling;          //流程里边的煎制
use app\models\TblPrescriptionProgress;     //处方药的进展
use app\models\TblTerminal;                 //药房终端
class PhysicianController extends Controller
{
    //登录接口
  public function actionLogin(){
      $staff = new TblInterfaceCallStaff();
      $token = isset($_GET['token'])?$_GET['token']:"";
      if($token==""){
          $login['code'] = "100";
          $login['message'] = "请输入您的token";
         echo json_encode($login);die;
      }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $login['code'] = "100";
          $login['message'] = "您没有权限调用本接口";
         echo json_encode($login);die;
      }
      $phone = isset($_GET['phone'])?$_GET['phone']:"1";
      if($phone == 1){
          $login['code'] = "100";
          $login['data'] = "请输入手机号";
         echo json_encode($login);die;
      }
      $pwd = isset($_GET['pwd'])?$_GET['pwd']:"2";
      if($pwd == 2){
          $login['code'] = "100";
          $login['message'] = "请输入验证码";
         echo json_encode($login);die;
      }
      $staffs = new TblDoctor();
      $user_list = $staffs->find()->where(['doctor_phone' => $phone])->asArray()->one();
      if($user_list == ""){
          $login['code'] = "100";
          $login['message'] = "手机号码不存在";
         echo json_encode($login);die;
      }
      if($user_list['auth_key'] != $pwd){
          $login['code'] = "100";
          $login['message'] = "验证码不正确";
         echo json_encode($login);die;
      }
      if($pwd==$user_list['auth_key']){
          $login['code'] = "200";
          $login['message']="请求处理成功";
          $gf=$staffs->find()->select(array('doctor_phone'))->where("doctor_id='222'")->asArray()->one();
          if(empty($gf)){
              $gf['doctor_phone']="暂无客服";
          }
          $user_list['service']=$gf['doctor_phone'];
          $login['data'] = $user_list;

          echo json_encode($login);die;
      }else{
          $login['code'] = "100";
          $login['message'] = "验证码不正确";
          echo json_encode($login);die;
      }
  }
  //处方接口
  public function actionPrescription(){
      //验证token
      $staff = new TblInterfaceCallStaff();
      $token = isset($_GET['token'])?$_GET['token']:"";
      if($token==""){
          $login['code'] = "100";
          $login['message'] = "请输入您的token";
         echo json_encode($login);die;
      }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $login['code'] = "100";
          $login['message'] = "您没有权限调用本接口";
         echo json_encode($login);die;
      }
      $prescription = new TblPrescription();
      $doctor_id = isset($_GET['doctor_id'])?$_GET['doctor_id']:"1";
      $new_time = date("Y-m-d",time());

      $doctor_models = new TblDoctor();
      $doctor_is = $doctor_models->find()->where(['doctor_id' =>  $doctor_id])->asArray()->one();
      $hospital_id = $doctor_is['hospital_id'];
      if($doctor_is['is_dean'] == 1){
          $where = "hospital_id =  '$hospital_id' and prescription_time like '$new_time%'";
      }else{
          $where = "doctor_id =  '$doctor_id' and prescription_time like '$new_time%'";
      }
      $prescription_list = $prescription->find()->orderBy("created_at desc")->where($where)->asArray()->all();

        $tbl_patient=new TblPatient();
       for($i=0;$i<count($prescription_list);$i++){
           $prescription_id=$prescription_list[$i]['prescription_id'];
           $prescription_list[$i]['patient']=$tbl_patient->find()->where("prescription_id='$prescription_id'")->asArray()->one();
       }

      $sum =count($prescription_list);
      foreach($prescription_list as $k=>$v){
          $prescription_id = $v['prescription_id'];
          //查询患者
          $patient = new TblPatient();
          $prescription_photo = new TblPrescriptionPhoto();
          //查讯地址照片
          $prescription_id = $v['prescription_id'];
          $where = "prescription_id= '$prescription_id' and photo_type = 2";
          $patient_list = $prescription_photo->find()->where($where)->asArray()->one();
              $prescription_list[$k]['address_img'] = $patient_list['photo_img']; 
              $patient_lists = $patient->find()->where(['prescription_id' =>$v['prescription_id']])->asArray()->one();
              $prescription_list[$k]['patient_name'] = $patient_lists['addressee_name'];
              $prescription_list[$k]['address'] =  $patient_lists['address'];
              $prescription_list[$k]['mobile'] = $patient_lists['mobile'] ;
          //查询药方照
          $where = "prescription_id= '$prescription_id' and photo_type = 1";
          $prescription_photo_list = $prescription_photo->find()->where($where)->asArray()->all();         
          if(empty($prescription_photo_list)){
               $list['code'] = "201";
               $list['message'] = "暂无数据";
               echo json_encode($list);die;
          }
          $photo_imgs1 = $prescription_photo_list['0']['photo_img'];
          $photo_sum = count($prescription_photo_list);
          $prescription_list[$k]['photo_sum'] = $photo_sum;
          $prescription_list[$k]['photo_img'] = $photo_imgs1;
          if($photo_sum==2){
                 $prescription_list[$k]['photo_img1']=$prescription_photo_list['1']['photo_img'];    
          }else{
                 $prescription_list[$k]['photo_img1']= "";
          }
          $prescription_list['sum'] = $sum;
      };
      if(empty($prescription_list)){
          $prescription_lists['code'] = "201";
          $prescription_lists['message'] = "暂无数据";
         echo json_encode($prescription_lists);die;
      }
   
      //echo json_encode($prescription_list);die;
      //print_r($prescription_list);die;
      unset($prescription_list['sum']);
      $rj='{"code":"200",';
      $rj.='"message":"请求处理成功",';
      $rj.='"sum":'.$sum.',';
      $rj.='"data":[';
      foreach($prescription_list as $tj){
	$rj.='{"hospital_id":"'.$tj['hospital_id'].'",';
//	$rj.='"addressee_name":"'.json_encode($tj['addressee_name']).'",';
        $rj.='"production_type_name":'.json_encode($tj['production_type_name']).',';
        $rj.='"production_type_name":'.json_encode($tj['production_type_name']).',';
        $rj.='"use_frequence_name":'.json_encode($tj['use_frequence_name']).',';
	$rj.='"hospital_name":'.json_encode($tj['hospital_name']).',';
	$rj.='"doctor_id":"'.$tj['doctor_id'].'",';
	$rj.='"doctor_name":'.json_encode($tj['doctor_name']).',';
	$rj.='"patient_name":'.json_encode($tj['patient']['patient_name']).',';
	$rj.='"prescription_id":"'.$tj['prescription_id'].'",';
	$rj.='"patient_type":"'.$tj['patient_type'].'",';
	$rj.='"patient_type_name":'.json_encode($tj['patient_type_name']).',';
	$rj.='"notes":'.json_encode($tj['notes']).',';
	$rj.='"prescription_time":"'.$tj['prescription_time'].'",';
	$rj.='"use_frequence":"'.$tj['use_frequence'].'",';
	$rj.='"usage_id":"'.$tj['usage_id'].'",';
	$rj.='"usage_name":'.json_encode($tj['usage_name']).',';
	$rj.='"piece":"'.$tj['piece'].'",';
	$rj.='"kinds_per_piece":"'.$tj['kinds_per_piece'].'",';
	$rj.='"production_type":"'.$tj['production_type'].'",';
	$rj.='"price":"'.$tj['price'].'",';
	$rj.='"need_reconfirm":"'.$tj['need_reconfirm'].'",';
	$rj.='"is_reconfirmed":"'.$tj['is_reconfirmed'].'",';
	$rj.='"excessive_prescription":"'.$tj['excessive_prescription'].'",';
	$rj.='"prescription_status":"'.$tj['prescription_status'].'",';
	$rj.='"created_at":"'.$tj['created_at'].'",';
	$rj.='"updated_at":"'.$tj['updated_at'].'",';
	$rj.='"address":'.json_encode($tj['address']).',';
	$rj.='"mobile":"'.$tj['mobile'].'",';
        $rj.='"address_img":"'.$tj['address_img'].'",';
	$rj.='"photo_img":"'.$tj['photo_img'].'",';
	$rj.='"photo_img1":"'.$tj['photo_img1'].'",';
	$rj.='"photo_sum":"'.$tj['photo_sum'].'"},';
      }
      $rj=substr($rj,0,-1);
      $rj.=']}';
      echo $rj;die;
      if($prescription_list){
          $prescription_lists['code'] = "200";
          $prescription_list['message']="请求处理成功";
          $prescription_lists['data'] = $prescription_list;
         echo json_encode($prescription_lists);die;
      }else{
          $prescription_lists['code'] = "201";
          $prescription_lists['message'] = "目前没有数据";
         echo json_encode($prescription_lists);die;
      }
  }
    //处方内容
    public function actionPrescriptioncontent()
    {
        //验证token
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"";
        if($prescription_id == ""){
            $login['code'] = "100";
            $login['message'] = "请传入药方Id";
            echo json_encode($login);die;
        }
        $tblPrescription = new TblPrescription();
        $patient = new TblPatient();
        $prescription_photo = new TblPrescriptionPhoto();
        $prescription_list = $tblPrescription->find()->where(['prescription_id' => $prescription_id])->asArray()->one();
        $patient_list = $patient->find()->where(['prescription_id'=> $prescription_id])->asArray()->one();
        $where = "prescription_id= '$prescription_id' and photo_type = 1";
        $prescription_yphoto_list =  $prescription_photo->find()->where($where)->asArray()->all();
        $lists['prescription_list'] = $prescription_list;
        $lists['prescription_yphoto_list'] = $prescription_yphoto_list;
            $where = "prescription_id= '$prescription_id' and photo_type = 2";
            $prescription_dphoto_list =  $prescription_photo->find()->where($where)->asArray()->one();
            $lists['prescription_dphoto_list'] = $prescription_dphoto_list;
            $lists['patient_list'] = $patient_list;
        if($lists){
            $listss['code'] = "200";
            $lists['message']="请求处理成功";
            $listss['data'] = $lists;
        }else{
            $listss['code'] = "201";
            $listss['message'] = "当前没有数据";
        }
        echo json_encode($listss);die;
    }
    //禁忌超量列表
  public function actionExcessive(){
    //  验证token
      $staff = new TblInterfaceCallStaff();
      $token = isset($_GET['token'])?$_GET['token']:"";
      if($token==""){
          $list['code'] = "100";
          $list['message'] = "请输入您的token";
          echo json_encode($list);die;
      }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $list['code'] = "101";
          $list['message'] = "您没有权限调用本接口";
          echo json_encode($list);die;
      }
      $doctor_id = isset($_GET['doctor_id'])?$_GET['doctor_id']:"1";
   
      $doctor_models = new TblDoctor();
      $doctor_is = $doctor_models->find()->where(['doctor_id' =>  $doctor_id])->asArray()->one();
      $hospital_id = $doctor_is['hospital_id'];
      if($doctor_is['is_dean'] == 1){
          $where = "hospital_id =  '$hospital_id' and excessive_prescription = 0";
      }else{
          $where = "doctor_id = '$doctor_id' and excessive_prescription = 0";
      }
      //查询禁忌超量的药方
      $prescription = new TblPrescription();
      $prescription_list = $prescription
          ->find()
          ->where($where)
          ->select(array('prescription_id','patient_name','created_at','kinds_per_piece','piece'))
          ->asArray()
          ->all();

      $sum = count($prescription_list);
      if($prescription_list){
          $prescription_lists['code'] = "200";
          $prescription_lists['message'] = "请求成功";
          $prescription_lists['data']['sum'] = $sum;
          $prescription_lists['data']['prescription_list'] = $prescription_list;
         echo json_encode($prescription_lists);die;
      }else{

          $prescription_lists['code'] = "201";
          $prescription_lists['message'] = "暂无数据";

         echo json_encode($prescription_lists);die;
      }
  }
   //超量禁忌确认
    public function actionTaboo(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $list['code'] = "100";
            $list['message'] = "请输入您的token";
           echo json_encode($list);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $list['code'] = "101";
            $list['message'] = "您没有权限调用本接口";
            echo json_encode($list);die;
        }
        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"1";
        if($prescription_id == 1){
            $detail_list['code'] = "102";
            $detail_list['message'] = "请传入正确参数";
           echo json_encode($detail_list);die;
        }
        $prescription = new TblPrescription();//药方详情
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('patient_name','prescription_id','production_type','kinds_per_piece','piece','hospital_name','doctor_name','created_at'))
            ->asArray()
            ->one();
        $detail_models = new TblPrescriptionDetail();//药材详情
        $detail_list = $detail_models
            ->find()
            ->where(['prescription_id' => $prescription_id])
            ->select(array('medicine_name','is_excess','is_violation','weight'))
            ->asArray()
            ->all();
       // if($detail_list){
       //     $prescription_list['detail_list'] = $detail_list;
       // }else{
       //     $prescription_list['detail_list'] = "null";
       // }
       if(empty($detail_list)){
           $detail_list=[];
       }
        if($prescription_list){
            $detail_lists['code'] = "200";
            $detail_lists['message'] = "请求成功";
            $detail_lists['data']['prescription_list'] = $prescription_list;
            $detail_lists['data']['detail_list']=$detail_list;
           echo json_encode($detail_lists);die;
        }else{
            $prescription_lists['code'] = "201";
            $prescription_lists['message'] = "暂无数据";
            echo json_encode($prescription_lists);die;
        }
    }
//    //超量禁忌确认里的药材详情显示
//    public function actionTabooprescription(){
//        $staff = new TblInterfaceCallStaff();
//        $token = isset($_GET['token'])?$_GET['token']:"";
//        if($token==""){
//            $login['code'] = "100";
//            $login['data'] = "请输入您的token";
//           echo json_encode($login);die;
//        }
//        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
//        if($user_token==""){
//            $login['code'] = "100";
//            $login['data'] = "您没有权限调用本接口";
//           echo json_encode($login);die;
//        }
//        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"1";
//        if($prescription_id == 1){
//            $detail_list['code'] = "100";
//            $detail_list['data'] = "请传入正确参数";
//           echo json_encode($detail_list);die;
//        }
//        $prescription = new TblPrescription();
//        $prescription_list = $prescription->find()->where("prescription_id='$prescription_id'")->asArray()->one();
//        if($prescription_list){
//            $prescription_lists['code'] = "200";
//            $prescription_lists['data'] = $prescription_list;
//           echo json_encode($prescription_lists);die;
//        }else{
//            $prescription_lists['code'] = "200";
//            $prescription_lists['data'] = "目前没有数据";
//           echo json_encode($prescription_lists);die;
//        }
//    }
    //处方上传接口
    public function actionTaboophotograph(){
        //  验证toke
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $time =strtotime(date('Y-m-d H:i:s'));
        $doctor_id = isset($_GET['doctor_id'])?$_GET['doctor_id']:"";//医师ID
        $production_type = isset($_GET['production_type'])?$_GET['production_type']:""; //原药或代煎
        $photo_img = isset($_GET['photo_img'])?$_GET['photo_img']:""; //药方照片
        $photo_img1 = isset($_GET['photo_img1'])?$_GET['photo_img1']:""; //药方照片2
        $patient_type = isset($_GET['patient_type'])?$_GET['patient_type']:""; //针对的用户类型
        $notes = isset($_GET['notes'])?$_GET['notes']:""; //注意事项
        $photo_address_img = isset($_GET['photo_address_img'])?$_GET['photo_address_img']:""; //地址照片
        $new_time = date("Y-m-d H:i:s",time());
        if($doctor_id  == ""){
            $list['code'] = "100";
            $list['message'] = "请传入医师ID";
           echo json_encode($list);die;
        }
        if($production_type == ""){
            $list['code'] = "100";
            $list['message'] = "请选择原药或代煎";
           echo json_encode($list);die;
        }
        if($photo_img == ""){
            $list['code'] = "100";
            $list['message'] = "请上传药方照片";
           echo json_encode($list);die;
        }
        if($patient_type == ""){
            $list['code'] = "100";
            $list['message'] = "请选择警示级别";
           echo json_encode($list);die;
        }
        $doctor = new TblDoctor();
        $doctor_list=$doctor->find()->where(['doctor_id'=>$doctor_id])->one();
        $chars = array_merge(range('a','z'));
        shuffle($chars);
        $password = '';
        for($i=0; $i<2; $i++) {
            $password .= $chars[$i];
        }
        $prescription_id = $password.$time;
        
         $patient_name = isset($_GET['patient_name'])?$_GET['patient_name']:"";
        if($patient_name != ""){
            if($patient_name == ""){
                $list['code'] = "100";
                $list['message'] = "收件人姓名不能为空";
               echo json_encode($list);die;
            }
            $mobile = isset($_GET['mobile'])?$_GET['mobile']:"";
            if($mobile == ""){
                $list['code'] = "100";
                $list['message'] = "收件人电话不能为空";
               echo json_encode($list);die;
            }
            $province = isset($_GET['province'])?$_GET['province']:"";
            if($province == ""){
                $list['code'] = "100";
                $list['message'] = "收件人省份不能为空";
               echo json_encode($list);die;
            }

         //   $street = isset($_GET['street'])?$_GET['street']:"";
         //   if($street == ""){
         //       $list['code'] = "100";
         //       $list['data'] = "收件人市区不能为空";
          //     echo json_encode($list);die;
          //  }
            $address_in_detail = isset($_GET['address_in_detail'])?$_GET['address_in_detail']:"";
            if($address_in_detail == ""){
                $list['code'] = "100";
                $list['message'] = "收件人详细地址不能为空";
               echo json_encode($list);die;
            }
            //配送地址添加
            $address =  $province.$address_in_detail;
            $patient = new TblPatient();
            $sqllss = "insert into tbl_patient(prescription_id,patient_name,mobile,address,created_at)values('$prescription_id','$patient_name','$mobile','$address','$new_time')";
          
            $db=Yii::$app->db;
            $db->createCommand($sqllss)->execute();
           // $patient->prescription_id = $prescription_id;
           // $patient->patient_name = $patient_name;
           // $patient->mobile = $mobile;
           // $patient->address =$address;
           // $patient->created_at =$new_time;
           //  $patient->save();
        }
        if($photo_address_img!=""){

            //配送地址照片添加
          //  $prescriptionphoto = new TblPrescriptionPhoto();
           $photod_id = "photod".$time;
          //  $prescriptionphoto->prescription_id = $prescription_id;
          //  $prescriptionphoto->photo_id = $photod_id;
          //  $prescriptionphoto->photo_type = '2';
          //  $prescriptionphoto->photo_img = $photo_address_img;
          //  $prescriptionphoto->created_at =$new_time;  
            $db=Yii::$app->db;
            $sqs = "insert into tbl_prescription_photo(prescription_id,photo_id,created_at,photo_type,photo_img)values('$prescription_id','$photod_id','$new_time','2','$photo_address_img')";
            $db->createCommand($sqs)->execute();
           // if($prescriptionphoto->hasErrors()){
           //     $list['code'] = "100";
           //     $list['data'] = "数据不合法";
           //    echo json_encode($list);die;
           // }
          //  $prescriptionphoto->save();
        }
        //药方照片添加
        $prescriptionphoto = new TblPrescriptionPhoto();
      
        $photoy_id = "photoy".$time;
      //  $prescriptionphoto->prescription_id = $prescription_id;
      //  $prescriptionphoto->photo_id = $photoy_id;
      //  $prescriptionphoto->created_at = $new_time;
      //   $prescriptionphoto->photo_type = 1;
      //   $prescriptionphoto->photo_type = 0;
      //  $prescriptionphoto->photo_img = $photo_img;
        
         $db=Yii::$app->db;
        $sql = "insert into tbl_prescription_photo(prescription_id,photo_id,created_at,photo_type,photo_img)values('$prescription_id','$photoy_id','$new_time','1','$photo_img')";
        $db->createCommand($sql)->execute();
      //  $prescriptionphoto->validate();
        //if($prescriptionphoto->hasErrors()){
        //    $list['code'] = "100";
        //    $list['data'] = "数据不合法";
        //    echo json_encode($list);die;
       // }
        $prescriptionphoto->save();
        if(!empty($photo_img1)){
            $photoy_id = "photoys".$time;
       //     $prescriptionphoto->prescription_id = $prescription_id;
       //     $prescriptionphoto->photo_id = $photoy_id;
       //     $prescriptionphoto->created_at = $new_time;
       //     $prescriptionphoto->photo_type = 1;
       //     $prescriptionphoto->photo_type = 0;
        //    $prescriptionphoto->photo_img = $photo_img1;
        //    $prescriptionphoto->validate();
        //    if($prescriptionphoto->hasErrors()){
        //        $list['code'] = "100";
        //        $list['data'] = "数据不合法";
        //        echo json_encode($list);die;
        //    }
        
        $sqq = "insert into tbl_prescription_photo(prescription_id,photo_id,created_at,photo_type,photo_img)values('$prescription_id','$photoy_id','$new_time','1','$photo_img1')";
        $re=$db->createCommand($sqq)->execute();
         }
        //药方添加
        $prescription = new TblPrescription();
        $hospital_id = $doctor_list['hospital_id'];
        $hospital_name = $doctor_list['hospital_name'];
        $doctor_id = $doctor_list['doctor_id'];
        $doctor_name = $doctor_list['doctor_name'];
       // $prescription->hospital_id = $doctor_list['hospital_id'];
       // $prescription->hospital_name = $doctor_list['hospital_name'];
       // $prescription->doctor_id = $doctor_list['doctor_id'];
       // $prescription->doctor_name = $doctor_list['doctor_name'];
       // $prescription->prescription_status = 0;
       // $prescription->prescription_time = $new_time;
       // $prescription->prescription_id = $prescription_id;
       // $prescription ->production_type = $production_type;
       // $prescription->patient_type = $patient_type;
       $sqqls = "insert into tbl_prescription(hospital_id,hospital_name,doctor_id,doctor_name,prescription_status,prescription_time,prescription_id,production_type,patient_type,created_at)values('$hospital_id','$hospital_name','$doctor_id','$doctor_name','0','$new_time','$prescription_id','$production_type','$patient_type','$new_time')";
      
        $db->createCommand($sqqls)->execute();
    // if(!empty($notes)){
     //       $prescription->notes = $notes;
     //   }
       // $prescription->prescription_id = $prescription_id;
    //    $prescription->created_at =$new_time;
  //      $prescription->validate();
       // if($prescription->hasErrors()){
       //     $list['code'] = "100";
       //     $list['data'] = "数据不合法";
       //     echo json_encode($list);die;
       // }
        $prescription->save();
        $list['code'] = "200";
        $list['message'] = "处方上传成功";
        $prescription_list=$prescription->find()->select(array('prescription_id','production_type_name'))->where("prescription_id='$prescription_id'")->asArray()->one();
        $tbl_prescription_photo=new TblPrescriptionPhoto();
        $tbl_patient=new TblPatient();
        $prescription_list['patient_list']=$tbl_patient->find()->where("prescription_id='$prescription_id'")->asArray()->one();
        $sum =count($prescription_list);
        //查询患者
        $patient = new TblPatient();
        $prescription_photo = new TblPrescriptionPhoto();
        //查讯地址照片
        $where = "prescription_id= '$prescription_id' and photo_type = 2";
        $patient_list = $prescription_photo->find()->where($where)->asArray()->one();
        $prescription_list['patient_list']['address_img'] = $patient_list['photo_img'];
        $patient_lists = $patient->find()->where(['prescription_id' =>$prescription_id])->asArray()->one();
        $prescription_list['patient_list']['patient_name'] = $patient_lists['addressee_name'];
        $prescription_list['patient_list']['address'] =  $patient_lists['address'];
        $prescription_list['patient_list']['mobile'] = $patient_lists['mobile'] ;
        //查询药方照
        $where = "prescription_id= '$prescription_id' and photo_type = 1";
        $prescription_photo_list = $prescription_photo->find()->where($where)->asArray()->all();

        $photo_imgs1 = $prescription_photo_list['0']['photo_img'];
        $photo_sum = count($prescription_photo_list);
        $prescription_list['patient_list']['photo_sum'] = $photo_sum;
        $prescription_list['patient_list']['photo_img'] = $photo_imgs1;
        if($photo_sum==2){
            $prescription_list['patient_list']['photo_img1']=$prescription_photo_list['1']['photo_img'];
        }else{
            $prescription_list['patient_list']['photo_img1']= "";
        }
        $prescription_list['patient_list']['sum'] = $sum;
        $prescription_list['patient_list']['production_type_name']=$prescription_list['production_type_name'];

        //print_r($prescription_list);die;
        $list['data']=$prescription_list['patient_list'];
         //推送给抓药师
        $soket['prescription_id'] =$prescription_id;
        $soket['doctor_name'] = $doctor_list['doctor_name'];
        $soket['hospital_name'] = $doctor_list['hospital_name'];
        $soket['production_type'] = $production_type;
        $soket['notes'] = $notes;
        $soket['prescription_status'] = 1;
        $soket['type'] = 'ryg';
        $terminal= new TblTerminal();
        $uid = $terminal->find()->where(['is_active' => 1])->asArray()->all();
        $key= array_rand($uid,1);
        foreach($uid  as $k=>$v){
            $to_uid = $v['terminal_id']+0;
            if($to_uid==$uid[$key]['terminal_id']){
                $soket['prescription_jurisdiction'] = 1;
            }else{
                $soket['prescription_jurisdiction'] = 0;
            }
           $sokets = json_encode($soket);
            // 推送的url地址，
            $push_api_url = "http://workerman.net:2121/";
            $post_data = array(
                "type" => "publish",
                "content" => $sokets,
                "to" => $to_uid,
            );
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            curl_setopt ( $ch, CURLOPT_HEADER, 0 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
            $return = curl_exec ( $ch );
            curl_close ( $ch );
        } 
       echo json_encode($list);die;
    }
    //确认禁忌超量
    public function actionConfirmexcess(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $list['code'] = "100";
            $list['message'] = "请输入您的token";
            echo json_encode($list);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $list['code'] = "101";
            $list['message'] = "您没有权限调用本接口";
            echo json_encode($list);die;
        }
        $photo_img =isset($_GET['photo_img'])?$_GET['photo_img']:"";
        if($photo_img==""){
            $list['code'] = "102";
            $list['message'] = "请传入照片";
            echo json_encode($list);die;
        }
        $photo_img1 =isset($_GET['photo_img1'])?$_GET['photo_img1']:"";
        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"";
        if($photo_img==""){
            $list['code'] = "103";
            $list['message'] = "请传入药方ID";
            echo json_encode($list);die;
        }
        $new_time = date("Y-m-d H:i:s");
        $confrim_photo = new TbConfirmPhoto();
        $confrim_photo->photo_img = $photo_img;
        $confrim_photo->prescription_id  = $prescription_id ;
        $confrim_photo->created_at  = $new_time ;
        $confrim_photo->save();
        if(!empty($photo_img1)){
            $new_time = date("Y-m-d H:i:s");
            $confrim_photo = new TbConfirmPhoto();
            $confrim_photo->photo_img = $photo_img1;
            $confrim_photo->prescription_id  = $prescription_id ;
            $confrim_photo->created_at  = $new_time ;
            $confrim_photo->save();
        }
        $tbl_prescription_photo =new TblPrescriptionPhoto();
        $result=$tbl_prescription_photo->updateAll(['is_newest'=>0],['prescription_id'=>$prescription_id]);
        $list['code'] = "200";
        $list['message'] = "上传成功";
        echo json_encode($list);die;
    }
    //发送短信
    public function actionMessage(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $verification_code = rand(100000,999999);
        $phone =isset($_GET['phone'])?$_GET['phone']:"";
        $staffs = new TblDoctor();
        $result=$staffs->updateAll(['auth_key'=>$verification_code],['doctor_phone'=> $phone]);
        include_once('sms.php');
        if($phone==""){
            $list['code'] = "100";
            $list['message'] = "请输入手机号";
            echo json_encode($list);die;
        }
        $tbl_doctor=new TblDoctor();
        $jj=$tbl_doctor->find()->where("doctor_phone='$phone'")->asArray()->one();
        if(empty($jj)){
            $list['code']="101";
            $list['message']="你的手机号不存在,请联系管理员";
            echo json_encode($list);die;
        }
        $target = "http://cf.51welink.com/submitdata/Service.asmx/g_Submit";
        $post_data = "sname=dlrunyig&spwd=ryg123456&scorpid=''&sprdid=1012888&sdst=$phone&smsg=您的验证码是：".$verification_code."。请不要把验证码泄露给其他人。【润医阁】";
         if(Post($post_data, $target)){
             $list['code'] = "200";
             $list['message'] = "验证码发送成功";
             echo json_encode($list);die;
         }
    }
    //追溯信息里边的煎制
    public function actionFried(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $list['code'] = "100";
            $list['message'] = "请输入您的token";
            echo json_encode($list);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $list['code'] = "101";
            $list['message'] = "您没有权限调用本接口";
            echo json_encode($list);die;
        }
         $boiling = new TblProgressBoiling();
         $progress = new TblPrescriptionProgress();
         $staff = new TblStaff();
         $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"";
         if($prescription_id==""){
             $list['code'] = "102";
             $list['message'] = "请传入药方ID";
             echo json_encode($list);die;
         } 
         $prescription = new TblPrescription();
         $prescription_list=$prescription->find()
            ->where(['prescription_id'=>$prescription_id])
            ->select(array('piece','kinds_per_piece'))
             ->asArray()
            ->one();  
         $boiling_list =  $boiling->find()->where(['prescription_id' => $prescription_id])->asArray()->one();
         $staff_id = $boiling_list['staff_id'];
         $staff_list = $staff
             ->find()
             ->where(['staff_id' => $staff_id])
             ->select(array('photo','role_name'))
             ->asArray()
             ->one();
         $boiling_list['piece'] = $prescription_list['piece'];
         $boiling_list['kinds_per_piece'] = $prescription_list['kinds_per_piece'];
         $boiling_list['photo_img'] = $staff_list['photo'];
         $boiling_list['role_name'] = $staff_list['role_name'];
         $where = "prescription_id = '$prescription_id' and progress_id = '3'";
         $where1 = "prescription_id = '$prescription_id' and progress_id = '4'";

         $progress_list = $progress->find()->where($where)->asArray()->one();

         if($progress_list == ""){
             $boiling_list['this_time'] = "null";
         }else{
             $boiling_list['this_time_start'] = $progress_list['start_time'];
             $boiling_list['this_time_end']=substr($progress_list['end_time'],10,10);
         }
         $progress_list2 = $progress->find()->where($where1)->asArray()->one();
        if(empty($progress_list2)){
            $boiling_list['side_time'] = "null";
        }else{
            $boiling_list['side_time_start'] = $progress_list2['start_time'];
            $boiling_list['side_time_end']=substr($progress_list2['end_time'],10,10);
        }
            $lists['code'] = "200";
            $lists['message'] = "请求成功";
            $lists['data']['boiling_list'] = $boiling_list;
            echo json_encode($lists);die;
    }

  public function actionCeshi(){
          return $this->renderPartial("ceshi");
}
}
