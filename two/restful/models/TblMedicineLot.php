<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_medicine_lot".
 *
 * @property string $medicine_id
 * @property string $production_place
 * @property string $production_date
 * @property string $purchase_date
 * @property string $lot_number
 * @property string $quanlity_grade
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 */
class TblMedicineLot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_medicine_lot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medicine_id'], 'required'],
            [['production_date', 'purchase_date', 'created_at', 'updated_at'], 'safe'],
            [['medicine_id'], 'string', 'max' => 30],
            [['production_place', 'lot_number'], 'string', 'max' => 20],
            [['quanlity_grade'], 'string', 'max' => 10],
            [['notes'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'medicine_id' => 'Medicine ID',
            'production_place' => 'Production Place',
            'production_date' => 'Production Date',
            'purchase_date' => 'Purchase Date',
            'lot_number' => 'Lot Number',
            'quanlity_grade' => 'Quanlity Grade',
            'notes' => 'Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
