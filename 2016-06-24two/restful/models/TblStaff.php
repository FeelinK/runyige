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
 * @property string $password_hash
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TblPrescriptionProgress[] $tblPrescriptionProgresses
 * @property TblRole $role
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
            [['password_hash'], 'string', 'max' => 255],
            [['photo'], 'string', 'max' => 30]
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
            'password_hash' => 'Password Hash',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblPrescriptionProgresses()
    {
        return $this->hasMany(TblPrescriptionProgress::className(), ['person_incharge' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(TblRole::className(), ['role_id' => 'role_id']);
    }
}
