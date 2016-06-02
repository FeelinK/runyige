<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_prescription_progress".
 *
 * @property string $prescription_id
 * @property integer $progress_id
 * @property string $progress_name
 * @property string $start_time
 * @property string $end_time
 * @property string $person_incharge
 * @property string $created_at
 * @property string $updated_at
 */
class TblPrescriptionProgress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_prescription_progress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id', 'progress_id'], 'required'],
            [['progress_id', 'person_incharge'], 'integer'],
            [['start_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['progress_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'progress_id' => 'Progress ID',
            'progress_name' => 'Progress Name',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'person_incharge' => 'Person Incharge',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrescription()
    {
        return $this->hasOne(TblPrescription::className(), ['prescription_id' => 'prescription_id']);
    }
}
