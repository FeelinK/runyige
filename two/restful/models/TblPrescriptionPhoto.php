<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_prescription_photo".
 *
 * @property string $prescription_id
 * @property integer $photo_type
 * @property string $photo_img
 * @property string $photo_id
 * @property integer $frequence
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_newest
 */
class TblPrescriptionPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_prescription_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id', 'photo_img', 'photo_id'], 'required'],
            [['photo_type', 'frequence', 'is_newest'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['photo_img'], 'string', 'max' => 50],
            [['photo_id'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'photo_type' => 'Photo Type',
            'photo_img' => 'Photo Img',
            'photo_id' => 'Photo ID',
            'frequence' => 'Frequence',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_newest' => 'Is Newest',
        ];
    }
}
