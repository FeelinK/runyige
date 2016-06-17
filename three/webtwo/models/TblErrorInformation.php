<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_error_information".
 *
 * @property integer $prescription_id
 * @property integer $progress_id
 * @property string $progress_name
 * @property integer $password_hash
 * @property string $staff_name
 * @property integer $password_hashs
 * @property string $staff_names
 * @property string $created_at
 * @property string $updated_at
 */
class TblErrorInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_error_information';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id'], 'required'],
            [['prescription_id', 'progress_id', 'password_hash', 'password_hashs'], 'integer'],
            [['created_at', 'updated_at'], 'number'],
            [['progress_name', 'staff_name', 'staff_names'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prescription_id' => 'Prescription ID',
            'progress_id' => 'Progress ID',
            'progress_name' => 'Progress Name',
            'password_hash' => 'Password Hash',
            'staff_name' => 'Staff Name',
            'password_hashs' => 'Password Hashs',
            'staff_names' => 'Staff Names',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
