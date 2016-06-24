<?php
/* 抓药师端接口     开始日期 2016-6-6  作者 马遥  */

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
use app\models\TblDoctor;//医生

use app\models\DoctorFeedbackForm;
use app\models\TblPrescriptionProgress;
use app\models\TblPatient;
use app\models\TblPatientFeedback;
use app\models\TblPrescriptionDetail;
use app\models\TblMedicineLot;
use app\models\TblStaff;
use app\models\TblPrescriptionPhoto;
use  Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use app\models\TblDoctorFeedbackForm;
use app\models\TblMedicine;
use app\models\TblProgressCheck;

class Z_whenController extends Controller
{
    public function actionLogin(){
        //登录
        $request=Yii::$app->request;
        $phone=$request->get('phone');
        $pwd=$request->get('pwd');
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        if(empty($token)){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if(empty($user_token)){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($phone)){
            $login['code']="102";
            $login['message']="请填写您的手机号";
            echo json_encode($login);die;
        }
        if(empty($pwd)){
            $login['code']="103";
            $login['message']="请填写您的密码";
            echo json_encode($login);die;
        }
        //实例化一个员工股表
        $tblstaff=new TblStaff();
        $arr=$tblstaff->find()->where("mobile='$phone'")->asArray()->one();
        if(empty($arr)){
            $login['code']="104";
            $login['message']="该账号不存在,请联系管理员";
            echo json_encode($login);die;
        }
        if(md5($arr['password_hash'])==$pwd){
            $login['code']="200";
            $login['message']="登录成功";
            $login['data']['phone']=$arr['mobile'];
            $login['data']['staff_name']=$arr['staff_name'];
            echo json_encode($login);die;
        }else{
            $login['code']="105";
            $login['message']="密码错误,请重新输入";
            echo json_encode($login);
        }
    }
    //忘记密码
    public function actionForgetpwd(){
        $request=Yii::$app->request;
        $phone=$request->get('phone');
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        if(empty($token)){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if(empty($user_token)){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($phone)){
            $login['code']="102";
            $login['message']="请输入你的手机号";
            echo json_encode($login);die;
        }
        $tbl_staff=new TblStaff();
        $hh=$tbl_staff->find()->where("mobile='$phone'")->asArray()->one();
        if(empty($hh)){
            $login['code']="103";
            $login['message']="您的手机号不存在,请联系管理员";
            echo json_encode($login);die;
        }
        $pwd=$hh['password_hash'];
        include_once('sms.php');
        $target = "http://cf.51welink.com/submitdata/Service.asmx/g_Submit";
        $post_data = "sname=dlrunyig&spwd=ryg123456&scorpid=''&sprdid=1012888&sdst=$phone&smsg=您的密码是：".$pwd."。请不要把验证码泄露给其他人。【润医阁】";
        if(Post($post_data, $target)){
            $list['code'] = "200";
            $list['message'] = "密码发送成功";
            echo json_encode($list);die;
        }
    }
    //重置密码
    public function actionResetpwd(){
        $request=Yii::$app->request;
        $phone=$request->get('phone');
        $resetpwd=$request->get('reset');
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        if(empty($token)){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if(empty($user_token)){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($phone)){
            $login['code']="102";
            $login['message']="请输入您的手机号码";
            echo json_encode($login);die;
        }
//        if(empty($lastpwd)){
//            $login['code']="103";
//            $login['message']="请输入您的旧密码";
//            echo json_encode($login);die;
//        }
//        if(empty($newpwd)){
//            $login['code']="104";
//            $login['message']="请输入您的新密码";
//            echo json_encode($login);die;
//        }
//        $tblstaff=new TblStaff();
//        $arr=$tblstaff->find()->where("mobile='$phone'")->asArray()->one();
//        if(empty($arr)){
//            $login['code']="105";
//            $login['message']="该手机号不存在,请联系管理员";
//            echo json_encode($login);die;
//        }
//        if($arr['password_hash']!=$lastpwd){
//            $login['code']="106";
//            $login['message']="请输入正确的旧密码";
//            echo json_encode($login);die;
//        }
//
//        $brr=$tblstaff->find()->where("password_hash='$newpwd'")->asArray()->one();
//        if(!empty($brr)){
//            $login['code']="107";
//            $login['message']="您的新密码不合法,请更换";
//            echo json_encode($login);die;
//        }
//        $arr=$tblstaff->updateAll(['password_hash'=>$newpwd],['mobile'=>$phone]);
//        if($arr){
//            $login['code']="200";
//            $login['message']="修改成功,请登录";
//            echo json_encode($login);die;
//        }
         if(empty($resetpwd)){
             $login['code']="103";
             $login['message']="请输入你的新密码";
             echo json_encode($login);die;
         }
        $tbl_staff=new TblStaff();
        $kk=$tbl_staff->find()->where("mobile='$phone'")->asArray()->one();
      if(empty($kk)){
          $login['code']="104";
          $login['message']="该员工不存在,请联系管理员";
          echo json_encode($login);die;
      }
        $lo=$tbl_staff->find()->where("password_hash='$resetpwd'")->asArray()->one();
       if(!empty($lo)){
           $login['code']="105";
           $login['message']="该密码不合法,请重新填写";
           echo json_encode($login);die;
       }
        $ll=$tbl_staff->updateAll(['password_hash'=>$resetpwd],['mobile'=>$phone]);
        if($ll){
            $login['code']="200";
            $login['message']="密码修改成功,请重新登录";
            echo json_encode($login);die;
        }
    }
//配药履历
public function actionResume()
{
    $request = Yii::$app->request;
    $tbl_prescription=new TblPrescription();
    $time = $request->get('time');
    $tblInterfaceCallStaff = new TblInterfaceCallStaff();
    $token = $request->get('token');
    $tbl_prescription_progress=new TblPrescriptionProgress();
    $pwd = $request->get('pwd');
    if (empty($token)) {
        $login['code'] = "100";
        $login['message'] = "请输入您的token";
        echo json_encode($login);
        die;
    }
    $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
    if (empty($user_token)) {
        $login['code'] = "101";
        $login['message'] = "您没有权限调用本接口";
        echo json_encode($login);
        die;
    }
    if (empty($pwd)) {
        $login['code'] = "102";
        $login['message'] = "请传入你的密码";
        echo json_encode($login);
        die;
    }
   $tbl_staff=new TblStaff();
    $kk=$tbl_staff->find()->where("password_hash='$pwd'")->asArray()->one();
    if (empty($kk)) {
        $login['code'] = "103";
        $login['message'] = "该员工不存在,请联系管理员";
        echo json_encode($login);
        die;
    }
    $staff_id=$kk['staff_id'];
    if (empty($time)) {
        $date = date('Y-m-d H:i:s', time());
        $one = explode("-", $date);
        $a = $one[0];
        $b = $one[1] - 1;
        $length = strlen($b);
        if ($length <= 1) {
            $b = "0" . $b;
        }
        $c = $a . "-" . $b;

        $where = "staff_id='$staff_id' and end_time like '$c%' and progress_id='3'";
        $ww=$tbl_prescription_progress->find()->select(array('prescription_id','end_time'))->where($where)->asArray()->all();
        /*$arr=$tbl_prescription->find()
           ->select(array('created_at','piece','kinds_per_piece','prescription_id','patient_name'))
           ->where($where)
            ->asArray()
           ->all();*/


     if(empty($ww)){
         $gg['code']="201";
         $gg['message']="暂无数据";
         echo json_encode($gg);die;
     }
        foreach($ww as $k=>$v){
            $prescription_id=$v['prescription_id'];
            $ww[$k]['prescription']=$tbl_prescription->find()->select(array('piece','kinds_per_piece','prescription_id','patient_name','patient_type'))->where("prescription_id='$prescription_id'")->asArray()->one();
        }
        $count=count($ww);
        $gg['code']="200";
        $gg['message']="请求处理成功";
        $gg['data']['count']=$count;
        $gg['data']['resume']=$ww;
        echo json_encode($gg);die;

    }else{
        $where = "staff_id='$staff_id' and end_time like '$time%' and progress_id='3'";
        $ww=$tbl_prescription_progress->find()->select(array('prescription_id','end_time'))->where($where)->asArray()->all();
        /*$arr=$tbl_prescription->find()
           ->select(array('created_at','piece','kinds_per_piece','prescription_id','patient_name'))
           ->where($where)
            ->asArray()
           ->all();*/


        if(empty($ww)){
            $gg['code']="201";
            $gg['message']="暂无数据";
            echo json_encode($gg);die;
        }
        foreach($ww as $k=>$v){
            $prescription_id=$v['prescription_id'];
            $ww[$k]['prescription']=$tbl_prescription->find()->select(array('piece','kinds_per_piece','prescription_id','patient_name'))->where("prescription_id='$prescription_id'")->asArray()->one();
        }
        $count=count($ww);
        $gg['code']="200";
        $gg['message']="请求处理成功";
        $gg['data']['count']=$count;
        $gg['data']['resume']=$ww;
        echo json_encode($gg);die;
    }
}
    //配药履历列表详情
    public function actionResume_detail(){
        $request = Yii::$app->request;
        $tbl_prescription=new TblPrescription();
        $prescription_id=$request->get('prescription_id');
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        $doctorid = $request->get('doctorid');
        if (empty($token)) {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if (empty($user_token)) {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
        if(empty($prescription_id)){
            $aa['code']="102";
            $aa['message']="请传入药方id";
            echo json_encode($aa);die;
        }
        $jrr=$tbl_prescription->find()->where("prescription_id='$prescription_id'")->asArray()->one();
        if(empty($jrr)){
            $jj['code']="103";
            $jj['message']="该药方不存在,请输入正确的药方id";
            echo json_encode($jj);die;
        }
        $arr=$tbl_prescription->find()
            ->select(array('prescription_id','production_type_name','piece','price','notes'))
            ->where("prescription_id='$prescription_id'")
            ->asArray()
            ->one();
       $tbl_prescription_detail=new TblPrescriptionDetail();
        $brr=$tbl_prescription_detail->find()->select(array('medicine_name','weight','medicine_photo','medicine_id','medicine_status'))->where("prescription_id='$prescription_id'")->asArray()->all();

       if(empty($brr)){
           $brr=[];
       }
    $tbl_medicine=new TblMedicine();

        for($i=0;$i<count($brr);$i++){
            $medicine_id=$brr[$i]['medicine_id'];
            $pp=$tbl_medicine->find()->select(array('drawer_location','medicine_id'))->where("medicine_id='$medicine_id'")->asArray()->one();
            $brr[$i]['drawer_location']=$pp['drawer_location'];
        }
       $crr['code']="200";
        $crr['message']="请求处理成功";
        $crr['data']['prescription_id']=$arr['prescription_id'];
        $crr['data']['production_type_name']=$arr['production_type_name'];
        $crr['data']['piece']=$arr['piece'];
        $crr['data']['price']=$arr['price'];
        $crr['data']['notes']=$arr['notes'];
        $crr['data']['detai']=$brr;
        echo json_encode($crr);die;
    }
//处方内容
public function actionPrescription_content(){
    $request = Yii::$app->request;
    $tbl_prescription=new TblPrescription();
    $tblInterfaceCallStaff = new TblInterfaceCallStaff();
    $prescription_id=$request->get('prescription_id');
    $token = $request->get('token');
    if (empty($token)) {
        $login['code'] = "100";
        $login['message'] = "请输入您的token";
        echo json_encode($login);
        die;
    }
    $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
    if (empty($user_token)) {
        $login['code'] = "101";
        $login['message'] = "您没有权限调用本接口";
        echo json_encode($login);
        die;
    }
    if(empty($prescription_id)){
        $login['code']="102";
        $login['message']="请输入药方id";
        echo json_encode($login);die;
    }
    $arr=$tbl_prescription->find()->where("prescription_id='$prescription_id'")->asArray()->one();
    if(empty($arr)){
        $login['code']="103";
        $login['message']="该药方id不存在,请输入正确的药方id";
        echo json_encode($login);die;
    }
    $brr=$tbl_prescription->find()->select(array('prescription_id','production_type_name','price','created_at'))->where("prescription_id='$prescription_id'")->asArray()->one();
    //根据药方id查询处方图片
    $tbl_prescription_photo=new TblPrescriptionPhoto();
    $where="prescription_id='$prescription_id' and photo_type=1 ";
	$wheretwo="prescription_id='$prescription_id' and photo_type=2 ";
    $crr=$tbl_prescription_photo->find()->select(array('photo_img'))->where($where)->asArray()->all();
	$count=count($crr);
	 $qrr=$tbl_prescription_photo->find()->select(array('photo_img'))->where($wheretwo)->asArray()->one();
	
    //根据药方id查询出药方地址
    $tbl_patient=new TblPatient();
    $drr=$tbl_patient->find()->select(array('address','mobile','patient_name'))->where("prescription_id='$prescription_id'")->asArray()->one();
       $lo['code']="200";
       $lo['message']="请求处理成功";
       $lo['data']['prescription_id']=$brr['prescription_id'];
       $lo['data']['production_type_name']=$brr['production_type_name'];
       $lo['data']['price']=$brr['price'];
       $lo['data']['created_at']=$brr['created_at'];
	   if($count=='1'){
       $lo['data']['photo_img1']=$crr[0]['photo_img'];
	   }else if($count=='2'){
	    $lo['data']['photo_img1']=$crr[0]['photo_img'];
		$lo['data']['photo_img2']=$crr[1]['photo_img'];

	   }else{
	      $lo['data']['photo_img1']=null;

	   }
	   if(!empty($qrr)){
	   	 $lo['data']['address_img']=$qrr['photo_img'];

	   }else{
	   	   	 $lo['data']['address_img']=null;

	   }
       $lo['data']['address']=$drr['address'];
       $lo['data']['mobile']=$drr['mobile'];
       $lo['data']['patient_name']=$drr['patient_name'];
       echo json_encode($lo);die;

}
    //已配处方
    public function actionAlready_prescription(){
        $request = Yii::$app->request;
        $tbl_prescription=new TblPrescription();
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
      $pwd=$request->get('pwd');
        $tbl_prescription_progress=new TblPrescriptionProgress();
        $db=Yii::$app->db;
        $token = $request->get('token');
        if (empty($token)) {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if (empty($user_token)) {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
       if(empty($pwd)){
           $login['code']="102";
           $login['message']="请传入您的密码";
           echo json_encode($login);die;
       }
        $tbl_staff=new TblStaff();
        $rr=$tbl_staff->find()->where("password_hash='$pwd'")->asArray()->one();
      if(empty($rr)){
          $login['code']="103";
          $login['message']="该员工不存在,请联系管理员";
          echo json_encode($login);die;
      }
        $staff_id=$rr['staff_id'];
      $tbl_prescription=new TblPrescription();
        $date=date('Y-m-d H:i:s',time());
        $date=substr($date,0,10);

        $where = "staff_id='$staff_id' and end_time like '$date%' and progress_id='3'";

        $ww=$tbl_prescription_progress->find()->select(array('prescription_id','end_time'))->where($where)->asArray()->all();
        /*$arr=$tbl_prescription->find()
           ->select(array('created_at','piece','kinds_per_piece','prescription_id','patient_name'))
           ->where($where)
            ->asArray()
           ->all();*/


        if(empty($ww)){
            $gg['code']="201";
            $gg['message']="暂无数据";
            echo json_encode($gg);die;
        }
        foreach($ww as $k=>$v){
            $prescription_id=$v['prescription_id'];
            $ww[$k]['prescription']=$tbl_prescription->find()->select(array('piece','kinds_per_piece','prescription_id','patient_name','patient_type'))->where("prescription_id='$prescription_id'")->asArray()->one();
        }
        $count=count($ww);
		
		for($i=0;$i<$count;$i++){
		$aa[$i]['prescription_id']=$ww[$i]['prescription_id'];
		$aa[$i]['end_time']=$ww[$i]['end_time'];
        $aa[$i]['piece']=$ww[$i]['prescription']['piece'];
	    $aa[$i]['kinds_per_piece']=$ww[$i]['prescription']['kinds_per_piece'];
	    $aa[$i]['patient_name']=$ww[$i]['prescription']['patient_name'];
		$aa[$i]['patient_type']=$ww[$i]['prescription']['patient_type'];

		}
		
        $gg['code']="200";
        $gg['message']="请求处理成功";
        $gg['data']['count']=$count;
        $gg['data']['already']=$aa;
        echo json_encode($gg);die;
    }
    //待配处方
    public function actionStay(){
        $request = Yii::$app->request;
        $tbl_prescription=new TblPrescription();
        $tbl_prescription_progress=new TblPrescriptionProgress();
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        if (empty($token)) {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if (empty($user_token)) {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
        $where = "(((password_hash='' OR password_hash is null) and progress_id='2' and end_time!='')  or
 (progress_id='3' and (end_time='' or end_time is null))    or   (progress_id='4' and (end_time='' or end_time is null)) )";
        $ww=$tbl_prescription_progress->find()->select(array('prescription_id','end_time','staff_name'))->where($where)->asArray()->all();
        /*$arr=$tbl_prescription->find()
           ->select(array('created_at','piece','kinds_per_piece','prescription_id','patient_name'))
           ->where($where)
            ->asArray()
           ->all();*/

        if(empty($ww)){
            $gg['code']="201";
            $gg['message']="暂无数据";
            echo json_encode($gg);die;
        }
        foreach($ww as $k=>$v){
            $prescription_id=$v['prescription_id'];
            $stay[]=$tbl_prescription->find()->select(array('piece','kinds_per_piece','prescription_id','production_type_name','price','patient_type'))->where("prescription_id='$prescription_id'")->asArray()->one();
        }

        $count=count($stay);
        $gg['code']="200";
        $gg['message']="请求处理成功";
        $gg['data']['count']=$count;
        $gg['data']['stay']=$stay;
        echo json_encode($gg);die;
    }
    //开始配药接口
    public function actionBeginthree(){
        $request = Yii::$app->request;
        $tbl_prescription=new TblPrescription();
        $tbl_prescription_progress=new TblPrescriptionProgress();
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $prescription_id=$request->get('prescription_id');
        $date=date('Y-m-d H:i:s',time());
        $db=Yii::$app->db;
        $pwd=$request->get('pwd');
        $token = $request->get('token');
        if (empty($token)) {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if (empty($user_token)) {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
        if(empty($prescription_id)){
            $login['code']="102";
            $login['message']="药方id不能为空";
            echo json_encode($login);die;
        }
        if(empty($pwd)){
            $login['code']="103";
            $login['message']="密码不能为空";
            echo json_encode($login);die;
        }
        $tbl_staff=new TblStaff();
        $ss=$tbl_staff->find()->where("password_hash='$pwd'")->asArray()->one();
        if(empty($ss)){
            $login['code']="104";
            $login['message']="该员工不存在,请联系管理员";
            echo json_encode($login);die;
        }
        $pp=$tbl_prescription_progress->find()->where("prescription_id='$prescription_id' and progress_id='2'")->asArray()->one();
       if(empty($pp)){
           $login['code']="105";
           $login['message']="该药方id不存在,请核实";
           echo json_encode($login);die;
       }
        $staff_id=$ss['staff_id'];

        $where="prescription_id='$prescription_id' and progress_id='2' and (password_hash='' or password_hash is null)";
        $arr=$tbl_prescription_progress->find()->where($where)->asArray()->one();

        if(empty($arr)){
            $two="prescription_id='$prescription_id' and progress_id='3'";
            $ko=$tbl_prescription_progress->find()->where($two)->asArray()->one();
            if($ko['staff_id']==$staff_id){
                $arr=$tbl_prescription->find()
                    ->select(array('prescription_id','production_type_name','piece','price','notes','kinds_per_piece'))
                    ->where("prescription_id='$prescription_id'")
                    ->asArray()
                    ->one();
                $tbl_prescription_detail=new TblPrescriptionDetail();
                $brr=$tbl_prescription_detail->find()->select(array('medicine_name','weight','medicine_photo','medicine_id','medicine_status'))->where("prescription_id='$prescription_id'")->asArray()->all();
                //计算出重量
                $db=Yii::$app->db;
                $sql="select sum(weight),prescription_id from tbl_prescription_detail where prescription_id='$prescription_id'";
                $we=$db->createCommand($sql)->queryone();
                if(empty($brr)){
                    $brr=[];
                }
                $tbl_medicine=new TblMedicine();
                for($i=0;$i<count($brr);$i++){
                    $medicine_id=$brr[$i]['medicine_id'];
                    $pp=$tbl_medicine->find()->select(array('drawer_location','medicine_id'))->where("medicine_id='$medicine_id'")->asArray()->one();
                    $brr[$i]['drawer_location']=$pp['drawer_location'];
                }
                $crr['code']="200";
                $crr['message']="请求处理成功";
                $crr['data']['prescription_id']=$arr['prescription_id'];
                $crr['data']['production_type_name']=$arr['production_type_name'];
                $crr['data']['piece']=$arr['piece'];
                $crr['data']['price']=$arr['price'];
                $crr['data']['kinds_per_piece']=$arr['kinds_per_piece'];
                $crr['data']['sumweight']=$we['sum(weight)'];
                $crr['data']['notes']=$arr['notes'];
                $crr['data']['detai']=$brr;
                echo json_encode($crr);die;
            }else{
             $login['code']="107";
                $login['message']="哎呀,你手慢了一步,单被人抢走了";
                echo json_encode($login);die;
            }
        }else{

              $sql="select * from tbl_prescription_progress where password_hash='$pwd'
               and ((progress_id='3' and (end_time='' or end_time is null)) or
             (progress_id='4' and (end_time='' or end_time is null)) )";
                $only=$db->createCommand($sql)->queryAll();

                if(!empty($only)){
                    $login['code']="106";
                    $login['message']="对不起,你不能抢单,上单完成才可以抢单.";
                    echo json_encode($login);die;
                }else {
                    $oo=$tbl_prescription_progress->updateAll(['password_hash'=>$pwd],['prescription_id'=>$prescription_id,'progress_id'=>'2']);
                    $pp=$tbl_prescription->updateAll(['prescription_status'=>25,'updated_at'=>$date],['prescription_id'=>$prescription_id]);
                    $tbl_prescription_progress->prescription_id = $prescription_id;
                    $tbl_prescription_progress->progress_id = "3";
                    $tbl_prescription_progress->created_at = $date;
                    $tbl_prescription_progress->password_hash = $pwd;
                    $tbl_prescription_progress->start_time=$date;
                    $tbl_prescription_progress->staff_id=$staff_id;
                    if ($tbl_prescription_progress->save()) {
                        $arr=$tbl_prescription->find()
                            ->select(array('prescription_id','production_type_name','piece','price','notes','kinds_per_piece'))
                            ->where("prescription_id='$prescription_id'")
                            ->asArray()
                            ->one();
                        $tbl_prescription_detail=new TblPrescriptionDetail();
                        $brr=$tbl_prescription_detail->find()->select(array('medicine_name','weight','medicine_photo','medicine_id','medicine_status'))->where("prescription_id='$prescription_id'")->asArray()->all();
                        //计算出重量
                        $db=Yii::$app->db;
                        $sql="select sum(weight),prescription_id from tbl_prescription_detail where prescription_id='$prescription_id'";
                        $we=$db->createCommand($sql)->queryone();
                        if(empty($brr)){
                            $brr=[];
                        }
                        $tbl_medicine=new TblMedicine();
                        for($i=0;$i<count($brr);$i++){
                            $medicine_id=$brr[$i]['medicine_id'];
                            $pp=$tbl_medicine->find()->select(array('drawer_location','medicine_id'))->where("medicine_id='$medicine_id'")->asArray()->one();
                            $brr[$i]['drawer_location']=$pp['drawer_location'];
                        }
                        $crr['code']="200";
                        $crr['message']="抢单成功";
                        $crr['data']['prescription_id']=$arr['prescription_id'];
                        $crr['data']['production_type_name']=$arr['production_type_name'];
                        $crr['data']['piece']=$arr['piece'];
                        $crr['data']['price']=$arr['price'];
                        $crr['data']['kinds_per_piece']=$arr['kinds_per_piece'];
                        $crr['data']['sumweight']=$we['sum(weight)'];
                        $crr['data']['notes']=$arr['notes'];
                        $crr['data']['detai']=$brr;
                        echo json_encode($crr);die;
                    }
                }
        }
    }
    //根据状态判断当前到呢一步
    //第三步
    public function actionThreestatus(){
        $request = Yii::$app->request;
        $tbl_prescription=new TblPrescription();
        $tbl_prescription_progress=new TblPrescriptionProgress();
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $prescription_id=$request->get('prescription_id');
        $date=date('Y-m-d H:i:s',time());
        $medicine_id=$request->get('medicine_id');
        $type=$request->get('type');
        $db=Yii::$app->db;
        $pwd=$request->get('pwd');
        $token = $request->get('token');
        if (empty($token)) {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if (empty($user_token)) {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
        if(empty($prescription_id)){
            $login['code']="102";
            $login['message']="请传入药方id";
            echo json_encode($login);die;
        }
        if(empty($medicine_id)){
            $login['code']="103";
            $login['message']="请传入药材id";
            echo json_encode($login);die;
        }
        $tbl_precription_detail=new TblPrescriptionDetail();
        $ls=$tbl_precription_detail->find()->where("prescription_id='$prescription_id' and medicine_id='$medicine_id'")->one();
        if(empty($ls)){
            $login['code']="104";
            $login['message']="你的药方id或者不存在,请检查";
            echo json_encode($login);die;
        }
        if(empty($type)){
            $login['code']="105";
            $login['message']="请传入类型";
            echo json_encode($login);die;
        }
        if($type=='three') {
            $ee = $tbl_precription_detail->updateAll(['medicine_status' => '3'], ['prescription_id' => $prescription_id, 'medicine_id' => $medicine_id]);
        }elseif($type=='four'){
            $ee = $tbl_precription_detail->updateAll(['medicine_status' => '4'], ['prescription_id' => $prescription_id, 'medicine_id' => $medicine_id]);

        }else if($type=='five'){
            $ee = $tbl_precription_detail->updateAll(['medicine_status' => '5'], ['prescription_id' => $prescription_id]);

        }else{
            $login['code']="106";
            $login['message']="请传入正确的类型";
            echo json_encode($login);die;
        }
        if($ee){
            $login['code']="200";
            $login['message']="请求处理成功";
            echo json_encode($login);die;
        }else{
            $login['code']="200";
            $login['message']="请不要重复点击";
            echo json_encode($login);die;
        }
    }
    //核方
    public function actionNuclear(){
        $request = Yii::$app->request;
        $tbl_prescription=new TblPrescription();
        $tbl_prescription_progress=new TblPrescriptionProgress();
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $prescription_id=$request->get('prescription_id');
        $date=date('Y-m-d H:i:s',time());
        $type=$request->get('type');
        $db=Yii::$app->db;
        $pwd=$request->get('pwd');
        $token = $request->get('token');
        if (empty($token)) {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if (empty($user_token)) {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
        if(empty($prescription_id)){
            $login['code']="102";
            $login['message']="请传入药方id";
            echo json_encode($login);die;
        }
        if(empty($pwd)){
            $login['code']="104";
            $login['message']="请传入您的密码";
            echo json_encode($login);die;
        }
        $tbl_staff=new TblStaff();
        $ft=$tbl_staff->find()->where("password_hash='$pwd'")->asArray()->one();
        if(empty($ft)){
            $login['code']="105";
            $login['message']="该员工不存在,请审核";
            echo json_encode($login);die;
        }
        $jj=$tbl_prescription_progress->find()
            ->where("prescription_id='$prescription_id' and progress_id='3' and (end_time='' or end_time is null )")
            ->asArray()
            ->one();


    if(empty($jj)){
        $jjtwo=$tbl_prescription_progress->find()
            ->where("prescription_id='$prescription_id' and progress_id='4' and (end_time='' or end_time is null)")
            ->asArray()
            ->one();
         if($ft['staff_id']==$jjtwo['staff_id']){
             $arr=$tbl_prescription->find()
                 ->select(array('prescription_id','production_type_name','piece','price','notes','kinds_per_piece'))
                 ->where("prescription_id='$prescription_id'")
                 ->asArray()
                 ->one();
             $tbl_prescription_detail=new TblPrescriptionDetail();
             $brr=$tbl_prescription_detail->find()->select(array('medicine_name','weight','medicine_photo','medicine_id','medicine_status'))->where("prescription_id='$prescription_id'")->asArray()->all();
             //计算出重量
             $db=Yii::$app->db;
             $sql="select sum(weight),prescription_id from tbl_prescription_detail where prescription_id='$prescription_id'";
             $we=$db->createCommand($sql)->queryone();
             if(empty($brr)){
                 $brr=[];
             }
             $tbl_medicine=new TblMedicine();
             for($i=0;$i<count($brr);$i++){
                 $medicine_id=$brr[$i]['medicine_id'];
                 $pp=$tbl_medicine->find()->select(array('drawer_location','medicine_id'))->where("medicine_id='$medicine_id'")->asArray()->one();
                 $brr[$i]['drawer_location']=$pp['drawer_location'];
             }
             $crr['code']="200";
             $crr['message']="请求处理成功";
             $crr['data']['prescription_id']=$arr['prescription_id'];
             $crr['data']['production_type_name']=$arr['production_type_name'];
             $crr['data']['piece']=$arr['piece'];
             $crr['data']['price']=$arr['price'];
             $crr['data']['kinds_per_piece']=$arr['kinds_per_piece'];
             $crr['data']['sumweight']=$we['sum(weight)'];
             $crr['data']['notes']=$arr['notes'];
             $crr['data']['detai']=$brr;
             echo json_encode($crr);die;
         }else {
             $login['code'] = "103";
             $login['message'] = "该药方id不存在,请填写正确的药方id";
             echo json_encode($login);
             die;
         }
    }

        $lk=$tbl_prescription_progress->updateAll(
            ['end_time'=>$date,'updated_at'=>$date],
            ['prescription_id'=>$prescription_id,'progress_id'=>'3']);
        $lj=$tbl_prescription->updateAll(['prescription_status'=>'35'],['prescription_id'=>$prescription_id]);
        $tbl_prescription_progress->prescription_id=$prescription_id;
        $tbl_prescription_progress->start_time=$date;
        $tbl_prescription_progress->created_at=$date;
        $tbl_prescription_progress->staff_id=$jj['staff_id'];
        $tbl_prescription_progress->password_hash=$jj['password_hash'];
        $tbl_prescription_progress->progress_id="4";
        if($tbl_prescription_progress->save()){
            $arr=$tbl_prescription->find()
                ->select(array('prescription_id','production_type_name','piece','price','notes','kinds_per_piece'))
                ->where("prescription_id='$prescription_id'")
                ->asArray()
                ->one();
            $tbl_prescription_detail=new TblPrescriptionDetail();
            $brr=$tbl_prescription_detail->find()->select(array('medicine_name','weight','medicine_photo','medicine_id','medicine_status'))->where   ("prescription_id='$prescription_id'")->asArray()->all();
            //计算出重量
            $db=Yii::$app->db;
            $sql="select sum(weight),prescription_id from tbl_prescription_detail where prescription_id='$prescription_id'";
            $we=$db->createCommand($sql)->queryone();
            if(empty($brr)){
                $brr=[];
            }
            $tbl_medicine=new TblMedicine();
            for($i=0;$i<count($brr);$i++){
                $medicine_id=$brr[$i]['medicine_id'];
                $pp=$tbl_medicine->find()->select(array('drawer_location','medicine_id'))->where("medicine_id='$medicine_id'")->asArray()->one();
                $brr[$i]['drawer_location']=$pp['drawer_location'];
            }
            $crr['code']="200";
            $crr['message']="请求处理成功";
            $crr['data']['prescription_id']=$arr['prescription_id'];
            $crr['data']['production_type_name']=$arr['production_type_name'];
            $crr['data']['piece']=$arr['piece'];
            $crr['data']['price']=$arr['price'];
            $crr['data']['kinds_per_piece']=$arr['kinds_per_piece'];
            $crr['data']['sumweight']=$we['sum(weight)'];
            $crr['data']['notes']=$arr['notes'];
            $crr['data']['detai']=$brr;
            echo json_encode($crr);die;
        }
    }
    //拍照
    public function actionPhotograph(){
        $request = Yii::$app->request;
        $tbl_prescription=new TblPrescription();
        $tbl_prescription_progress=new TblPrescriptionProgress();
        $tblInterfaceCallStaff = new TblInterfaceCallStaff();
        $prescription_id=$request->get('prescription_id');
        $date=date('Y-m-d H:i:s',time());
        $type=$request->get('type');
        $db=Yii::$app->db;
        $pwd=$request->get('pwd');
        $token = $request->get('token');
        $photoone=$request->get('photoone');
        $phototwo=$request->get('phototwo');
        $photothree=$request->get('photothree');
        if (empty($token)) {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $tblInterfaceCallStaff->find()->where(['token' => $token])->asArray()->one();
        if (empty($user_token)) {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
        if(empty($prescription_id)){
            $login['code']="102";
            $login['message']="请传入药方id";
            echo json_encode($login);die;
        }
        $jh=$tbl_prescription_progress->find()->where("prescription_id='$prescription_id' and progress_id='4' and end_time!=''")->asArray()->one();
        if(!empty($jh)){
            $login['code']="107";
            $login['message']="该状态已经处理成功";
            echo json_encode($login);die;
        }
        $ss=$tbl_prescription_progress->find()->where("prescription_id='$prescription_id'")->asArray()->one();
        if(empty($ss)){
            $login['code']="103";
            $login['message']="该药方id不存在";
            echo json_encode($login);die;
        }
        if(empty($photoone) || empty($phototwo) || empty($photothree)){
            $login['code']="104";
            $login['message']="照片不能为空";
            echo json_encode($login);die;
        }
       $one=new TblProgressCheck();
        $two=new TblProgressCheck();
        $three=new TblProgressCheck();
        $mn=$one->find()->where("prescription_id='$prescription_id'")->asArray()->all();
        $lll=count($mn);
        if($lll==3){
            $login['code']="105";
            $login['message']="请不要重复上传照片";
            echo json_encode($login);die;
        }
        $dd=$tbl_prescription_progress->find()->where("prescription_id='$prescription_id' and progress_id='4' and (end_time='' or end_time is null)")->asArray()->one();
        if(empty($dd)){
            $login['code']="106";
            $login['message']="你不能跳跃步骤";
            echo json_encode($login);die;
        }

        //照片1
        $one->prescription_id=$prescription_id;
        $one->progress="4";
        $one->photo=$photoone;
        $one->taken_type="1";
        $one->taken_name="远景";
        $one->taken_time=$date;
        $one->created_at=$date;
        $one->save();
        //照片2
        $two->prescription_id=$prescription_id;
        $two->progress="4";
        $two->photo=$phototwo;
        $two->taken_type="2";
        $two->taken_name="近景";
        $two->taken_time=$date;
        $two->created_at=$date;
        $two->save();
        //照片3
        $three->prescription_id=$prescription_id;
        $three->progress="4";
        $three->photo=$photothree;
        $three->taken_type="3";
        $three->taken_name="药材混合";
        $three->taken_time=$date;
        $three->created_at=$date;

        $three->save();
        $fd=$tbl_prescription_progress->updateAll(['end_time'=>$date,'updated_at'=>$date],['prescription_id'=>$prescription_id,'progress_id'=>'4']);
        $df=$tbl_prescription->updateAll(['prescription_status'=>'40','updated_at'=>$date],['prescription_id'=>$prescription_id]);
        $login['code']="200";
        $login['message']="请求处理成功";
        echo json_encode($login);die;

    }
}

