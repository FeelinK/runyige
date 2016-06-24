<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_daily_statistics".
 *
 * @property string $day
 * @property integer $prescription_number
 * @property integer $naked_medicine_number
 * @property integer $decocted_medicine_number
 * @property integer $used_medicine_kinds
 * @property integer $used_medicine_quantity
 * @property string $created_at
 * @property string $updated_at
 */
class TblDailyStatistics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_daily_statistics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day'], 'required'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['prescription_number', 'naked_medicine_number', 'decocted_medicine_number', 'used_medicine_kinds', 'used_medicine_quantity'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'day' => 'Day',
            'prescription_number' => 'Prescription Number',
            'naked_medicine_number' => 'Naked Medicine Number',
            'decocted_medicine_number' => 'Decocted Medicine Number',
            'used_medicine_kinds' => 'Used Medicine Kinds',
            'used_medicine_quantity' => 'Used Medicine Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
