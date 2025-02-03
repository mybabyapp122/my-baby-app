<?php

namespace backend\controllers;

use common\libraries\CustomWidgets;
use common\libraries\Moyasar;
use common\models\Availability;
use common\models\Grade;
use common\models\GradeRatio;
use common\models\GradeTeacher;
use common\models\GradeTeacherSchedule;
use common\models\Sale;
use common\models\SaleSearch;
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
class PaymentController extends Controller {
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
//                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Sale models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $school_id = Yii::$app->user->id;
        $searchModel = new SaleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $school_id);
        $formatter = Yii::$app->formatter;

        $columns = [
//            'id',
            'invoice_id',
            [
                'attribute' => 'id',
                'format' => 'raw', // Enables rendering HTML
                'label' => Yii::t('app', 'Issued By'),
                'value' => function ($model) {

                    $creator = $model->creator_model;
                    if (strtolower($creator) == 'mybaby') return '<span class="badge badge-pill bg-primary">'. strtoupper(Status::readStatus($creator)) .'</span>';
                    if (strtolower($creator) == 'school') return '<span class="badge badge-pill bg-info">'. strtoupper(Status::readStatus($creator)) .'</span>';
                    return '<strong>'. $creator .'</strong>';
                },
            ],

            [
                'attribute' => 'id',
                'format' => 'raw', // Enables rendering HTML
                'label' => Yii::t('app', 'Issued To'),
                'value' => function ($model) {
                    $metadata = is_array($model->metadata) ? $model->metadata : json_decode($model->metadata, true);
                    if ($model->payer_model == 'parent') {
                        if (!empty($metadata['metadata']['student_id'])) {
                            $student = Student::findOne($metadata['metadata']['student_id']);
                            if (!empty($student)) {
//                                return '<strong>'. $student->name .'</strong>' . '<br>';

                                return '<div class="summary-details">'.
                                    '<strong>'. $student->name .'</strong>'.
                                    '<br><strong>'.Yii::t('app', 'Parent Name').': </strong>'. $student->parent->name.
                                    '</div>';
                            }
                        }
                    }
                    return '<strong>'. ucfirst($model->payer_model) .'</strong>';
                },
            ],

            [
                'attribute' => 'id',
                'format' => 'raw', // Enables rendering HTML
                'label' => Yii::t('app', 'Title'),
                'value' => function ($model) {
                    $metadata = is_array($model->metadata) ? $model->metadata : json_decode($model->metadata, true);
                    if (empty($metadata['items'][0]['title'])) return '';
                    return '<strong>'. $metadata['items'][0]['title'] .'</strong>';
                },
            ],

            [
                'attribute' => 'id',
                'format' => 'raw', // Enables rendering HTML
                'label' => Yii::t('app', 'Amount'),
                'value' => function ($model) use ($formatter) {
                    $data = $model->invoiceJson();
                    $subtotal = $formatter->asCurrency($data['subtotal'], 'SAR');
                    $vat = $formatter->asCurrency($data['vat'], 'SAR');
                    $total = $formatter->asCurrency($data['total'], 'SAR');

                    return '<strong>'. $total .'</strong>';
                    return '<div class="summary-details">'.
                        '<p><strong>'.Yii::t('app', 'Subtotal').': </strong>'. $subtotal .'</p>'.
                        '<p><strong>'.Yii::t('app', 'Value Added Tax (15%)').': </strong>'. $vat .'</p>'.
                        '<p><strong>'.Yii::t('app', 'Total').': </strong>'. $total .'</p>'.
                    '</div>';
                },
            ],

            [
                'attribute' => 'status',
                'format' => 'raw', // Enables rendering HTML
                'value' => function ($model) {
                    $checked = $model->status == 'active' ? 'checked' : '';
                    return '<span class="badge badge-pill '.  ($model->status == "paid" ? "bg-success" : "bg-danger") .'">'. ucfirst(Status::readStatus($model->status)) .'</span>' . '<p class="text-muted mb-0 italic">'. Status::readStatus($model->status_ex) .'</p>';
                },
            ],

            [
                'attribute' => 'due_date',
                'format' => ['datetime', 'php:M d, Y'], // Customize the format as needed
//                'label' => 'Due Date', // Optional: Customize the column label
            ],

            [
                'attribute' => 'create_time',
                'format' => ['datetime', 'php:M d, Y'], // Customize the format as needed
//                'format' => ['datetime', 'php:M d, Y h:i A'], // Customize the format as needed
//                'headerOptions' => ['style' => 'width:200px'], // Optional: Adjust column width
//                'contentOptions' => ['class' => 'text-center'], // Optional: Center the content
//                'label' => 'Created At', // Optional: Customize the column label
            ],
        ];

        $params = [
            'title' => 'Invoices',
            'update_action' => 'update-invoice',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'school_id' => $school_id,
        ];

        return $this->render('index', $params);
    }

    public function actionCancel($id){
        $school = Yii::$app->user->identity;
        $sale = Sale::find()
            ->where(['id' => $id])
            ->andWhere(['creator_model' => 'school'])
            ->andWhere(['creator_id' => $school->id])
            ->andWhere(['status' => 'unpaid'])
            ->one();

        if ($sale) {
            $sale->status = 'cancelled';
            if ($sale->save()) {
                Yii::$app->session->setFlash('success', 'Invoice cancelled');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Invoice can not be cancelled');
        }

        return $this->redirect(['payment/index']); // Redirect to an appropriate page
    }

    public function actionDelete($id){
        $school = Yii::$app->user->identity;
        $sale = Sale::find()
            ->where(['id' => $id])
            ->andWhere(['creator_model' => 'school'])
            ->andWhere(['creator_id' => $school->id])
            ->andWhere(['status' => 'cancelled'])
            ->one();

        if ($sale) {
//            $sale->status = 'cancelled';
            if ($sale->delete()) {
                Yii::$app->session->setFlash('success', 'Invoice deleted');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Invoice can not be deleted');
        }

        return $this->redirect(['payment/index']); // Redirect to an appropriate page
    }

    public function actionInvoicePaid($id){
        $school = Yii::$app->user->identity;
        $sale = Sale::find()
            ->where(['id' => $id])
            ->andWhere(['creator_model' => 'school'])
            ->andWhere(['creator_id' => $school->id])
            ->andWhere(['status' => 'unpaid'])
            ->one();

        if ($sale) {
            $sale->status = 'paid';
            if ($sale->save()) {
                Yii::$app->session->setFlash('success', 'Invoice marked as paid');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Invoice can not be marked as paid');
        }

        return $this->redirect(['payment/index']); // Redirect to an appropriate page
    }


    public function actionCreate()
    {
        $school = Yii::$app->user->identity;
        $model = new Sale();

        $all_students = $school->getAssociatedPeople(false, false, true);

        return $this->render('_invoice_form', [
            'model' => $model,
            'all_students' => $all_students
//            'school_id' => $school_id,
//            'timeSlots' => $this->getTimeSlots() // Helper method for time slots
        ]);
    }

    public function actionPay($id, $view_invoice = false)
    {
        $sale = Sale::findOne($id);

        if (!$sale) {
            Yii::$app->session->setFlash('error', 'Invalid invoice');
            return $this->redirect(['payment/index']); // Redirect to an appropriate page
        }

        //if true then show invoice doesn't matter paid or unpaid
        if ($view_invoice) {
            return $this->redirect($sale->invoice_url);
        }

        //if paid, show our invoice
        if ($sale->status === 'paid') {
            return $this->redirect($sale->invoice_url);
        }

        //if view_invoice was set to false and gateway_invoice_url is not null then open it
        if (!empty($sale->gateway_invoice_url)) {
            return $this->redirect($sale->gateway_invoice_url); // Redirect to existing payment link
        }

        $moyasar = new Moyasar();
        try {
            // Generate a new payment link if none exists
            $payment = $moyasar->generatePaymentLink($sale->invoice_id, $sale->invoiceJson()['total']);
            // Store the new payment link in the sale record
            $sale->gateway_invoice_id = $payment['id'];
            $sale->gateway_invoice_url = $payment['url'];
            $sale->update(false); // Save without validation if fields are already validated

            return $this->redirect($payment['url']); // Redirect to the new payment link
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Failed to generate payment link: ' . $e->getMessage());
            return $this->redirect(['site/index']);
        }
    }
}
