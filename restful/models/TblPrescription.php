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
 *
 * @property TblDoctor $doctor
 * @property TblPatient $prescription
 * @property TblMedicineUsage $usage
 * @property TblHospital $hospital
 * @property TblPrescriptionDetail[] $tblPrescriptionDetails
 * @property TblMedicine[] $medicines
 * @property TblPrescriptionProgress[] $tblPrescriptionProgresses
 * @property TblProgress[] $progresses
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(TblDoctor::className(), ['doctor_id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrescription()
    {
        return $this->hasOne(TblPatient::className(), ['prescription_id' => 'prescription_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsage()
    {
        return $this->hasOne(TblMedicineUsage::className(), ['usage_id' => 'usage_id']);
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
    public function getTblPrescriptionDetails()
    {
        return $this->hasMany(TblPrescriptionDetail::className(), ['prescription_id' => 'prescription_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicines()
    {
        return $this->hasMany(TblMedicine::className(), ['medicine_id' => 'medicine_id'])->viaTable('tbl_prescription_detail', ['prescription_id' => 'prescription_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblPrescriptionProgresses()
    {
        return $this->hasMany(TblPrescriptionProgress::className(), ['prescription_id' => 'prescription_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgresses()
    {
        return $this->hasMany(TblProgress::className(), ['progress_id' => 'progress_id'])->viaTable('tbl_prescription_progress', ['prescription_id' => 'prescription_id']);
    }
}
