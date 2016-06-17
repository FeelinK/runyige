<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_patient".
 *
 * @property string $prescription_id
 * @property string $patient_name
 * @property integer $age
 * @property integer $gender
 * @property string $address
 * @property string $mobile
 * @property string $created_at
 * @property string $updated_at
 */
class TblPatient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_patient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id'], 'required'],
            [['age', 'gender', 'mobile'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['patient_name'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'patient_name' => 'Patient Name',
            'age' => 'Age',
            'gender' => 'Gender',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
