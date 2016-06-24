<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_hospital".
 *
 * @property string $hospital_id
 * @property string $hospital_name
 * @property string $address
 * @property string $business_registration_id
 * @property string $practising_certification_id
 * @property string $main_account_id
 * @property string $clearing_type
 * @property integer $clearing_date
 * @property double $profit_margine
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblDoctor[] $tblDoctors
 * @property TblPrescription[] $tblPrescriptions
 */
class TblHospital extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_hospital';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hospital_id'], 'required'],
            [['clearing_date'], 'integer'],
            [['profit_margine'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['hospital_id'], 'string', 'max' => 20],
            [['hospital_name', 'address'], 'string', 'max' => 100],
            [['business_registration_id', 'practising_certification_id', 'clearing_type'], 'string', 'max' => 30],
            [['main_account_id'], 'string', 'max' => 15]
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
            'address' => 'Address',
            'business_registration_id' => 'Business Registration ID',
            'practising_certification_id' => 'Practising Certification ID',
            'main_account_id' => 'Main Account ID',
            'clearing_type' => 'Clearing Type',
            'clearing_date' => 'Clearing Date',
            'profit_margine' => 'Profit Margine',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblDoctors()
    {
        return $this->hasMany(TblDoctor::className(), ['hospital_id' => 'hospital_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblPrescriptions()
    {
        return $this->hasMany(TblPrescription::className(), ['hospital_id' => 'hospital_id']);
    }
}
