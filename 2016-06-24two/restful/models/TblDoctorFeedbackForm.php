<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_doctor_feedback_form".
 *
 * @property integer $f_id
 * @property string $doctor_id
 * @property string $create_at
 * @property string $f_content
 */
class TblDoctorFeedbackForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_doctor_feedback_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at'], 'safe'],
            [['f_content'], 'string'],
            [['doctor_id'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'f_id' => 'F ID',
            'doctor_id' => 'Doctor ID',
            'create_at' => 'Create At',
            'f_content' => 'F Content',
        ];
    }
}
