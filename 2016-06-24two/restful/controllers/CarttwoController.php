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
use app\models\TblProgressCheck;
use app\models\TblConfirmPhotos;

class CarttwoController extends Controller
{
//图片入库接口
    public function actionImgadd(){
        $time=date('Y-m-d H:i:s',time());
        $request=Yii::$app->request;
        $doctorname=$request->get('doctorname');
        $doctorimg=$request->get('doctorimg');
        $doctorphone=$request->get('doctorphone');
        $tbl_doctor=new TblDoctor();
        $staff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }else if(empty($doctorphone)){
            $login['code'] = "102";
            $login['message'] = "请填写您的手机号";
            echo  json_encode($login);die;
        }else if(empty($doctorname)){
            $login['code'] = "103";
            $login['message'] = "请填写您的姓名";
            echo  json_encode($login);die;
        }else{
            $arr=$tbl_doctor->find()->where("doctor_phone='$doctorphone'")->asArray()->one();
            if(empty($arr)){

                $login['code'] = "105";
                $login['message'] = "该用户不存在,请审核";
                echo json_encode($login);
                die;
            }else{
                if(!empty($doctorimg)) {
                    $brr = $tbl_doctor->updateAll([ 'doctor_name' => $doctorname, 'doctor_img' =>$doctorimg,'updated_at'=>$time], ['doctor_phone' => $doctorphone]);
                    if ($brr) {
                        $login['code'] = "200";
                        $login['message'] = "请求处理成功";
                        echo json_encode($login);
                        die;
                    }else{
                        $login['code'] = "200";
                        $login['message'] = "请求处理成功";
                        echo json_encode($login);
                        die;
                    }
                }else{
                    $brr = $tbl_doctor->updateAll([ 'doctor_name' => $doctorname], ['doctor_phone' => $doctorphone]);
                    if ($brr) {
                        $login['code'] = "200";
                        $login['message'] = "请求处理成功";
                        echo json_encode($login);
                        die;
                    }else{
                        $login['code'] = "200";
                        $login['message'] = "请求处理成功";
                        echo json_encode($login);
                        die;
                    }
                }
            }
        }
    }
    //医师管理接口
    public function actionPhysician(){
        $staff = new TblInterfaceCallStaff();
        $tbl_doctor=new TblDoctor();
        $request=Yii::$app->request;
        $doctorid=$request->get('doctorid');
        $token = $request->get('token');
        if(empty($doctorid)){
            $login['code'] = "102";
            $login['message'] = "请输入医生的id";
            echo  json_encode($login);die;
        }
        //通过接过来的类型 来判断是什么操作
        $type=$request->get('type');
        if(empty($type)) {
            $login['code'] = "104";
            $login['message'] = "请输入类型";
            echo  json_encode($login);die;
        }else if($type=="list"){
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($doctorid)){
            $login['code'] = "102";
            $login['message'] = "请输入你的医生id";
            echo  json_encode($login);die;
        }else{
            $where="doctor_id='$doctorid'and  is_dean='1'";
            $arr=$tbl_doctor->find()->where($where)->asArray()->one();
            if(empty($arr)){
                $login['code'] = "103";
                $login['message'] = "你不是管理员,你无权查看该信息";
                echo  json_encode($login);die;
            }else{
                $hospital_id=$arr['hospital_id'];
                $crr=$tbl_doctor->find()->where("hospital_id='$hospital_id'")->asArray()->all();
                $count=count($crr);
                if(empty($crr)){
                    $kk['code']="201";
					$kk['message']="暂无数据";
                    echo json_encode($kk);die;
                }
                //$count=array($count);
                 $ll['code']="200";
				 $ll['message']="请求处理成功";
				 $ll['data']['count']=$count;
				 $ll['data']['doctor_list']=$crr;
          
                echo json_encode($ll);
            }
        }
    }else if($type=="list_details"){
            $crr=$tbl_doctor->find()->where("doctor_id='$doctorid'")->asArray()->one();
            //实例化一个药方表
            $tbl_prescription=new TblPrescription();
            //以医生的doctor_id为条件查询处方
            $frr=$tbl_prescription->find()->where("doctor_id='$doctorid'")->asArray()->all();
            //通过查询结果通过count计算该医师的处方数
            $number=count($frr);

            if(empty($number)||$number==0){
                $number="暂无处方";
            }
            //获取创建时间
			if(!empty($crr)){
            $date1=$crr['created_at'];
            $date2=date('Y-m-d H:i:s',time());
            list($Y1,$m1,$d1)=explode('-',$date1);
            list($Y2,$m2,$d2)=explode('-',$date2);
            $Y=$Y2-$Y1;
            $m=$m2-$m1;
            $d=$d2-$d1;
            if($d<0){
                $d+=(int)date('t',strtotime("-1 month $date2"));
                $m--;
            }
            if($m<0){
                $m+=12;
                $Y--;
            }
            if(empty($Y)&&$m!="0"){
                $usertime=$m."月";
            }elseif(empty($Y)&&empty($m)){
             $usertime=$d."天";
            }elseif(empty($Y)&&empty($m)&&empty($d)||$m=="0"){
                $usertime="刚刚";
            }else{
                $usertime=$Y."年".$m."月";
            }
			
			
           $drr=array();
		   $drr['code']="200";
		   $drr['message']="请求处理成功";
		   $drr['data']['doctor_name']=$crr['doctor_name'];
		   $drr['data']['doctor_img']=$crr['doctor_img'];
		   $drr['data']['usertime']=$usertime;
		   $drr['data']['number']=$number;
           
            echo json_encode($drr);die;
			}else{
			$ff['code']="201";
			$ff['message']="暂无数据";
			echo json_encode($ff);die;
			}
        }else if($type=="updatephone"){
            //通过doctorid查询出他的手机号
            $xrr=$tbl_doctor->find()->where("doctor_id='$doctorid'")->asArray()->one();
            $phone=$xrr['doctor_phone'];
            $lastphone=$request->get('lastphone');
            $newphone=$request->get('newphone');
            if(empty($lastphone)||empty($newphone)){
                $login['code'] = "106";
                $login['message'] = "请输入手机号";
                echo  json_encode($login);die;
            }else{
               if($phone==$lastphone){
               $vrr=$tbl_doctor->updateAll(['doctor_phone'=>$newphone],['doctor_id'=>$doctorid]);
                   if($vrr){
                       $login['code'] = "200";
                       $login['message'] = "请求处理成功";
                       echo json_encode($login);die;
                   }else{
                       $login['code'] = "200";
                       $login['message'] = "请求处理成功";
                       echo json_encode($login);die;
                   }
               }else{
                   $login['code'] = "107";
                   $login['message'] = "请输入正确的手机号";
                   echo  json_encode($login);die;
               }
            }
        }else{
            $login['code'] = "108";
            $login['message'] = "请输入正确的type类型";
            echo  json_encode($login);die;
        }
    }
    //意见反馈接口
    public function actionDoctor_feedback_form(){
        $doctor_feedback_form=new TblDoctorFeedbackForm();
        $request=Yii::$app->request;
        $doctor_id=$request->get('doctorid');
        $f_content=$request->get('f_content');
        $staff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($doctor_id)){
            $login['code'] = "102";
            $login['message'] = "医生id不能为空";
            echo  json_encode($login);die;
        }else if(empty($f_content)){
            $login['code'] = "103";
            $login['message'] = "反馈内容不能为空";
            echo  json_encode($login);die;
        }else{
         $create_at=date('Y-m-d H:i:s',time());
            $doctor_feedback_form->create_at=$create_at;
            $doctor_feedback_form->doctor_id=$doctor_id;
            $doctor_feedback_form->f_content=$f_content;
           if($doctor_feedback_form->save()){
               $login['code'] = "200";
               $login['message'] = "请求处理成功";
               echo  json_encode($login);die;
           }

        }

    }
