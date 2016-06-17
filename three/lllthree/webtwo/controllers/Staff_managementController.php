<?php
/**
 * 润衣阁员工管理
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
use app\models\TblStaff;
use app\models\TblRole;


class Staff_managementController extends Controller
{
    public $enableCsrfValidation =false;

    public function actionIndex()
    {
        $db=Yii::$app->db;
        $request=Yii::$app->request;
        //按照员工分组
        $sql="select  staff_id,staff_name from tbl_staff GROUP BY staff_name";
        $arr=$db->createCommand($sql)->queryAll();
     return $this->renderPartial("index",['arr'=>$arr]);
    }
    //根据首字母然后匹配数据
    public function actionSearch(){
        $request=Yii::$app->request;
        $first_letter=$request->get('first_letter');
        $db=Yii::$app->db;
       $where="";
        if(!empty($first_letter)){
            $aa=explode("-",$first_letter);
            $begin=$aa[0];
            $end=$aa[1];
            $where.="first_letter between '$begin' and '$end'";
        }
        //按照员工分组
        $sql="select  staff_id,staff_name from tbl_staff where $where GROUP BY staff_name";
        $arr=$db->createCommand($sql)->queryAll();
        return $this->renderPartial("search",['arr'=>$arr]);
    }
    //基本信息
public function actionDetail(){
    $request=Yii::$app->request;
    $staff_id=$request->get('staff_id');
    $tbl_staff=new TblStaff();
    $tbl_role=new TblRole();
    //根据员工id查询我的员工表
    $brr=$tbl_staff->find()->where("staff_id='$staff_id'")->asArray()->one();
   return $this->renderPartial("detail",['brr'=>$brr]);
}
    //删除员工
    public function actionDelstaff(){
        $request=Yii::$app->request;
        $staff_id=$request->get('staff_id');
        $tbl_staff=new TblStaff();
        $arr=$tbl_staff->deleteAll(['staff_id'=>$staff_id]);
        echo "1";
    }

    public function actionAbcd(){
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/bb.php');
        $abcd=new \abcd();
        $str="人参";
        $str= iconv("utf-8","gbk", $str);
        $char_index= $abcd::strr($str);

    }
    public function actionUpload(){
        require 'php-sdk-master/autoload.php';
        $bucket = 'runyige-bucket';
        $accessKey = 'w2fkBssYidWHBhS7WuVe8PqrIsTrdLcuLE6Vq4_8';
        $secretKey = 'zC-vQhYqipkIEBpWXA3AlddM6ldk5qvVRamPKboK';
        $auth = new Auth($accessKey, $secretKey);
        $upToken = $auth->uploadToken($bucket);
        return $this->renderPartial("upload",['token'=>$upToken]);
    }
    public function actionUploadtwo(){
//HTTP上传文件的开关，默认为ON即是开
        ini_set('file_uploads','ON');
//通过POST、GET以及PUT方式接收数据时间进行限制为90秒 默认值：60
        ini_set('max_input_time','90');
//脚本执行时间就由默认的30秒变为180秒
        ini_set('max_execution_time', '180');
//正在运行的脚本大量使用系统可用内存,上传图片给多点，最好比post_max_size大1.5倍
        ini_set('memory_limit','200M');
        if(!is_dir(dirname(__FILE__) . '/upload')) {
            mkdir(dirname(__FILE__) . '/upload');
        }
        $file_path = dirname(__FILE__) . "/upload/".$_FILES['FileData']['name'];
        $returnMsg="{status:true}";
        move_uploaded_file( $_FILES["FileData"]["tmp_name"], $file_path);
        echo $returnMsg;



    }
}
