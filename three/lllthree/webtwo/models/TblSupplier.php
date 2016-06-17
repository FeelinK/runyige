<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_supplier".
 *
 * @property string $supplier_id
 * @property string $supplier_name
 * @property string $address
 * @property string $contact
 * @property string $tel
 * @property string $email
 * @property string $weixin
 * @property string $created_at
 * @property string $updated_at
 */
class TblSupplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['supplier_id', 'contact', 'tel'], 'string', 'max' => 20],
            [['supplier_name'], 'string', 'max' => 100],
            [['address', 'email', 'weixin'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplier_id' => 'Supplier ID',
            'supplier_name' => 'Supplier Name',
            'address' => 'Address',
            'contact' => 'Contact',
            'tel' => 'Tel',
            'email' => 'Email',
            'weixin' => 'Weixin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
