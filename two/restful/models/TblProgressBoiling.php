<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_progress_boiling".
 *
 * @property string $prescription_id
 * @property integer $progress_id
 * @property integer $p_prescription_id_check
 * @property integer $p_soaking_time
 * @property integer $b_prescription_id_check
 * @property integer $b_piece_check
 * @property integer $b_kinds_check
 * @property integer $b_appearance_check
 * @property integer $b_water_yield
 * @property double $b_pressure
 * @property integer $b_boiling_time
 * @property integer $b_boiling_machine_number
 * @property integer $b_pre_boiling
 * @property integer $b_post_boiling
 * @property string $b_boiling_start_time
 * @property string $a_prescription_id_check
 * @property integer $a_soup_appearance_check
 * @property integer $a_quantity_check
 * @property string $a_boiling_end_time
 * @property string $created_at
 * @property string $updated_at
 * @property string $staff_id
 */
class TblProgressBoiling extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_progress_boiling';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prescription_id', 'progress_id'], 'required'],
            [['progress_id', 'p_prescription_id_check', 'p_soaking_time', 'b_prescription_id_check', 'b_piece_check', 'b_kinds_check', 'b_appearance_check', 'b_water_yield', 'b_boiling_time', 'b_boiling_machine_number', 'b_pre_boiling', 'b_post_boiling', 'a_soup_appearance_check', 'a_quantity_check', 'staff_id'], 'integer'],
            [['b_pressure'], 'number'],
            [['b_boiling_start_time', 'a_boiling_end_time', 'created_at', 'updated_at'], 'safe'],
            [['prescription_id'], 'string', 'max' => 30],
            [['a_prescription_id_check'], 'string', 'max' => 255]
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
            'p_prescription_id_check' => 'P Prescription Id Check',
            'p_soaking_time' => 'P Soaking Time',
            'b_prescription_id_check' => 'B Prescription Id Check',
            'b_piece_check' => 'B Piece Check',
            'b_kinds_check' => 'B Kinds Check',
            'b_appearance_check' => 'B Appearance Check',
            'b_water_yield' => 'B Water Yield',
            'b_pressure' => 'B Pressure',
            'b_boiling_time' => 'B Boiling Time',
            'b_boiling_machine_number' => 'B Boiling Machine Number',
            'b_pre_boiling' => 'B Pre Boiling',
            'b_post_boiling' => 'B Post Boiling',
            'b_boiling_start_time' => 'B Boiling Start Time',
            'a_prescription_id_check' => 'A Prescription Id Check',
            'a_soup_appearance_check' => 'A Soup Appearance Check',
            'a_quantity_check' => 'A Quantity Check',
            'a_boiling_end_time' => 'A Boiling End Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'staff_id' => 'Staff ID',
        ];
    }
}
