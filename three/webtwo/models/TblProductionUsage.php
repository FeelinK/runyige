<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_production_usage".
 *
 * @property integer $usage_id
 * @property string $usage_name
 * @property string $created_at
 * @property string $updated_at
 */
class TblProductionUsage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_production_usage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usage_id'], 'required'],
            [['usage_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['usage_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usage_id' => 'Usage ID',
            'usage_name' => 'Usage Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
