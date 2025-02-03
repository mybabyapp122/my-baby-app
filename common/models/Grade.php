<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property int $id
 * @property int|null $school_id user table
 * @property string|null $title
 *
 * @property GradeTeacher[] $gradeTeachers
 * @property User $school
 * @property GradeRatio $gradeRatio
 * @property Feed[] $feeds
 * @property Student[] $students
 * @property String $shortTitle
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['school_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'School ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[GradeTeachers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGradeTeachers()
    {
        return $this->hasMany(GradeTeacher::class, ['grade_id' => 'id']);
    }

    public function getTeachers()
    {
        return $this->hasMany(User::class, ['id' => 'teacher_id'])
            ->viaTable('grade_teacher', ['grade_id' => 'id']);
    }

    /**
     * Gets query for [[School]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(User::class, ['id' => 'school_id']);
    }

    /**
     * Gets query for [[Feeds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeds()
    {
        return $this->hasMany(Feed::class, ['grade_id' => 'id']);
    }

    /**
     * Gets query for [[GradeRatio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGradeRatio()
    {
        return $this->hasOne(GradeRatio::class, ['grade_id' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::class, ['grade_id' => 'id']);
    }

    function getShortTitle() {
        $title = trim($this->title);
        $shortTitle = '';

        // Step 1: Check for digits at the end
        if (preg_match('/^([A-Za-z])(\D*)(\d+)$/u', $title, $matches)) {
            // If digits at the end exist: First letter + digits
            $shortTitle = $matches[1] . $matches[3];
        } else {
            // Step 2: If no digits, split the title into words
            $words = preg_split('/\s+/u', $title); // Split by spaces

            if (count($words) > 1) {
                // Take the first letter of the first two words
                $shortTitle =
                    mb_strtoupper(mb_substr($words[0], 0, 1)) .
                    mb_strtoupper(mb_substr($words[1], 0, 1));
            } else {
                // Single word: Take the first letter
                $shortTitle = mb_strtoupper(mb_substr($words[0], 0, 1));
            }
        }

        return $shortTitle;
    }

    function toBasicJson() {
        $data = $this->toArray(['id', 'title']);
        $data['short_title'] = $this->shortTitle;
        $data['school_name'] = isset($this->school) ? $this->school->name : '';
        $data['school_id'] = isset($this->school) ? $this->school->id : 0;
        return $data;
    }

    public function linkTeachers($school_id, $selectedTeachers = null)
    {
        if (empty($selectedTeachers)) {
            GradeTeacher::updateAll(['grade_id' => NULL],['school_id' => $school_id, 'grade_id' => $this->id]);
            return;
        }
        foreach ($selectedTeachers as $teacherId) {
            $teacher = User::findTeacher($teacherId);
            if ($teacher) {
                $exists = GradeTeacher::find()->where(['school_id' => $school_id, 'teacher_id' => $teacherId, 'grade_id' => $this->id])->one();

                if (empty($exists)) {
                    //Does not exist, add it
                    $teacher_grade = new GradeTeacher();
                    $teacher_grade->school_id = $school_id;
                    $teacher_grade->grade_id = $this->id;
                    $teacher_grade->teacher_id = $teacherId;
                    $teacher_grade->save();
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Check if a GradeRatio already exists for this Grade
        $existingRatio = GradeRatio::findOne(['grade_id' => $this->id]);

        // If no GradeRatio exists, create one with default values (1:4)
        if ($existingRatio === null) {
            $defaultTeacherRatio = 1;
            $defaultStudentRatio = 4;

            $gradeRatio = new GradeRatio();
            $gradeRatio->grade_id = $this->id;
            $gradeRatio->teacher_ratio = $defaultTeacherRatio;
            $gradeRatio->student_ratio = $defaultStudentRatio;
            $gradeRatio->save(false); // Use save(false) to skip validation if not needed
        }
    }
}
