<?php
/**
 * 润衣阁客户页
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
use app\models\Tbldoctor;


class UserController extends Controller
{

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $datetime = $request->get('datetime');
        $yd = $request->get('yd');
        $firstletter=$request->get('firstletter');
        $hospital_name = $request->get('hospital_name');
        $patient_name = $request->get('patient_name');
        $where = "";
        if(empty($firstletter)) {
            if (!empty($hospital_name)) {
                $where .= "  hospital_name='$hospital_name'";
            } else if (!empty($patient_name)) {
                $where = "patient_name='$patient_name'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
            $where.="first_letter between '$beginfirst' and '$endfirst'";
        }
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        $yue = substr($date, 0, 7);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();

        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询出当天的客户的一些信息
        if (!empty($where)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'prescription_status', 'production_type', 'Prescription_status', 'price'))
                ->where($where)
                ->asArray()
                ->all();
        } elseif (!empty($yd)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where(" created_at like '$yue%'")
                ->asArray()
                ->all();
        } elseif (!empty($datetime)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where("created_at like '$datetime%'")
                ->asArray()
                ->all();
        } else {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where("created_at like '$date%'")
                ->asArray()
                ->all();
        }
        //根据结果统计出总共多少条数据 然后count 然后分页
        $zong = count($drr);
        $meiye = 6;
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        if (!empty($where)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price,prescription_id,prescription_status from tbl_prescription where $where
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        } elseif (!empty($yd)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where   created_at like '$yue%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();

        } elseif (!empty($datetime)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where   created_at like '$datetime%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        } else {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where   created_at like '$date%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        }
        //按照医馆名称进行分组 并统计出来每个医馆的数量
        $sqlfour = "SELECT hospital_name,count(hospital_name) from tbl_prescription where hospital_name!=''  GROUP BY hospital_name";
        $frr = $db->createCommand($sqlfour)->queryAll();
        return $this->renderPartial("index", ['date' => $date, 'datetime' => $datetime, 'crr' => $crr, 'drr' => $drr, 'frr' => $frr, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name, 'patient_name' => $patient_name, 'datetime' => $datetime,'firstletter'=>$firstletter]);
    }

    //根据医馆名称查询出属于该医馆医生的一些信息
    public function actionOne()
    {
        $request = Yii::$app->request;
        $firstletter=$request->get('firstletter');
        $yd = $request->get('yd');
        $hospital_name = $request->get('hospital_name');
        $patient_name = $request->get('patient_name');
        $datetime = $request->get('datetime');
        $where = "";
        if(empty($firstletter)) {
            if (!empty($hospital_name)) {
                $where .= "  hospital_name='$hospital_name'";
            } else if (!empty($patient_name)) {
                $where = "patient_name='$patient_name'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
         $where.="first_letter between '$beginfirst' and '$endfirst'";
        }
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        $yue = substr($date, 0, 7);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();
        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询出当天的客户的一些信息
        if (!empty($where)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'prescription_status', 'production_type', 'Prescription_status', 'price'))
                ->where($where)
                ->asArray()
                ->all();
        } elseif (!empty($yd)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where("doctor_name!=''and created_at like '$yue%'")
                ->asArray()
                ->all();
        } elseif (!empty($datetime)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where("doctor_name!=''and created_at like '$datetime%'")
                ->asArray()
                ->all();
        } else {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where("doctor_name!=''and created_at like '$date%'")
                ->asArray()
                ->all();
        }
        //根据结果统计出总共多少条数据 然后count 然后分页
        $zong = count($drr);
        $meiye = 6;
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        if (!empty($where)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price,prescription_id,prescription_status from tbl_prescription where $where
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        } elseif (!empty($yd)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where  created_at like '$yue%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        } elseif (!empty($datetime)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where  created_at like '$datetime%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        } else {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where doctor_name!=''and  created_at like '$date%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        }
        //按照医馆名称进行分组 并统计出来每个医馆的数量
        $sqlfour = "SELECT hospital_name,count(hospital_name) from tbl_prescription where hospital_name!=''  GROUP BY hospital_name";
        $frr = $db->createCommand($sqlfour)->queryAll();
        return $this->renderPartial("one", ['date' => $date, 'datetime' => $datetime, 'crr' => $crr, 'drr' => $drr, 'frr' => $frr, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name, 'patient_name' => $patient_name, 'datetime' => $datetime,'firstletter'=>$firstletter]);
    }

    //下载
    public function actionDown()
    {
        //下载每天的一些医师信息
        //header("content-type:text/html; charset=utf8");

        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=doctor.xls");
        $str = "";
        $str = "医馆名称\t药方编号\t医师名称\t付数\t味数\t金额\t备注\t原药/代煎\t状态\n";
        $datetwo = date('Y-m-d H:i:s', time());
        $date = substr($datetwo, 0, 10);
        $tbl = new TblPrescription();
        $drr = $tbl->find()
            ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
            ->where("doctor_name!=''and created_at like '$date%'")
            ->asArray()
            ->all();

        foreach ($drr as $k) {
            $str .= $k['hospital_name']."\t".$k['prescription_id'] . "\t" . $k['doctor_name'] . "\t" . $k['price'] . "\t" . $k['kinds_per_piece'] . "\t" . $k['piece'] . "\t" . $k['notes'] . "\t" . $k['production_type'] . "\t" . $k['Prescription_status'] . "\n";

        }
        echo iconv("utf-8", "gbk", $str);
    }

    //月度别
    public function actionYue()
    {
        $request = Yii::$app->request;
        $firstletter=$request->get('firstletter');
        $yd = $request->get('yd');
        $hospital_name = $request->get('hospital_name');
        $datetime = $request->get('datetime');
        $patient_name = $request->get('patient_name');
        $where = "";
        if(empty($firstletter)) {
            if (!empty($hospital_name)) {
                $where .= "  hospital_name='$hospital_name'";
            } else if (!empty($patient_name)) {
                $where = "patient_name='$patient_name'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
            $where.="first_letter between '$beginfirst' and '$endfirst'";
        }
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        $yue = substr($date, 0, 7);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();
        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询出当天的客户的一些信息
        if (!empty($where)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'prescription_status', 'production_type', 'Prescription_status', 'price'))
                ->where($where)
                ->asArray()
                ->all();
        } elseif (!empty($yd)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where(" created_at like '$yue%'")
                ->asArray()
                ->all();
        } else {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where("created_at like '$date%'")
                ->asArray()
                ->all();
        }
        //根据结果统计出总共多少条数据 然后count 然后分页
        $zong = count($drr);
        $meiye = 6;
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        if (!empty($where)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price,prescription_id,prescription_status from tbl_prescription where $where
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        } elseif (!empty($yd)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where  created_at like '$yue%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();

        } else {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where  created_at like '$date%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        }
        //按照医馆名称进行分组 并统计出来每个医馆的数量
        $sqlfour = "SELECT hospital_name,count(hospital_name) from tbl_prescription where hospital_name!=''  GROUP BY hospital_name";
        $frr = $db->createCommand($sqlfour)->queryAll();
        return $this->renderPartial("yue", ['date' => $date, 'datetime' => $datetime, 'crr' => $crr, 'drr' => $drr, 'frr' => $frr, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name, 'patient_name' => $patient_name,'firstletter'=>$firstletter]);
    }

    //客户信息
    public function actionKehu()
    {
        $request = Yii::$app->request;
        $hospital_name = $request->get('hospital_name');
        //实例化一个医院表
        $tbl_hos = new TblHospital();
        $arr = $tbl_hos->find()->where("hospital_name='$hospital_name'")->asArray()->one();

        if (empty($arr)) {
            return $this->renderPartial("kehuno");
        }
        //通过医院表里的医生主馆id查询出他的一些其他信息
        //实例一个医生表
        $doctor_id = $arr['main_account_id'];
        $tbl_doctor = new TblDoctor();
        $crr = $tbl_doctor->find()->select(array('doctor_phone', 'created_at', 'doctor_name'))->where("doctor_id='$doctor_id'")->asArray()->one();
        if (empty($crr)) {
            return $this->renderPartial("kehuno");
        }
        if (!empty($crr)) {
            $arr['doctor_phone'] = $crr['doctor_phone'];
            $arr['created_at'] = $crr['created_at'];
            $arr['doctor_name'] = $crr['doctor_name'];
        }

        //查询出这个医馆下的医生
        $brr = $tbl_doctor->find()->where("hospital_name='$hospital_name'")->asArray()->all();
        $arr['brr'] = $brr;
        if (empty($brr)) {
            return $this->renderPartial("kehuno");
        }
        return $this->renderPartial("kehu", ['arr' => $arr]);
    }

    //下载月度
    public function actionDownyuedu()
    {
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=doctor.xls");
        $str = "";
        $str = "医馆名称\t药方编号\t医师名称\t付数\t味数\t金额\t备注\t原药/代煎\t状态\n";
        $datetwo = date('Y-m-d H:i:s', time());
        $date = substr($datetwo, 0, 10);
        $yue = substr($date, 0, 7);
        $tbl = new TblPrescription();
        $drr = $tbl->find()
            ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
            ->where(" created_at like '$yue%'")
            ->asArray()
            ->all();

        foreach ($drr as $k) {
            $str .= $k['hospital_name']."\t".$k['prescription_id'] . "\t" . $k['doctor_name'] . "\t" . $k['price'] . "\t" . $k['kinds_per_piece'] . "\t" . $k['piece'] . "\t" . $k['notes'] . "\t" . $k['production_type'] . "\t" . $k['Prescription_status'] . "\n";

        }
        echo iconv("utf-8", "gbk", $str);
    }

    public function actionDoctordata()
    {
        $request = Yii::$app->request;
        $doctor_name=$request->get('doctor_name');
        $firstletter=$request->get('firstletter');
        //先接收一个医馆名称
        $hospital_name = $request->get('hospital_name');
        //根据这个医馆名称然后 查询出该医馆的所有医生
        $datetime=$request->get('datetime');
        $db = Yii::$app->db;
        $sql = "SELECT doctor_name,hospital_name from tbl_prescription where hospital_name='$hospital_name' GROUP BY doctor_name";
        $qq = $db->createCommand($sql)->queryAll();
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();
        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询当天数据
        $where = "";
        if(empty($firstletter)) {
            if (empty($datetime)) {

                $where .= "hospital_name='$hospital_name' and created_at like '$date%'";
                if (!empty($doctor_name)) {
                    $where .= " and doctor_name='$doctor_name'";
                }
            } else {

                $where .= "hospital_name='$hospital_name' and created_at like '$datetime%'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
            $where.="hospital_name='$hospital_name' and first_letter between '$beginfirst' and '$endfirst'";
        }
        $ww = $tblprescription->find()->where($where)->asArray()->all();
        //取总
        $zong = count($ww);
        //每页几个
        $meiye = 6;
        //取整
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        $sqlww = "select * from tbl_prescription where $where limit $pianyi,$meiye";
        $ww = $db->createCommand($sqlww)->queryAll();
        return $this->renderPartial("doctordata", ['date' => $date, 'firstletter'=>$firstletter,'crr' => $crr, 'qq' => $qq, 'ww' => $ww, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name,'doctor_name'=>$doctor_name,'datetime'=>$datetime]);
    }
    //根据左侧的医生姓名然后匹配数据
    public function actionDoctordatatwo(){
        $request = Yii::$app->request;
        //接收医生名称
        $doctor_name=$request->get('doctor_name');
        $datetime=$request->get('datetime');
        $firstletter=$request->get('firstletter');
        //先接收一个医馆名称
        $hospital_name = $request->get('hospital_name');
        //根据这个医馆名称然后 查询出该医馆的所有医生
        $db = Yii::$app->db;
        $sql = "SELECT doctor_name,hospital_name from tbl_prescription where hospital_name='$hospital_name' GROUP BY doctor_name";
        $qq = $db->createCommand($sql)->queryAll();
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();
        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询当天数据
        $where = "";
        if(empty($firstletter)) {
            if (empty($datetime)) {

                $where .= "hospital_name='$hospital_name' and created_at like '$date%'";
                if (!empty($doctor_name)) {
                    $where .= " and doctor_name='$doctor_name'";
                }
            } else {

                $where .= "hospital_name='$hospital_name' and created_at like '$datetime%'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
            $where.="hospital_name='$hospital_name' and first_letter between '$beginfirst' and '$endfirst'";
        }
        $ww = $tblprescription->find()->where($where)->asArray()->all();
        //取总
        $zong = count($ww);
        //每页几个
        $meiye = 6;
        //取整
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        $sqlww = "select * from tbl_prescription where $where limit $pianyi,$meiye";
        $ww = $db->createCommand($sqlww)->queryAll();
        return $this->renderPartial("doctordatatwo", ['date' => $date, 'firstletter'=>$firstletter,'crr' => $crr, 'qq' => $qq, 'ww' => $ww, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name,'doctor_name'=>$doctor_name,'datetime'=>$datetime]);
    }
    //医师信息
    public function actionDoctorinfo(){
        $request=Yii::$app->request;
        $doctor_name=$request->get('doctor_name');
        $hospital_name=$request->get('hospital_name');

        //根据医生名称和医馆名称查询出该医生的一些信息
        $tbl_doctor=new TblDoctor();
        $arr=$tbl_doctor->find()->where("hospital_name='$hospital_name' and doctor_name='$doctor_name'")->asarray()->all();
        return $this->renderPartial("doctorinfo",['arr'=>$arr]);
    }
    //下载当前医馆今日的数据
public function actionDownthree(){
    $request=Yii::$app->request;
    $hospital_name=$request->get('hospital_name');
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=doctor.xls");
    $str = "";
    $str = "医馆名称\t药方编号\t医师名称\t付数\t味数\t金额\t备注\t原药/代煎\t状态\n";
    $datetwo = date('Y-m-d H:i:s', time());
    $date = substr($datetwo, 0, 10);
    $yue = substr($date, 0, 7);
    $tbl = new TblPrescription();
    $drr = $tbl->find()
        ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
        ->where(" created_at like '$date%' and hospital_name='$hospital_name'")
        ->asArray()
        ->all();

    foreach ($drr as $k) {
        $str .= $k['hospital_name']."\t".$k['prescription_id'] . "\t" . $k['doctor_name'] . "\t" . $k['price'] . "\t" . $k['kinds_per_piece'] . "\t" . $k['piece'] . "\t" . $k['notes'] . "\t" . $k['production_type'] . "\t" . $k['Prescription_status'] . "\n";

    }
    echo iconv("utf-8", "gbk", $str);
}
    //医师数据的月度
    public function actionDoctordatayue(){
        $request = Yii::$app->request;
        $doctor_name=$request->get('doctor_name');
        $firstletter=$request->get('firstletter');
        //先接收一个医馆名称
        $hospital_name = $request->get('hospital_name');
        //根据这个医馆名称然后 查询出该医馆的所有医生
        $datetime=$request->get('datetime');
        $db = Yii::$app->db;
        $sql = "SELECT doctor_name,hospital_name from tbl_prescription where hospital_name='$hospital_name' GROUP BY doctor_name";
        $qq = $db->createCommand($sql)->queryAll();
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        $yue=substr($date,0,7);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();
        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询当月数据
        $where = "";
        if(empty($firstletter)) {
            if (empty($datetime)) {

                $where .= "hospital_name='$hospital_name' and created_at like '$yue%'";
                if (!empty($doctor_name)) {
                    $where .= " and doctor_name='$doctor_name'";
                }
            } else {

                $where .= "hospital_name='$hospital_name' and created_at like '$datetime%'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
            $where.="hospital_name='$hospital_name' and first_letter between '$beginfirst' and '$endfirst'";
        }
        $ww = $tblprescription->find()->where($where)->asArray()->all();
        //取总
        $zong = count($ww);
        //每页几个
        $meiye = 6;
        //取整
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        $sqlww = "select * from tbl_prescription where $where limit $pianyi,$meiye";

        $ww = $db->createCommand($sqlww)->queryAll();

        return $this->renderPartial("doctordatayue", ['date' => $date,'firstletter'=>$firstletter, 'crr' => $crr, 'qq' => $qq, 'ww' => $ww, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name,'doctor_name'=>$doctor_name,'datetime'=>$datetime]);
    }
    //下载该医馆该月的数据
    public function actionDownfour(){
        $request=Yii::$app->request;
        $hospital_name=$request->get('hospital_name');
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=doctor.xls");
        $str = "";
        $str = "医馆名称\t药方编号\t医师名称\t付数\t味数\t金额\t备注\t原药/代煎\t状态\n";
        $datetwo = date('Y-m-d H:i:s', time());
        $date = substr($datetwo, 0, 10);
        $yue = substr($date, 0, 7);
        $tbl = new TblPrescription();
        $drr = $tbl->find()
            ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
            ->where(" created_at like '$yue%' and hospital_name='$hospital_name'")
            ->asArray()
            ->all();

        foreach ($drr as $k) {
            $str .= $k['hospital_name']."\t".$k['prescription_id'] . "\t" . $k['doctor_name'] . "\t" . $k['price'] . "\t" . $k['kinds_per_piece'] . "\t" . $k['piece'] . "\t" . $k['notes'] . "\t" . $k['production_type'] . "\t" . $k['Prescription_status'] . "\n";

        }
        echo iconv("utf-8", "gbk", $str);
    }
    public function actionDoctordatayuetwo(){
        $request = Yii::$app->request;
        $doctor_name=$request->get('doctor_name');
        $firstletter=$request->get('firstletter');
        //先接收一个医馆名称
        $hospital_name = $request->get('hospital_name');
        //根据这个医馆名称然后 查询出该医馆的所有医生
        $datetime=$request->get('datetime');
        $db = Yii::$app->db;
        $sql = "SELECT doctor_name,hospital_name from tbl_prescription where hospital_name='$hospital_name' GROUP BY doctor_name";
        $qq = $db->createCommand($sql)->queryAll();
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        $yue=substr($date,0,7);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();
        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询当月数据
        $where = "";
        if(empty($firstletter)) {
            if (empty($datetime)) {

                $where .= "hospital_name='$hospital_name' and created_at like '$yue%'";
                if (!empty($doctor_name)) {
                    $where .= " and doctor_name='$doctor_name'";
                }
            } else {

                $where .= " hospital_name='$hospital_name' and  created_at like '$datetime%'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
            $where.="hospital_name='$hospital_name' and first_letter between '$beginfirst' and '$endfirst'";
        }
        $ww = $tblprescription->find()->where($where)->asArray()->all();
        //取总
        $zong = count($ww);
        //每页几个
        $meiye = 6;
        //取整
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        $sqlww = "select * from tbl_prescription where $where limit $pianyi,$meiye";

        $ww = $db->createCommand($sqlww)->queryAll();

        return $this->renderPartial("doctordatayuetwo", ['date' => $date,'firstletter'=>$firstletter, 'crr' => $crr, 'qq' => $qq, 'ww' => $ww, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name,'doctor_name'=>$doctor_name,'datetime'=>$datetime]);
    }
    //月two
    public function actionYuetwo(){
        $request = Yii::$app->request;
        $firstletter=$request->get('firstletter');
        $yd = $request->get('yd');
        $hospital_name = $request->get('hospital_name');
        $datetime = $request->get('datetime');
        $patient_name = $request->get('patient_name');
        $where = "";
        if(empty($firstletter)) {
            if (!empty($hospital_name)) {
                $where .= "  hospital_name='$hospital_name'";
            } else if (!empty($patient_name)) {
                $where = "patient_name='$patient_name'";
            }
        }else{
            $aa=explode("-",$firstletter);
            $beginfirst=$aa[0];
            $endfirst=$aa[1];
            $where.="first_letter between '$beginfirst' and '$endfirst'";
        }
        //实例化一个药方表
        $tblprescription = new TblPrescription();
        //首先需要查出首页的的客户数和医师数量
        //获取当前日期
        $date = date('Y-m-d H:i:s', time());
        $date = substr($date, 0, 10);
        $yue = substr($date, 0, 7);
        //然后根据当前的日期获取当日的客户数量和医师数量
        //实例化一个db
        $db = Yii::$app->db;
        //查询出今天的客户数
        $sql = "SELECT * from tbl_prescription where hospital_name!=''and created_at like '$date%' GROUP BY hospital_name ";
        $arr = $db->createCommand($sql)->queryAll();
        $aa = count($arr);
        //查询出今天的医师数量
        $sqltwo = "SELECT * from tbl_prescription where doctor_name!=''and created_at like '$date%' GROUP BY doctor_name";
        $brr = $db->createCommand($sqltwo)->queryAll();
        $bb = count($brr);
        $crr = array();
        $crr['arr'] = $aa;
        $crr['brr'] = $bb;
        //查询出当天的客户的一些信息
        if (!empty($where)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'prescription_status', 'production_type', 'Prescription_status', 'price'))
                ->where($where)
                ->asArray()
                ->all();
        } elseif (!empty($yd)) {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where(" created_at like '$yue%'")
                ->asArray()
                ->all();
        } else {
            $drr = $tblprescription->find()
                ->select(array('prescription_id', 'hospital_name', 'prescription_status', 'doctor_name', 'kinds_per_piece', 'piece', 'notes', 'production_type', 'Prescription_status', 'price'))
                ->where("created_at like '$date%'")
                ->asArray()
                ->all();
        }
        //根据结果统计出总共多少条数据 然后count 然后分页
        $zong = count($drr);
        $meiye = 6;
        $quzheng = ceil($zong / $meiye);
        //判断当前页
        if (empty($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        //偏移量
        $pianyi = ($page - 1) * $meiye;
        if (!empty($where)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price,prescription_id,prescription_status from tbl_prescription where $where
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        } elseif (!empty($yd)) {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where  created_at like '$yue%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();

        } else {
            $sqlfive = "SELECT prescription_id
        ,hospital_name
        ,doctor_name
        ,piece,kinds_per_piece
        ,notes,production_type
        ,Prescription_status
        ,price
         ,doctor_id
         ,prescription_id,prescription_status
         from tbl_prescription where  created_at like '$date%'
        limit $pianyi,$meiye  ";
            $drr = $db->createCommand($sqlfive)->queryAll();
        }
        //按照医馆名称进行分组 并统计出来每个医馆的数量
        $sqlfour = "SELECT hospital_name,count(hospital_name) from tbl_prescription where hospital_name!=''  GROUP BY hospital_name";
        $frr = $db->createCommand($sqlfour)->queryAll();
        return $this->renderPartial("yue", ['date' => $date, 'datetime' => $datetime, 'crr' => $crr, 'drr' => $drr, 'frr' => $frr, 'quzheng' => $quzheng, 'hospital_name' => $hospital_name, 'patient_name' => $patient_name,'firstletter'=>$firstletter]);
    }
}
