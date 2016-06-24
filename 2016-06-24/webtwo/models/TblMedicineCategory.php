<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_medicine_category".
 *
 * @property integer $category
 * @property string $category_name
 * @property integer $parent
 * @property integer $sequence
 */
class TblMedicineCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_medicine_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category', 'parent', 'sequence'], 'integer'],
            [['category_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category' => 'Category',
            'category_name' => 'Category Name',
            'parent' => 'Parent',
            'sequence' => 'Sequence',
        ];
    }
}
