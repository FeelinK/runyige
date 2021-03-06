<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_medicine".
 *
 * @property integer $frequence_code
 * @property string $medicine_id
 * @property integer $sub_code
 * @property string $medicine_name
 * @property string $gb_code
 * @property string $pinyin
 * @property integer $min
 * @property integer $max
 * @property integer $category1
 * @property integer $category2
 * @property double $purchase_price
 * @property double $cost_rate
 * @property double $cost_price
 * @property double $profit_rate
 * @property double $sale_price
 * @property string $supplier_id
 * @property string $drawer_location
 * @property integer $standard
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 */
class TblMedicine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_medicine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequence_code', 'sub_code', 'min', 'max', 'category1', 'category2', 'standard'], 'integer'],
            [['medicine_id'], 'required'],
            [['purchase_price', 'cost_rate', 'cost_price', 'profit_rate', 'sale_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['medicine_id', 'gb_code', 'supplier_id', 'drawer_location'], 'string', 'max' => 20],
            [['medicine_name', 'pinyin'], 'string', 'max' => 30],
            [['photo'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'frequence_code' => 'Frequence Code',
            'medicine_id' => 'Medicine ID',
            'sub_code' => 'Sub Code',
            'medicine_name' => 'Medicine Name',
            'gb_code' => 'Gb Code',
            'pinyin' => 'Pinyin',
            'min' => 'Min',
            'max' => 'Max',
            'category1' => 'Category1',
            'category2' => 'Category2',
            'purchase_price' => 'Purchase Price',
            'cost_rate' => 'Cost Rate',
            'cost_price' => 'Cost Price',
            'profit_rate' => 'Profit Rate',
            'sale_price' => 'Sale Price',
            'supplier_id' => 'Supplier ID',
            'drawer_location' => 'Drawer Location',
            'standard' => 'Standard',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
