<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', $title);
$this->params['breadcrumbs'][] = $this->title;


//$this->registerCss("
//    .grid-view table tbody tr:hover {
//        background-color: #f5f5f5; /* Change to your preferred hover color */
//        cursor: pointer;
//    }
//");
//

$actionColumn = [
    'header' => Yii::t('app', 'Actions'),
    'class' => 'yii\grid\ActionColumn',
    'template' => '{pay} {view} {paid}', // Define your custom template
    'buttons' => [
        'pay' => function ($url, $model) use ($school_id) {

            //Generated by the school and unpaid then school can cancel it only
            if ($model->status == 'cancelled' && $model->creator_model == 'school' && $model->creator_id == Yii::$app->user->id) {
                return Html::a(
                    '<i class="ri-delete-bin-3-line me-1 align-bottom"></i> ' . Yii::t('app', 'Delete'),
                    ['payment/delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger btn-sm',
                    ]
                );
            }

            //Generated by the school and unpaid then school can cancel it only
            if ($model->status == 'unpaid' && $model->creator_model == 'school' && $model->creator_id == Yii::$app->user->id) {
                return Html::a(
                    '<i class="ri-delete-bin-3-line me-1 align-bottom"></i> ' . Yii::t('app', 'Cancel'),
                    ['payment/cancel', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger btn-sm',
                    ]
                );
            }

            //Generated by someone else and unpaid then school can pay only
            if ($model->status == 'unpaid') {
                return Html::a(
                    '<i class="ri-secure-payment-fill me-1 align-bottom"></i> ' . Yii::t('app', 'Pay'),
                    ['payment/pay', 'id' => $model->id, 'school_id' => $school_id],
                    [
                        'class' => 'btn btn-success btn-sm',
                    ]
                );
            }
            return '';
        },

        'paid' => function ($url, $model) use ($school_id) {
            //Generated by the school and unpaid then school can mark it as paid
            if ($model->status == 'unpaid' && $model->creator_model == 'school' && $model->creator_id == Yii::$app->user->id) {
                return Html::a(
                    '<i class="ri-check-line me-1 align-bottom"></i> ' . Yii::t('app', 'Mark as Paid'),
                    ['payment/invoice-paid', 'id' => $model->id],
                    [
                        'class' => 'btn btn-success btn-sm',
                    ]
                );
            }
            return '';
        },
        'view' => function ($url, $model) use ($school_id){
            return Html::a(
                '<i class="ri-eye-fill me-1 align-bottom"></i> ' . Yii::t('app', 'View Invoice'),
                ['payment/pay', 'id' => $model->id, 'view_invoice' => true,'school_id' => $school_id],
                [
                    'class' => 'btn btn-light btn-sm',
                ]
            );
        },
    ],
];

$gridColumns = array_merge($columns, [$actionColumn]);
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div class="row g-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table-card">

                            <?php Pjax::begin(['id' => 'pjax-container']); ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'options' => ['class' => 'table-responsive'], // Optional: makes the table scrollable
                                'headerRowOptions' => ['class' => 'table-light text-muted'],
                                'tableOptions' => ['class' => 'table table-borderless align-middle mb-0 table-striped'],
                                'columns' => $gridColumns,
                                'summary' => '',
//                                'rowOptions' => function ($model) use ($update_action, $school_id) {
//                                    return ['class' => 'entry-row', 'data-url' => Url::to([$update_action, 'id' => $model->id, 'school_id' => $school_id])];
//                                },
                            ]); ?>

                            <?php Pjax::end(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
</div>
