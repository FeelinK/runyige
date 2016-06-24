<?php
/**
 * 润衣阁客户管理
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
use app\models\TblClearDay;


class Customer_managementController extends Controller
{
    public function actionIndex()
    {
        //查询结算方式
        $tbl_clear_day = new TblClearDay();
        $clearday = $tbl_clear_day->find()->asArray()->all();
        $request = Yii::$app->request;
        $hospital_name = $request->get('hospital_name');
        //实例化一个医院表
        $tblhospital = new TblHospital();
        $db = Yii::$app->db;
        $where = "";
        if (!empty($hospital_name)) {
            $where .= "hospital_name like '$hospital_name%'";
        }
        if (empty($where)) {
            $where = "1=1";
        }
        //通过查询医院表然后获取医馆名称  然后点击医馆名称然后获取信息
        $sql = "select  hospital_name,hospital_id,main_account_id  from tbl_hospital where $where  GROUP BY hospital_name";
        $arr = $db->createCommand($sql)->queryAll();
        return $this->renderPartial("index", ['arr' => $arr, 'hospital_name' => $hospital_name, 'clearday' => $clearday]);
    }

    //基本信息详情
    public function actionDetail()
    {
        $request = Yii::$app->request;
        //接收主账户id然后和tbl_doctor匹配信息
        $main_account_id = $request->get('main_account_id');
        //实例化一个医生表
        $tbl_doctor = new TblDoctor();
        $brr = $tbl_doctor->find()->where("doctor_id='$main_account_id'")->asArray()->one();
        //然后查询医院表
        $tblhospital = new TblHospital();
        $crr = $tblhospital->find()->where("main_account_id='$main_account_id'")->asArray()->one();
        $drr = array();

        if (!empty($brr) && !empty($crr)) {
            $drr['doctor_name'] = $brr['doctor_name'];
            $drr['mobile'] = $brr['mobile'];
            $drr['doctor_phone'] = $brr['doctor_phone'];
            $drr['hospital_name'] = $crr['hospital_name'];
            $drr['created_at'] = $crr['created_at'];
            $drr['clearing_date'] = $crr['clearing_date'];
            $drr['profit_margine'] = $crr['profit_margine'];
            $drr['address'] = $crr['address'];
        } else {
            $drr = array();
        }

        return $this->renderPartial("detail", ['drr' => $drr, 'main_account_id' => $main_account_id]);
    }

    //修改我的基本信息
    public function actionUpinfo()
    {
        //查询结算方式
        $tbl_clear_day = new TblClearDay();
        $clearday = $tbl_clear_day->find()->asArray()->all();
        $request = Yii::$app->request;
        $main_account_id = $request->get('main_account_id');
        //实例化一个医生表
        $tbl_doctor = new TblDoctor();
        $brr = $tbl_doctor->find()->where("doctor_id='$main_account_id'")->asArray()->one();
        //然后查询医院表
        $tblhospital = new TblHospital();
        $crr = $tblhospital->find()->where("main_account_id='$main_account_id'")->asArray()->one();
        $drr = array();

        if (!empty($brr) && !empty($crr)) {
            $drr['doctor_name'] = $brr['doctor_name'];
            $drr['mobile'] = $brr['mobile'];
            $drr['doctor_phone'] = $brr['doctor_phone'];
            $drr['hospital_name'] = $crr['hospital_name'];
            $drr['created_at'] = $crr['created_at'];
            $drr['clearing_date'] = $crr['clearing_date'];
            $drr['profit_margine'] = $crr['profit_margine'];
            $drr['address'] = $crr['address'];
        } else {
            $drr = array();
        }

        return $this->renderPartial("upinfo", ['drr' => $drr, 'main_account_id' => $main_account_id,'clearday'=>$clearday]);
    }
    //修改我的信息第二步拿到信息
    public function actionUpinfotwo(){
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
        $pinyin=new \Pinyin();
        $request = Yii::$app->request;
        $date = date('Y-m-d H:i:s', time());
        $h_name = $request->get('h_name');
        $h_address = $request->get('h_address');
        $main_account_id = $request->get('main_account_id');
        $doctor_name = $request->get('doctor_name');
        $doctor_phone = $request->get('doctor_phone');
        $clearing_type = $request->get('clearing_type');
        $profit_margine = $request->get('profit_margine');
        $two=$pinyin::getShortPinyin($h_name);
        $first_letter=substr($two,0,1);
        $mobile=$request->get('mobile');
        $tbl_doctor = new TblDoctor();
        $tbl_hospital = new TblHospital();
        $arr=$tbl_hospital->updateAll(
            ['hospital_name'=>$h_name,
            'address'=>$h_address,
                'profit_margine'=>$profit_margine,
                'clearing_type'=>$clearing_type,'updated_at'=>$date,'first_letter'=>$first_letter],['main_account_id'=>$main_account_id]);
        $brr=$tbl_doctor->updateAll(['mobile'=>$mobile,'doctor_name'=>$doctor_name,'doctor_phone'=>$doctor_phone,'updated_at'=>$date],['doctor_id'=>$main_account_id]);
        echo "1";
    }

    //根据搜索匹配医馆
    public function actionSearch()
    {
        $request = Yii::$app->request;
        $first_letter = $request->get('first_letter');
        $hospital_name = $request->get('hospital_name');
        //实例化一个医院表
        $tblhospital = new TblHospital();
        $db = Yii::$app->db;
        $where = "";
        if (!empty($hospital_name)) {
            $where .= "hospital_name like '$hospital_name%'";
        }
        if (!empty($first_letter)) {
            if (empty($hospital_name)) {
                $oo = explode("-", $first_letter);
                $begin = $oo[0];
                $end = $oo[1];
                $where .= " first_letter between '$begin' and '$end'";
            } else {
                $oo = explode("-", $first_letter);
                $begin = $oo[0];
                $end = $oo[1];
                $where .= " and first_letter between '$begin' and '$end'";
            }
        }


        if (empty($where)) {
            $where = "1=1";
        }
        //通过查询医院表然后获取医馆名称  然后点击医馆名称然后获取信息
        $sql = "select  hospital_name,hospital_id,main_account_id  from tbl_hospital where $where  GROUP BY hospital_name";
        $arr = $db->createCommand($sql)->queryAll();
        return $this->renderPartial("search", ['arr' => $arr, 'hospital_name' => $hospital_name]);
    }

//添加客户
    public function actionAddhospital()
    {
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
        $pinyin=new \Pinyin();
        $request = Yii::$app->request;
        $date = date('Y-m-d H:i:s', time());
        $h_name = $request->get('h_name');
        $h_address = $request->get('h_address');
        $main_account_id = $request->get('main_account_id');
        $doctor_name = $request->get('doctor_name');
        $doctor_phone = $request->get('doctor_phone');
        $clearing_type = $request->get('clearing_type');
        $profit_margine = $request->get('profit_margine');
        $tbl_doctor = new TblDoctor();
        $tbl_hospital = new TblHospital();
        $tbl_doctor->doctor_phone = $doctor_phone;
        $tbl_doctor->doctor_name = $doctor_name;
        $tbl_doctor->doctor_id = $main_account_id;
        $tbl_doctor->hospital_name = $h_name;
        $one=$pinyin::getPinyin($h_name);
        $hospital_id=$one.time();
        $two=$pinyin::getShortPinyin($h_name);
        $first_letter=substr($two,0,1);
        $tbl_doctor->hospital_id = $hospital_id;
        $tbl_doctor->created_at = $date;
        $tbl_doctor->mobile = $doctor_phone;
        $tbl_hospital->hospital_name = $h_name;
        $tbl_hospital->address = $h_address;
        $tbl_hospital->main_account_id = $main_account_id;
        $tbl_hospital->clearing_type = $clearing_type;
        $tbl_hospital->profit_margine = $profit_margine;
        $tbl_hospital->created_at = $date;
        $tbl_hospital->hospital_id = $hospital_id;
        $tbl_hospital->first_letter=$first_letter;


        if ($tbl_doctor->save() && $tbl_hospital->save()) {
            echo "1";
        } else {
            echo "2";
        }

    }
    //删除基本信息
    public function actionDeleteinfo(){
        $request=Yii::$app->request;
        $main_account_id=$request->get('main_account_id');
        $tbl_hospital=new TblHospital();
        $tbldoctor=new TblDoctor();
        $aa=$tbl_hospital->deleteAll(['main_account_id'=>$main_account_id]);
        $bb=$tbldoctor->deleteAll(['doctor_id'=>$main_account_id]);
       echo "1";
    }
    public function actionAbcd(){

    }

}
