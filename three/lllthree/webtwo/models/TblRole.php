<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_role".
 *
 * @property integer $role_id
 * @property string $role_name
 * @property string $created_at
 * @property string $updated_at
 */
class TblRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            [['role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['role_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
