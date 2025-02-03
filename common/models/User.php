<?php

namespace common\models;

use common\libraries\CustomWidgets;
use common\libraries\SmartNSP;
use Yii;
use yii\base\NotSupportedException;
use yii\base\Security;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $name
 * @property string|null $name_ar
 * @property string|null $email
 * @property string|null $mobile
 * @property string|null $dob
 * @property string|null $gender
 * @property string|null $role
 * @property string $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property int|null $show_notification
 * @property string|null $language
 * @property string|null $status
 * @property string|null $status_ex
 * @property string|null $business_website
 * @property string|null $social_instagram
 * @property string|null $social_facebook
 * @property string|null $create_time
 * @property string $update_time
 * @property int $plan_id
 * @property string|null $plan_renewal_date
 * @property string|null $plan_expiry_date
 * @property float|null $plan_amount
 *
 * @property string $password write-only password
 *
 * @property string $imageUrl
 * @property Announcement[] $announcements
 * @property Attendance[] $attendances
 * @property FeedComments[] $feedComments
 * @property FeedLikes[] $feedLikes
 * @property Feed[] $feeds
 * @property GradeTeacher[] $gradeTeachers
 * @property Grade[] $grades
 * @property Student $selectedStudent
 * @property Student[] $students
 * @property UserAttributes[] $userAttributes
 * @property Sale[] $outgoingSales user created the invoice
 * @property Sale[] $incomingSales user is the payer
 *
 */

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    public $plainPassword; // Temporary property to store plain password
    const SCENARIO_NEW_USER = 'new_user';

    public $gradeTeacherSchedules = []; // This will hold an array of GradeTeacherSchedule models

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            TimestampBehavior::class,
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dob', 'create_time', 'update_time', 'plan_renewal_date', 'plan_expiry_date'], 'safe'],
            [['gender', 'role'], 'string'],
            [['auth_key'], 'required'],
            [['show_notification', 'plan_id'], 'integer'],
            [['plan_amount'], 'number'],
            [['username', 'name', 'name_ar', 'email', 'mobile', 'auth_key', 'password_hash', 'password_reset_token', 'language', 'status', 'status_ex'], 'string', 'max' => 255],
            [['business_website', 'social_instagram', 'social_facebook'], 'string', 'max' => 500],
            [['username'], 'unique'],
            [['email'], 'unique'],
