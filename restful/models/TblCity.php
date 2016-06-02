<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_city".
 *
 * @property integer $region_id
 * @property integer $parent_id
 * @property string $region_name
 * @property string $region_type
 */
class TblCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['region_name'], 'string', 'max' => 120],
            [['region_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'parent_id' => 'Parent ID',
            'region_name' => 'Region Name',
            'region_type' => 'Region Type',
        ];
    }
}
