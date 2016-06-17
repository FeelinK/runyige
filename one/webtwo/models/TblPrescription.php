<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_prescription".
 *
 * @property string $hospital_id
 * @property string $hospital_name
 * @property string $doctor_id
 * @property string $doctor_name
 * @property string $patient_name
 * @property string $prescription_id
 * @property integer $patient_type
 * @property string $patient_type_name
 * @property string $notes
 * @property string $prescription_time
 * @property integer $use_frequence
 * @property integer $usage_id
 * @property string $usage_name
 * @property integer $piece
 * @property integer $kinds_per_piece
 * @property integer $production_type
 * @property double $price
 * @property integer $need_reconfirm
 * @property integer $is_reconfirmed
 * @property integer $excessive_prescription
 * @property integer $prescription_status
 * @property string $created_at
 * @property string $updated_at
 */
class TblPrescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_prescription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id'], 'required'],
            [['patient_type', 'use_frequence', 'usage_id', 'piece', 'kinds_per_piece', 'production_type', 'need_reconfirm', 'is_reconfirmed', 'excessive_prescription', 'prescription_status'], 'integer'],
            [['prescription_time', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
            [['hospital_id', 'doctor_name', 'patient_name', 'usage_name'], 'string', 'max' => 20],
            [['hospital_name'], 'string', 'max' => 25],
            [['doctor_id'], 'string', 'max' => 15],
            [['prescription_id'], 'string', 'max' => 30],
            [['patient_type_name'], 'string', 'max' => 10],
            [['notes'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hospital_id' => 'Hospital ID',
            'hospital_name' => 'Hospital Name',
            'doctor_id' => 'Doctor ID',
            'doctor_name' => 'Doctor Name',
            'patient_name' => 'Patient Name',
            'prescription_id' => 'Prescription ID',
            'patient_type' => 'Patient Type',
            'patient_type_name' => 'Patient Type Name',
            'notes' => 'Notes',
            'prescription_time' => 'Prescription Time',
            'use_frequence' => 'Use Frequence',
            'usage_id' => 'Usage ID',
            'usage_name' => 'Usage Name',
            'piece' => 'Piece',
            'kinds_per_piece' => 'Kinds Per Piece',
            'production_type' => 'Production Type',
            'price' => 'Price',
            'need_reconfirm' => 'Need Reconfirm',
            'is_reconfirmed' => 'Is Reconfirmed',
            'excessive_prescription' => 'Excessive Prescription',
            'prescription_status' => 'Prescription Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