//            [['mobile'], 'unique'],
            [['password_reset_token'], 'unique'],

            [['email'], 'email'], // Valid email format

            [['email'], 'required', 'on' => self::SCENARIO_NEW_USER], // Required fields for new user

            // Ensure that mobile is unique within the same role
            [['mobile'], 'unique', 'targetAttribute' => ['role', 'mobile'], 'message' => Yii::t('app', 'The mobile number must be unique for the same role.')],

            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::class, 'targetAttribute' => ['plan_id' => 'id']],

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_NEW_USER] = ['email']; // Fields required for new user
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'name' => Yii::t('app', 'Name'),
            'name_ar' => Yii::t('app', 'Name Ar'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'dob' => Yii::t('app', 'Dob'),
            'gender' => Yii::t('app', 'Gender'),
            'role' => Yii::t('app', 'Role'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'show_notification' => Yii::t('app', 'Show Notification'),
            'language' => Yii::t('app', 'Language'),
            'status' => Yii::t('app', 'Status'),
            'status_ex' => Yii::t('app', 'Status Ex'),
            'business_website' => Yii::t('app', 'Business Website'),
            'social_instagram' => Yii::t('app', 'Social Instagram'),
            'social_facebook' => Yii::t('app', 'Social Facebook'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'plan_id' => Yii::t('app', 'Plan ID'),
            'plan_renewal_date' => Yii::t('app', 'Plan Renewal Date'),
            'plan_expiry_date' => Yii::t('app', 'Plan Expiry Date'),
            'plan_amount' => Yii::t('app', 'Plan Amount'),
        ];
    }

    public static function findById($validateStatus = true)
    {
        if ($validateStatus) {
            return static::findOne(['id' => Yii::$app->user->id, 'status' => 'active']);
        } else {
            return static::findOne(['id' => Yii::$app->user->id]);
        }
    }

    /**
     * @return Grade|null
     */
    public static function getCurrentGrade()
    {
        $gt = User::findById(false)->getGradeTeachers()->andWhere(['grade_id' => $_POST['grade_id'] ?? '0'])->one();
        if (!empty($gt)) {
            return $gt->grade;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id, $activeOnly = false)
    {
        if ($activeOnly) return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return static::findOne(['id' => $id]);
    }

    public static function findByMobile($enteredData) {
        $user = static::findOne(['mobile' => $enteredData, 'status' => self::STATUS_ACTIVE]);
        if (!isset($user)) {
            $user = static::findOne(['mobile' => '0' . $enteredData, 'status' => self::STATUS_ACTIVE]);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds school by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findSchool($id)
    {
        return static::findOne(['id' => $id, 'role' => 'school']);
    }

    /**
     * Finds teacher by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findTeacher($id)
    {
        return static::findOne(['id' => $id, 'role' => 'teacher']);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new password
     */
    public function generatePassword()
    {
        $this->plainPassword = Yii::$app->security->generateRandomString(8);
        $this->setPassword($this->plainPassword);
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /**
     * Generates a unique username based on the user's name and email.
     */
    public function generateUniqueUsername()
    {
        // Extract name and email parts
//        $name = $this->name ?? '';
        $emailPrefix = explode('@', $this->email)[0]; // Get the part before '@' in email

        // Generate initial username by combining name and email prefix
        $baseUsername = Inflector::slug($emailPrefix);

        // Ensure the username is less than 255 characters
        $username = mb_substr($baseUsername, 0, 254); // Reserving a character for uniqueness handling

        // Check if the username is already in use
        $counter = 0;
        while ($this->isUsernameTaken($username)) {
            // If the username is taken, append a number to make it unique
            $counter++;
            $username = mb_substr($baseUsername, 0, 254 - strlen($counter)) . $counter;
        }

        // Assign the generated unique username
        $this->username = $username;
    }

    /**
     * Checks if the given username is already taken.
     * @param string $username The username to check
     * @return bool True if the username is already taken, false otherwise
     */
    protected function isUsernameTaken($username)
    {
        return static::find()->where(['username' => $username])->exists();
    }

    public function getImageUrl() {
        $img = Image::readImage('user', $this->id);
        if ($img['success']) {
            return $img['data'][0];
        }
        return '';
    }

    /**
     * Gets query for [[Announcements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncements()
    {
        return $this->hasMany(Announcement::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Attendances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[FeedComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedComments()
    {
        return $this->hasMany(FeedComments::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[FeedLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedLikes()
    {
        return $this->hasMany(FeedLikes::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Feeds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeds()
    {
        return $this->hasMany(Feed::class, ['user_id' => 'id'])->andOnCondition(['status' => 'active']);
    }

    /**
     * Gets query for [[GradeTeachers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGradeTeachers($school_id = null)
    {
        if (!empty($school_id)) return $this->hasMany(GradeTeacher::class, ['teacher_id' => 'id', 'school_id' => $school_id]);
        return $this->hasMany(GradeTeacher::class, ['teacher_id' => 'id']);
    }

    // Teachers linked with this school, parents, or both merged
    public function getAssociatedPeople($includeTeachers = true, $includeParents = true, $studentsOnly = false, $gradesOnly = false) {
        $uniqueTeachers = [];
        $uniqueParents = [];
        $uniqueStudents = [];

        $school = User::findById();

        // Ensure $school is not null
        if (!$school) {
            return [];
        }

        // Step 1: Get unique teacher IDs
        if ($includeTeachers) {
            $teachers = GradeTeacher::find()
                ->where(['school_id' => $school->id])
                ->all();
            if ($teachers) {
                $teacherMap = ArrayHelper::map($teachers, 'teacher_id', 'teacher_id');
                $uniqueTeachers = array_values(array_unique($teacherMap));
            }
        }

        if ($includeParents || $studentsOnly || $gradesOnly) {
            // Step 2: Get unique grade IDs
            $grades = Grade::find()
                ->where(['school_id' => $school->id])
                ->all();
            $uniqueGrades = [];

            if ($grades) {
                $gradeMap = ArrayHelper::map($grades, 'id', 'id');
                $uniqueGrades = array_values(array_unique($gradeMap));
            }
            if ($gradesOnly) {
                return $uniqueGrades; // Return early if only grades are required
            }

            if (!empty($uniqueGrades)) {
                // Step 3: Get unique parent IDs of active students in those grades
                $students = Student::find()
                    ->where(['IN', 'grade_id', $uniqueGrades])
                    ->all();

                if ($students) {
                    $parentMap = ArrayHelper::map($students, 'parent_id', 'parent_id');
                    $uniqueParents = array_values(array_unique($parentMap));
                }

                if ($studentsOnly && !empty($uniqueParents)) {
                    $schoolStudents = Student::find()
                        ->where(['IN', 'grade_id', $uniqueGrades])
                        ->andWhere(['IN', 'parent_id', $uniqueParents])
                        ->all();

                    if ($schoolStudents) {
                        $studentMap = ArrayHelper::map($schoolStudents, 'id', 'id');
                        $uniqueStudents = array_values(array_unique($studentMap));
                    }

                    // Null the following to show only student IDs
                    $uniqueParents = [];
                    $uniqueTeachers = [];
                }
            }
        }
        // Step 4: Merge all unique values into a single array
        $result = array_merge($uniqueTeachers, $uniqueParents, $uniqueStudents);

        // Remove duplicates in the merged array as well
        $result = array_unique($result);
        return $result;

//            $schoolGrades = ArrayHelper::map(Grade::find()->where(['school_id' => $school->id])->all(), 'id', 'id');
//            $uniqueGrades = array_values(array_unique($schoolGrades));
//            if ($gradesOnly) return $uniqueGrades;
//            // Step 3: Get unique parent IDs of active students in those grades
//            $parents = ArrayHelper::map(Student::find()->where(['IN', 'grade_id', $uniqueGrades])
////                ->andWhere(['status' => 'active'])
//                ->all(), 'parent_id', 'parent_id');
//            $uniqueParents = array_values(array_unique($parents));
//
//            if ($studentsOnly) {
//                $schoolStudents = ArrayHelper::map(
//                    Student::find()
//                        ->where(['IN', 'grade_id', $uniqueGrades])
//                        ->andWhere(['IN', 'parent_id', $uniqueParents])
////                        ->andWhere(['status' => 'active'])
//                        ->all(),
//                    'id', 'id');
//                $uniqueStudents = array_values(array_unique($schoolStudents));
//                //Null the following to show only student IDs
//                $uniqueParents = [];
//                $uniqueTeachers = [];
//            }
//        }

        // Step 4: Merge all unique values into a single array
//        $result = array_merge($uniqueTeachers, $uniqueParents, $uniqueStudents);
//
//        // Optionally, if you want to remove duplicates in the merged array as well
//        $result = array_unique($result);
//        return $result;
    }

    /**
     * Gets query for [[Grades]].
     * To fetch grades of the teacher
     * @return \yii\db\ActiveQuery
     */
    public function getGrades($school_id = null)
    {
        return $this->hasMany(Grade::class, ['id' => 'grade_id'])
            ->viaTable('grade_teacher', ['teacher_id' => 'id'], function($query) use ($school_id) {
                if (!empty($school_id)) $query->andWhere(['grade_teacher.school_id' => $school_id]); // Apply condition on the grade_teacher table
            });

//        return $this->hasMany(Grade::class, ['id' => 'grade_id'])
//            ->viaTable('grade_teacher', ['teacher_id' => 'id'])
//            ->andWhere(['grade_teacher.school_id' => $school_id]); // Add the condition
    }

    /**
     * Gets query for [[GradeTeachers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherGrades($school_id = null)
    {
        $query = $this->hasMany(GradeTeacher::class, ['teacher_id' => 'id']);
        if (!empty($school_id)) {
            $query->andWhere(['school_id' => $school_id]);
        }
        return $query;
    }

    /**
     * Gets query for [[Grades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolGrades()
    {
        return $this->hasMany(Grade::class, ['school_id' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [Students].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSelectedStudent()
    {
        return $this->hasOne(Student::class, ['parent_id' => 'id'])->andOnCondition(['id' => $_POST['student_id'] ?? 0]);
    }

    /**
     * Gets query for [[Plan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::class, ['id' => 'plan_id']);
    }

    /**
     * Gets query for [[UserAttributes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAttributes()
    {
        return $this->hasMany(UserAttributes::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Sales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutgoingSales()
    {
        return $this->hasMany(Sale::class, ['creator_id' => 'id', 'creator_model' => 'role']);
    }

    /**
     * Gets query for [[Sales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIncomingSales()
    {
        return $this->hasMany(Sale::class, ['payer_id' => 'id', 'payer_model' => 'role']);
    }

    public function removeHiddenCharacters() {
        $chars = CustomWidgets::$hiddenChars;
        foreach ($chars as $item) {
            $this->name = str_replace($item, '', $this->name ?? '');
            $this->name_ar = str_replace($item, '', $this->name_ar ?? '');
            $this->email = str_replace($item, '', $this->email ?? '');
            $this->mobile = str_replace($item, '', $this->mobile ?? '');
        }
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    function random_username() {
        if ($this->username != null && $this->username != '') return;
        if ($this->email == '') $this->email = null;


        if ($this->email != null) {
            $usernameRegex = '/(\w+)(@)(\w+)(\.\w+)/'; //Reads email and groups the part before @ as $1
            $this->username = preg_replace($usernameRegex, '$1', $this->email) . rand(1000, 9999);
            $this->username = str_replace('.', '', $this->username);
            $this->username = str_replace('-', '', $this->username);

        } else {
            $nrRand = rand(1000, 9999);
            $this->username = $this->generateRandomString() . $nrRand;
        }
    }

    function basicInfoJson() {
        $fields = ['id', 'name', 'email', 'mobile', 'gender', 'role', 'auth_key', 'status', 'status_ex'];
        $result = $this->toArray($fields);
        $result['image_url'] = $this->imageUrl;
        return $result;
    }

    public function getSchoolDp() {
        $img = Image::readImage('user', $this->id);
        if ($img['success']) {
            return $img['data'][0];
        }
        return '/images/school/school-0'. rand(1, 5) .'.jpg';
    }

    /**
     * Get all teachers associated with the current school by school ID.
     * @param bool $asArray Whether to return the results as an array
     * @return \yii\db\ActiveRecord[]|array
     */
    public function getTeachersOfSchool($asArray = false)
    {
        $query = User::find()
            ->innerJoin('grade_teacher', 'grade_teacher.teacher_id = user.id') // Join with the junction table
            ->innerJoin('grade', 'grade_teacher.grade_id = grade.id') // Join with the grade table
            ->where(['grade.school_id' => $this->id, 'user.role' => 'teacher']); // Filter by school_id and role


        if ($asArray) {
            return $query->asArray()->all(); // Return as an array if requested
        }

        return $query->all(); // Return as ActiveRecord objects
    }

    public function displayableTeachers() {
        $teacherData = [];
        foreach ($this->getTeachersOfSchool() as $teacher) {
            $teacherData[] = [
                'name' => $teacher->name,
                'image_url' => 'https://st5.depositphotos.com/4428871/65716/i/450/depositphotos_657161234-stock-photo-tell-more-text-button-keyboard.jpg',
            ];
        }

        return $teacherData;
    }

    public function getTeacherDevices()
    {
        return DevicePreferences::find()
            ->where(['project' => 'teacher'])
            ->andWhere(['title' => 'user_id'])
            ->andWhere(['value' => $this->id])
            ->all();
    }

    public function getParentDevices()
    {
        return DevicePreferences::find()
            ->where(['project' => 'parent'])
            ->andWhere(['title' => 'user_id'])
            ->andWhere(['value' => $this->id])
            ->all();
    }

    public function logoutDevice($user_id = null, $all = false) {
        if ($all) {
            $teachers = $this->getTeachersOfSchool();
            foreach ($teachers as $teacher) {
                $security = new Security();
                $teacher->auth_key = $security->generatePasswordHash($security->generateRandomKey());
                $teacher->save(false);
            }
            return true;
        }

        if (!empty($user_id)) {
            $teacher = User::findOne($user_id);
            $security = new Security();
            $teacher->auth_key = $security->generatePasswordHash($security->generateRandomKey());
            $teacher->save(false);
            return true;
        }
        return false;
    }

    public function linkGrades(array $selectedGrades, $school_id)
    {
        foreach ($selectedGrades as $gradeIdOrTitle) {
            if (is_numeric($gradeIdOrTitle)) {
                // Existing grade, link by ID
                $grade = Grade::findOne($gradeIdOrTitle);
            } else {
                // New grade, create if it doesn't exist
                $grade = Grade::findOne(['title' => $gradeIdOrTitle, 'school_id' => $school_id]);
                if (!$grade) {
                    $grade = new Grade();
                    $grade->title = $gradeIdOrTitle;
                    $grade->school_id = $school_id;
                    $grade->save();
                }
            }

            if ($grade) {
                $exists = GradeTeacher::find()->where(['school_id' => $school_id, 'teacher_id' => $this->id, 'grade_id' => $grade->id])->one();

                if (empty($exists)) {
                    //Does not exist, add it
                    $teacher_grade = new GradeTeacher();
                    $teacher_grade->school_id = $grade->school_id;
                    $teacher_grade->grade_id = $grade->id;
                    $teacher_grade->teacher_id = $this->id;
                    $teacher_grade->save();
                }
            }
        }
    }

    public function loadGradeTeacherSchedules($selectedGrades)
    {
        $this->gradeTeacherSchedules = [];
        foreach ($selectedGrades as $gradeId) {
            // Fetch all schedules for the given grade and teacher
            $schedules = GradeTeacherSchedule::find()
                ->where(['teacher_id' => $this->id, 'grade_id' => $gradeId])
                ->orderBy(['day_of_week' => SORT_ASC, 'start_time' => SORT_ASC])
                ->all();

            // Initialize a new GradeTeacherSchedule model for this grade
            $scheduleModel = new GradeTeacherSchedule();
            $scheduleModel->grade_id = $gradeId;
            $scheduleModel->teacher_id = $this->id;

            // Initialize empty arrays for each day of the week
            foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                $scheduleModel->schedule[$day] = ['start_time' => []];
            }

            // Populate the schedule array with formatted time slots
            foreach ($schedules as $schedule) {
                $day = $schedule->day_of_week;
                // Format start and end times to match '6am-7am' format
                $formattedTimeSlot = date('ga', strtotime($schedule->start_time)) . '-' . date('ga', strtotime($schedule->end_time));
                $scheduleModel->schedule[$day]['start_time'][] = $formattedTimeSlot;

                // Set start_date and end_date only once, assuming all records for the grade have the same date range
                if (empty($scheduleModel->start_date) && empty($scheduleModel->end_date)) {
                    $scheduleModel->start_date = date('Y-m-d', strtotime($schedule->start_date));
                    $scheduleModel->end_date = date('Y-m-d', strtotime($schedule->end_date));
                }
            }

            // Assign the populated schedule model to the gradeTeacherSchedules array
            $this->gradeTeacherSchedules[$gradeId] = $scheduleModel;
        }
    }

//    public function sendTestNotification(){
//
//        $notificationService = new SmartNSP();
//        $notificationService->sendPush(1);
//
////        $notificationService->sendEmail();
////        $notificationService->setReceiverEmail($this->email);
//
//        return $notificationService->createNotification('mybaby',
//            $this->id,
//            Yii::t('app', 'Invitation to join MyBaby'),
//            Yii::t('app', 'You have been invited to join MyBaby as a Teacher')
//        );
//    }

    //Will notify user via email and push notification
    public function sendInvoiceNotification($invoice_id, $custom_text = null){
        $sale = Sale::findOne(['invoice_id' => $invoice_id]);
        if (!empty($sale)) {
            $lang = $this->language ?? 'ar';
            // Fetch HTML content from the URL
            $invoiceHtml = file_get_contents($sale->invoice_url . '&returnHtmlContent=true' . '&lang='.$lang);
            if ($invoiceHtml === false) {
                Yii::error("Unable to fetch invoice HTML from URL: " . $sale->invoice_url);
                return false;
            }

            $notificationService = new SmartNSP();;
            $notificationService->sendPush(1);
            $notificationService->sendEmail();
            $notificationService->setReceiverEmail($this->email);
            $notificationService->setEmailHtml($invoiceHtml);

            $invoice_status = '';
            if (empty($custom_text)) {
                if ($sale->status == 'paid') $invoice_status = ' - ' . Yii::t('app', 'PAID');
                if ($sale->status == 'unpaid') $invoice_status = ' - ' . Yii::t('app', 'UNPAID');
            } else {
                $invoice_status = ' - ' . $custom_text;
            }

            $notificationService->createNotification('mybaby',
                $this->id,
                Yii::t('app', 'Invoice #'). $sale->invoice_id . $invoice_status,
                Yii::t('app', 'MyBaby'),
            );
        }
        return false;
    }

    public function sendPasswordResetEmail($new_password){

        $this->password_reset_token = $new_password;
        $this->save(false);

        $notificationService = new SmartNSP();;

        $notificationService->sendPush(0);
        $notificationService->sendEmail();
        $notificationService->setReceiverEmail($this->email);

        $notificationService->setEmailData([
            'template_id' => 3,
            'name' => 'Password Reset',
            'school_name' => 'MyBaby',
            'your_role' => ucfirst($this->role),
            'password' => $new_password,
            'project_name' => 'MyBaby App',
            'app_url' => 'https://welcome.mybabyapp.net/site/index?lang=ar#download',
            'website_url' => 'https://welcome.mybabyapp.net',
        ]);

        return $notificationService->createNotification('mybaby',
            $this->id,
            Yii::t('app', 'Password Reset'),
            Yii::t('app', 'You have requested to reset your password at MyBaby')
        );
    }

    public function sendParentInvitationEmail($new_password){

        $this->password_reset_token = $new_password;
        $this->save(false);

//        return;

        $notificationService = new SmartNSP();;


        $notificationService->sendPush(0);
        $notificationService->sendEmail();
        $notificationService->setReceiverEmail($this->email);

        $notificationService->setEmailData([
            'template_id' => 3,
            'name' => 'New User',
            'school_name' => $school->name ?? 'MyBaby',
            'your_role' => ucfirst($this->role),
            'password' => $new_password,
            'project_name' => 'MyBaby App',
            'app_url' => 'https://welcome.mybabyapp.net/site/index?lang=ar#download',
            'website_url' => 'https://welcome.mybabyapp.net',
        ]);

        return $notificationService->createNotification('mybaby',
            $this->id,
            Yii::t('app', 'Invitation to join MyBaby'),
            Yii::t('app', 'You have been invited to join MyBaby as a Teacher')
        );
    }


    public function sendTeacherInvitationEmail($school_id, $new_password){
            $school = User::findSchool($school_id);

            $this->password_reset_token = $new_password;
            $this->save(false);

//            return;

            $notificationService = new SmartNSP();;


            $notificationService->sendPush(0);
            $notificationService->sendEmail();
            $notificationService->setReceiverEmail($this->email);

            $notificationService->setEmailData([
                'template_id' => 3,
                'name' => 'New User',
                'school_name' => $school->name ?? 'MyBaby',
                'your_role' => ucfirst($this->role),
                'password' => $new_password,
                'project_name' => 'MyBaby App',
                'app_url' => 'https://welcome.mybabyapp.net/site/index?lang=ar#download',
                'website_url' => 'https://welcome.mybabyapp.net',
            ]);

            return $notificationService->createNotification('mybaby',
                $this->id,
                Yii::t('app', 'Invitation to join MyBaby'),
                Yii::t('app', 'You have been invited to join MyBaby as a Teacher')
            );
    }

    public function sendSchoolInvitationEmail($new_password){
        $notificationService = new SmartNSP();

        $notificationService->sendPush(0);
        $notificationService->sendEmail();
        $notificationService->setReceiverEmail($this->email);

        $notificationService->setEmailData([
            'template_id' => 4,
            'name' => 'New User',
            'your_role' => 'School',
            'password' => $new_password,
            'project_name' => 'MyBaby App',
            'app_url' => 'https://dash.mybabyapp.net',
            'website_url' => 'https://welcome.mybabyapp.net',
        ]);

        return $notificationService->createNotification('mybaby',
            $this->id,
            Yii::t('app', 'Invitation to join MyBaby'),
            Yii::t('app', 'You have been invited to join MyBaby')
        );
    }

    public function sendSchoolPlanUpgradeEmail($isUpgrade = false){
        $notificationService = new SmartNSP();

        $notificationService->sendPush(0);
        $notificationService->sendEmail();
        $notificationService->setReceiverEmail($this->email);

        new \DateTime('now');
        $notificationService->setEmailData([
            'template_id' => 6,
            'name' => $this->name,
            "action" => $isUpgrade ? Yii::t('app', 'upgraded') : Yii::t('app', 'renewed'),
            "plan_name" => Yii::$app->language == 'en' ? $this->plan->name : $this->plan->name_ar,
            "start_date"=> $this->plan_renewal_date ?? (new \DateTime('now'))->format('Y-m-d'),
            "expiry_date" => $this->plan_expiry_date ?? (new \DateTime('now'))->format('Y-m-d'),
            'project_name' => 'MyBaby App',
            'app_url' => 'https://dash.mybabyapp.net',
            'website_url' => 'https://welcome.mybabyapp.net',
        ]);

        return $notificationService->createNotification('mybaby',
            $this->id,
            Yii::t('app', 'Plan Renewal'),
            Yii::t('app', 'Your plan has been updated')
        );
    }

    public function getGroups()
    {
        return $this->hasMany(Groups::class, ['id' => 'group_id'])
            ->viaTable('group_members', ['user_id' => 'id']);
    }

    private function beautifulReturn($success = false, $message = '', $status = 400) {
        return [
            'success' => $success,
            'message' => $message,
            'status' => $status
        ];
    }

    public function applyPlan($plan_id) {
        $plan = Plan::findOne($plan_id);
        if ($plan !== null) {
            $currentDate = new \DateTime();
            $plan_renewal_date = $currentDate->format('Y-m-d H:i:s');

            $remaining_days = 0;
            if (!empty($this->plan_renewal_date)) $remaining_days = self::calculatePlanRemainingDays();
            $remaining_days = max($remaining_days, 0);
            if ($remaining_days > 0) {
                //Add remaining days into the calculation
                $expiryDate = new \DateTime($this->plan_expiry_date);
                $expiryDate->modify('+' . $plan->subscription_period . ' days');
                $plan_expiry_date = $expiryDate->format('Y-m-d H:i:s');
            } else {
                //if plan expired a while ago, just add the subscription period
                $expiryDate = clone $currentDate;
                $expiryDate->modify('+' . $plan->subscription_period . ' days');
                $plan_expiry_date = $expiryDate->format('Y-m-d H:i:s');
            }

            $this->updateAttributes([
                'plan_renewal_date' => $plan_renewal_date,
                'plan_expiry_date' => $plan_expiry_date,
                'plan_id' => $plan_id,
            ]);

            $this->validatePlan();
            return $this->beautifulReturn(true, $plan->name . ' Plan Assigned', 200);
        }
        return $this->beautifulReturn(false, 'Plan not found', 400);
    }

    public function validatePlan() {
        //Means no plan was assigned yet. Assign Trial Plan
        if ($this->role == 'school') {
            if (empty($this->plan_renewal_date)) {
                $this->applyPlan(1);
            }

            // Check if the plan is expired
            $currentDate = new \DateTime();
            $planExpiryDate = new \DateTime($this->plan_expiry_date);

            if ($planExpiryDate < $currentDate) {
                $this->status_ex = 'plan_expired';

                $this->updateAttributes([
                    'status_ex' => $this->status_ex,
                ]);
                return false;
            } else {
                if ($this->status_ex == 'plan_expired') {
                    $this->status_ex = NULL;
                }
                if ($this->status == 'pending') {
                    $this->status = 'active';
                }

                $this->updateAttributes([
                    'status' => $this->status,
                    'status_ex' => $this->status_ex,
                ]);
            }
        }
        return true;
    }

    public function calculatePlanRemainingDays() {

        //Means no plan was assigned yet. Assign Trial Plan
        if (empty($this->plan_renewal_date)) {
            $this->applyPlan(1);
        }

        // Check if the plan is expired
        $currentDate = new \DateTime();
        $planExpiryDate = new \DateTime($this->plan_expiry_date);

        // Calculate the difference between the current date and the plan expiry date
        $interval = $currentDate->diff($planExpiryDate);

        // Get the number of days remaining
        $daysRemaining = $interval->format('%r%a'); // %r gives the sign (+/-), %a gives the total days

        return $daysRemaining;
    }


    public function planInformation() {
        //Plan should not be null though
        if (!isset($this->plan)) {
            return self::beautifulReturn(false, 'Plan not set', 401);
        }
        //If current plan is for lifetime
        if (empty($this->plan_expiry_date)) {
            $_return = self::beautifulReturn(true, 'Information fetched', 200);
            $_return['data'] = [
                'id' => $this->plan_id,
                'title' => Yii::$app->language == 'en' ? $this->plan->name : $this->plan->name_ar,
                'subtitle' => Yii::t('app', 'Lifetime'),
                'plan_amount' => 0,
                'plan_renewal' => $this->plan_renewal_date,
                'plan_expiry' => $this->plan_expiry_date,
                'upgrade_to' => $this->plan->upgrade_to,
                'remaining_balance' => sprintf('%.2f',0),
                'status' => $this->status_ex == 'plan_expired' ? Yii::t('app', 'Your subscription is expired') : Yii::t('app', 'Your subscription is active'),
            ];
            return $_return;
        }

        $renewal_date = date_create_from_format('Y-m-d H:i:s', $this->plan_renewal_date);
        $expiry_date = date_create_from_format('Y-m-d H:i:s', $this->plan_expiry_date);
        $today = new \DateTime("now");

        $_subscriptionDays = date_diff($renewal_date, $expiry_date)->days + 1;
        $_subscriptionRemainingDays = date_diff($today, $expiry_date)->format('%r%a');
        $_subscriptionRemainingDays += 1;
        $_planAmount = $this->plan_amount;

        if (isset($_planAmount) && !is_null($_planAmount) && $_planAmount > 0) {
            $_costPerDay = $this->plan_amount / $_subscriptionDays;
            $remaining_balance = sprintf('%.2f',($_costPerDay * $_subscriptionRemainingDays));
        } else {
            $_costPerDay = $this->plan->price / $_subscriptionDays;
            $remaining_balance = sprintf('%.2f',($_costPerDay * $_subscriptionRemainingDays));
        }
        $_costPerDay = sprintf('%.2f', $_costPerDay);

        $_return = self::beautifulReturn(true, 'Information fetched', 200);
        $expiry = new \DateTime($this->plan_expiry_date);
        $_return['data'] = [
            'id' => $this->plan_id,
            'title' => Yii::$app->language == 'en' ? $this->plan->name : $this->plan->name_ar,
            'subtitle' => Yii::t('app', 'Expires: ') . $expiry->format('M d, Y'),

            'plan_amount' => $_planAmount,
            'plan_renewal' => $this->plan_renewal_date,
            'plan_expiry' => $this->plan_expiry_date,
            'upgrade_to' => $this->plan->upgrade_to,
            'today' => $today->format('Y-m-d H:i:s'),
            'subscription_period' => $_subscriptionDays . ' days',
            'remaining_days' => $_subscriptionRemainingDays,
            'cost_per_day' => $_costPerDay,
            'remaining_balance' => $remaining_balance,
            'status' => $this->status_ex == 'plan_expired' ? Yii::t('app', 'Your subscription is expired') : Yii::t('app', 'Your subscription is active'),
        ];

        return $_return;
    }

    public static function getSchoolAttendanceMetrics()
    {
        $student_ids = Yii::$app->user->identity->getAssociatedPeople(false, false, true);

        $currentYear = date('Y');
        $lastYear = $currentYear - 1;

        // Fetch attendance data grouped by month for the current year
        $currentYearAttendance = Attendance::find()
            ->select([
                'month' => 'MONTH(create_time)',
                'total_time' => 'SUM(
                IF(
                    time_out IS NULL, 
                    TIMESTAMPDIFF(MINUTE, time_in, DATE_ADD(time_in, INTERVAL 1 HOUR)), 
                    TIMESTAMPDIFF(MINUTE, time_in, time_out)
                )
            )'
            ])
            ->where(['YEAR(create_time)' => $currentYear])
            ->andWhere(['IN' , 'student_id', $student_ids])
            ->groupBy(['MONTH(create_time)'])
            ->indexBy('month')
            ->asArray()
            ->all();

        // Fetch attendance data grouped by month for the last year
        $lastYearAttendance = Attendance::find()
            ->select([
                'month' => 'MONTH(create_time)',
                'total_time' => 'SUM(
                IF(
                    time_out IS NULL, 
                    TIMESTAMPDIFF(MINUTE, time_in, DATE_ADD(time_in, INTERVAL 1 HOUR)), 
                    TIMESTAMPDIFF(MINUTE, time_in, time_out)
                )
            )'
            ])
            ->where(['YEAR(create_time)' => $lastYear])
            ->andWhere(['IN' , 'student_id', $student_ids])
            ->groupBy(['MONTH(create_time)'])
            ->indexBy('month')
            ->asArray()
            ->all();

        // Prepare data for 12 months
        $currentYearData = [];
        $lastYearData = [];
        for ($month = 1; $month <= 12; $month++) {
            $currentYearData[] = isset($currentYearAttendance[$month]) ? round($currentYearAttendance[$month]['total_time'] / 60, 2) : 0;
            $lastYearData[] = isset($lastYearAttendance[$month]) ? round($lastYearAttendance[$month]['total_time'] / 60, 2) : 0;
        }

        return [
            'currentYear' => $currentYearData,
            'lastYear' => $lastYearData,
        ];
    }

    public function generateUserAccess($teacher_id) {
        $user_attributes = UserAttributes::find()->where(['user_id' => $teacher_id])->andWhere(['key' => 'homepage_access'])->one();
        if ( empty($user_attributes) ) {
            $allOptions = ['announcement', 'upcoming_event', 'attendance', 'result', 'social_media'];
            $user_attributes = new UserAttributes();
            $user_attributes->user_id = $teacher_id;
            $user_attributes->key = 'homepage_access';
            $user_attributes->value = implode(',', $allOptions);
            $user_attributes->type = 'public';
            $user_attributes->save();
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert && $this->role == 'school') {
            //If it's a school signup, assign trial plan to his account
            $this->applyPlan(1);
        }

        if ($this->role == 'teacher') {
            //If it's a school signup, assign trial plan to his account
            $this->generateUserAccess($this->id);
        }

    }

}
