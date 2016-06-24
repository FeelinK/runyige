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
        $tbl_role=new TblRole();
        $role=$tbl_role->find()->asArray()->all();
        //按照员工分组
        $sql="select  staff_id,staff_name from tbl_staff GROUP BY staff_name";
        $arr=$db->createCommand($sql)->queryAll();
     return $this->renderPartial("index",['arr'=>$arr,'role'=>$role]);
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

        $a=$_FILES['a'];
        if(empty($a['tmp_name'])){
            echo "1";die;
        }
        $name="o7eryb4fl.bkt.clouddn.com/".time().".jpg";
        $mv=time().".jpg";
        move_uploaded_file($a['tmp_name'],"up/".$mv);

        //echo "up/".$name;
        require 'php-sdk-master/autoload.php';
        // 要上传的空间
        $bucket = 'runyige-bucket';
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = 'w2fkBssYidWHBhS7WuVe8PqrIsTrdLcuLE6Vq4_8';
        $secretKey = 'zC-vQhYqipkIEBpWXA3AlddM6ldk5qvVRamPKboK';
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径

        $filePath ="up/".$mv;
        // 上传到七牛后保存的文件名
        $key = $mv;
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        echo $mv;
    }
    //验证密码,手机号,用户名的唯一
    public function actionPwdonly(){
        $tbl_staff=new TblStaff();
        $request=Yii::$app->request;
        $addpassword_hash=$request->get('addpassword_hash');
        $addmobile=$request->get('addmobile');
        $addstaff_name=$request->get('addstaff_name');
        $arr=$tbl_staff->find()->where("mobile='$addmobile'")->asArray()->one();
        $brr=$tbl_staff->find()->where("staff_name='$addstaff_name'")->asArray()->one();
        $crr=$tbl_staff->find()->where("password_hash='$addpassword_hash'")->asArray()->one();
        if(!empty($arr)){
            echo "1";die;
        }
        if(!empty($brr)){
            echo "2";die;
        }
        if(!empty($crr)){
            echo "3";die;
        }

    }
    //添加员工
    public function actionAddstaff(){
        //print_r($_GET);die;
        $request=Yii::$app->request;
        $addpassword_hash=$request->get('addpassword_hash');
        $addmobile=$request->get('addmobile');
        $addstaff_name=$request->get('addstaff_name');
        $addimg=$request->get('addimg');
        $img="http://o7eryb4fl.bkt.clouddn.com/".$addimg;
        $addrole_id=$request->get('addrole_id');
        $tbl_staff=new TblStaff();
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
        $pinyin=new \Pinyin();
        $first_letter=$pinyin->getShortPinyin($addstaff_name);
        $first_letter=substr($first_letter,0,1);
        $date=date('Y-m-d H:i:s',time());
//        $tbl_staff->role_id=$addrole_id;
//        $tbl_staff->staff_name=$addstaff_name;
//        $tbl_staff->mobile=$addmobile;
//        $tbl_staff->created_at=$date;
//        $tbl_staff->first_letter=$first_letter;
//        $tbl_staff->password_hash=$addpassword_hash;
//        $tbl_staff->photo=$img;
//        if($tbl_staff->save()){
//            echo "1";
//        }
        $db=Yii::$app->db;
        $sql="insert into tbl_staff(staff_name,role_id,photo,created_at,mobile,password_hash,first_letter)
      VALUES ('$addstaff_name','$addrole_id','$img','$date','$addmobile','$addpassword_hash','$first_letter')
      ";
        $arr=$db->createCommand($sql)->query();
        if($arr){
            echo "1";
        }
    }
//修改员工信息
public function actionUpstafftwo(){
    $tbl_role=new TblRole();
    $role=$tbl_role->find()->asArray()->all();
    $request=Yii::$app->request;
    $staff_id=$request->get('staff_id');
    $tbl_staff=new TblStaff();
    $arr=$tbl_staff->find()->where("staff_id='$staff_id'")->asArray()->one();
    return $this->renderPartial("upstafftwo",['arr'=>$arr,'role'=>$role]);
}
    //修改
    public function actionUpstaffthree(){
        $request=Yii::$app->request;
        $staff_id=$request->get('staff_id');
        $addpassword_hash=$request->get('addpassword_hash');
        $addmobile=$request->get('addmobile');
        $addstaff_name=$request->get('addstaff_name');
        $addimg=$request->get('addimg');
        $img="http://o7eryb4fl.bkt.clouddn.com/".$addimg;
        $addrole_id=$request->get('addrole_id');
        $tbl_staff=new TblStaff();
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
        $pinyin=new \Pinyin();
        $first_letter=$pinyin->getShortPinyin($addstaff_name);
        $first_letter=substr($first_letter,0,1);
        $date=date('Y-m-d H:i:s',time());
        $aa=$tbl_staff->updateAll(['updated_at'=>$date,'first_letter'=>$first_letter,'mobile'=>$addmobile,'photo'=>$img,'password_hash'=>$addpassword_hash,'staff_name'=>$addstaff_name,'role_id'=>$addrole_id],['staff_id'=>$staff_id]);
        if($aa){
            echo "1";
        }

    }

}
