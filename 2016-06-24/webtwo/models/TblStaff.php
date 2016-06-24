<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_staff".
 *
 * @property string $staff_id
 * @property string $staff_name
 * @property string $mobile
 * @property integer $role_id
 * @property string $role_name
 * @property string $password_hash
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 * @property string $first_letter
 */
class TblStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['staff_id', 'mobile', 'role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_name'], 'string', 'max' => 20],
            [['role_name'], 'string', 'max' => 30],
            [['password_hash', 'photo'], 'string', 'max' => 255],
            [['first_letter'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'Staff ID',
            'staff_name' => 'Staff Name',
            'mobile' => 'Mobile',
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
            'password_hash' => 'Password Hash',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'first_letter' => 'First Letter',
        ];
    }
}
