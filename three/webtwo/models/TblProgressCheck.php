<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_progress_check".
 *
 * @property string $prescription_id
 * @property integer $progress
 * @property string $photo
 * @property integer $taken_type
 * @property string $taken_name
 * @property string $taken_time
 * @property string $created_at
 * @property string $updated_at
 */
class TblProgressCheck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_progress_check';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id', 'progress'], 'required'],
            [['progress', 'taken_type'], 'integer'],
            [['taken_time', 'created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['photo'], 'string', 'max' => 150],
            [['taken_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'progress' => 'Progress',
            'photo' => 'Photo',
            'taken_type' => 'Taken Type',
            'taken_name' => 'Taken Name',
            'taken_time' => 'Taken Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
