
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'action' => ['101.200.232.66/restful/web/index.php?r=physician/taboophotograph'],
    'method'=>'post',
]); ?>
doctor_id<input type="text" name="doctor_id"/>production_type<input type="text" name="production_type"/>token<input type="text" name="token"/>
photo_img<input type="text" name="photo_img"/>patient_type_name<input type="text" name="patient_type_name"/>photo_address_img<input type="text" name="photo_address_img"/>
<input type="submit"/>
<?php ActiveForm::end(); ?>
