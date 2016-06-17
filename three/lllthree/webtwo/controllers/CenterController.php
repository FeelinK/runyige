<?php

/**
 * 润衣阁首页
 * ============================================================================
 * * 版权所有 2016- 北京润衣阁科技有限公司，并保留所有权利。
 * 网站地址:
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: my $
 */
namespace app\controllers;
use app\models\TblPatient;                                      //病人表
use app\models\TblPrescriptionDetail;                           //药材的用法用量
use app\models\TblPrescriptionPhoto;                            //药方照片
use app\models\TblProgressBoiling;
use app\models\TblProgressDistribution;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TblPrescription;                                  //药方表
use  yii\data\Pagination;                                        //yii框架内置的分页类
use  app\models\TblHospital;                                     //医院表
use app\models\TblDailyStatistics;                               //每日的统计表
use app\models\TblPrescriptionUnhandledByPatient;                //未经处理的病人处方数
use  Qiniu\Auth;
use Qiniu\Storage\UploadManager;                                 //药方操作流程
use app\models\TblPrescriptionProgress;                          //处方药的进展
use app\models\TblProductionUsage;                                 //处方药的用法用量表
use app\models\TblUseFrequenceType;                              //处方药的服用频次
use app\models\TblMedicine;                                      //药材价目表
use app\models\TblProduceFrequenceType;                          //中药制作顺序管理表
use app\models\TblProgressCheck;                                 //中药制作顺序管理表
use app\models\TblErrorInformation;                              //错误信息表



