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
use app\models\TblPatient;
use app\models\TblPrescriptionDetail;
use app\models\TblPrescriptionPhoto;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TblPrescription;//药方表
use  yii\data\Pagination;//yii框架内置的分页类
use  app\models\TblHospital;//医院表
use app\models\TblDailyStatistics;//每日的统计表
use app\models\TblPrescriptionUnhandledByPatient;//未经处理的病人处方数
use  Qiniu\Auth;
use Qiniu\Storage\UploadManager;


class CenterController extends Controller
{
    //润衣阁楼
    public function actionIndex(){
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
            $already="prescription_status <7";
        }else{
            $already="prescription_status = 7";

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
            $aa="prescription_status <7";
        }else{
            $aa="prescription_status = 7";
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
            $already="prescription_status <7";
        }else{
            $already="prescription_status = 7";

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
            $aa="prescription_status <7";
        }else{
            $aa="prescription_status = 7";
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
    //测试websocket
    public function actionWebsocket(){
        return $this->render("websocket");
    }
    public function actionTowebsocket(){
        return $this->render("towebsocket");
    }
    public function actionFf(){
        $date=date('Y-m-d H:i:s',time());
        $date=substr($date,0,10);
        $yue=substr($date,0,7);
        echo $date;
        echo "<br>";
        echo $yue;
    }
    //流程主页
    public function actionTechnological(){
        $prescription_id =$_GET['prescription_id'];
        $prescription = new TblPrescription();    //处方
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type','notes'))
            ->asArray()
            ->one();
        $progress= new TblPrescriptionProgress();  //处方进度
        $progress_list = $progress
            ->find()
            ->where("prescription_id='$prescription_id'")
//            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type','notes'))
            ->asArray()
            ->all();
        $progress_sum = count($progress_list);
        return $this->renderPartial('progress',[
                'prescription_list'=>$prescription_list,
                'progress_list'=>json_encode($progress_list),
                'progress_sum' => $progress_sum
            ]
        );
    }
    //药方添加页面
    public function actionPrescription_add(){
        $prescription_id =$_GET['prescription_id'];
        $prescription = new TblPrescription();     //处方
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type','notes'))
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
        return $this->renderPartial('prescriptionadd',[
            'prescription_list' => $prescription_list,                          //处方
            'prescription_photo_list' => $prescription_photo_list,             //处方照片
            'usage_list' => $usage_list,                                         //用法
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
        $weiht =  $_POST['weight'];                              //重量
        $produce_frequence = $_POST['produce_frequence'];     //制作方法
        $use_frequence =  $_POST['use_frequence'];              //服用频次
        $password_hash =  $_POST['password_hash'];              //操作人密码
        $prescription_id =  $_POST['prescription_id'];          //药方ID
        $usage_id =  $_POST['usage_id'];                         //用法ID
        $medicine_name =  $_POST['medicine_name'];              //药名
        $new_time= date("Y-m-d H:i:s",time());
        $prescription = new TblPrescription();
        //药方添加
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
        //药放的用法用量
//        $detail = new TblPrescriptionDetail();
//        $i="";
//        for($i=0;$i<count($medicine_id);$i++){
//            $detail-> prescription_id = $prescription_id;
//            $detail-> produce_frequence = $produce_frequence[$i];
//            $detail-> weight = $weight[$i];
//            $detail-> created_at = $new_time;
//        }
        $prescription_photo = new TblPrescriptionPhoto(); //药方照片
        $prescription_photo_list = $prescription_photo
            ->find()
            ->where("prescription_id='$prescription_id' and photo_type=2")
            ->select(array('photo_img','photo_id'))
            ->asArray()
            ->one();
        $prescription_list = $prescription
            ->find()
            ->where("prescription_id='$prescription_id'")
            ->select(array('prescription_id','hospital_name','doctor_name','piece','kinds_per_piece','production_type'))
            ->asArray()
            ->one();
        $list['prescription_photo_list'] = $prescription_photo_list;
        $list['prescription_list'] = $prescription_list;
        echo json_encode($list);die;
    }
}

