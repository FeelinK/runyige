<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_produce_frequence_type".
 *
 * @property integer $produce_frequence_type
 * @property string $produce_frequence_name
 */
class TblProduceFrequenceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_produce_frequence_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['produce_frequence_type'], 'required'],
            [['produce_frequence_type'], 'integer'],
            [['produce_frequence_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'produce_frequence_type' => 'Produce Frequence Type',
            'produce_frequence_name' => 'Produce Frequence Name',
        ];
    }
}
