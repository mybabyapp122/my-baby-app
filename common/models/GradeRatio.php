<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grade_ratio".
 *
 * @property int $id
 * @property int $grade_id
 * @property int $teacher_ratio
 * @property int $student_ratio
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property Grade $grade
 */
class GradeRatio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade_ratio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade_id'], 'required'],
            [['grade_id', 'teacher_ratio', 'student_ratio'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::class, 'targetAttribute' => ['grade_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'grade_id' => Yii::t('app', 'Grade ID'),
            'teacher_ratio' => Yii::t('app', 'Teacher Ratio'),
            'student_ratio' => Yii::t('app', 'Student Ratio'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[Grade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(Grade::class, ['id' => 'grade_id']);
    }
}
