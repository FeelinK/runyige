<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_prescription_detail".
 *
 * @property string $prescription_id
 * @property string $medicine_id
 * @property string $medicine_name
 * @property string $produce_frequence_name
 * @property integer $produce_frequence
 * @property integer $is_excess
 * @property integer $is_violation
 * @property integer $weight
 * @property string $medicine_photo
 * @property string $created_at
 * @property string $updated_at
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
            [['produce_frequence', 'is_excess', 'is_violation', 'weight'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['prescription_id', 'medicine_id', 'medicine_name'], 'string', 'max' => 30],
            [['produce_frequence_name'], 'string', 'max' => 10],
            [['medicine_photo'], 'string', 'max' => 100]
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
            'produce_frequence_name' => 'Produce Frequence Name',
            'produce_frequence' => 'Produce Frequence',
            'is_excess' => 'Is Excess',
            'is_violation' => 'Is Violation',
            'weight' => 'Weight',
            'medicine_photo' => 'Medicine Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
