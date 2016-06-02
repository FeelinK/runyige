<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_confirm_photos".
 *
 * @property string $prescription_id
 * @property string $photo_img
 * @property string $created_at
 * @property string $updated_at
 */
class TbConfirmPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_confirm_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['photo_img'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'photo_img' => 'Photo Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
