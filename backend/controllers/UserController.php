<?php

namespace backend\controllers;

use common\models\Grade;
use common\models\GradeTeacherSchedule;
use common\models\Image;
use common\models\Plan;
use common\models\Status;
use common\models\User;
use common\models\UserAttributes;
use common\models\UserSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\libraries\CustomWidgets;
use yii\web\Response;
use yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    /**
     * @inheritDoc
     */
//    public function behaviors()
//    {
//        return array_merge(
//            parent::behaviors(),
//            [
//                'verbs' => [
//                    'class' => VerbFilter::className(),
//                    'actions' => [
//                        'delete' => ['POST'],
//                    ],
//                ],
//            ]
//        );
//    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionSchools()
    {
        if (Yii::$app->user->can('admin')) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search($this->request->queryParams, 'school');

            $columns = [
                'id', 'name',
                [
                    'attribute' => 'status',
                    'format' => 'raw', // Enables rendering HTML
                    'value' => function ($model) {
                        $checked = $model->status == 'active' ? 'checked' : '';
                        return '<span class="badge badge-pill '.  ($model->status == "active" ? "bg-success" : "bg-danger") .'">'. ucfirst($model->status) .'</span>' . '<p class="text-muted mb-0 italic">'. Status::readStatus($model->status_ex) .'</p>';
                    },
                ],
            ];

            return $this->render('index', [
                'title' => 'Schools',
                'update_action' => 'update-school',
                'view_action' => 'view-school',
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columns' => $columns,
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

    }
    public function actionLoginByAccessToken()
    {
        if (Yii::$app->user->can('admin')) {
            if (empty($_REQUEST['id'])) {
                throw new BadRequestHttpException();
            }
            $user = User::find()->where(['auth_key' => $_REQUEST['id']])->one();
            if (is_null($user)) {
                throw new BadRequestHttpException();
            }
            Yii::$app->user->login($user, 0);
            return $this->goHome();
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionTeachers($school_id, $return_partial = false)
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 'teacher', $school_id);

        $columns = [
            'id',
            'name',
            [
                'attribute' => 'status',
                'format' => 'raw', // Enables rendering HTML
                'value' => function ($model) {
                    $checked = $model->status == 'active' ? 'checked' : '';
                    return '<span class="badge badge-pill '.  ($model->status == "active" ? "bg-success" : "bg-danger") .'">'. ucfirst($model->status) .'</span>' . '<p class="text-muted mb-0 italic">'. Status::readStatus($model->status_ex) .'</p>';
                },
            ],
        ];

        $params = [
            'title' => 'Teachers',
            'update_action' => 'update-teacher',
            'update_schedule_action' => 'update-teacher-schedule',
            'update_access_action' => 'update-teacher-access',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'school_id' => $school_id,
        ];

        if ($return_partial) {
            return $this->renderPartial('view/_teachers', $params);
        }

        return $this->render('view/_teachers', $params);
    }

    public function actionUpdateSchool() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = $_REQUEST['id'] ?? $_REQUEST['User']['id'] ?? 0;

        $model = User::findSchool($id);
        if (empty($model)) {
            $model = new User();
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->scenario = User::SCENARIO_NEW_USER; // Set the scenario
            $new_password = '';
            $send_invite = false;

            if ($model->isNewRecord) {
                $model->generateUniqueUsername();
                $model->generatePassword();
                $model->generateAuthKey();
                $model->role = 'school';
                $model->status = 'pending';
                $new_password = $model->plainPassword;
                $send_invite = true;
            }

            if (Yii::$app->request->isAjax) {
                if ($model->validate() && $model->save(false)) {
                    if ($send_invite) $model->sendSchoolInvitationEmail($new_password);
                    return [
                        'success' => true,
                        'message' => Yii::t('app', 'Changes saved')
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => Yii::t('app', 'Failed to save'),
                        'error' => $model->getErrors(),
                    ];
                }

            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return CustomWidgets::returnSuccess([
            'heading' => Yii::t('app', 'School Invitation Form'),
            'body' => $this->renderAjax('_school_form', [
                'model' => $model,
            ]),
        ]);
    }


    public function actionUpdateTeacherAccess()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        print_r($_REQUEST);die();
        $id = $_REQUEST['teacher_id'] ?? 0;

//        $id = $_REQUEST['teacher_id'];


        $model = UserAttributes::find()
            ->where(['user_id' => $id])
            ->andWhere(['key' => 'homepage_access'])
            ->one();
        if (empty($model)) {
            $model = new UserAttributes();
        }

        if ($this->request->isPost && Yii::$app->request->isAjax) {
            // Load and save grade schedules

            $selectedAttributes = $_POST['UserAttributes']['value'] ?? [];

//            if (!empty($selectedAttributes)) {
                $model->user_id = $id;
                $model->key = 'homepage_access';
                $model->value = implode(',', $selectedAttributes) ?? NULL;
                $model->save();
//            }

            return [
                'success' => true,
                'message' => Yii::t('app', 'Changes saved'),
                'data' => $model,
            ];

        }
        $allOptions = ['announcement', 'upcoming_event', 'attendance', 'result', 'social_media'];

        //CHECK IF IT IS ALLOWED AS PER SCHOOL PLAN OR NOT
        $school = Yii::$app->user->identity;
        if ( !(Plan::PLANS[(string)$school->plan_id]['teacher_access_management']) ) {
            return CustomWidgets::returnSuccess([
                'heading' => Yii::t('app', 'Upgrade Your Plan'),
                'body' => $this->renderAjax('/user/_upgrade_plan', [
                ]),
            ]);
        }

        return CustomWidgets::returnSuccess([
            'heading' => Yii::t('app', 'Save'),
            'body' => $this->renderAjax('view/_access', [
                'model' => $model,
                'allOptions' => $allOptions,
                'teacher_id' => $id
            ]),
        ]);
    }



    public function actionUpdateTeacherSchedule()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = $_REQUEST['teacher_id'];
        $school_id = $_REQUEST['school_id'];

        $model = User::findTeacher($id);
        if (empty($model)) {
            return [
                'success' => false,
                'message' => Yii::t('app', 'Not found'),
            ];
        }
        $selectedGrades = ArrayHelper::map($model->getGrades($school_id)->all(), 'id', 'title');

        if ($this->request->isPost && Yii::$app->request->isAjax) {
            // Load and save grade schedules
            foreach ($selectedGrades as $gradeId => $gradeTitle) {
                $scheduleData = Yii::$app->request->post('GradeTeacherSchedule')[$gradeId] ?? [];

                if (!empty($scheduleData)) {
                    // Delete all existing schedules for this teacher and grade
                    GradeTeacherSchedule::deleteAll([
                        'teacher_id' => $model->id,
                        'grade_id' => $gradeId,
                    ]);
                }

                // Loop through the days of the week
                foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                    if (!empty($scheduleData['schedule'][$day]['start_time'])) {
                        // Loop through each selected time slot for the day
                        foreach ($scheduleData['schedule'][$day]['start_time'] as $timeSlot) {
                            // Extract start and end times from the selected slot (e.g., "6am-7am")
                            $times = explode('-', $timeSlot);
                            $startTime = date('H:i', strtotime($times[0])); // Convert to 24-hour format
                            $endTime = date('H:i', strtotime($times[1]));

                            // Create a new entry in the grade_teacher_schedule table
                            $gradeTeacherSchedule = new GradeTeacherSchedule();
                            $gradeTeacherSchedule->grade_id = $gradeId;
                            $gradeTeacherSchedule->teacher_id = $model->id;
                            $gradeTeacherSchedule->day_of_week = $day;
                            $gradeTeacherSchedule->start_time = $startTime;
                            $gradeTeacherSchedule->end_time = $endTime;
                            $gradeTeacherSchedule->start_date = $scheduleData['start_date'];
                            $gradeTeacherSchedule->end_date = $scheduleData['end_date'];

//                            $transaction = new yii\db\Transaction();
                            // Save the schedule entry to the database
                            if ($gradeTeacherSchedule->validate()) {
                                // Delete all existing schedules for this teacher and grade
//                                GradeTeacherSchedule::deleteAll([
//                                    'teacher_id' => $model->id,
//                                    'grade_id' => $gradeId,
//                                    'day_of_week' => $day,
//                                    'start_time' => $startTime,
//                                    'end_time' => $endTime,
//                                ]);
                            }
                            if (!$gradeTeacherSchedule->save()) {
                                return [
                                    'success' => false,
                                    'message' => Yii::t('app', 'Failed to save'),
                                    'error' => $gradeTeacherSchedule->getErrors(),
                                ];
                            }
                        }
                    }
                }
            }

            return [
                'success' => true,
                'message' => Yii::t('app', 'Changes saved'),
                'data' => $selectedGrades,
            ];

        }

        // Load grade schedules
        $model->loadGradeTeacherSchedules(array_keys($selectedGrades));
        Yii::$app->response->format = Response::FORMAT_JSON;

        return CustomWidgets::returnSuccess([
            'heading' => $model->isNewRecord ? 'Add Schedule' : 'Update Schedule',
            'body' => $this->renderAjax('view/_schedule', [
                'model' => $model,
                'school_id' => $school_id,
                'selectedGrades' => $selectedGrades,
            ]),
        ]);
    }

    public function actionUpdateTeacher() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = $_REQUEST['id'] ?? $_REQUEST['User']['id'] ?? 0;
        $school_id = $_REQUEST['school_id'] ?? $_REQUEST['User']['school_id'] ?? 0;
        $email = $_REQUEST['User']['email'] ?? '';

        $model = User::findTeacher($id);
        if (empty($model)) {
            $model = new User();
            if (!empty($email)) {
                $model = User::findByEmail($email);
                if (empty($model)) $model = new User();
            }
        }
        if ($this->request->isPost && $model->load($this->request->post())) {
            $new_password = '';
            $send_invite = false;
            if ($model->isNewRecord) {
                $model->scenario = User::SCENARIO_NEW_USER; // Set the scenario
                $model->generateUniqueUsername();
                $model->generatePassword();
                $model->generateAuthKey();
                $model->status = 'pending';
                $model->status_ex = 'invited';
                $model->role = 'teacher';
                $new_password = $model->plainPassword;
                $send_invite = true;
                //User added his info now generate auth key, generic password etc and
            }

            if (Yii::$app->request->isAjax) {
                if ($model->save()) {
                    if ($send_invite) $model->sendTeacherInvitationEmail($school_id, $new_password);
                    $selectedGrades = Yii::$app->request->post('User')['grades'] ?? [];
                     if (!empty($selectedGrades)) $model->linkGrades($selectedGrades, $school_id);

                    return [
                        'success' => true,
                        'message' => Yii::t('app', 'Changes saved'),
                        'data' => $selectedGrades,
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => Yii::t('app', 'Failed to save'),
                        'error' => $model->getErrors(),
                    ];
                }

            }
            return $this->redirect(Yii::$app->request->referrer);
        }

        // Load grade schedules
        $selectedGrades = yii\helpers\ArrayHelper::map($model->grades, 'id', 'title');
        $model->loadGradeTeacherSchedules(array_keys($selectedGrades));

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->isNewRecord) {
            //CHECK HOW MANY TEACHERS ALREADY ADDED AND ADDING MORE IS ALLOWED AS PER SCHOOL PLAN OR NOT
            $school = Yii::$app->user->identity;
            $teachers = count($school->getAssociatedPeople(true, false, false));

            if ($teachers >= Plan::PLANS[(string)$school->plan_id]['max_teachers']) {
                return CustomWidgets::returnSuccess([
                    'heading' => Yii::t('app', 'Upgrade Your Plan'),
                    'body' => $this->renderAjax('_upgrade_plan', [
                    ]),
                ]);
            }
        }

        $form = yii\widgets\ActiveForm::begin([
            'id' => 'teacher-form',
            'options' => ['class' => 'ajax-form'],
            'action' => ['update-teacher'],
        ]);
        return CustomWidgets::returnSuccess([
            'heading' => $model->isNewRecord ? 'Add Teacher' : 'Update Teacher',
            'body' => $this->renderAjax('_teacher_form', [
                'model' => $model,
                'school_id' => $school_id,
                'selectedGrades' => $selectedGrades,
                'form' => $form
            ]),
        ]);
    }

    public function actionDeleteSchool($id) {
        $model = User::findSchool($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteTeacher($id, $school_id = 4) {
        $model = User::findTeacher($id);
        $teacher_grades = $model->getTeacherGrades($school_id)->all();
        foreach ($teacher_grades as $grade) {
            $grade->delete();
        }
//        $model->delete();
        Yii::$app->session->setFlash('success', 'Deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Displays a single User model (SCHOOL).
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewSchool($id)
    {
        $school = User::findSchool($id);

        // Define the fields to check
        $fieldsToCheck = [
            'name',
//            'name_ar',
            'email',
            'mobile',
//            'business_website',
//            'social_instagram',
//            'social_facebook',
        ];

        // Calculate the percentage of completion
        $completedFields = 0;
        foreach ($fieldsToCheck as $field) {
            if (!empty($school->$field)) {
                $completedFields++;
            }
        }

        $totalFields = count($fieldsToCheck);
        $completionPercentage = ($completedFields / $totalFields) * 100;

        return $this->render('view', [
            'model' => $school,
            'completionPercentage' => number_format($completionPercentage, 0),
//            'devices' => $devices
        ]);
    }

    public function actionSchoolDeviceLogout()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $schoolId = Yii::$app->request->post('school_id');
            $teacherId = Yii::$app->request->post('teacher_id');
            $school = User::findSchool($schoolId);

            $action = Yii::$app->request->post('action');

            if ($action === 'logoutAll') {
                $result = $school->logoutDevice(null, true); // Implement this in your model
                return [
                    'success' => $result,
                    'message' => $result ? Yii::t('app', 'All devices logged out successfully') : Yii::t('app', 'Failed to log out all devices')
                ];
            } elseif ($action === 'logoutDevice') {
//                $staffId = Yii::$app->request->post('staff_id');
                $result = $school->logoutDevice($teacherId); // Implement this in your model
                return [
                    'success' => $result,
                    'message' => $result ? Yii::t('app', 'Device logged out successfully') : Yii::t('app', 'Failed to log out the device')
                ];
            }
        }
        return [
            'success' => false,
            'message' => Yii::t('app', 'An error occurred'),
        ];
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionUploadImage($model, $model_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Optionally set a path specific to each model
        $path = "uploads/{$model}/";
        $currentImageUrl = null;

        $result = Image::uploadImages($model, $model_id, $currentImageUrl, $path);
        return $result;
    }

    public function actionLoadTabContent($tab, $id)
    {
        $model = $this->findModel($id); // Load the model based on the ID
        switch ($tab) {
            case 'schoolProfile':
//                break;
                return $this->renderAjax('view/_info', ['model' => $model]);
            case 'teachersList':
                return $this->runAction('teachers', ['school_id' => $model->id, 'return_partial' => true]);
            case 'devices':
                $teachersList = $model->getTeachersOfSchool();
                $devices = [];
                foreach ($teachersList as $teacher) {
                    if (!empty($teacher)) {
                        $teacherDevices = $teacher->getTeacherDevices();
                        $devices = array_merge($devices, $teacherDevices);
                    }
                }
                return $this->renderPartial('view/_devices', ['model' => $model, 'devices' => $devices]);
            case 'students':
                return Yii::$app->runAction('student/index', ['school_id' => $model->id, 'return_partial' => true]);
            case 'grades':
                return Yii::$app->runAction('grade/index', ['school_id' => $model->id, 'return_partial' => true]);
            case 'actions':
                if (Yii::$app->user->can('admin')) {
                    return $this->renderPartial('view/_actions', ['model' => $model]);
                } else {
                    return '<div></div>';
                }
            case 'availability':
                return $this->renderPartial('view/_availability', ['school_id' => $model->id]);
            case 'chats':
                return Yii::$app->runAction('chat/index', ['school_id' => $model->id]);
//                return Yii::$app->runAction('availability/show-calculator', ['school_id' => $model->id, 'return_partial' => true]);
            default:
                return '<p>Invalid tab</p>';
        }
    }


}
