<?php

namespace app\controllers;

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
class PhysicianController extends Controller
{
    //登录接口
  public function actionLogin(){
      $staff = new TblInterfaceCallStaff();
      $token = isset($_GET['token'])?$_GET['token']:"";
      if($token==""){
          $login['code'] = "100";
          $login['data'] = "请输入您的token";
         echo json_encode($login);die;
      }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $login['code'] = "100";
          $login['data'] = "您没有权限调用本接口";
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
          $login['data'] = "请输入验证码";
         echo json_encode($login);die;
      }
      $staffs = new TblDoctor();
      $user_list = $staffs->find()->where(['doctor_phone' => $phone])->asArray()->one();
      if($user_list == ""){
          $login['code'] = "100";
          $login['data'] = "手机号码不存在";
         echo json_encode($login);die;
      }
      if($user_list['auth_key'] != $pwd){
          $login['code'] = "100";
          $login['data'] = "验证码不正确";
         echo json_encode($login);die;
      }
      if($pwd==$user_list['auth_key']){
          $login['code'] = "200";
          $login['data'] = $user_list;
          echo json_encode($login);die;
      }else{
          $login['code'] = "100";
          $login['data'] = "验证码不正确";
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
          $login['data'] = "请输入您的token";
         echo json_encode($login);die;
      }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $login['code'] = "100";
          $login['data'] = "您没有权限调用本接口";
         echo json_encode($login);die;
      }
      $prescription = new TblPrescription();
      $doctor_id = isset($_GET['doctor_id'])?$_GET['doctor_id']:"1";
      $new_time = date("Y-m-d",time());
      if($doctor_id == 1){
          $prescription_list['code'] = "100";
          $prescription_list['data'] = "请传入医生id";
         echo json_encode($prescription_list);die;
      }
      $doctor_models = new TblDoctor();
      $doctor_is = $doctor_models->find()->where(['doctor_id' =>  $doctor_id])->asArray()->one();
      $hospital_id = $doctor_is['hospital_id'];
      if($doctor_is['is_dean'] == 1){
          $where = "hospital_id =  '$hospital_id' and prescription_time like '$new_time%'";
      }else{
          $where = "doctor_id =  '$doctor_id' and prescription_time like '$new_time%'";
      }
      $prescription_list = $prescription->find()->where($where)->asArray()->all();
      $sum =count($prescription_list);
      foreach($prescription_list as $k=>$v){
          $prescription_id = $v['prescription_id'];
          //查询患者
          $patient = new TblPatient();
          $prescription_photo = new TblPrescriptionPhoto();
          //查讯地址照片
          $prescription_id = $v['prescription_id'];
          $where = "'prescription_id'= '$prescription_id' and 'photo_type' = 2";
          $patient_list = $patient->find()->where($where)->asArray()->one();
          if($patient_list==""){
              $patient_list = $prescription_photo->find()->where(['prescription_id'=>$v['prescription_id']])->asArray()->one();
              $prescription_list[$k]['patient_name'] = $patient_list['patient_name'];
              $prescription_list[$k]['address'] =  $patient_list['address'];
              $prescription_list[$k]['mobile'] = $patient_list['mobile'] ;
          }
          //查询药方照片
          $prescription_photo_list = $prescription_photo->find()->where(['prescription_id'=>$v['prescription_id']])->asArray()->one();
          $prescription_list[$k]['photo_img'] = $prescription_photo_list['photo_img'];
          $prescription_list['sum'] = $sum;

      };
      if($prescription_list){
          $prescription_lists['code'] = "200";
          $prescription_lists['data'] = $prescription_list;
         echo json_encode($prescription_lists);die;
      }else{
          $prescription_lists['code'] = "200";
          $prescription_lists['data'] = "目前没有数据";
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
            $login['data'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"";
        if($prescription_id == ""){
            $login['code'] = "100";
            $login['data'] = "请传入药方Id";
            echo json_encode($login);die;
        }
        $tblPrescription = new TblPrescription();
        $patient = new TblPatient();
        $prescription_photo = new TblPrescriptionPhoto();
        $prescription_list = $tblPrescription->find()->where(['prescription_id' => $prescription_id])->asArray()->one();
        $patient_list = $patient->find()->where(['prescription_id'=> $prescription_id])->asArray()->one();
        $where = "prescription_id= '$prescription_id' and photo_type = 1";
        $prescription_yphoto_list =  $prescription_photo->find()->where($where)->asArray()->one();
        $lists['prescription_list'] = $prescription_list;
        $lists['prescription_yphoto_list'] = $prescription_yphoto_list;
        if($patient_list['address']==""){
            $where = "prescription_id= '$prescription_id' and photo_type = 2";
            $prescription_dphoto_list =  $prescription_photo->find()->where($where)->asArray()->one();
            $lists['prescription_dphoto_list'] = $prescription_dphoto_list;
        }else{
            $lists['patient_list'] = $patient_list;
        }
        if($lists){
            $listss['code'] = "200";
            $listss['data'] = $lists;
        }else{
            $listss['code'] = "100";
            $listss['data'] = "当前没有数据";
        }
        echo json_encode($listss);die;
    }
    //禁忌超量
  public function actionExcessive(){
    //  验证token
      $staff = new TblInterfaceCallStaff();
      $token = isset($_GET['token'])?$_GET['token']:"";
      if($token==""){
          $login['code'] = "100";
          $login['data'] = "请输入您的token";
         echo json_encode($login);die;
      }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $login['code'] = "100";
          $login['data'] = "您没有权限调用本接口";
         echo json_encode($login);die;
      }
      $doctor_id = isset($_GET['doctor_id'])?$_GET['doctor_id']:"1";
      if($doctor_id == 1){
          $prescription_list['code'] = "100";
          $prescription_list['data'] = "请传入正确参数";
         echo json_encode($prescription_list);die;
      }
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
      $prescription_list = $prescription->find()->where($where)->asArray()->all();
      $sum = count($prescription_list);
      if($prescription_list){
          $prescription_lists['code'] = "200";
          $prescription_lists['data'] = $prescription_list;
          $prescription_lists['sum'] = $sum;
         echo json_encode($prescription_lists);die;
      }else{
          $prescription_lists['code'] = "200";
          $prescription_lists['data'] = "目前没有数据";
         echo json_encode($prescription_lists);die;
      }
  }
   //超量禁忌确认里的药方详情
    public function actionTaboo(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['data'] = "请输入您的token";
           echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
           echo json_encode($login);die;
        }
        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"1";
        if($prescription_id == 1){
            $detail_list['code'] = "100";
            $detail_list['data'] = "请传入正确参数";
           echo json_encode($detail_list);die;
        }
        $detail_models = new TblPrescriptionDetail();
        $detail_list = $detail_models->find()->where(['prescription_id' => $prescription_id])->asArray()->all();
        if($detail_list){
            $detail_lists['code'] = "200";
            $detail_lists['data'] = $detail_list;
           echo json_encode($detail_lists);die;
        }else{
            $detail_lists['code'] = "200";
            $detail_lists['data'] = "目前没有数据";
           echo json_encode($detail_lists);die;
        }
    }
    //超量禁忌确认里的药材详情显示
    public function actionTabooprescription(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['data'] = "请输入您的token";
           echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
           echo json_encode($login);die;
        }
        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"1";
        if($prescription_id == 1){
            $detail_list['code'] = "100";
            $detail_list['data'] = "请传入正确参数";
           echo json_encode($detail_list);die;
        }
        $prescription = new TblPrescription();
        $prescription_list = $prescription->find()->where("prescription_id='$prescription_id'")->asArray()->one();
        if($prescription_list){
            $prescription_lists['code'] = "200";
            $prescription_lists['data'] = $prescription_list;
           echo json_encode($prescription_lists);die;
        }else{
            $prescription_lists['code'] = "200";
            $prescription_lists['data'] = "目前没有数据";
           echo json_encode($prescription_lists);die;
        }
    }
    //处方上传接口
    public function actionTaboophotograph(){
        //  验证token
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['data'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $time =strtotime(date('Y-m-d H:i:s'));
        $doctor_id = isset($_GET['doctor_id'])?$_GET['doctor_id']:"";//医师ID
        $production_type = isset($_GET['production_type'])?$_GET['production_type']:""; //原药或代煎
        $photo_img = isset($_GET['photo_img'])?$_GET['photo_img']:""; //药方照片
        $photo_img1 = isset($_GET['photo_img1'])?$_GET['photo_img1']:""; //药方照片2
        $patient_type_name = isset($_GET['patient_type_name'])?$_GET['patient_type_name']:""; //针对的用户类型
        $notes = isset($_GET['notes'])?$_GET['notes']:""; //注意事项
        $photo_address_img = isset($_GET['photo_address_img'])?$_GET['photo_address_img']:""; //地址照片
        $new_time = date("Y-m-d H:i:s",time());
        if($doctor_id  == ""){
            $list['code'] = "100";
            $list['data'] = "请传入医师ID";
           echo json_encode($list);die;
        }
        if($production_type == ""){
            $list['code'] = "100";
            $list['data'] = "请选择原药或代煎";
           echo json_encode($list);die;
        }
        if($photo_img == ""){
            $list['code'] = "100";
            $list['data'] = "请上传药方照片";
           echo json_encode($list);die;
        }
        if($patient_type_name == ""){
            $list['code'] = "100";
            $list['data'] = "请选择警示级别";
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
        if($photo_address_img == ""){
            $patient_name = isset($_GET['patient_name'])?$_GET['patient_name']:"";
            if($patient_name == ""){
                $list['code'] = "100";
                $list['data'] = "收件人姓名不能为空";
               echo json_encode($list);die;
            }
            $mobile = isset($_GET['mobile'])?$_GET['mobile']:"";
            if($mobile == ""){
                $list['code'] = "100";
                $list['data'] = "收件人电话不能为空";
               echo json_encode($list);die;
            }
            $province = isset($_GET['province'])?$_GET['province']:"";
            if($province == ""){
                $list['code'] = "100";
                $list['data'] = "收件人省份不能为空";
               echo json_encode($list);die;
            }

            $street = isset($_GET['street'])?$_GET['street']:"";
            if($street == ""){
                $list['code'] = "100";
                $list['data'] = "收件人街道不能为空";
               echo json_encode($list);die;
            }
            $address_in_detail = isset($_GET['address_in_detail'])?$_GET['address_in_detail']:"";
            if($address_in_detail == ""){
                $list['code'] = "100";
                $list['data'] = "收件人详细地址不能为空";
               echo json_encode($list);die;
            }
            //配送地址添加
            $address =  $province.$street.$address_in_detail;
            $patient = new TblPatient();
            $patient->prescription_id = $prescription_id;
            $patient->patient_name = $patient_name;
            $patient->mobile = $mobile;
            $patient->address =$address;
            $patient->created_at =$new_time;
            if($patient->hasErrors()){
                $list['code'] = "100";
                $list['data'] = "数据不合法";
               echo json_encode($list);die;
            }
            $patient->save();
        }else{
            //配送地址照片添加
            $prescription_id = $doctor_list['hospital_id'].$time;
            $prescriptionphoto = new TblPrescriptionPhoto();
            $photod_id = "photod".$time;
            $prescriptionphoto->prescription_id = $prescription_id;
            $prescriptionphoto->photo_id = $photod_id;
            $prescriptionphoto->photo_type = '2';
            $prescriptionphoto->photo_img = $photo_address_img;
            $prescriptionphoto->created_at =$new_time;
            if($prescriptionphoto->hasErrors()){
                $list['code'] = "100";
                $list['data'] = "数据不合法";
               echo json_encode($list);die;
            }
            $prescriptionphoto->save();
        }
        //药方照片添加
        $prescriptionphoto = new TblPrescriptionPhoto();
        $photoy_id = "photoy".$time;
        $prescriptionphoto->prescription_id = $prescription_id;
        $prescriptionphoto->photo_id = $photoy_id;
        $prescriptionphoto->created_at = $new_time;
        $prescriptionphoto->photo_type = 1;
        $prescriptionphoto->photo_type = 0;
        $prescriptionphoto->photo_img = $photo_img;
        $prescriptionphoto->validate();
        if($prescriptionphoto->hasErrors()){
            $list['code'] = "100";
            $list['data'] = "数据不合法";
            echo json_encode($list);die;
        }
        $prescriptionphoto->save();
        if(!empty($photo_img1)){
            $photoy_id = "photoy".$time;
            $prescriptionphoto->prescription_id = $prescription_id;
            $prescriptionphoto->photo_id = $photoy_id;
            $prescriptionphoto->created_at = $new_time;
            $prescriptionphoto->photo_type = 1;
            $prescriptionphoto->photo_type = 0;
            $prescriptionphoto->photo_img = $photo_img1;
            $prescriptionphoto->validate();
            if($prescriptionphoto->hasErrors()){
                $list['code'] = "100";
                $list['data'] = "数据不合法";
                echo json_encode($list);die;
            }
        }
        //药方添加
        $prescription = new TblPrescription();
        $prescription->hospital_id = $doctor_list['hospital_id'];
        $prescription->hospital_name = $doctor_list['hospital_name'];
        $prescription->doctor_id = $doctor_list['doctor_id'];
        $prescription->doctor_name = $doctor_list['doctor_name'];
        $prescription->prescription_status = 0;
        $prescription->prescription_time = $new_time;
        $prescription->prescription_id = $prescription_id;
        $prescription ->production_type = $production_type;
        $prescription->patient_type_name = $patient_type_name;

        if(!empty($notes)){
            $prescription->notes = $notes;
        }
        $prescription_id = "prescription".$time;
        $prescription->prescription_id = $prescription_id;
        $prescription->created_at =$new_time;
        $prescription->validate();
        if($prescription->hasErrors()){
            $list['code'] = "100";
            $list['data'] = "数据不合法";
            echo json_encode($list);die;
        }
        $prescription->save();
        $list['code'] = "200";
        $list['data'] = "处方上传成功";
       echo json_encode($list);die;
    }
    //配送地址联动接口
    public function actionCity(){
        //  验证token
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['data'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $city = new TblCity();
        $city_id = isset($_GET['city_id'])?$_GET['city_id']:"";
        if(!empty($city_id)){
            $city_list =$city->find()->where(['parent_id'=>$city_id])->asArray()->all();
            $list['code'] = "200";
            $list['data'] = $city_list;
            echo json_encode($list);die;
        }
        $region_id = isset($_GET['region_id'])?$_GET['region_id']:"";
        if(!empty($region_id)){
            $region_list = $city->find()->where(['region_id'=>$region_id])->asArray()->all();
            $list['code'] = "200";
            $list['data'] = $region_list;
            echo json_encode($list);die;
        }
        $province_list =$city->find()->where(['region_type'=>1])->asArray()->all();
        $list['code'] = "200";
        $list['data'] = $province_list;
        echo json_encode($list);die;
    }
    //确认禁忌超量
    public function actionConfirmexcess(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['data'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $photo_img =isset($_GET['photo_img'])?$_GET['photo_img']:"";
        if($photo_img==""){
            $login['code'] = "100";
            $login['data'] = "请传入照片";
            echo json_encode($login);die;
        }
        $photo_img1 =isset($_GET['photo_img1'])?$_GET['photo_img1']:"";
        $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"";
        if($photo_img==""){
            $login['code'] = "100";
            $login['data'] = "请传入药方ID";
            echo json_encode($login);die;
        }
        $new_time = date("Y-m-d H:i:s");
        $confrim_photo = new TbConfirmPhoto();
        $confrim_photo->photo_img = $photo_img;
        $confrim_photo->prescription_id  = $prescription_id ;
        $confrim_photo->created_at  = $new_time ;
        if($confrim_photo->hasErrors()){
            $list['code'] = "100";
            $list['data'] = "数据不合法";
            echo json_encode($list);die;
        }
        $confrim_photo->save();
        if(!empty($photo_img1)){
            $new_time = date("Y-m-d H:i:s");
            $confrim_photo = new TbConfirmPhoto();
            $confrim_photo->photo_img = $photo_img1;
            $confrim_photo->prescription_id  = $prescription_id ;
            $confrim_photo->created_at  = $new_time ;
            if($confrim_photo->hasErrors()){
                $list['code'] = "100";
                $list['data'] = "数据不合法";
                echo json_encode($list);die;
            }
            $confrim_photo->save();
        }
        $tbl_prescription_photo =new TblPrescriptionPhoto();
        $result=$tbl_prescription_photo->updateAll(['is_newest'=>0],['prescription_id'=>$prescription_id]);
        $list['code'] = "200";
        $list['data'] = "上传成功";
        echo json_encode($list);die;
    }
    //发送短信
    public function actionMessage(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['data'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
        $verification_code = rand(100000,999999);
        $phone =isset($_GET['phone'])?$_GET['phone']:"";
        $staffs = new TblDoctor();
        $result=$staffs->updateAll(['auth_key'=>$verification_code],['doctor_phone'=> $phone]);
        include_once('sms.php');
        if($phone==""){
            $list['code'] = "100";
            $list['data'] = "请输入手机号";
            echo json_encode($list);die;
        }
        $target = "http://cf.51welink.com/submitdata/Service.asmx/g_Submit";
        $post_data = "sname=dlrunyig&spwd=ryg123456&scorpid=''&sprdid=1012888&sdst=$phone&smsg=您的验证码是：".$verification_code."。请不要把验证码泄露给其他人。【润医阁】";
         if(Post($post_data, $target)){
             $list['code'] = "200";
             $list['data'] = "验证码发送成功";
             echo json_encode($list);die;
         }
    }
    //追溯信息里边的煎制
    public function actionFried(){
        $staff = new TblInterfaceCallStaff();
        $token = isset($_GET['token'])?$_GET['token']:"";
        if($token==""){
            $login['code'] = "100";
            $login['data'] = "请输入您的token";
            echo json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "100";
            $login['data'] = "您没有权限调用本接口";
            echo json_encode($login);die;
        }
         $boiling = new TblProgressBoiling();
         $progress = new TblPrescriptionProgress();
         $staff = new TblStaff();
         $prescription_id = isset($_GET['prescription_id'])?$_GET['prescription_id']:"";
         if($prescription_id==""){
             $list['code'] = "100";
             $list['data'] = "请传入药方ID";
         }
         $boiling_list =  $boiling->find()->where(['prescription_id' => $prescription_id])->asArray()->one();
         $staff_id = $boiling_list['staff_id'];
         $staff_list = $staff->find()->where(['staff_id' => $staff_id])->asArray()->one();
         $boiling_list['photo_img'] = $staff_list['photo'];
         $boiling_list['role_name'] = $staff_list['role_name'];
         $where = "'prescription_id' = '$prescription_id' and progress_id = 3";
         $where1 = "'prescription_id' = '$prescription_id' and progress_id = 4";
         $progress_list = $progress->find()->where($where)->asArray()->one();
         if($progress_list == ""){
             $boiling_list['this_time'] = "暂无数据";
         }else{
             $end_time =substr($progress_list['end_time'],10);
             $this_time = $progress_list['start_time']."-".$end_time;
             $boiling_list['this_time'] = $this_time;
         }
         $progress_list2 = $progress->find()->where($where1)->asArray()->one();
        if(empty($progress_list2)){
            $boiling_list['side_time'] = "暂无数据";
        }else{
            $end_time1 =substr($progress_list2['end_time'],10);
            $side_time = $progress_list2['start_time']."-".$end_time1;
            $boiling_list['side_time'] = $side_time;
        }
            $lists['code'] = "200";
            $lists['data'] = $boiling_list;
            echo json_encode($lists);die;
    }
}