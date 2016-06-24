<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_prescription_unhandled_by_patient".
 *
 * @property integer $total
 * @property integer $pregnant
 * @property integer $child
 * @property integer $special
 * @property integer $normal
 * @property string $created_at
 * @property string $updated_at
 */
class TblPrescriptionUnhandledByPatient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_prescription_unhandled_by_patient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total', 'pregnant', 'child', 'special', 'normal'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'total' => 'Total',
            'pregnant' => 'Pregnant',
            'child' => 'Child',
            'special' => 'Special',
            'normal' => 'Normal',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
