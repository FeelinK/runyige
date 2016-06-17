<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_use_frequence_type".
 *
 * @property integer $use_frequence_type
 * @property string $use_frequence_type_name
 */
class TblUseFrequenceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_use_frequence_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['use_frequence_type'], 'required'],
            [['use_frequence_type'], 'integer'],
            [['use_frequence_type_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'use_frequence_type' => 'Use Frequence Type',
            'use_frequence_type_name' => 'Use Frequence Type Name',
        ];
    }
}