//统计数据接口
public function actionStatistical_data(){
    $request=Yii::$app->request;
    $tbl_doctor=new TblPrescription();
    $tbl_prescription=new TblPrescription();
    $begintime=$request->get('begintime');
    $endtime=$request->get('endtime');
    $doctorid=$request->get('doctorid');
    $type=$request->get('type');
    $staff = new TblInterfaceCallStaff();
    $token = $request->get('token');

    if($token==""){
        $login['code'] = "100";
        $login['message'] = "请输入您的token";
        echo  json_encode($login);die;
    }
    $user_token = $staff->find()->where(['token' => $token])->asArray()->one();

    if($user_token==""){
        $login['code'] = "101";
        $login['message'] = "您没有权限调用本接口";
        echo  json_encode($login);die;
    }
	if(empty($doctorid)){
            $login['code'] = "102";
            $login['message'] = "请填写你的doctorid";
            echo  json_encode($login);die;
        }
    if($type=="physician_list"){
        if(empty($doctorid)){
            $login['code'] = "102";
            $login['message'] = "请填写你的doctorid";
            echo  json_encode($login);die;
        }else{
        $tbl_doctor=new TblDoctor();
            $hospital_id=$tbl_doctor->find()->where("doctor_id='$doctorid'and is_dean='1'")->asArray()->one();
            if(empty($hospital_id)){
                $login['code'] = "103";
                $login['message'] = "你不是管理者,你无权查看信息";
                echo  json_encode($login);die;
            }else{
                $hospital_id=$hospital_id['hospital_id'];
                $doctor_name=$tbl_doctor->find()->select(array('doctor_name','doctor_id'))->where("hospital_id='$hospital_id' and is_dean='0'")->asArray()->all();
               
              if(empty($doctor_name)){
			  $aa['code']="201";
			  $aa['message']="暂无数据";
			  }else{
				  $aa['code']="200";
				  $aa['message']="请求处理成功";
				  $aa['data']=$doctor_name;
				  echo json_encode($aa);die;
				   
				   
		       
                
            }
			}
        }
    }else if($type=="search"){

    if(empty($begintime)||empty($endtime)){
   $date=date('Y-m-d');
   $date=substr($date,0,7);
   //echo $date;die;
    $tbl_doctor=new TblDoctor();
   $is_dean=$tbl_doctor->find()->where("doctor_id='$doctorid'")->asarray()->one();
   $hospital_id=$is_dean['hospital_id'];
        if($is_dean['is_dean']=='1'){
            $where="hospital_id='$hospital_id' and created_at like '$date%'";

        }else {
            $where = "doctor_id='$doctorid' and created_at like '$date%'";
        }
    }else{
       $aa=substr($endtime,5,2);
        $rr=$aa+1;
        $endtime=str_replace("05",$rr,$endtime);
       $where="";
        $tbl_doctor=new TblDoctor();
        $is_dean=$tbl_doctor->find()->where("doctor_id='$doctorid'")->asarray()->one();
        $hospital_id=$is_dean['hospital_id'];
        if($is_dean['is_dean']=='1') {
            $where.="hospital_id='$hospital_id' and created_at > $begintime and  created_at< '$endtime'";

        }
        else {
            $where .= "doctor_id='$doctorid' and created_at > $begintime and  created_at< '$endtime'";
        }



}


    $sql="select created_at,doctor_id,sum(price),count(prescription_id)
    from tbl_prescription where $where GROUP BY DATE_FORMAT(created_at, '%Y-%m' ) 
    ";
	
    $db=Yii::$app->db;
        $frr=$db->createCommand($sql)->queryAll();
         //$frr[0]['sum(price)']=(double)$frr[0]['sum(price)'];
		//var_dump($frr);die;
        //print_r($frr);die;
        if(empty($frr)){
            $login['code'] = "201";
            $login['message'] = "暂无数据";
            echo  json_encode($login);die;
        }else{
           
               $tbl_prescription=new TblPrescription();
               $sumcount=$tbl_prescription->find()
                ->select(array('created_at','doctor_id','sum(price)'))
                ->where($where)
                ->asArray()
                ->one();
			
//           $frr['sumprice']= $sumcount['sum(price)'];
//           $aa['code']="200";
//		   $aa['message']="请求处理成功";
//		   $aa['data']['sumprice']=$sumcount['sum(price)'];
//		   $aa['data']['search']=$frr;
		   $bb='{"code":"200",';
           $bb.='"message":"请求处理成功",';
		  
		   $bb.='"data":{';
          $bb.='"sumprice":"'.$sumcount['sum(price)'].'",';
            $bb.='"search":[';
		   foreach($frr as $k){
			   if(is_array($k)){
		   $bb.='{"created_at":"'.$k['created_at'].'",';
		 
			  $bb.='"count":"'.$k['count(prescription_id)'].'",';
			  $bb.='"price":"'.$k['sum(price)'].'",';
		   $bb.='"doctor_id":"'.$k['doctor_id'].'"},';
		   }
		   }
		   $bb=substr($bb,0,-1);
		   $bb.="]}}";
		   echo $bb;
        }
    }else{
        $login['code'] = "104";
        $login['message'] = "请输入正确的type";
        echo  json_encode($login);die;
    }
  }
    //药方追踪接口
    public function actionTrace_back_to()
    {
        $request = Yii::$app->request;
        $type=$request->get('type');
        $age=$request->get('age');
        $sex=$request->get('sex');
		$doctorid=$request->get('doctorid');
        $patient_name=$request->get('patient_name');
        $time = $request->get('time');
        $tbl_prescription_progress = new TblPrescriptionProgress();
        $staff = new TblInterfaceCallStaff();
        $token = $request->get('token');
        if ($token == "") {
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo json_encode($login);
            die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if ($user_token == "") {
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo json_encode($login);
            die;
        }
		 if ($doctorid == "") {
            $login['code'] = "105";
            $login['message'] = "请输入doctorid";
            echo json_encode($login);
            die;
        }
        if ($type =="search") {

                $where="";
            if(!empty($patient_name)){
                $where.="patient_name like '$patient_name%'";

            }
                if(!empty($age)&&!empty($patient_name)){
                    $bb=substr($age,1,1);
                    $cc=substr($age,0,1);
                    if($bb=="-") {
                        $aa = explode("-", $age);
                        $begin = $aa['0'];
                        $end = $aa[1];
                        $where .= "and age between $begin and $end ";
                    }else if($cc==">"||$cc=="<"){
                        $where .= "and age $age ";
                    }else{
                        $where.="and age='$age'";
                    }
                }else if(!empty($age)){
                    $bb=substr($age,1,1);
                    $cc=substr($age,0,1);
                    if($bb=="-") {
                        $aa = explode("-", $age);
                        $begin = $aa['0'];
                        $end = $aa[1];
                        $where .= "age between $begin and $end ";
                    }else if($cc==">"||$cc=="<"){
                        $where .= "age $age ";
                    }else{
                        $where.="age='$age'";
                    }
                }
                if(!empty($sex)){
                    if(!empty($patient_name)||!empty($age)) {
                        $where .= "and gender='$sex'";
                    }else{
                        $where .= "gender='$sex'";

                    }
                }


                $tbl_patient=new TblPatient();
                $hrr=$tbl_patient->find()->select(array('patient_name','age','created_at','prescription_id'))->where($where)->asArray()->all();
                $tbl_pation_feedback=new TblPatientFeedback();
				if(empty($hrr)){
				  $vv['code']="201";
                    $vv['message']="暂无数据";
					echo json_encode($vv);
				}
                foreach($hrr as  $k=>$v){
                    $prescription_id=$v['prescription_id'];
                    $feedback_count=$tbl_pation_feedback->find()->where("prescription_id='$prescription_id'")->asArray()->all();
                    if(!empty($feedback_count)) {
                        $count = count($feedback_count);
                        $hrr[$k]['count'] = $count;
                    }else{
                        $hrr[$k]['count']=0+0;
;
                    }
                }
                $tbl_prescription=new TblPrescription();
                foreach($hrr as  $k=>$v){
                    $prescription_id=$v['prescription_id'];

                    $wei=$tbl_prescription->find()->select(array('kinds_per_piece','piece'))->where("prescription_id='$prescription_id'")->asArray()->all();

                    if(!empty($wei)) {
                        foreach ($wei as $kk => $vv) {
                            $rr = $vv["kinds_per_piece"] . "味" . "/" . $vv['piece'] . "副";
                            $hrr[$k]['piece'] = $rr;
                            if(empty($vv["kinds_per_piece"])||empty($vv['piece'])){
                                $hrr[$k]['piece'] = "暂无数据";
                            }
                        }
                    }else{
                        $hrr[$k]['piece'] = "0味/0副";
                    }
                }  $vv=array();
                if(empty($hrr)){
                    $vv['code']="201";
                    $vv['message']="暂无数据";
                }else {

                    $vv['code']="200";
                    $vv['message']="请求处理成功";
                    $vv['data']['search']=$hrr;

                    echo json_encode($vv);
                }
//				$rj='{"code":"200",';
//					$rj.='"data":[';
//              foreach($hrr as $k){
//				  if(is_array($k)){
//			   $rj.='{"created_at":"'.$k['created_at'].'",';
//					$rj.='"prescription_id":"'.$k['prescription_id'].'",';
//					$rj.='"age":"'.$k['age'].'",';
//					$rj.='"count":"'.$k['count'].'",';
//					$rj.='"patient_name":'.json_encode($k['patient_name']).'},';
//				  }
//			  }
//			  $rj=substr($rj,0,-1);
//					$rj.=']}';
//					echo $rj;

        } else if($type=="trace_list") {
            $time=$request->get('time');
          $tblprescription=new Tblprescription();
		  //根据doctorid然后查药方表 然后返给对应的数据
            $where="";
            if(!empty($time)){
                $where.="and created_at like '$time%'";
            }
            if(empty($time)) {
                $mrr = $tblprescription->find()->select(array('prescription_id', 'created_at', 'prescription_time', 'prescription_status'))->Orderby("created_at desc")->where("doctor_id='$doctorid' and prescription_status>0")->asarray()->all();
            }else{
                $mrr = $tblprescription->find()->select(array('prescription_id', 'created_at', 'prescription_time', 'prescription_status'))->Orderby("created_at desc")->where("doctor_id='$doctorid' and prescription_status>0 $where")->asarray()->all();
            }
             if(empty($mrr)){
                 $login['code']="201";
                 $login['message']="暂无数据";
                 echo json_encode($login);die;
                   }

             $login['code']="200";
                $login['message']="请求处理成功";
                $count=count($mrr);
                $login['data']['count']=$count;
                $login['data']['trace_list']=$mrr;
                echo json_encode($login);die;



        }else if($type=="patient_details"){

       $prescription_id=$request->get('prescription_id');
            $tbl_prescription=new TblPrescription();
            if(empty($prescription_id)){
                $login['code'] = "104";
                $login['message'] = "请输入药方id";
                echo json_encode($login);
                die;
            }else{
                //根据药方id查询出味数和副数
                $grr=$tbl_prescription->find()->where("prescription_id='$prescription_id'")->asarray()->all();
               //根据药方id查询出病人的信息
                foreach($grr as $k=>$v){
                    $fu=$v['kinds_per_piece']."味"."/".$v['piece']."副";
                    if(empty($v['kinds_per_piece'])||empty($v['piece'])){
                        $fu="暂无数据";
                    }
                }
              $tbl_patient=new TblPatient();
                $trr=$tbl_patient->find()
                    ->select(array('patient_name','age','gender','created_at'))
                    ->where("prescription_id='$prescription_id'")
                    ->asArray()
                    ->one();
                //根据药方id查出反馈
                $tbl_prescription_feedback=new TblPatientFeedback();
                $drr=$tbl_prescription_feedback->find()
                    ->where("prescription_id='$prescription_id'")
                    ->asArray()
                    ->all();
                $count=count($drr);
                if($count=="0"){
                    $trr['feedback']=[];
                }else{
                $trr['feedback']=$drr;

                }
            $trr['count']=$count;

                //根据药方id查询出药方
                 $tbl_prescription_detail=new TblPrescriptionDetail();
            $vrr=$tbl_prescription_detail->find()
                ->where("prescription_id='$prescription_id'")
                ->asArray()
                ->all();
                if(empty($vrr)){
                    $trr['prescription']=[] ;
                }else {
                    $trr['prescription'] = $vrr;
                }
                $trr['code']="200";
                $trr['message']="请求处理成功";

                if(!empty($grr)){
                    $trr['fu']=$fu;
             }else{
                    $trr['fu']="暂无副数信息";
                }
                $mrr = array();
           if( !empty($trr['patient_name'])){

                    $mrr['code'] = "200";
                    $mrr['message'] = "请求处理成功";
                    $mrr['data']['patient_name'] = $trr['patient_name'];
                    $mrr['data']['age'] = $trr['age'];
                    $mrr['data']['gender'] = $trr['gender'];
                    $mrr['data']['created_at'] = $trr['created_at'];
                    $mrr['data']['count'] = $trr['count'];
                    $mrr['data']['piece'] = $trr['fu'];
                    $mrr['data']['feedback'] = $trr['feedback'];
                    $mrr['data']['prescription'] = $trr['prescription'];
                }else{
          $mrr['code']="201";
          $mrr['message']="暂无数据";
}
            }

          echo json_encode($mrr);


        }else if($type=="prescription_details"){
         $prescription_id=$request->get('prescription_id');
            if(empty($prescription_id)){
                $login['code'] = "104";
                $login['message'] = "请输入药方id";
                echo json_encode($login);
                die;
            }else{

                $tbl_prescription=new TblPrescription();
                //根据药方id查询出味数和副数
                $grr=$tbl_prescription->find()->where("prescription_id='$prescription_id'")->asarray()->all();
                //根据药方id查询出病人的信息

                $tbl_patient=new TblPatient();
                $trr=$tbl_patient->find()
                    ->select(array('patient_name','age','gender','prescription_id'))
                    ->where("prescription_id='$prescription_id'")
                    ->asArray()
                    ->one();
		
                if(empty($grr)){
                    $trr['fu'] = "0味/0副";
                }else {
                    foreach ($grr as $k => $v) {
                        $fu = $v['kinds_per_piece'] . "味" . "/" . $v['piece'] . "副";
                        if (empty($v['kinds_per_piece']) || empty($v['piece'])) {
                            $fu = "0味/0副";
                        } 
						
                            $trr['fu'] = $fu;
                            $trr['hospital_name']=$v['hospital_name'];
                            $trr['doctor_name']=$v['doctor_name'];
                            $trr['production_type']=$v['production_type'];
                            $trr['created_at']=$v['created_at'];
							$trr['prescription_status']=$v['prescription_status'];
							$trr['prescription_id']=$v['prescription_id'];
                        
                    }
                }
		
                //根据药方id查出反馈
//                $tbl_prescription_feedback=new TblPatientFeedback();
//                $drr=$tbl_prescription_feedback->find()
//                    ->where("prescription_id='$prescription_id'")
//                    ->asArray()
//                    ->all();
//                $count=count($drr);
//                if($count=="0"){
//                    $count="暂无反馈";
//                }else{
//                    $trr['feedback']=$drr;
//
//                }
//                $trr['count']=$count;

                //根据药方id查询出药方
                $tbl_prescription_detail=new TblPrescriptionDetail();
                $vrr=$tbl_prescription_detail->find()
                    ->where("prescription_id='$prescription_id'")
                    ->asArray()
                    ->all();
                if(empty($vrr)){
                    $trr['prescription']=[];
                }else {
                    $trr['prescription'] = $vrr;
                }

                $hy=array();
                if(!empty($trr['patient_name'])) {
                    $hy['code'] = "200";
                    $hy['message'] = "请求处理成功";
                    $hy['data']['patient_name'] = $trr['patient_name'];
                    $hy['data']['age'] = $trr['age'];
                    $hy['data']['gender'] = $trr['gender'];
                    $hy['data']['prescription_id'] = $trr['prescription_id'];
					$hy['data']['prescription_status']=$trr['prescription_status'];

                    $hy['data']['piece'] = $trr['fu'];
                    $hy['data']['hospital_name'] = $trr['hospital_name'];
                    $hy['data']['doctor_name'] = $trr['doctor_name'];
                    $hy['data']['production_type'] = $trr['production_type'];
                    $hy['data']['created_at'] = $trr['created_at'];
                    $hy['data']['prescription'] = $trr['prescription'];

                }else{
                  $hy['code'] = "200";
                    $hy['message'] = "请求处理成功";
					  $hy['data']['patient_name'] = null;

                    $hy['data']['prescription_id'] = $trr['prescription_id'];
					$hy['data']['prescription_status']=$trr['prescription_status'];

                    $hy['data']['piece'] = $trr['fu'];
                    $hy['data']['hospital_name'] = $trr['hospital_name'];
                    $hy['data']['doctor_name'] = $trr['doctor_name'];
                    $hy['data']['production_type'] = $trr['production_type'];
                    $hy['data']['created_at'] = $trr['created_at'];
                    $hy['data']['prescription'] = $trr['prescription'];
                }
                echo json_encode($hy);
            }
        }else if($type=="feedback"){
  $prescription_id=$request->get('prescription_id');
            if(empty($prescription_id)){
                $login['code'] = "104";
                $login['message'] = "请输入药方id";
                echo json_encode($login);
                die;
            }else{
				$tbl_prescription_progress = new TblPrescriptionProgress();
				$endtime=$tbl_prescription_progress->find()->where("progress_id=8 and prescription_id='$prescription_id'")->asarray()->one();
			 if(empty($endtime)){

                    $rr['code']="201";
                    $rr['message']="暂无数据";
                    echo json_encode($rr);die;
                }
                $tbl_patient_feedback=new TblPatientFeedback();
                $where="prescription_id='$prescription_id'";
                $rr=$tbl_patient_feedback->find()
                    ->select(array('prescription_id','contents','created_at','occurence_date'))
                    ->where($where)
                    ->asArray()
                    ->all();

                if(empty($rr)){

                    $rr['code']="201";
                    $rr['message']="暂无数据";
                    echo json_encode($rr);die;
                }else{
                    $aa=array();
                    $aa['code']="200";
                    $aa['message']="请求处理成功";
					$aa['data']['starttime']=$endtime['end_time'];
					$aa['data']['presscription_id']=$endtime['prescription_id'];
                    $aa['data']['feedback']=$rr;
                    echo json_encode($aa);die;
//                     $rj='{"code":"200",';
//
//					$rj.='"data":[';
//					foreach($rr as $k){
//						if(is_array($k)){
//                    $rj.='{"occurence_date":"'.$k['occurence_date'].'",';
//					$rj.='"prescription_id":"'.$k['prescription_id'].'",';
//					$rj.='"created_at":"'.$k['created_at'].'",';
//					$rj.='"contents":'.json_encode($k['contents']).'},';
//						}
//					}
//					$rj=substr($rj,0,-1);
//					$rj.=']}';
//					echo $rj;
                }
            }
        }elseif($type=="medicinal_materials"){
            $prescription_id=$request->get('prescription_id');
            if(empty($prescription_id)){
                $login['code'] = "104";
                $login['message'] = "请输入药方id";
                echo json_encode($login);die;
             
            }else {
                //通过药方id查出与他匹配的药方
                $tbl_prescription_detail = new TblPrescriptionDetail();
                $where = "prescription_id='$prescription_id'";
                $nrr = $tbl_prescription_detail->find()->where($where)->asArray()->all();

                $tblMedicinelot=new TblMedicineLot();
                foreach($nrr as $k){
					if(is_array($k)){
					$medicine_id=$k['medicine_id'];
				$jrr[]=$tblMedicinelot->find()->where("medicine_id='$medicine_id'")->asArray()->one();
				
                                
					}//print_r($jrr);die;

					}
					

if(!empty($nrr)&&!empty($jrr)){
                            for($i=0;$i<count($nrr);$i++){
                            $jrr[$i]['medicine_name']=$nrr[$i]['medicine_name'];
 			   $jrr[$i]['medicine_photo']=$nrr[$i]['medicine_photo'];
                           
                            }
              

 
				
                $oo=array();
                $oo['code']="200";
                $oo['message']="请求处理成功";
                
                $oo['data']['medicinal_materials']=$jrr;
          echo json_encode($oo);
					}else{
					$oo=array();
                $oo['code']="201";
				$oo['message']="暂无数据";
				echo json_encode($oo);die;
					
					}
			}
             
        }else if($type=="when") {
            $prescription_id = $request->get('prescription_id');
            if (empty($prescription_id)) {
                $login['code'] = "104";
                $login['message'] = "请输入药方id";
                echo json_encode($login);die;
               
            } else {
                //查询药的进展表
                $tbl_prescription_progress = new TblPrescriptionProgress();
                //抓药这块必须有3和4过程 因为3是抓药 4是核方
                $three = $tbl_prescription_progress->find()->select(array('start_time','password_hash','progress_id','prescription_id'))->where("progress_id=3 and prescription_id='$prescription_id'")->asArray()->one();
                $four = $tbl_prescription_progress->find()->select(array('start_time', 'password_hash','progress_id','prescription_id'))->where("progress_id=4 and prescription_id='$prescription_id'")->asArray()->one();

                //通过担当者的id查询出头像与姓名
                if (empty($three) || empty($four)) {
                    $login['code'] = "201";
                    $login['message'] = "暂无抓药数据";
                    echo json_encode($login);
                    die;
                } else {
                    $person_incharge = $four['password_hash'];
                    $tbl_staff = new TblStaff();
                    $aa = $tbl_staff->find()
                        ->select(array('staff_name', 'photo', 'role_name'))
                        ->where("staff_id=' $person_incharge'")
                        ->asArray()
                        ->one();
                    $uo = array();
                    $uo['zhuayao'] = $three['start_time'];
                    $uo['hefang'] = $four['start_time'];
                    $uo['photo'] = $aa['photo'];
                    $uo['role_name'] = $aa['role_name'];

                    //通过药方id查询出付数和味数
                    $tbl_prescription=new TblPrescription();
                    $lk=$tbl_prescription->find()->select(array('piece','kinds_per_piece'))->where("prescription_id='$prescription_id'")                         ->asArray()->one();
                    if(!empty($lk)) {
                        $uo['piece'] = $lk['piece'];
                        $uo['kinds_per_piece'] = $lk['kinds_per_piece'];

                        $tblprescriptionphoto = new TblPrescriptionPhoto();
                        //检查进展表
                        $tbl_progress_check=new TblProgressCheck();
                        $nn = $tbl_progress_check->find()
                            ->select(array('photo','taken_type'))
                            ->where("prescription_id='$prescription_id' and progress='4'")
                            ->orderBy("taken_type asc")
                            ->asArray()
                            ->all();
						if(!empty($nn)){
                        $uo['prescriptionphoto']=$nn;

						}else{
						$uo['prescriptionphoto']="暂无图片信息";

						}
                    }else{
                        $uo['piece']="暂无副数信息";
                        $uo['kinds_per_piece']="味数信息";


                    }
                   if(!empty($nn)) {
                       $mm = array();
                       for ($i = 0; $i < count($uo['prescriptionphoto']); $i++) {
                           $mm[$i] = $uo['prescriptionphoto'][$i]['photo'];
                       }
                   }else{

                       $mm=[];
                   }
                    $pp=array();
                    $pp['code']="200";
                    $pp['message']="请求处理成功";
                    $pp['data']['whentime']=$uo['zhuayao'];
                    $pp['data']['nucleartime']=$uo['hefang'];
                    $pp['data']['photo']=$uo['photo'];
                    $pp['data']['piece']=$uo['piece'];
                    $pp['data']['kinds_per_piece']=$uo['kinds_per_piece'];
                    $pp['data']['role_name']=$uo['role_name'];
                    $pp['data']['prescriptionphoto']=$mm;
                    echo json_encode($pp);die;

                }
            }

        }else{
            $login['code'] = "103";
            $login['message'] = "请输入正确的类型";
            echo json_encode($login);
            die;
        }
    }
    //院长生成账号
    public function actionAddaccount(){
        $tbl_doctor=new TblDoctor();
        $request=Yii::$app->request;
        $phone=$request->get('phone');
        $lkj=date('Y-m-d H:i:s',time());
        if(empty($phone)){
            $login['code'] = "104";
            $login['message'] = "请填写手机号";
            echo  json_encode($login);die;
        }
        $hrr=$tbl_doctor->find()->where("doctor_phone='$phone'")->asArray()->one();
        if(!empty($hrr)){
            $login['code'] = "105";
            $login['message'] = "该手机号已经注册,请登录";
            echo  json_encode($login);die;
        }
        $staff = new TblInterfaceCallStaff();
        $doctorid=$request->get('doctorid');
        $token = $request->get('token');
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($doctorid)){
            $login['code'] = "102";
            $login['message'] = "医生id不能为空";
            echo  json_encode($login);die;
        }else{
            $where="doctor_id='$doctorid'and  is_dean='1'";
            $arr=$tbl_doctor->find()->where($where)->asArray()->one();
            if(empty($arr)){
                $login['code'] = "103";
                $login['message'] = "你不是管理员,你无权查看该信息";
                echo  json_encode($login);die;
            }else{
                $arr=$tbl_doctor->find()->select(array('hospital_id','hospital_name'))->where($where)->asArray()->one();
                $hospital_id=$arr['hospital_id'];
                $hospital_name=$arr['hospital_name'];
                $nowtime=time();
                $newdoctorid=$hospital_id.$nowtime;
                $db=Yii::$app->db;
                $sql="insert into tbl_doctor(doctor_id,doctor_phone,hospital_id,hospital_name,created_at)
                VALUES ('$newdoctorid','$phone','$hospital_id','$hospital_name','$lkj')";
                $arr=$db->createCommand($sql)->query();
//                $tbl_doctor->doctor_id=$newdoctorid;
//                $tbl_doctor->hospital_name=$hospital_name;
//                $tbl_doctor->hospital_id=$hospital_id;
//                $tbl_doctor->doctor_phone=$phone;
//
//                $tbl_doctor->save();
                    $login['code'] = "200";
                    $login['message'] = "注册成功,请登录";
                   $tbl_doctor=new TblDoctor();
                $bbq=$tbl_doctor->find()->where("doctor_phone='$phone'")->asArray()->one();
                $login['data']['doctor_id']=$bbq['doctor_id'];
                    echo  json_encode($login);die;
            }
        }
    }
    //删除账号接口
    public function actionDeleteaccount(){
        $staff = new TblInterfaceCallStaff();
        $request=Yii::$app->request;
        $deleteaccount=$request->get('deleteaccount');
        $doctorid=$request->get('doctorid');
        $token = $request->get('token');
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        if(empty($deleteaccount)){
        $login['code']="102";
       $login['message']="医生id不能为空";
      echo json_encode($login);
	}
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($doctorid)){
            $login['code'] = "102";
            $login['message'] = "医生id不能为空";
            echo  json_encode($login);die;
        }
        $tbl_doctor=new TblDoctor();
        $where="doctor_id='$doctorid'and  is_dean='1'";
        $arr=$tbl_doctor->find()->where($where)->asArray()->one();
        if(empty($arr)){
            $login['code'] = "103";
            $login['message'] = "你不是管理员,你无权查看该信息";
            echo  json_encode($login);die;
        }else{
       $aa=$tbl_doctor->deleteAll(['doctor_id'=>$deleteaccount]);
            $login['code'] = "200";
            $login['message'] = "删除成功";
            echo  json_encode($login);die;
        }
    }


    public function actionUpphoto(){
        $staff = new TblInterfaceCallStaff();
        $request=Yii::$app->request;
        $doctorid=$request->get('doctorid');
        $token = $request->get('token');
        $newphoto=$request->get('newphoto');
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($doctorid)){
            $login['code'] = "102";
            $login['message'] = "医生id不能为空";
            echo  json_encode($login);die;
        }
        if(empty($newphoto)){
            $login['code'] = "103";
            $login['message'] = "请填写新的图片地址";
            echo  json_encode($login);die;
        }else{
            $tbldoctor=new TblDoctor();
            $arr=$tbldoctor->find()->where("doctor_id='$doctorid'")->asArray()->one();
            if(empty($arr)){
                $login['code'] = "104";
                $login['message'] = "暂无该用户信息";
                echo  json_encode($login);die;
            }else{
                $aa=$tbldoctor->updateAll(['doctor_img'=>$newphoto],['doctor_id'=>$doctorid]);
                if($aa){
                    $login['code'] = "200";
                    $login['message'] = "请求处理完成";
                    echo  json_encode($login);die;
                }else{
                    $login['code'] = "200";
                    $login['message'] = "请求处理完成";
                    echo  json_encode($login);die;
                }
            }
        }
    }
    //七牛token接口
  public function actionQiniutoken(){
      require 'php-sdk-master/autoload.php';
      $request=Yii::$app->request;
      $staff = new TblInterfaceCallStaff();
      $token = $request->get('token');
      if($token==""){
          $login['code'] = "100";
          $login['message'] = "请输入您的token";
          echo  json_encode($login);die;
      }
      $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
      if($user_token==""){
          $login['code'] = "101";
          $login['message'] = "您没有权限调用本接口";
          echo  json_encode($login);die;
      }
      $bucket = 'runyige-bucket';
      $accessKey = 'w2fkBssYidWHBhS7WuVe8PqrIsTrdLcuLE6Vq4_8';
      $secretKey = 'zC-vQhYqipkIEBpWXA3AlddM6ldk5qvVRamPKboK';
      $auth = new Auth($accessKey, $secretKey);

      $upToken = $auth->uploadToken($bucket);
      $aa['code']="200";
      $aa['message']="七牛token请求成功";
      $aa['data']['token']=$upToken;
      echo json_encode($aa);die;

  }
    //处方影印件
    public function actionPrescription_photocopy(){
        $request=Yii::$app->request;
        $staff = new TblInterfaceCallStaff();
        $prescription_id=$request->get('prescription_id');
        $token = $request->get('token');
        if($token==""){
            $login['code'] = "100";
            $login['message'] = "请输入您的token";
            echo  json_encode($login);die;
        }
        $user_token = $staff->find()->where(['token' => $token])->asArray()->one();
        if($user_token==""){
            $login['code'] = "101";
            $login['message'] = "您没有权限调用本接口";
            echo  json_encode($login);die;
        }
        if(empty($prescription_id)){
            $login['code']="102";
            $login['message']="请输入药方id";
            echo json_encode($login);die;
        }
        $tbl_prescription=new TblPrescription();
        $arr=$tbl_prescription->find()->where("prescription_id='$prescription_id'")->asArray()->one();
        if(empty($arr)){
           $login['code']="103";
            $login['message']="该药方不存在,请输入正确的药方id";
            echo json_encode($login);die;
        }
     if($arr['excessive_prescription']=='1'){
     $tbl_prescription_photo=new TblPrescriptionPhoto();
         $brr=$tbl_prescription_photo->find()->select(array('photo_img'))
             ->orderBy("frequence asc")
             ->where("photo_type='1' and prescription_id='$prescription_id'")
             ->asArray()
             ->all();
        
         if(empty($brr)){
             $login['code']="201";
             $login['message']="暂无图片信息";
             echo json_encode($login);die;
         }
         $count=count($brr);
         if(!empty($brr)){
           if($count=='2'){
               $drr['prescription_photo1']=$brr[0]['photo_img'];
               $drr['prescription_photo2']=$brr[1]['photo_img'];
           }else{
               $drr['prescription_photo1']=$brr[0]['photo_img'];

           }

         }

     

        $login['code']="200";
         $login['message']="请求处理成功";
         $login['data']=$drr;
         echo json_encode($login);
     }else{
         if($arr['is_reconfirmed']=='0'){
             $tbl_prescription_photo=new TblPrescriptionPhoto();
             $brr=$tbl_prescription_photo->find()->select(array('photo_img'))
                 ->orderBy("frequence asc")
                 ->where("photo_type='1' and prescription_id='$prescription_id'")
                 ->asArray()
                 ->all();
          
             if(empty($brr)){
                 $login['code']="201";
                 $login['message']="暂无图片信息";
                 echo json_encode($login);die;
             }
             $drr=array();
             if(!empty($brr)){
                 for($i=0;$i<count($brr);$i++){
                     $drr[$i]['prescription_photo']=$brr[$i]['photo_img'];
                 }

             }
             $count=count($drr);
            

             $login['code']="200";
             $login['message']="请求处理成功";
             $login['data']=$drr;
             echo json_encode($login);
         }else{
        $tbl_confirm=new TblConfirmPhotos();
             $confirmphoto=$tbl_confirm->find()->select(array('photo_img'))->where("prescription_id='$prescription_id'")->asArray()->one();
             $tbl_prescription_photo=new TblPrescriptionPhoto();
             
             if(empty($confirmphoto)){
                 $login['code']="201";
                 $login['message']="暂无数据";
                 echo json_encode($login);die;
             }
             
             if(!empty($confirmphoto)){
                 $aa['confirmphoto']=$confirmphoto['photo_img'];
             }
            $login['code']="200";
             $login['message']="请求处理成功";
             $login['data']=$aa;
             echo json_encode($login);die;
         }
     }

    }
}
