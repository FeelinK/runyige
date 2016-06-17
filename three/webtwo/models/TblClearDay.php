<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_clear_day".
 *
 * @property integer $id
 * @property integer $plus
 * @property string $day
 * @property string $name
 */
class TblClearDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_clear_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plus'], 'integer'],
            [['day'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plus' => 'Plus',
            'day' => 'Day',
            'name' => 'Name',
        ];
    }
}
