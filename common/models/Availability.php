<?php

namespace common\models;

use yii\base\Model;
use Yii;

class Availability extends Model
{
    public $school_id;
    public $grade_id;
    public $time_slots = [];
    public $start_date;
    public $end_date;

    /**
     * Define validation rules for the form fields.
     */
    public function rules()
    {
        return [
            [['school_id', 'grade_id', 'start_date', 'end_date'], 'required'],
            [['school_id', 'grade_id'], 'integer'],
            [['time_slots'], 'safe'], // Allow array for time slots
            [['start_date', 'end_date'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    /**
     * Define attribute labels for the form fields.
     */
    public function attributeLabels()
    {
        return [
            'school_id' => Yii::t('app', 'School'),
            'grade_id' => Yii::t('app', 'Grade'),
            'time_slots' => Yii::t('app', 'Preferred Time Slots'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }
}
