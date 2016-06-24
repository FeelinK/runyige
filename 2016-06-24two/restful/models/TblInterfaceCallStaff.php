<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_interface_call_staff".
 *
 * @property string $user_name
 * @property string $position
 * @property string $token
 */
class TblInterfaceCallStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_interface_call_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name'], 'required'],
            [['user_name'], 'string', 'max' => 10],
            [['position'], 'string', 'max' => 20],
            [['token'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_name' => 'User Name',
            'position' => 'Position',
            'token' => 'Token',
        ];
    }
}
