<?php
/**
 * 润衣阁商品管理
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
use app\models\TblSupplier;
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
use app\models\TblMedicine;
use app\models\TblMedicineCategory;
use app\models\TblMedicineLot;


class Commodity_managementController extends Controller
{
    public $enableCsrfValidation =false;

    public function actionIndex()
    {
        $tbl_supplier=new TblSupplier();
   $tbl_medicine_ca=new TblMedicineCategory();
    //查询一级分类
    $arr=$tbl_medicine_ca->find()->where("parent='0'")->orderBy("sequence asc")->asArray()->all();
     //查询出供应商
        $suppiler=$tbl_supplier->find()->asArray()->all();
   return $this->renderPartial("index",['arr'=>$arr,'supplier'=>$suppiler]);
    }
    public function actionLitwo(){
        $request=Yii::$app->request;
        $category=$request->get('category');
        $tbl_medicine_ca=new TblMedicineCategory();
        //查询二级分类
        $arr=$tbl_medicine_ca->find()->orderBy("sequence desc")->where("parent='$category'")->limit(20)->asArray()->all();
        echo json_encode($arr);
    }
    //查询三级分类
    public function actionLithree(){
        $request=Yii::$app->request;
        $category=$request->get('category');
       $tbl_medicine=new TblMedicine();
        //查询三级分类
        $arr=$tbl_medicine->find()->orderBy("created_at desc")->where("category2='$category'")->limit(20)->asArray()->all();
        echo json_encode($arr);
    }
    //药材详情
    public function actionDetail(){
        $request=Yii::$app->request;
        $tbl_medicine_ca=new TblMedicineCategory();
        $tbl_medicine=new TblMedicine();
        $tbl_medicine_lot=new TblMedicineLot();
        $tbl_supplier=new TblSupplier();
        $medicine_id=$request->get('medicine_id');
        //根据药材id查询一些详细信息
        $arr=$tbl_medicine->find()->select(array('medicine_name','medicine_id','category1','category2','purchase_price','cost_price','sale_price','supplier_id','medicine_nickname'))->where("medicine_id='$medicine_id'")->asArray()->one();
        $maxtypeid=$arr['category1'];
        $mintypeid=$arr['category2'];
        $supplier_id=$arr['supplier_id'];
       //查询大分类名称
        $maxtypename=$tbl_medicine_ca->find()->select(array('category_name'))->where("category='$maxtypeid'")->asArray()->one();
        //查询小分类名称
        $mintypename=$tbl_medicine_ca->find()->select(array('category_name'))->where("category='$mintypeid'")->asArray()->one();
        $arr['maxtypename']=$maxtypename['category_name'];
        $arr['mintypename']=$mintypename['category_name'];
        //查询产地等一些信息
        $medicine_lot=$tbl_medicine_lot->find()->where("medicine_id='$medicine_id'")->asArray()->one();
        if(!empty($medicine_lot)){
            $arr['production_place']=$medicine_lot['production_place'];
            $arr['production_date']=$medicine_lot['production_date'];
            $arr['purchase_date']=$medicine_lot['purchase_date'];
            $arr['lot_number']=$medicine_lot['lot_number'];
            $arr['quanlity_grade']=$medicine_lot['quanlity_grade'];
            $arr['notes']=$medicine_lot['notes'];
        }else{
            $arr['production_place']="";
            $arr['production_date']="";
            $arr['purchase_date']="";
            $arr['lot_number']="";
            $arr['quanlity_grade']="";
            $arr['notes']="";
        }
        //查询出供货商
        $supplier_name=$tbl_supplier->find()->select(array('supplier_name'))->where("supplier_id='$supplier_id'")->asarray()->one();
        if(!empty($supplier_name)){
            $arr['supplier_name']=$supplier_name['supplier_name'];
        }else{
            $arr['supplier_name']="";

        }
        return $this->renderPartial("detail",['arr'=>$arr]);
    }
//药材入库
public function actionAddmedicinethree(){
        $tbl_medicine=new TblMedicine();
       $tbl_medicine_lot=new TblMedicineLot();
        $request=Yii::$app->request;
        $date=date('Y-m-d H:i:s',time());
        $medicine_name=$request->get('medicine_name');
        $medicine_nickname=$request->get('medicine_nickname');
        $photo=$request->get('photo');
        $newphoto="http://o7eryb4fl.bkt.clouddn.com/".$photo;
        $category1=$request->get('category1');
        $category2=$request->get('category2');
        $production_place=$request->get('production_place');
        $production_date=$request->get('production_date');
        $lot_number=$request->get('lot_number');
        $purchase_date=$request->get('purchase_date');
        $quanlity_grade=$request->get('quanlity_grade');
        $notes=$request->get('notes');
        $purchase_price=$request->get('purchase_price');
        $cost_price=$request->get('cost_price');
        $sale_price=$request->get('sale_price');
        $supplier_id=$request->get('supplier_id');

        $frequence_code=$request->get('frequence_code');
        $medicine_id=$request->get('medicine_id');
        $sub_code=$request->get('sub_code');
        $gb_code=$request->get('gb_code');
        $min=$request->get('min');
        $max=$request->get('max');
        $cost_rate=$request->get('cost_rate');
        $profit_rate=$request->get('profit_rate');
        $drawer_location=$request->get('drawer_location');

       require str_replace('\\', '/', \Yii::$app->basePath . '/vendor/abcd/Pinyin.php');
       $pinyintwo=new \Pinyin();
       $pinyin=$pinyintwo->getPinyin($medicine_name);
       $tbl_medicine->medicine_name=$medicine_name;
       $tbl_medicine->created_at=$date;
       $tbl_medicine->medicine_nickname=$medicine_nickname;
       $tbl_medicine->pinyin=$pinyin;
       $tbl_medicine->photo=$newphoto;
       $tbl_medicine->category1=$category1;
       $tbl_medicine->category2=$category2;
       $tbl_medicine->purchase_price=$purchase_price;
      $tbl_medicine->cost_price=$cost_price;
      $tbl_medicine->sale_price=$sale_price;
      $tbl_medicine->supplier_id=$supplier_id;
     $tbl_medicine->medicine_id=$medicine_id;
    $tbl_medicine->frequence_code=$frequence_code;
    $tbl_medicine->sub_code=$sub_code;
    $tbl_medicine->gb_code=$gb_code;
    $tbl_medicine->min=$min;
    $tbl_medicine->max=$max;
    $tbl_medicine->cost_rate=$cost_rate;
    $tbl_medicine->profit_rate=$profit_rate;
    $tbl_medicine->drawer_location=$drawer_location;






    $tbl_medicine_lot->production_place=$production_place;
    $tbl_medicine_lot->production_date=$production_date;
    $tbl_medicine_lot->purchase_date=$purchase_date;
    $tbl_medicine_lot->lot_number=$lot_number;
    $tbl_medicine_lot->quanlity_grade=$quanlity_grade;
    $tbl_medicine_lot->notes=$notes;
    $tbl_medicine_lot->created_at=$date;
    $tbl_medicine_lot->medicine_id=$medicine_id;
    if($tbl_medicine->save() && $tbl_medicine_lot->save()){
        echo "1";
    }
}
    //判断药材唯一
    public function actionMedicineidonly(){
        $request=Yii::$app->request;
        $medicine_id=$request->get('medicine_id');
        $tbl_medicine=new TblMedicine();
        $arr=$tbl_medicine->find()->where("medicine_id='$medicine_id'")->asArray()->one();
        if(!empty($arr)){
            echo "1";
        }
    }
//删除药材
public function actionDelmedicine(){
    $request=Yii::$app->request;
    $medicine_id=$request->get('medicine_id');
    $tbl_medicine=new TblMedicine();
    $arr=$tbl_medicine->deleteAll(['medicine_id'=>$medicine_id]);
    if($arr){
        echo "1";
    }
}
    //修改基本信息
    public function actionUpone(){
        $tbl_medicine_ca=new TblMedicineCategory();
        $tbl_medicine=new TblMedicine();
        $tbl_medicine_lot=new TblMedicineLot();
        $request=Yii::$app->request;
        $medicine_id=$request->get('medicine_id');
        //根据药材id查询一些详细信息
        $arr=$tbl_medicine->find()->select(array('medicine_name','medicine_id','category1','category2','purchase_price','cost_price','sale_price','supplier_id','medicine_nickname'))->where("medicine_id='$medicine_id'")->asArray()->one();
        $maxtypeid=$arr['category1'];
        $mintypeid=$arr['category2'];
        $supplier_id=$arr['supplier_id'];
        //查询大分类名称
        $maxtypename=$tbl_medicine_ca->find()->select(array('category_name'))->where("category='$maxtypeid'")->asArray()->one();
        //查询小分类名称
        $mintypename=$tbl_medicine_ca->find()->select(array('category_name'))->where("category='$mintypeid'")->asArray()->one();
        $arr['maxtypename']=$maxtypename['category_name'];
        $arr['mintypename']=$mintypename['category_name'];
        //查询产地等一些信息
        $medicine_lot=$tbl_medicine_lot->find()->where("medicine_id='$medicine_id'")->asArray()->one();
        if(!empty($medicine_lot)){
            $arr['production_place']=$medicine_lot['production_place'];
            $arr['production_date']=$medicine_lot['production_date'];
            $arr['purchase_date']=$medicine_lot['purchase_date'];
            $arr['lot_number']=$medicine_lot['lot_number'];
            $arr['quanlity_grade']=$medicine_lot['quanlity_grade'];
            $arr['notes']=$medicine_lot['notes'];
        }else{
            $arr['production_place']="";
            $arr['production_date']="";
            $arr['purchase_date']="";
            $arr['lot_number']="";
            $arr['quanlity_grade']="";
            $arr['notes']="";
        }
        $brr=$tbl_medicine_ca->find()->where("parent='0'")->orderBy("sequence asc")->asArray()->all();

        return $this->renderPartial("upone",['arr'=>$arr,'brr'=>$brr]);
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
    //修改价格
    public function actionUptwo(){
        $request=Yii::$app->request;
        $medicine_id=$request->get('medicine_id');
        $tbl_medicine=new TblMedicine();
        $arr=$tbl_medicine->find()->where("medicine_id='$medicine_id'")->asArray()->one();

        return $this->renderPartial("uptwo",['arr'=>$arr,'medicine_id'=>$medicine_id]);
    }
    //接收修改价格的值
    public function actionUptwoprice()
    {
        $request = Yii::$app->request;
        $tbl_medicine = new TblMedicine();
        $medicine_id = $request->get('medicine_id');
        $purchase_price = $request->get('purchase_price');
        $cost_price = $request->get('cost_price');
        $sale_price = $request->get('sale_price');
        $cost_rate = $request->get('cost_rate');
        $profit_rate = $request->get('profit_rate');
        $arr = $tbl_medicine->updateAll(['purchase_price' => $purchase_price, 'cost_price' => $cost_price, 'sale_price' => $sale_price, 'cost_rate' => $cost_rate, 'profit_rate' => $profit_rate], ['medicine_id' => $medicine_id]);
        if ($arr) {
            echo "1";
        }else{
         echo "1";
        }

    }
    //修改供货商
    public function actionUpthree(){
        $request=Yii::$app->request;
        $tbl_supplier=new TblSupplier();
        $tbl_medicine=new TblMedicine();
        $medicine_id=$request->get("medicine_id");
        $supplier=$tbl_supplier->find()->limit(5)->asArray()->all();
        $supplier_id=$tbl_medicine->find()->where("medicine_id='$medicine_id'")->asArray()->one();
        return $this->renderPartial("upthree",['supplier'=>$supplier,'supplier_id'=>$supplier_id,'medicine_id'=>$medicine_id]);
    }
    //接收值 修改供货商
    public function actionUpthreeok(){
        $request=Yii::$app->request;
        $medicine_id=$request->get('medicine_id');
        $supplier_id=$request->get('supplier_id');
        $tbl_medicine=new TblMedicine();
        $arr=$tbl_medicine->updateAll(['supplier_id'=>$supplier_id],['medicine_id'=>$medicine_id]);
        if($arr){
            echo "1";
        }else{
            $brr=$tbl_medicine->find()->where("medicine_id='$medicine_id'")->asArray()->one();
            if($brr['supplier_id']==$supplier_id){
                echo "1";
            }
        }
    }
//按照药材名称进行搜索
public function actionSearch(){
    $request=Yii::$app->request;
    $tbl_medicine=new TblMedicine();
    $medicine_name=$request->get('medicine_name');
    $where="medicine_name like '$medicine_name'";
    $arr=$tbl_medicine->find()->where($where)->asArray()->one();
     if(!empty($arr)){
         echo $arr['medicine_id'];
     }

}
}
