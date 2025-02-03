<?php

namespace backend\controllers;

use common\libraries\CustomWidgets;
use common\models\Grade;
use common\models\GradeRatio;
use common\models\GradeSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;

/**
 * GradeController implements the CRUD actions for Grade model.
 */
class GradeController extends BaseController
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
     * Lists all Grade models.
     *
     * @return string
     */
    public function actionIndex($school_id = null, $return_partial = false)
    {

        $searchModel = new GradeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $school_id);

        $columns = [
            'title', 'gradeRatio.teacher_ratio', 'gradeRatio.student_ratio'
        ];

        $params = [
            'title' => 'Grades',
            'update_action' => '/grade/update-grade',
            'view_action' => 'view-grade',
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

    public function actionUpdateGrade() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = $_REQUEST['id'] ?? $_REQUEST['Grade']['id'] ?? 0;
        $school_id = $_REQUEST['school_id'] ?? $_REQUEST['Grade']['school_id'] ?? 0;
        $model = Grade::findOne($id);
        if (empty($model)) {
            $model = new Grade();
            $gradeRatio = new GradeRatio();
            $model->school_id = $school_id;
        } else {
            $gradeRatio = $model->gradeRatio;
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $gradeRatio = $model->gradeRatio;
            $gradeRatio->load($this->request->post());
            $gradeRatio->save(false);

            $selectedTeachers = Yii::$app->request->post('Grade')['teachers'] ?? null;
            $model->linkTeachers($model->school_id, $selectedTeachers);

            if (Yii::$app->request->isAjax) {
                if ($model->save(false)) {
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
            'heading' => $model->isNewRecord ? 'Add Grade' : 'Update Grade',
            'body' => $this->renderAjax('_form', [
                'model' => $model,
                'gradeRatio' => $gradeRatio,
            ]),
        ]);
    }

    public function actionDeleteGrade($id) {
        $model = Grade::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionSearch()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $q = Yii::$app->request->get('q', ''); // Default to empty string if 'q' is not provided
        $schoolId = Yii::$app->request->get('school_id'); // Ensure to pass school_id from your form if required
        $selected = Yii::$app->request->get('selected', []); // Array of selected grade IDs

        // Convert selected to an array if it's not already
        if (!is_array($selected)) {
            $selected = explode(',', $selected);
        }

        // Search for grades based on the query term
        $grades = Grade::find()
            ->where(['school_id' => $schoolId])
            ->andFilterWhere(['like', 'title', $q]) // Search if there's a query term
            ->andWhere(['not in', 'id', $selected]) // Exclude already selected grades
            ->all();

        $items = [];
        foreach ($grades as $grade) {
            $items[] = ['id' => $grade->id, 'text' => $grade->title];
//            $items[] = ['id' => $grade->title, 'text' => $grade->title];
        }

        // If no existing grades are found, return a new tag with an id of 0
        if (empty($items) && !empty($q)) {
//            $items[] = ['id' => 0, 'text' => $q]; // New tag placeholder with id 0
            $items[] = ['id' => $q, 'text' => $q, 'newTag' => true]; // Mark new tag with a flag
        }

        return ['items' => $items, 'selected' => $selected];
    }

    public function actionSearchTeachers()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $q = Yii::$app->request->get('q', ''); // Default to empty string if 'q' is not provided
        $schoolId = Yii::$app->request->get('school_id'); // Ensure to pass school_id from your form if required
        $selected = Yii::$app->request->get('selected', []); // Array of selected grade IDs

        // Convert selected to an array if it's not already
        if (!is_array($selected)) {
            $selected = explode(',', $selected);
        }

        // Search for grades based on the query term
        $grades = Grade::find()
            ->where(['school_id' => $schoolId])
            ->andFilterWhere(['like', 'title', $q]) // Search if there's a query term
            ->andWhere(['not in', 'id', $selected]) // Exclude already selected grades
            ->all();

        $items = [];
        foreach ($grades as $grade) {
            $items[] = ['id' => $grade->id, 'text' => $grade->title];
//            $items[] = ['id' => $grade->title, 'text' => $grade->title];
        }

        // If no existing grades are found, return a new tag with an id of 0
        if (empty($items) && !empty($q)) {
//            $items[] = ['id' => 0, 'text' => $q]; // New tag placeholder with id 0
            $items[] = ['id' => $q, 'text' => $q, 'newTag' => true]; // Mark new tag with a flag
        }

        return ['items' => $items, 'selected' => $selected];
    }


//    public function actionCreate()
//    {
//        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        $title = Yii::$app->request->post('title');
//        $schoolId = Yii::$app->request->post('school_id');
//
//        if (!empty($title) && !empty($schoolId)) {
//
//            $exists = Grade::find()->where(['school_it' => $schoolId])
//                ->andWhere(['title' => $title])
//                ->exists();
//
//            if ($exists) return ['success' => true];
//
//            // Create a new grade
//            $grade = new Grade();
//            $grade->title = $title;
//            $grade->school_id = $schoolId;
//
//            if ($grade->save()) {
//                return ['success' => true];
//            } else {
//                return ['success' => false, 'error' => 'Failed to create grade'];
//            }
//        }
//        return ['success' => false, 'error' => 'Invalid data'];
//    }

    /**
     * Displays a single Grade model.
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
     * Updates an existing Grade model.
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
     * Deletes an existing Grade model.
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
     * Finds the Grade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Grade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grade::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
