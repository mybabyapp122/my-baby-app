<?php

namespace backend\controllers;

use common\libraries\CustomWidgets;
use common\models\Grade;
use common\models\Plan;
use common\models\Sale;
use common\models\Status;
use common\models\Student;
use common\models\StudentSchedule;
use common\models\StudentSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Student models.
     *
     * @return string
     */
    public function actionIndex($school_id = null, $return_partial = false)
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $columns = [
            'name',
            [
                'attribute' => 'parent.name',
                'label' => Yii::t('app', 'Parent Name'),
            ],
            [
                'attribute' => 'parent.status',
                'label' => Yii::t('app', 'Parent account status'),
                'format' => 'raw', // Enables rendering HTML
                'value' => function ($model) {
                    $checked = $model->parent->status == 'active' ? 'checked' : '';
                    return '<span class="badge badge-pill '.  ($model->parent->status == "active" ? "bg-success" : "bg-danger") .'">'. ucfirst($model->parent->status) .'</span>' . '<p class="text-muted mb-0 italic">'. Status::readStatus($model->parent->status_ex)  .'</p>';
                },
            ],

            [
                'attribute' => 'dob',
//                'label' => 'DOB',
                'format' => 'raw', // Enables rendering HTML
                'value' => function ($model) {
                    // Check if dob is not null
                    if ($model->dob) {
                        $dob = date('Y-m-d', strtotime($model->dob));
                        $age = ucfirst($model->getAge());
                        return '<span class="badge badge-pill badge-soft-primary">' . $age . '</span>' . '<p class="text-muted mb-3 italic">' . $dob . '</p>';
                    } else {
                        return '<span class="badge badge-pill badge-soft-secondary">' . Yii::t('app', 'N/A') . '</span>' .
                            '<p class="text-muted mb-0 italic">' . Yii::t('app', 'No date of birth') . '</p>';
                    }
                },
            ],
            [
                'attribute' => 'gender',
                'format' => 'raw', // Enables rendering HTML
                'value' => function ($model) {
                    // Check gender value and return appropriate badge
                    if ($model->gender === 'm') {
                        return '<span class="badge badge-pill badge-soft-primary">' . Yii::t('app', 'Boy') . '</span>';
                    } elseif ($model->gender === 'f') {
                        return '<span class="badge badge-pill" style="background-color: #FFB6C1">' . Yii::t('app', 'Girl') . '</span>';
                    } else {
                        return '<span class="badge badge-pill badge-soft-secondary">' . Yii::t('app', 'N/A') . '</span>' .
                            '<p class="text-muted mb-0 italic">' . Yii::t('app', 'No gender specified') . '</p>';
                    }
                },
            ],
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
            'title' => 'Grades',
            'update_action' => '/student/update-student',
            'update_schedule_action' => 'update-student-schedule',
            'update_finance_action' => 'update-student-finance',
            'view_action' => 'view-student',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'school_id' => $school_id,
        ];

        if ($return_partial) {
            return $this->renderPartial('index', $params);
        }

        return $this->render('index', $params);
    }

    public function actionUpdateStudentSchedule()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = $_REQUEST['student_id'];

        $model = Student::findOne($id);
        if (empty($model)) {
            return [
                'success' => false,
                'message' => Yii::t('app', 'Student not found'),
            ];
        }

        $selectedGrade = $model->grade_id;
        $gradeTitle = Grade::findOne($selectedGrade)->title ?? '';

        if ($this->request->isPost && Yii::$app->request->isAjax) {
            // Load and save schedule for the student
            $scheduleData = Yii::$app->request->post('StudentSchedule')[$selectedGrade] ?? [];

            if (!empty($scheduleData)) {
                //Delete all existing and add new
                StudentSchedule::deleteAll([
                    'student_id' => $model->id,
                    'grade_id' => $selectedGrade,
                ]);
            }

            // Loop through the days of the week
            foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                if (!empty($scheduleData['schedule'][$day]['start_time'])) {
                    // Loop through each selected time slot for the day
                    foreach ($scheduleData['schedule'][$day]['start_time'] as $timeSlot) {
                        $times = explode('-', $timeSlot);
                        $startTime = date('H:i', strtotime($times[0]));
                        $endTime = date('H:i', strtotime($times[1]));

                        $studentSchedule = new StudentSchedule();
                        $studentSchedule->grade_id = $selectedGrade;
                        $studentSchedule->student_id = $model->id;
                        $studentSchedule->day_of_week = $day;
                        $studentSchedule->start_time = $startTime;
                        $studentSchedule->end_time = $endTime;
                        $studentSchedule->start_date = $scheduleData['start_date'];
                        $studentSchedule->end_date = $scheduleData['end_date'];

//                        StudentSchedule::deleteAll([
//                            'student_id' => $model->id,
//                            'grade_id' => $selectedGrade,
//                            'day_of_week' => $day,
//                            'start_time' => $startTime,
//                            'end_time' => $endTime,
//                        ]);

                        if (!$studentSchedule->save()) {
                            return [
                                'success' => false,
                                'message' => Yii::t('app', 'Failed to save'),
                                'error' => $studentSchedule->getErrors(),
                            ];
                        }
                    }
                }
            }

            return [
                'success' => true,
                'message' => Yii::t('app', 'Changes saved'),
                'data' => $gradeTitle,
            ];
        }

        // Load schedules for display in the form
        $model->loadStudentSchedules([$selectedGrade]);
        return CustomWidgets::returnSuccess([
            'heading' => $model->isNewRecord ? 'Add Schedule' : 'Update Schedule',
            'body' => $this->renderAjax('_schedule', [
                'model' => $model,
                'gradeTitle' => $gradeTitle,
            ]),
        ]);
    }

    public function actionUpdateStudentFinance()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = $_REQUEST['student_id'];
        $student = Student::findOne($id);

        $schedule = Student::scheduleDetails($id);

        if (empty($student)) {
            return [
                'success' => false,
                'message' => Yii::t('app', 'Student not found'),
            ];
        }

        $model = new Sale();
        if ($this->request->isPost && Yii::$app->request->isAjax) {
            // Load and save schedule for the student

            $metadata = [
                'student_id' => $_REQUEST['student_id'],
                'per_hour_rate' => $_REQUEST['per_hour_rate'],
                'total_hours' => $_REQUEST['total_hours'],
                'total_amount' => $_REQUEST['total_amount'],
                'starting_date' => $_REQUEST['starting_date'],
                'ending_date' => $_REQUEST['ending_date'],
            ];

            $sale = Sale::processBillingCycles($metadata);
            return $sale;
        }

        //CHECK IF IT IS ALLOWED AS PER SCHOOL PLAN OR NOT
        $school = Yii::$app->user->identity;
        if ( !(Plan::PLANS[(string)$school->plan_id]['generate_invoices_for_parents']) ) {
            return CustomWidgets::returnSuccess([
                'heading' => Yii::t('app', 'Upgrade Your Plan'),
                'body' => $this->renderAjax('/user/_upgrade_plan', [
                ]),
            ]);
        }

        return CustomWidgets::returnSuccess([
            'heading' => Yii::t('app', 'Generate Invoice'),
            'body' => $this->renderAjax('_finance', [
                'model' => $model,
                'student' => $student,
                'schedule' => $schedule
            ]),
        ]);
    }


    public function actionUpdateStudent() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = $_REQUEST['id'] ?? $_REQUEST['Student']['id'] ?? 0;
        $school_id = $_REQUEST['school_id'] ?? $_REQUEST['Student']['school_id'] ?? 0;

        $model = Student::findOne($id);
        if (empty($model)) {
            $model = new Student();
        }
        $model->scenario = Student::SCENARIO_NEW_STUDENT; // Set the scenario

        // Initialize a parent model (User) if it doesn't exist
        if ($model->isNewRecord || empty($model->parent)) {
            $model->populateRelation('parent', new User()); // Populate the relation with a new User instance
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if (Yii::$app->request->isAjax) {
                $parentEmail = $_REQUEST['User']['email'] ?? NULL;
                $model->parent->email = $parentEmail;
                // Check for existing student by id_number

                if ($model->isNewRecord) {
                    $idNumber = $model->id_number; // Ensure this field is loaded in the form
                    $existingStudent = Student::find()
                        ->where(['id_number' => $idNumber])
                        ->andWhere(['!=', 'id', $id])
//                        ->andWhere(['status' => 'active'])
                        ->one();

                    if ($existingStudent) {
                        if ($existingStudent->status == 'active') {
                            return CustomWidgets::returnFail(Yii::t('app', 'A student with this ID number already exists'));
                        } else {
                            $model = $existingStudent;
                        }
                    }

                    $model->status = 'pending';
                    $model->status_ex = 'profile';
                }

                // Get parent email from the request

                if ($parentEmail) {
                    // Check if the parent already exists
                    $parentUser = User::findOne(['email' => $parentEmail]);

                    if (!$parentUser) {
                        $new_password = '';
                        $send_invite = false;
                        // If parent does not exist, create a new User
                        $parentUser = new User();
                        $parentUser->email = $parentEmail;
                        $parentUser->generateUniqueUsername();
                        $parentUser->generatePassword();
                        $parentUser->generateAuthKey();
                        $parentUser->status = 'pending';
                        $parentUser->status_ex = 'invited';
                        $parentUser->role = 'parent';

                        $new_password = $parentUser->plainPassword;
                        $send_invite = true;
                        // Send email logic to notify user of their new account goes here...

                        if (!$parentUser->save()) {
                            return [
                                'success' => false,
                                'message' => Yii::t('app', 'Failed to create parent user'),
                                'error' => $parentUser->getErrors(),
                            ];
                        } else {
                            $parentUser->sendParentInvitationEmail($new_password);
                        }
                    }

                    // Link the student to the existing or newly created parent
                    $model->parent_id = $parentUser->id;
                } else {
                    return [
                        'success' => false,
                        'message' => Yii::t('app', 'Write parent\'s email'),
                    ];
                }


                if ($model->save()) {
                    return [
                        'success' => true,
                        'message' => Yii::t('app', 'Changes saved')
                    ];
                } else {
                    $array = $model->getFirstErrors();
                    $error = reset($array);
                    return [
                        'success' => false,
                        'message' => Yii::t('app', 'Failed to save: {error}', [
                            'error' => $error
                        ]),
                        'error' => $model->getErrors(),
                    ];
                }

            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return CustomWidgets::returnSuccess([
            'heading' => $model->isNewRecord ? 'Add Student' : 'Update Student',
            'body' => $this->renderAjax('_form', [
                'model' => $model,
                'school_id' => $school_id
            ]),
        ]);
    }

    public function actionDeleteStudent($id) {
        $model = Student::findOne($id);
        $model->status = 'removed';
        $model->save();
        Yii::$app->session->setFlash('success', 'Deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }

//    /**
//     * Displays a single Student model.
//     * @param int $id ID
//     * @return string
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
//
//    /**
//     * Creates a new Student model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return string|\yii\web\Response
//     */
//    public function actionCreate()
//    {
//        $model = new Student();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Updates an existing Student model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param int $id ID
//     * @return string|\yii\web\Response
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing Student model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param int $id ID
//     * @return \yii\web\Response
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

//    /**
//     * Finds the Student model based on its primary key value.
//     * If the model is not found, a 404 HTTP exception will be thrown.
//     * @param int $id ID
//     * @return Student the loaded model
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    protected function findModel($id)
//    {
//        if (($model = Student::findOne(['id' => $id])) !== null) {
//            return $model;
//        }
//
//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
//    }
}