class CenterController extends Controller
{
    public $enableCsrfValidation =false;
    //润衣阁楼
    public function actionIndex(){
        $tbl_medicine = new TblMedicine();  //药材名称
        $medicine_list = $tbl_medicine
            ->find()
            ->select(array('medicine_name','medicine_id','pinyin'))
            ->asArray()
            ->all();
        foreach($medicine_list as $k=>$v){
            $medicine_id = $v['medicine_id'];
            $medicines_list[$medicine_id] = $v['pinyin']." ".$v['medicine_name'];
        }
        //实例化一个药方表
        $tbl_prescription=new TblPrescription();
        //实例化一个request
        $request=Yii::$app->request;
        $search=$request->get('search');
        $hospital_name=$request->get('hospital_name');
        $yi=$request->get('already');
        if(empty($yi)){
            $already="prescription_status <80";
        }else{
            $already="prescription_status = 80";
        }
        $patient_type_name=$request->get('patient_type_name');
        if(!empty($patient_type_name)){
            $already.=" and patient_type_name='$patient_type_name'";
        }
        if(!empty($hospital_name)){
            $already.=" and hospital_name='$hospital_name'";
        }
        if(!empty($search)){
            $already.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        $aa="";
        if(empty($yi)){
            $aa="prescription_status <80";
        }else{
            $aa="prescription_status = 80";
        }

        if(!empty($hospital_name)){
            $aa.=" and hospital_name='$hospital_name'";
        }
        if(!empty($search)){
            $aa.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        //查询出药方的所有数据
          $models=$tbl_prescription->find()
              ->where($already)
              ->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','Prescription_status'))
              ->asArray()
              ->all();
        //分页开始
        //首先count总共多少条 然后取整
        $zong=count($models);
        //每页几个
        $meiye=6;
        $quzheng=ceil($zong/$meiye);
        //判断当前页
        if(empty($_GET['page'])){
            $page=1;
        }else{
            $page=$_GET['page'];
        }
        //上一页
        $lastpage=$page-1<1?1:$page-1;
        //下一页
        $nextpage=$page+1>$quzheng?$quzheng:$page+1;

        //偏移量
        $pianyi=($page-1)*$meiye;
        //实例化一个db
        $db=Yii::$app->db;
        $sql="select * from tbl_prescription where $already limit $pianyi,$meiye";
        $modelstwo=$db->createCommand($sql)->queryAll();
        //根据每页几个和偏移量作为条件分页
//        $modelstwo=$tbl_prescription->find()->limit($pianyi,$meiye)->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','Prescription_status'))->asArray()->all();
//print_r($modelstwo);die;
        //分页结束
         //实例化一个每日统计表
        $tbl_daily_statistics=new TblDailyStatistics();
        //获取当前时间
        $nowtime=date('Y-m-d H:i:s');
        $nowtime=substr($nowtime,0,10);
        //根据当前世界查询每日统计表然后展示数据
        $crr=$tbl_daily_statistics->find()->where("day like '$nowtime%'")->asArray()->one();
        //查询出孕妇儿童特殊普通各自占几个
        $sql="select patient_type_name,count(patient_type_name),prescription_status  from tbl_prescription where $aa GROUP BY patient_type_name ";
         $vrr=$db->createCommand($sql)->queryAll();
        //求出
        //实例化一个医院表
        $tbl_hospital=new TblHospital();
        //查询出医院id和医院名称
        $brr=$tbl_hospital->find()->select(array('hospital_id','hospital_name'))->asArray()->all();
        if(!empty($yi)){
            $already=1;
        }else{
            $already="";
        }
         return $this->renderPartial('index', [
         'medicines_list' => json_encode($medicines_list),
         'models' => $modelstwo,
          'brr'=>$brr,
          'crr'=>$crr,
           'nowtime'=>$nowtime,
             'lastpage'=>$lastpage,
             'nextpage'=>$nextpage,
             'end'=>$quzheng,
             'zong'=>$zong,
             'vrr'=>$vrr,
              'already'=>$already,
             'patient_type_name'=>$patient_type_name,
             'hospital_name'=>$hospital_name,
               'search'=>$search
        ]);
    }
    //根据条件二匹配数据
    public function actionTypetwo(){
        //实例化一个药方表
        $tbl_prescription=new TblPrescription();
        //实例化一个request
        $request=Yii::$app->request;
        $search=$request->get('search');
        $hospital_name=$request->get('hospital_name');
        $patient_type_name=$request->get('patient_type_name');
        $yi=$request->get('already');
        if(empty($yi)){
            $already="prescription_status <80";
        }else{
            $already="prescription_status = 80";

        }
        if(!empty($patient_type_name)){
            $already.=" and patient_type_name='$patient_type_name'";
        }
        if(!empty($hospital_name)){
            $already.=" and hospital_name='$hospital_name'";
        }
        if(!empty($search)){
            $already.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        $aa="";
        if(empty($yi)){
            $aa="prescription_status <80";
        }else{
            $aa="prescription_status = 80";
        }

        if(!empty($hospital_name)){
            $aa.=" and hospital_name='$hospital_name'";
        }
        if(!empty($search)){
            $aa.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        //查询出药方的所有数据
        $models=$tbl_prescription->find()
            ->where($already)
            ->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','prescription_status'))
            ->asArray()
            ->all();
        //分页开始
        //首先count总共多少条 然后取整
        $zong=count($models);
        //每页几个
        $meiye=6;
        $quzheng=ceil($zong/$meiye);
        //判断当前页
        if(empty($_GET['page'])){
            $page=1;
        }else{
            $page=$_GET['page'];
        }
        //上一页
        $lastpage=$page-1<1?1:$page-1;
        //下一页
        $nextpage=$page+1>$quzheng?$quzheng:$page+1;

        //偏移量
        $pianyi=($page-1)*$meiye;
        //实例化一个db
        $db=Yii::$app->db;
        $sql="select * from tbl_prescription where $already limit $pianyi,$meiye";
        $modelstwo=$db->createCommand($sql)->queryAll();
        //根据每页几个和偏移量作为条件分页
//        $modelstwo=$tbl_prescription->find()->limit($pianyi,$meiye)->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','Prescription_status'))->asArray()->all();
//print_r($modelstwo);die;
        //分页结束
        //实例化一个每日统计表
        $tbl_daily_statistics=new TblDailyStatistics();
        //获取当前时间
        $nowtime=date('Y-m-d H:i:s');
        $nowtime=substr($nowtime,0,10);
        //根据当前世界查询每日统计表然后展示数据
        $crr=$tbl_daily_statistics->find()->where("day like '$nowtime%'")->asArray()->one();
        //查询出孕妇儿童特殊普通各自占几个
        $sql="select patient_type_name,count(patient_type_name),prescription_status  from tbl_prescription where $aa GROUP BY patient_type_name ";
        $vrr=$db->createCommand($sql)->queryAll();
        //求出
        //实例化一个医院表
        $tbl_hospital=new TblHospital();
        //查询出医院id和医院名称
        $brr=$tbl_hospital->find()->select(array('hospital_id','hospital_name'))->asArray()->all();
        if(!empty($yi)){
            $already=1;
        }else{
            $already="";
        }
        return $this->renderPartial('typetwo', [
            'models' => $modelstwo,
            'brr'=>$brr,
            'crr'=>$crr,
            'nowtime'=>$nowtime,
            'lastpage'=>$lastpage,
            'nextpage'=>$nextpage,
            'end'=>$quzheng,
            'zong'=>$zong,
            'vrr'=>$vrr,
            'already'=>$already,
            'patient_type_name'=>$patient_type_name,
            'hospital_name'=>$hospital_name,
            'search'=>$search

        ]);
    }
    //根据第三个条件然后匹配数据
    public function actionTypethree(){
        //实例化一个药方表
        $tbl_prescription=new TblPrescription();
        //实例化一个request
        $request=Yii::$app->request;
        $search=$request->get('search');
        //接收医馆名称
        $hospital_name=$request->get('hospital_name');
        //接收针对的用户分类
        $patient_type_name=$request->get('patient_type_name');
        $yi=$request->get('already');
        if(empty($yi)){
            $already="prescription_status <80";
        }else{
            $already="prescription_status = 80";

        }
        if(!empty($patient_type_name)){
            $already.=" and patient_type_name='$patient_type_name'";
        }
       if(!empty($hospital_name)){
           $already.=" and hospital_name='$hospital_name'";
       }
        if(!empty($search)){
            $already.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        $aa="";
        if(empty($yi)){
            $aa="prescription_status <80";
        }else{
            $aa="prescription_status = 80";
        }

        if(!empty($hospital_name)){
            $aa.=" and hospital_name='$hospital_name'";
        }
        if(!empty($search)){
            $aa.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        //查询出药方的所有数据
        $models=$tbl_prescription->find()
            ->where($already)
            ->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','prescription_status'))
            ->asArray()
            ->all();
        //分页开始
        //首先count总共多少条 然后取整
        $zong=count($models);
        //每页几个
        $meiye=6;
        $quzheng=ceil($zong/$meiye);
        //判断当前页
        if(empty($_GET['page'])){
            $page=1;
        }else{
            $page=$_GET['page'];
        }
        //上一页
        $lastpage=$page-1<1?1:$page-1;
        //下一页
        $nextpage=$page+1>$quzheng?$quzheng:$page+1;

        //偏移量
        $pianyi=($page-1)*$meiye;
        //实例化一个db
        $db=Yii::$app->db;
        $sql="select * from tbl_prescription where $already limit $pianyi,$meiye";
        $modelstwo=$db->createCommand($sql)->queryAll();
        //根据每页几个和偏移量作为条件分页
//        $modelstwo=$tbl_prescription->find()->limit($pianyi,$meiye)->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','Prescription_status'))->asArray()->all();
//print_r($modelstwo);die;
        //分页结束
        //实例化一个每日统计表
        $tbl_daily_statistics=new TblDailyStatistics();
        //获取当前时间
        $nowtime=date('Y-m-d H:i:s');
        $nowtime=substr($nowtime,0,10);
        //根据当前世界查询每日统计表然后展示数据
        $crr=$tbl_daily_statistics->find()->where("day like '$nowtime%'")->asArray()->one();
        //查询出孕妇儿童特殊普通各自占几个
        $sql="select patient_type_name,count(patient_type_name),prescription_status  from tbl_prescription where $aa GROUP BY patient_type_name ";
        $vrr=$db->createCommand($sql)->queryAll();
        //求出
        //实例化一个医院表
        $tbl_hospital=new TblHospital();
        //查询出医院id和医院名称
        $brr=$tbl_hospital->find()->select(array('hospital_id','hospital_name'))->asArray()->all();
        if(!empty($yi)){
            $already=1;
        }else{
            $already="";
        }
        return $this->renderPartial('typetwo', [
            'models' => $modelstwo,
            'brr'=>$brr,
            'crr'=>$crr,
            'nowtime'=>$nowtime,
            'lastpage'=>$lastpage,
            'nextpage'=>$nextpage,
            'end'=>$quzheng,
            'zong'=>$zong,
            'vrr'=>$vrr,
            'already'=>$already,
            'patient_type_name'=>$patient_type_name,
            'hospital_name'=>$hospital_name,
            'search'=>$search
        ]);
    }
    //根据搜索的条件然后匹配数据
    public function actionTypefour(){
        //实例化一个药方表
        $tbl_prescription=new TblPrescription();
        //实例化一个request
        $request=Yii::$app->request;
        //接收医馆名称
        $hospital_name=$request->get('hospital_name');
        //接收针对的用户分类
        $patient_type_name=$request->get('patient_type_name');
        $yi=$request->get('already');
        $search=$request->get('search');
        if(empty($yi)){
            $already="prescription_status <80";
        }else{
            $already="prescription_status = 80";

        }
        if(!empty($patient_type_name)){
            $already.=" and patient_type_name='$patient_type_name'";
        }
        if(!empty($hospital_name)){
            $already.=" and hospital_name='$hospital_name'";
        }
        if(!empty($search)){
            $already.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        $aa="";
        if(empty($yi)){
            $aa="prescription_status <80";
        }else{
            $aa="prescription_status = 80";
        }

        if(!empty($hospital_name)){
            $aa.=" and hospital_name='$hospital_name'";
        }
        if(!empty($search)){
            $aa.=" and doctor_name='$search' or hospital_name='$search' or patient_name='$search' or prescription_id='$search'";
        }
        //查询出药方的所有数据
        $models=$tbl_prescription->find()
            ->where($already)
            ->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','prescription_status'))
            ->asArray()
            ->all();
        //分页开始
        //首先count总共多少条 然后取整
        $zong=count($models);
        //每页几个
        $meiye=6;
        $quzheng=ceil($zong/$meiye);
        //判断当前页
        if(empty($_GET['page'])){
            $page=1;
        }else{
            $page=$_GET['page'];
        }
        //上一页
        $lastpage=$page-1<1?1:$page-1;
        //下一页
        $nextpage=$page+1>$quzheng?$quzheng:$page+1;

        //偏移量
        $pianyi=($page-1)*$meiye;
        //实例化一个db
        $db=Yii::$app->db;
        $sql="select * from tbl_prescription where $already limit $pianyi,$meiye";
        $modelstwo=$db->createCommand($sql)->queryAll();
        //根据每页几个和偏移量作为条件分页
//        $modelstwo=$tbl_prescription->find()->limit($pianyi,$meiye)->select(array('prescription_id','doctor_id','hospital_name','doctor_name','piece','kinds_per_piece','notes','production_type','Prescription_status'))->asArray()->all();
//print_r($modelstwo);die;
        //分页结束
        //实例化一个每日统计表
        $tbl_daily_statistics=new TblDailyStatistics();
        //获取当前时间
        $nowtime=date('Y-m-d H:i:s');
        $nowtime=substr($nowtime,0,10);
        //根据当前世界查询每日统计表然后展示数据
        $crr=$tbl_daily_statistics->find()->where("day like '$nowtime%'")->asArray()->one();
        //查询出孕妇儿童特殊普通各自占几个
        $sql="select patient_type_name,count(patient_type_name),prescription_status  from tbl_prescription where $aa GROUP BY patient_type_name ";
        $vrr=$db->createCommand($sql)->queryAll();
        //求出
        //实例化一个医院表
        $tbl_hospital=new TblHospital();
        //查询出医院id和医院名称
        $brr=$tbl_hospital->find()->select(array('hospital_id','hospital_name'))->asArray()->all();
        if(!empty($yi)){
            $already=1;
        }else{
            $already="";
        }
        return $this->renderPartial('typetwo', [
            'models' => $modelstwo,
            'brr'=>$brr,
            'crr'=>$crr,
            'nowtime'=>$nowtime,
            'lastpage'=>$lastpage,
            'nextpage'=>$nextpage,
            'end'=>$quzheng,
            'zong'=>$zong,
            'vrr'=>$vrr,
            'already'=>$already,
            'patient_type_name'=>$patient_type_name,
            'hospital_name'=>$hospital_name,
            'search'=>$search
        ]);
    }
    //七牛测试
    public function actionQiniu(){
        require 'php-sdk-master/autoload.php';

//        $accessKey = 'w2fkBssYidWHBhS7WuVe8PqrIsTrdLcuLE6Vq4_8';
//        $secretKey = 'zC-vQhYqipkIEBpWXA3AlddM6ldk5qvVRamPKboK';
//        $auth = new Auth($accessKey, $secretKey);
//
//        // 空间名  http://developer.qiniu.com/docs/v6/api/overview/concepts.html#bucket
//        $bucket = 'runyige-bucket';
//
//        // 生成上传Token
//        $token = $auth->uploadToken($bucket);
//
//       echo $token;die;
//        // 构建 UploadManager 对象
//        $uploadMgr = new UploadManager();
        $bucket = 'runyige-bucket';
        $accessKey = 'w2fkBssYidWHBhS7WuVe8PqrIsTrdLcuLE6Vq4_8';
        $secretKey = 'zC-vQhYqipkIEBpWXA3AlddM6ldk5qvVRamPKboK';
        $auth = new Auth($accessKey, $secretKey);

        $upToken = $auth->uploadToken($bucket);

        echo $upToken;
    }
    //药方详情
    public function actionDetail(){
     $request=Yii::$app->request;
      //接收药方id
        $prescription_id=$request->get('prescription_id');
        //先实例化一个药方表
        $tblPrescription=new TblPrescription();
        //然后根据药方id进行查询
        $arr=$tblPrescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type','notes'))
            ->asArray()
            ->one();
        //根据药方id查询出药方图片
        //实例化一个图片表
        $tblPrescriptionphoto=new TblPrescriptionPhoto();
        $brr=$tblPrescriptionphoto
            ->find()
            ->where("prescription_id='$prescription_id' and photo_type='1'")
            ->select(array('photo_img'))
            ->asArray()
            ->all();
        //根据药方id查询出药方配送的一些信息
        //实例化一个病人表
        $tbl_patient=new TblPatient();
        $crr=$tbl_patient->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('patient_name','mobile','address'))
            ->asArray()
            ->all();
        //根据药方id查询出药材的一些信息
        //实例化一个药的用法用量表
        $tbl_prescription_detail=new TblPrescriptionDetail();
        $drr=$tbl_prescription_detail
            ->find()
            ->select(array('medicine_name','weight','medicine_photo'))
            ->where("prescription_id='$prescription_id'")
            ->asArray()
            ->all();
        $arr['brr']=$brr;
        $arr['crr']=$crr;
        $arr['drr']=$drr;
       return $this->renderPartial("detail",['arr'=>$arr]);
    }
    //流程主页
    public function actionTechnological(){
         $prescription_id =$_GET['prescription_id'];
         $progress = $this->progress($prescription_id);
          return $progress;
    }
   //录入开始
    public function actionPrescription_add(){
        $prescription_id =$_GET['prescription_id'];
        $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展（处方药开始添加）
        $new_time = date("Y-m-d H:i:s",time());
        $tbl_prescription_progress->prescription_id=$prescription_id;
        $tbl_prescription_progress->progress_id=1;
        $tbl_prescription_progress->created_at=$new_time;
        $tbl_prescription_progress->start_time=$new_time;
        $tbl_prescription_progress->save();
        $frequence =new TblUseFrequenceType();      //服用频次
        $frequence_list = $frequence
            ->find()
            ->asArray()
            ->all();
        $prescription = new TblPrescription();     //处方
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type','notes'))
            ->asArray()
            ->one();
        $prescription->updateAll(['prescription_status'=>5,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
        $prescription_photo = new TblPrescriptionPhoto(); //药方照片
        $prescription_photo_list = $prescription_photo
            ->find()
            ->where("prescription_id='$prescription_id' and photo_type=1")
            ->select(array('photo_img','photo_id'))
            ->asArray()
            ->all();
        $usage =new TblProductionUsage(); //药的用法用量
        $usage_list = $usage
            ->find()
            ->select(array('usage_id','usage_name'))
            ->asArray()
            ->all();

        $tbl_medicine = new TblMedicine();  //药材名称
        $medicine_list = $tbl_medicine
            ->find()
            ->select(array('medicine_name','medicine_id','pinyin'))
            ->asArray()
            ->all();
        foreach($medicine_list as $k=>$v){
            $medicine_id = $v['medicine_id'];
            $medicines_list[$medicine_id] = $v['pinyin'] .$v['medicine_name'];
        }
        return $this->renderPartial('prescriptionadd',[
            'medicines_list' => json_encode($medicines_list),                 //药材名称
            'prescription_list' => $prescription_list,                          //处方
            'prescription_photo_list' => $prescription_photo_list,             //处方照片
            'usage_list' => $usage_list,                                         //用法
            'frequence_list' => $frequence_list,                                 //服用频次
        ]);
    }
    //药方添加图片切换
    public function actionPrescription_photo(){
        $photo_id =$_GET['photo_id'];
        $prescription_photo = new TblPrescriptionPhoto();
        $prescription_photo_list = $prescription_photo
            ->find()
            ->where("photo_id='$photo_id' and photo_type=1")
            ->select(array('photo_img'))
            ->asArray()
            ->one();
        echo json_encode($prescription_photo_list);die;
    }
    //药方添加
    public function actionPrescriptionadds(){
        $rand= chr(rand(97, 122)).chr(rand(97, 122));
        $time= strtotime(date("Y-m-d H:i:s",time()));
        $medicine_id = "uad".$rand.$time;
        $patient_name = $_POST["patient_name"];                  //病人名字
        $gender =  $_POST['gender'];                               //性别
        $age =  $_POST['age'];                                     //年龄
        $piece =  $_POST['piece'];                                //副数
        $kinds_per_pieces =  $_POST['kinds_per_pieces'];        //味数
        $weight =  $_POST['weight'];                              //重量
        $produce_frequence = $_POST['produce_frequence'];     //制作方法
        $use_frequence =  $_POST['use_frequence'];              //服用频次
        $password_hash =  $_POST['password_hash'];              //操作人密码
        $prescription_id =  $_POST['prescription_id'];          //药方ID
        $usage_id =  $_POST['usage_id'];                         //用法ID
        $medicine_id =  $_POST['medicine_id'];              //药材ID
        $new_time= date("Y-m-d H:i:s",time());
        //病人添加
        $patient = new TblPatient();
        $patient_list=$patient->find()->where(['prescription_id'=>$prescription_id])->one();
        if(empty($patient_list)){
            $patient->patient_name=$patient_name;
            $patient->age=$age;
            $patient->gender=$gender;
            $patient->updated_at=$new_time;
            $patient->prescription_id=$prescription_id;
            $patient->save();
        }else{
            $patient_list->patient_name=$patient_name;
            $patient_list->age=$age;
            $patient_list->gender=$gender;
            $patient_list->updated_at=$new_time;
            $patient_list->save();
        }
        $produce_frequence = explode(",",$produce_frequence);
        $weight = explode(",",$weight);
        $medicine_id= explode(",",$medicine_id);
        //药方的用法用量
        $detail = new TblPrescriptionDetail();
        $prescription_detail=$detail
            ->find()
            ->select(array('medicine_name','weight','medicine_photo'))
            ->where("prescription_id='$prescription_id'")
            ->asArray()
            ->all();
        if($weight){
            $detail->deleteAll(['prescription_id' => $prescription_id]);
        }
            $i="";
            for($i=1;$i<count($medicine_id);$i++){
                $db=Yii::$app->db;
                $sql = "insert into tbl_prescription_detail(prescription_id,medicine_id,produce_frequence,weight,created_at)VALUES('$prescription_id','$medicine_id[$i]','$produce_frequence[$i]','$weight[$i]','$new_time')";
                $db->createCommand($sql)->execute();
            }
         $command = $db->createCommand("SELECT func_check_conflict_excess('$prescription_id')")->queryScalar();
        $prescription = new TblPrescription();
        //药方修改
        $prescription_list=$prescription->find()->where(['prescription_id'=>$prescription_id])->one();
        $prescription_list->patient_name=$patient_name;
        $prescription_list-> piece= $piece;
        $prescription_list-> kinds_per_piece= $kinds_per_pieces;
        $prescription_list-> use_frequence= $use_frequence;
        $prescription_list-> prescription_status= 1;
        $prescription_list-> excessive_prescription= $command;
        $prescription_list->usage_id=$usage_id;
        $prescription_list->updated_at=$new_time;
        $prescription_list->save();
        //修改处方药的进展
        $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展（处方药开始添加）
        $tbl_prescription_progress->updateAll(['password_hash'=>$password_hash,'updated_at'=>$new_time],['prescription_id'=>$prescription_id,'progress_id'=>1]);
        $prescription_photo = new TblPrescriptionPhoto(); //药方照片
        $prescription_photo_list = $prescription_photo
            ->find()
            ->where("prescription_id='$prescription_id' and photo_type=2")
            ->select(array('photo_img','photo_id'))
            ->asArray()
            ->one();
        $prescription_list = $prescription     //药方
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type'))
            ->asArray()
            ->one();
        $patient_lists=$patient
            ->find()
            ->where(['prescription_id'=>$prescription_id])
            ->select(array('address','mobile','addressee_name'))
            ->asArray()
            ->one();
            $list['prescription_photo_list'] = $prescription_photo_list;
            $list['prescription_list'] = $prescription_list;
            $list['patient_list'] = $patient_lists;
            echo json_encode($list);die;
    }
    //配送地址添加
    public function actionDistribution_add(){
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];
        $patient_name = $_POST['patient_name'];
        $prescription_id = $_POST['prescription_id'];
        $new_time = date("Y-m-d H:i:s",time());
        $patient = new TblPatient();    //病人表
        $patient->updateAll(['address'=>$address,'mobile'=>$mobile,'addressee_name'=>$patient_name,'updated_at'=>$new_time],['prescription_id'=>$prescription_id]);
        $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展
        $tbl_prescription_progress->updateAll(['end_time'=>$new_time,],['prescription_id'=>$prescription_id,'progress_id'=>1]);
        $prescription = new TblPrescription();    //处方
        $prescription->updateAll(['prescription_status'=>10,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
        $progress = $this->progress($prescription_id);   //调用流程公用方法
        return $progress;
    }
    //录入修改
    public function actionPrescription_upd(){
        $prescription_id =$_GET['prescription_id'];
        $frequence =new TblUseFrequenceType();   //服用频次
        $frequence_list = $frequence
            ->find()
            ->asArray()
            ->all();
        $prescription = new TblPrescription();     //处方
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','doctor_id','piece','kinds_per_piece','production_type','notes','excessive_prescription','use_frequence','usage_id'))
            ->asArray()
            ->one();
        $prescription_photo = new TblPrescriptionPhoto(); //药方照片
        $prescription_photo_list = $prescription_photo
            ->find()
            ->where("prescription_id='$prescription_id' and photo_type=1")
            ->select(array('photo_img','photo_id'))
            ->asArray()
            ->all();
        $usage =new TblProductionUsage(); //药的用法用量
        $usage_list = $usage
            ->find()
            ->select(array('usage_id','usage_name'))
            ->asArray()
            ->all();
        $tbl_medicine = new TblMedicine();  //药材名称
        $medicine_list = $tbl_medicine
            ->find()
            ->select(array('medicine_name','medicine_id','pinyin'))
            ->asArray()
            ->all();
        foreach($medicine_list as $k=>$v){
            $medicine_id = $v['medicine_id'];
            $medicines_list[$medicine_id] = "renshen ".$v['medicine_name'];
        }
        $tbl_patient=new TblPatient();    //病人表
        $patient_list=$tbl_patient->find()
            ->where("prescription_id='$prescription_id'")
            ->asArray()
            ->one();
        $tbl_prescription_detail=new TblPrescriptionDetail();  //药材的用法用量
        $prescription_detail=$tbl_prescription_detail
            ->find()
            ->select(array('medicine_name','medicine_id','weight','medicine_photo','produce_frequence','is_excess','is_violation'))
            ->where("prescription_id='$prescription_id'")
            ->asArray()
            ->all();
        $tbl_produce_frequence_type = new TblProduceFrequenceType();       //中药制作顺序管理表
        $produce_frequence=$tbl_produce_frequence_type
            ->find()
            ->select(array('produce_frequence_type','produce_frequence_name'))
            ->asArray()
            ->all();
        return $this->renderPartial('prescriptionupd',[
            'produce_frequence' => $produce_frequence,                           //中药制作顺序
            'prescription_detail'=>$prescription_detail,                        //药材的用法用量
            'patient_list'=> $patient_list,                                      //病人信息
            'medicines_list'=> json_encode($medicines_list),                     //药材名称
            'prescription_list' => $prescription_list,                          //处方
            'prescription_photo_list' => $prescription_photo_list,             //处方照片
            'usage_list' => $usage_list,                                         //用法
            'frequence_list' => $frequence_list,                                 //服用频次
        ]);
    }
    //审方开始
    public function actionPrescription_sf(){
        $new_time = date("Y-m-d H:i:s",time());
        $prescription_id =$_GET['prescription_id'];
        $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展（审方开始）
        $tbl_prescription_progress->prescription_id=$prescription_id;
        $tbl_prescription_progress->progress_id=2;
        $tbl_prescription_progress->created_at=$new_time;
        $tbl_prescription_progress->start_time=$new_time;
        $tbl_prescription_progress->save();
        $frequence =new TblUseFrequenceType();   //服用频次
        $frequence_list = $frequence
            ->find()
            ->asArray()
            ->all();
        $prescription = new TblPrescription();     //处方
        $prescription->updateAll(['prescription_status'=>15,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','doctor_id','piece','kinds_per_piece','production_type','notes','excessive_prescription','use_frequence','usage_id'))
            ->asArray()
            ->one();
        $prescription_photo = new TblPrescriptionPhoto(); //药方照片
        $prescription_photo_list = $prescription_photo
            ->find()
            ->where("prescription_id='$prescription_id' and photo_type=1")
            ->select(array('photo_img','photo_id'))
            ->asArray()
            ->all();
        $usage =new TblProductionUsage(); //药的用法用量
        $usage_list = $usage
            ->find()
            ->select(array('usage_id','usage_name'))
            ->asArray()
            ->all();
        $tbl_medicine = new TblMedicine();  //药材名称
        $medicine_list = $tbl_medicine
            ->find()
            ->select(array('medicine_name','medicine_id','pinyin'))
            ->asArray()
            ->all();
        foreach($medicine_list as $k=>$v){
            $medicine_id = $v['medicine_id'];
            $medicines_list[$medicine_id] = "renshen ".$v['medicine_name'];
        }
        $tbl_patient=new TblPatient();    //病人表
        $patient_list=$tbl_patient->find()
            ->where("prescription_id='$prescription_id'")
            ->asArray()
            ->one();
        $tbl_prescription_detail=new TblPrescriptionDetail();  //药材的用法用量
        $prescription_detail=$tbl_prescription_detail
            ->find()
            ->select(array('medicine_name','medicine_id','weight','medicine_photo','produce_frequence','is_excess','is_violation'))
            ->where("prescription_id='$prescription_id'")
            ->asArray()
            ->all();
        $tbl_produce_frequence_type = new TblProduceFrequenceType();       //中药制作顺序管理表
        $produce_frequence=$tbl_produce_frequence_type
            ->find()
            ->select(array('produce_frequence_type','produce_frequence_name'))
            ->asArray()
            ->all();
        return $this->renderPartial('prescriptionsf',[
            'produce_frequence' => $produce_frequence,                           //中药制作顺序
            'prescription_detail'=>$prescription_detail,                        //药材的用法用量
            'patient_list'=> $patient_list,                                      //病人信息
            'medicines_list'=> json_encode($medicines_list),                     //药材名称
            'prescription_list' => $prescription_list,                          //处方
            'prescription_photo_list' => $prescription_photo_list,             //处方照片
            'usage_list' => $usage_list,                                         //用法
            'frequence_list' => $frequence_list,                                 //服用频次
        ]);
    }
    //审方结束
    public function actionPrescription_sf_ok(){
        $rand= chr(rand(97, 122)).chr(rand(97, 122));
        $time= strtotime(date("Y-m-d H:i:s",time()));
        $medicine_id = "uad".$rand.$time;
        $patient_name = $_POST["patient_name"];                  //病人名字
        $gender =  $_POST['gender'];                               //性别
        $age =  $_POST['age'];                                     //年龄
        $piece =  $_POST['piece'];                                //副数
        $kinds_per_pieces =  $_POST['kinds_per_pieces'];        //味数
        $weight =  $_POST['weight'];                              //重量
        $produce_frequence = $_POST['produce_frequence'];       //制作方法
        $use_frequence =  $_POST['use_frequence'];              //服用频次
        $prescription_id =  $_POST['prescription_id'];          //药方ID
        $usage_id =  $_POST['usage_id'];                         //用法ID
        $medicine_id =  $_POST['medicine_id'];                  //药材ID
        $password_hash =  $_POST['password_hash'];              //操作人密码
        $new_time= date("Y-m-d H:i:s",time());
        $prescription = new TblPrescription();
        //药方修改
        $prescription_list=$prescription->find()->where(['prescription_id'=>$prescription_id])->one();
        $prescription_list->patient_name=$patient_name;
        $prescription_list-> piece= $piece;
        $prescription_list-> kinds_per_piece= $kinds_per_pieces;
        $prescription_list-> use_frequence= $use_frequence;
        $prescription_list-> prescription_status= 1;
        $prescription_list->updated_at=$new_time;
        $prescription_list->save();
        //病人添加
        $patient = new TblPatient();
        $patient_list=$patient->find()->where(['prescription_id'=>$prescription_id])->one();
        if(empty($patient_list)){
            $patient->patient_name=$patient_name;
            $patient->age=$age;
            $patient->gender=$gender;
            $patient->updated_at=$new_time;
            $patient->prescription_id=$prescription_id;
            $patient->save();
        }else{
            $patient_list->age=$age;
            $patient_list->gender=$gender;
            $patient_list->updated_at=$new_time;
            $prescription_list->save();
        }
        $produce_frequence = explode(",",$produce_frequence);
        $weight = explode(",",$weight);
        $medicine_id= explode(",",$medicine_id);
        //药放的用法用量
        $detail = new TblPrescriptionDetail();
       $detail->deleteAll(['prescription_id' => $prescription_id]);
        $i="";
        for($i=1;$i<count($medicine_id);$i++){
            $db=Yii::$app->db;
            $sql = "insert into tbl_prescription_detail(prescription_id,medicine_id,produce_frequence,weight,created_at)VALUES('$prescription_id','$medicine_id[$i]','$produce_frequence[$i]','$weight[$i]','$new_time')";
            $db->createCommand($sql)->execute();
        }
        $command = $db->createCommand("SELECT func_check_conflict_excess('$prescription_id')")->queryScalar();
        $tbl_prescription = new TblPrescription();                   //修改处方表的进度
        $tbl_prescription->updateAll(['prescription_status'=>20,'excessive_prescription'=>$command,'updated_at'=>$new_time],['prescription_id'=>$prescription_id]);
        $tbl_prescription_progress = new TblPrescriptionProgress();   //修改处方进度表
        $tbl_prescription_progress->updateAll(['end_time'=>$new_time,'updated_at'=>$new_time,'password_hash'=>$password_hash],['prescription_id'=>$prescription_id,'progress_id'=>2]);
        $progress = $this->progress($prescription_id);
        return $progress;
    }
    //复查开始
    public function actionPrescription_fc(){
        $new_time = date("Y-m-d H:i:s",time());
        $prescription_id =$_GET['prescription_id'];
        $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展（复查开始）
        $tbl_prescription_progress->prescription_id=$prescription_id;
        $tbl_prescription_progress->progress_id=5;
        $tbl_prescription_progress->created_at=$new_time;
        $tbl_prescription_progress->start_time=$new_time;
        $tbl_prescription_progress->save();
        $tbl_prescription = new TblPrescription();                   //修改处方表的进度
        $tbl_prescription->updateAll(['prescription_status'=>45,'updated_at'=>$new_time],['prescription_id'=>$prescription_id]);
        $prescription = new TblPrescription();     //处方
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type'))
            ->asArray()
            ->one();
        $tbl_progress_check = new TblProgressCheck();    //检查进展
        $progress_check_list = $tbl_progress_check
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('taken_type','photo'))
            ->asArray()
            ->all();
        $tbl_prescription_detail = new TblPrescriptionDetail();   //药的用法用量
        $prescription_detail_list = $tbl_prescription_detail
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('medicine_name','weight','medicine_id'))
            ->asArray()
            ->all();
        return $this->renderPartial('prescriptionfc',[
                'prescription_list' => $prescription_list,   //处方
                'progress_check_list' =>  $progress_check_list,   //检查进展
                'prescription_detail_list' => $prescription_detail_list   //药的用法用量
        ]);
    }
    //发现差错重新配药
    public function actionPrescription_del(){
        $prescription_id =$_GET['prescription_id'];
        $password_hash = $_GET['password_hash'];
        $progress = new TblPrescriptionProgress();
        $progress_list = $progress                        //查询错误的担当人
            ->find()
            ->where("prescription_id='$prescription_id' and progress_id= 3")
            ->select(array('password_hash'))
            ->asArray()
            ->one();
        $tbl_error_information= new TblErrorInformation();        //添加错误信息
        $tbl_error_information->prescription_id = $prescription_id;
        $tbl_error_information->progress_id = 3;
        $tbl_error_information->password_hash = $password_hash;
        $tbl_error_information->password_hashs = $progress_list['password_hash'];
        $prescription = new TblPrescription();    //处方
        $prescription->updateAll(['prescription_status'=>20,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
        $progress->deleteAll("prescription_id='$prescription_id' and progress_id>2");
        $progress = $this->progress($prescription_id);   //调用流程公用方法
        return $progress;
    }
    //复查点击切换图片
    public function actionPrescription_fc_photo(){
        $taken = $_GET['taken_type'];
        $prescription_id = $_GET['prescription_id'];
        $tbl_progress_check = new TblProgressCheck();    //检查进展
        $progress_check_list = $tbl_progress_check
            ->find()
            ->where("prescription_id='$prescription_id' and taken_type= '$taken'")
            ->select(array('taken_type','photo'))
            ->asArray()
            ->one();
        echo json_encode($progress_check_list);die;
    }
    //复查完成
    public function actionPrescription_ok(){
        $new_time = date("Y-m-d H:i:s",time());
        $password_hash = $_POST['password_hash'];
        $prescription_id = $_POST['prescription_id'];
        $tbl_prescription_progress = new TblPrescriptionProgress();   //修改处方进度表
        $tbl_prescription_progress->updateAll(['end_time'=>$new_time,'updated_at'=>$new_time,'password_hash'=>$password_hash],['prescription_id'=>$prescription_id,'progress_id'=>5]);
        $tbl_prescription = new TblPrescription();                   //修改处方表的进度
        $tbl_prescription->updateAll(['prescription_status'=>50,'updated_at'=>$new_time],['prescription_id'=>$prescription_id]);
        $progress = $this->progress($prescription_id);   //调用流程公用方法
        return $progress;
    }
    //流程公用方法
    function progress($prescription_id){
        $prescription = new TblPrescription();    //处方
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type'))
            ->asArray()
            ->one();
        $progress= new TblPrescriptionProgress();  //处方进度
        $progress_list = $progress
            ->find()
            ->where("prescription_id='$prescription_id'")
//            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type','notes'))
            ->asArray()
            ->all();
        for($i=0;$i<count($progress_list);$i++){
            $start_time = strtotime($progress_list[$i]['start_time']);
            $end_time = strtotime($progress_list[$i]['end_time']);
            $time_consuming = $end_time-$start_time;
            $remain = $time_consuming%86400;
            $hours = intval($remain/3600);
            $remains = $remain%3600;
            $mins = intval($remains/60);
            if($hours==0){
                $progress_list[$i]['time_consuming']=$mins."分";
            }else{
                $progress_list[$i]['time_consuming']=$hours."时".$mins."分";
            }
        }
        $progress_sum = count($progress_list);
        if($progress_sum>=4){
            $tbl_progress_check = new TblProgressCheck();    //检查进展
            $progress_check_list = $tbl_progress_check
                ->find()
                ->where("prescription_id='$prescription_id'")
                ->select(array('photo'))
                ->asArray()
                ->all();
        }else{
            $progress_check_list = "null";
        }
            return $this->renderPartial('progress',[
                    'prescription_list'=>$prescription_list,           //药方信息
                    'progress_check_list'=>json_encode($progress_check_list),       //检查照片
                    'progress_list'=>json_encode($progress_list),      //处方进度
                    'progress_sum' => $progress_sum                    //处方进度到第几步了
                ]
            );
    }
    //煎制开始
    public function actionPrescription_jz(){
        $new_time = date("Y-m-d H:i:s",time());
        $prescription_id = $_POST['prescription_id'];
        $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展（煎制开始还开始）
        $tbl_prescription_progress->prescription_id=$prescription_id;
        $tbl_prescription_progress->progress_id=6;
        $tbl_prescription_progress->created_at=$new_time;
        $tbl_prescription_progress->start_time=$new_time;
        $tbl_prescription_progress->save();
        $prescription = new TblPrescription();    //处方
        $prescription->updateAll(['prescription_status'=>55,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type'))
            ->asArray()
            ->one();
        return $this->renderPartial('prescriptionjz',['prescription_list'=>$prescription_list]);
    }
    //煎制添加
    public function actionPrescription_jz_add(){
        $prescription_id = $_POST['prescription_id'];                     //药方编号
        $password_hash = $_POST['password_hash'];                         //操作人密码
        $a_boiling_end_time = $_POST['a_boiling_end_time'];              //出药时间
        $a_quantity_check = $_POST['a_quantity_check'];                  //量确认
        $a_soup_appearance_check = $_POST['a_soup_appearance_check'];   //汤外观确认
        if($a_soup_appearance_check=="on"){
            $a_soup_appearance_check = 0;
        }else{
            $a_soup_appearance_check = 1;
        }
        $a_prescription_id_check = $_POST['b_boiling_start_time'];       //煎制后编号确认
        if($a_prescription_id_check=="on"){
            $a_soup_appearance_check = 0;
        }else{
            $a_soup_appearance_check = 1;
        }
        $b_boiling_start_time = $_POST['b_boiling_start_time'];          //下药时间
        $b_post_boiling = $_POST['b_post_boiling'];                       //后下
        if($b_post_boiling=="on"){
            $b_post_boiling=0;
        }else{
            $b_post_boiling=1;
        }
        $b_pre_boiling = $_POST['b_pre_boiling'];                         //先煎
        if($b_pre_boiling=="on"){
            $b_post_boiling=0;
        }else{
            $b_post_boiling=1;
        }
        $decocting_machine = $_POST['decocting_machine'];                 //煎药机
        $b_boiling_time = $_POST['b_boiling_time'];                        //煎制时间
        $b_pressure = $_POST['b_pressure'];                                 //压力
        $b_water_yield = $_POST['b_water_yield'];                           //用水量
        $b_appearance_check = $_POST['b_appearance_check'];                //外观确认
        if($b_appearance_check=="on"){
            $b_appearance_check=0;
        }else{
            $b_appearance_check=1;
        }
        $b_kinds_check = $_POST['b_kinds_check'];                           //味数确认
        if($b_kinds_check=="on"){
            $b_appearance_check=0;
        }else{
            $b_appearance_check=1;
        }
        $b_piece_check = $_POST['b_piece_check'];                           //副数确认
        $b_prescription_id_check = $_POST['b_prescription_id_check'];     //煎制前编号确认
        if($b_prescription_id_check=="on"){
            $b_prescription_id_check=0;
        }else{
            $b_prescription_id_check=1;
        }
        $p_soaking_time = $_POST['p_soaking_time'];                         //泡制时间
        $p_prescription_id_check = $_POST['p_prescription_id_check'];      //药方编号确认
        if($p_prescription_id_check = "on"){
            $p_prescription_id_check = 0;
        }else{
            $p_prescription_id_check= 1;
        }
//        $tbl_progress_boiling = new TblProgressBoiling();            //熬药流程添加
//        $tbl_progress_boiling ->prescription_id = $prescription_id;                  //药方编号
//        $tbl_progress_boiling ->password_hash = $password_hash;                        //操作人密码
//        $tbl_progress_boiling ->a_boiling_end_time=$a_boiling_end_time;               //出药时间
//        $tbl_progress_boiling ->a_quantity_check=$a_quantity_check;                   //量确认
//        $tbl_progress_boiling ->a_soup_appearance_check=$a_soup_appearance_check;    //汤外观确认
//        $tbl_progress_boiling ->a_prescription_id_check=$a_prescription_id_check;       //煎制后编号确认
//        $tbl_progress_boiling ->b_boiling_start_time=$b_boiling_start_time;           //下药时间
//        $tbl_progress_boiling ->b_post_boiling = $b_post_boiling;                        //后下
//        $tbl_progress_boiling ->b_pre_boiling=$b_pre_boiling;                           //先煎
//        $tbl_progress_boiling ->decocting_machine=$decocting_machine;                 //煎药机
//        $tbl_progress_boiling ->b_boiling_time=$b_boiling_time;                        //煎制时间
//        $tbl_progress_boiling ->b_pressure=$b_pressure;                                  //压力
//        $tbl_progress_boiling ->b_water_yield=$b_water_yield;                           //用水量
//        $tbl_progress_boiling ->b_appearance_check=$b_appearance_check;                //外观确认
//        $tbl_progress_boiling ->b_kinds_check=$b_kinds_check;                           //味数确认
//        $tbl_progress_boiling ->b_piece_check=$b_piece_check;                            //副数确认
//        $tbl_progress_boiling ->b_prescription_id_check=$b_prescription_id_check;      //煎制前编号确认
//        $tbl_progress_boiling ->p_soaking_time=$p_soaking_time;                           //泡制时间
//        $tbl_progress_boiling ->p_prescription_id_check=$p_prescription_id_check;       //药方编号确认
//        $tbl_progress_boiling ->progress_id=6;       //药方编号确认
//        $tbl_progress_boiling->save();
        $new_time = date("Y-m-d H:i:s",time());
        $db=Yii::$app->db;
        $sql = "insert into tbl_progress_boiling(prescription_id,a_boiling_end_time,a_quantity_check,a_soup_appearance_check,a_prescription_id_check,b_boiling_start_time,b_post_boiling,b_pre_boiling,decocting_machine,b_boiling_time,b_pressure,b_water_yield,b_appearance_check,b_kinds_check,b_piece_check,b_prescription_id_check,p_soaking_time,p_prescription_id_check,progress_id,created_at)VALUES('$prescription_id','$a_boiling_end_time','$a_quantity_check','$a_soup_appearance_check','$a_prescription_id_check','$b_boiling_start_time','$b_post_boiling','$b_pre_boiling','$decocting_machine','$b_boiling_time','$b_pressure','$b_water_yield','$b_appearance_check','$b_kinds_check','$b_piece_check','$b_prescription_id_check','$p_soaking_time','$p_prescription_id_check','6','$new_time')";
        $db->createCommand($sql)->execute();
        $prescription = new TblPrescription();    //处方
        $prescription->updateAll(['prescription_status'=>60,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
        $tbl_prescription_progress = new TblPrescriptionProgress();         //修改进程表的进展
        $tbl_prescription_progress->updateAll(['end_time'=>$new_time,'updated_at'=>$new_time,'password_hash'=>$password_hash],['prescription_id'=>$prescription_id,'progress_id'=>6]);
        $progress = $this->progress($prescription_id);   //调用流程公用方法
        return $progress;
    }
    //审方里的超量禁忌医师再度确认
    public function actionPhysician_confirmation()
    {
        $prescription_id = $_POST['prescription_id'];
        $doctor_id = "13683691417";
        $prescription_list['cood'] = "200";
        $prescription_list['msg'] = "接收成功";
        $list['prescription_id'] = $prescription_id;
        $list['message'] = "您有一副超量禁忌的药方请及时确认！";
        $prescription_list['data'] = $list;
        $lists = json_encode($prescription_list);
        require_once("/JPush/JPush.php");
        $app_key = 'a91d6c09b1e955cf232cd193';
        $master_secret = '67e15474e820d389e1f1d49b';
        $client = new JPush($app_key, $master_secret);
        $result = $client->push()
            ->setPlatform(array('ios', 'android'))
            ->addAlias('alias1')
            ->addTag(array('tag1', 'tag2'))
            ->setNotificationAlert('Hi, JPush')
            ->addAndroidNotification('Hi, android notification', 'notification title', 1, array("key1" => "value1", "key2" => "value2"))
            ->addIosNotification("Hi, iOS notification", 'iOS sound', JPush::DISABLE_BADGE, true, 'iOS category', array("key1" => "value1", "key2" => "value2"))
            ->setMessage("msg content", 'msg title', 'type', array("key1" => "value1", "key2" => "value2"))
            ->setOptions(100000, 3600, null, false)
            ->send();
    }
    //第七步配送开始
    public function actionPrescription_ps(){
        $prescription_id = $_POST['prescription_id'];
        $new_time = date("Y-m-d H:i:s");
        $prescription = new TblPrescription();    //处方
        $prescription->updateAll(['prescription_status'=>65,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
        $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展（配送开始）
        $tbl_prescription_progress->prescription_id=$prescription_id;
        $tbl_prescription_progress->progress_id=7;
        $tbl_prescription_progress->created_at=$new_time;
        $tbl_prescription_progress->start_time=$new_time;
        $tbl_prescription_progress->save();
        $prescription_list = $prescription         //处方信息
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type'))
            ->asArray()
            ->one();
        $prescription_photo = new TblPrescriptionPhoto(); //照片
        $prescriptiond_photo_list = $prescription_photo   //配送地址照片
            ->find()
            ->where("prescription_id='$prescription_id' and photo_type=2")
            ->select(array('photo_img','photo_id'))
            ->asArray()
            ->one();
        $patient = new TblPatient();                      //配送地址
        $patient_lists=$patient                           //地址信息
            ->find()
            ->where(['prescription_id'=>$prescription_id])
            ->select(array('address','mobile','addressee_name'))
            ->asArray()
            ->one();
        return $this->renderPartial('prescriptionps',[
                'patient_lists'=>$patient_lists,                    //地址信息
                'prescription_list'=>$prescription_list,           //药方信息
                'prescriptiond_photo_list'=>$prescriptiond_photo_list      //配送地址照片
            ]
        );
    }
    //第七步配送结束
    public function actionPrescription_ps_add(){
            $odd_numbers = $_POST['odd_numbers'];
            $prescription_id = $_POST['prescription_id'];
            $password_hash = $_POST['password_hash'];
            $new_time = date("Y-m-d H:i:s",time());
            $tbl_progress_distribution = new TblProgressDistribution();   //配送记录表
            $tbl_progress_distribution ->delivery_bill_number = $odd_numbers;
            $tbl_progress_distribution ->prescription_id = $prescription_id;
            $tbl_progress_distribution ->progress_id = 7;
            $tbl_progress_distribution ->created_at = $new_time;
            $tbl_progress_distribution ->save();
            $tbl_prescription_progress = new TblPrescriptionProgress();   //处方药的进展
            $tbl_prescription_progress->updateAll(['password_hash'=>$password_hash,'updated_at'=>$new_time,'end_time'=>$new_time],['prescription_id'=>$prescription_id,'progress_id'=>7]);
            $tbl_prescription_progress->prescription_id=$prescription_id;
            $tbl_prescription_progress->progress_id=8;
            $tbl_prescription_progress->password_hash=$password_hash;
            $tbl_prescription_progress->created_at=$new_time;
            $tbl_prescription_progress->start_time=$new_time;
            $tbl_prescription_progress->end_time=$new_time;
            $tbl_prescription_progress->save();
            $prescription = new TblPrescription();    //处方
            $prescription->updateAll(['prescription_status'=>80,],['prescription_id'=>$prescription_id,]);  //修改处方表的进展
            $progress = $this->progress($prescription_id);   //调用流程公用方法
            return $progress;
    }
}
