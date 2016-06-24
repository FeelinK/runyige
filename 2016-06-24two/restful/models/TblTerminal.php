<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_terminal".
 *
 * @property string $terminal_id
 * @property string $terminal_name
 * @property string $password
 * @property integer $terminal_role
 * @property integer $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class TblTerminal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_terminal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['terminal_id'], 'required'],
            [['terminal_role', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['terminal_id'], 'string', 'max' => 10],
            [['terminal_name'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'terminal_id' => 'Terminal ID',
            'terminal_name' => 'Terminal Name',
            'password' => 'Password',
            'terminal_role' => 'Terminal Role',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
