<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_patient_feedback".
 *
 * @property string $prescription_id
 * @property string $feedback_id
 * @property string $occurence_date
 * @property string $contents
 * @property string $report_at
 * @property string $created_at
 * @property string $updated_at
 */
class TblPatientFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_patient_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id', 'feedback_id'], 'required'],
            [['feedback_id'], 'integer'],
            [['occurence_date', 'report_at', 'created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['contents'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'feedback_id' => 'Feedback ID',
            'occurence_date' => 'Occurence Date',
            'contents' => 'Contents',
            'report_at' => 'Report At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
