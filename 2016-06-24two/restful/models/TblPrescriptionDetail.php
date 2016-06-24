<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_prescription_detail".
 *
 * @property string $prescription_id
 * @property string $medicine_id
 * @property string $medicine_name
 * @property integer $dosage
 * @property integer $produce_frequence
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_excess
 * @property integer $is_violation
 * @property integer $weight
 *
 * @property TblMedicine $medicine
 * @property TblPrescription $prescription
 */
class TblPrescriptionDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_prescription_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id', 'medicine_id'], 'required'],
            [['dosage', 'produce_frequence', 'is_excess', 'is_violation', 'weight'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['prescription_id', 'medicine_id', 'medicine_name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'medicine_id' => 'Medicine ID',
            'medicine_name' => 'Medicine Name',
            'dosage' => 'Dosage',
            'produce_frequence' => 'Produce Frequence',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_excess' => 'Is Excess',
            'is_violation' => 'Is Violation',
            'weight' => 'Weight',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicine()
    {
        return $this->hasOne(TblMedicine::className(), ['medicine_id' => 'medicine_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrescription()
    {
        return $this->hasOne(TblPrescription::className(), ['prescription_id' => 'prescription_id']);
    }
}
