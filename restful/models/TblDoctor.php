<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_doctor".
 *
 * @property string $hospital_id
 * @property string $hospital_name
 * @property string $doctor_id
 * @property string $mobile
 * @property string $doctor_name
 * @property string $auth_key
 * @property integer $is_available
 * @property string $created_at
 * @property string $updated_at
 * @property string $doctor_phone
 * @property string $doctor_img
 * @property integer $is_dean
 *
 * @property TblHospital $hospital
 * @property TblPrescription[] $tblPrescriptions
 */
class TblDoctor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_doctor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id'], 'required'],
            [['mobile', 'is_available', 'doctor_phone', 'is_dean'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['hospital_id'], 'string', 'max' => 20],
            [['hospital_name'], 'string', 'max' => 100],
            [['doctor_id'], 'string', 'max' => 15],
            [['doctor_name'], 'string', 'max' => 10],
            [['auth_key'], 'string', 'max' => 255],
            [['doctor_img'], 'string', 'max' => 50]
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
            'mobile' => 'Mobile',
            'doctor_name' => 'Doctor Name',
            'auth_key' => 'Auth Key',
            'is_available' => 'Is Available',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'doctor_phone' => 'Doctor Phone',
            'doctor_img' => 'Doctor Img',
            'is_dean' => 'Is Dean',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospital()
    {
        return $this->hasOne(TblHospital::className(), ['hospital_id' => 'hospital_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblPrescriptions()
    {
        return $this->hasMany(TblPrescription::className(), ['doctor_id' => 'doctor_id']);
    }
}
