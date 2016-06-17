<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_progress_distribution".
 *
 * @property string $prescription_id
 * @property integer $progress_id
 * @property string $delivery_bill_number
 * @property string $created_at
 * @property string $updated_at
 */
class TblProgressDistribution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_progress_distribution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id', 'progress_id'], 'required'],
            [['progress_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['delivery_bill_number'], 'string', 'max' => 20]
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
            'delivery_bill_number' => 'Delivery Bill Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
