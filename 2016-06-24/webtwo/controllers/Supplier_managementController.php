<?php
/**
 * 润衣阁供应商管理
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
use app\models\TblSupplier;

class Supplier_managementController extends Controller
{
    public function actionIndex()
    {
        $db=Yii::$app->db;
        $sql="select  supplier_id,supplier_name from tbl_supplier group by supplier_name";
        $arr=$db->createCommand($sql)->queryAll();
        return $this->renderPartial("index",['arr'=>$arr]);
    }
    //根据id匹配基恩信息
    public function actionDetail(){
        $request=Yii::$app->request;
        $supplier_id=$request->get('supplier_id');
        $tbl_supplier=new TblSupplier();
        $brr=$tbl_supplier->find()->where("supplier_id='$supplier_id'")->asArray()->one();
        return $this->renderPartial("detail",['brr'=>$brr]);
    }
    //删除信息
    public function actionDelete(){
        $request=Yii::$app->request;
        $supplier_id=$request->get('supplier_id');
        $tbl_supplier=new TblSupplier();
        $arr=$tbl_supplier->deleteAll(['supplier_id'=>$supplier_id]);
        echo 1;
    }
//根据首字母匹配数据
public function actionFirst_letter(){
    $request=Yii::$app->request;
    $first_letter=$request->get('first_letter');
    $where="";
    if(!empty($first_letter)){
        $aa=explode("-",$first_letter);
       $begin=$aa[0];
        $end=$aa[1];
        $where.="first_letter between '$begin' and '$end' ";
    }
    $db=Yii::$app->db;
    $sql="select  supplier_id,supplier_name,first_letter from tbl_supplier where $where group by supplier_name";
    $arr=$db->createCommand($sql)->queryAll();
    return $this->renderPartial("first_letter",['arr'=>$arr]);
}
    public function actionUpdate(){
        $request=Yii::$app->request;
        $supplier_id=$request->get('supplier_id');
        $tbl_supplier=new TblSupplier();
        $arr=$tbl_supplier->find()->where("supplier_id='$supplier_id'")->asArray()->one();
        return $this->renderPartial("update",['arr'=>$arr]);
    }
    //修改保存数据
    public function actionUpdatetwo(){
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
        $pinyin=new \Pinyin();
        $request=Yii::$app->request;
        $supplier_id=$request->get('supplier_id');
        $supplier_name=$request->get('supplier_name');
        $address=$request->get('address');
        $contact=$request->get('contact');
        $tel=$request->get('tel');
        $email=$request->get('email');
        $weixin=$request->get('weixin');
        $first_lettertwo= $pinyin::getShortPinyin( $supplier_name);
        $first_letter=substr($first_lettertwo,0,1);
        $tblsupplier=new TblSupplier();
        $arr=$tblsupplier->updateAll(['supplier_name'=>$supplier_name,
            'address'=>$address,
            'contact'=>$contact,
            'tel'=>$tel,
           'email'=>$email,
            'weixin'=>$weixin,
            'first_letter'=>$first_letter
        ],['supplier_id'=>$supplier_id]);
        if($arr){
            echo "1";
        }
    }
    public function actionAdd(){
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
        $pinyin=new \Pinyin();
        $request=Yii::$app->request;
        $supplier_name=$request->get('supplier_name');
        $first_lettertwo= $pinyin::getShortPinyin( $supplier_name);
       $first_letter=substr($first_lettertwo,0,1);
        $address=$request->get('address');
        $contact=$request->get('contact');
        $tel=$request->get('tel');
        $email=$request->get('email');
        $weixin=$request->get('weixin');
        $tblsupplier=new TblSupplier();
        $tblsupplier->supplier_name=$supplier_name;
        $tblsupplier->address=$address;
        $tblsupplier->contact=$contact;
        $tblsupplier->tel=$tel;
        $tblsupplier->email=$email;
        $tblsupplier->weixin=$weixin;
        $supplier_id=$tel;
        $tblsupplier->supplier_id=$supplier_id;
        $date=date('Y-m-d H:i:s',time());
        $tblsupplier->created_at=$date;
        $tblsupplier->first_letter=$first_letter;
        if($tblsupplier->save()){
            echo "1";
        }
    }
    public function actionAbcd(){
        require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
        $pinyin=new \Pinyin();
        echo $pinyin::getPinyin("早上好");
        echo $pinyin::getShortPinyin("早上好");
    }
}
