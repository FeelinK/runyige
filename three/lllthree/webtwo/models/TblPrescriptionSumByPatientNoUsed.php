<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_prescription_sum_by_patient_no_used".
 *
 * @property integer $patient_type
 * @property string $patient_type_name
 * @property integer $prescription_number
 * @property integer $medicine_kinds
 * @property double $medicine_quantity
 * @property string $created_at
 * @property string $updated_at
 */
class TblPrescriptionSumByPatientNoUsed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_prescription_sum_by_patient_no_used';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patient_type', 'prescription_number', 'medicine_kinds'], 'integer'],
            [['medicine_quantity'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['patient_type_name'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'patient_type' => 'Patient Type',
            'patient_type_name' => 'Patient Type Name',
            'prescription_number' => 'Prescription Number',
            'medicine_kinds' => 'Medicine Kinds',
            'medicine_quantity' => 'Medicine Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
